<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pangkalan_data extends MY_Controller
{
  /// |----------------------------------------------------------------------
  /// | >> CONSTRUCT
  /// |----------------------------------------------------------------------
  public function __construct()
  {
    parent::__construct();

    $is_ajax = $this->input->is_ajax_request();
    if (!$is_ajax) {
      $this->session->set_userdata('menu', 'PDT_Dashboard');
      if (!is_logged_in()) {
        redirect(site_url('login'));
      }
    }

    $this->load->model('mdl_pangkalan_data', 'mdl_pkldata');
  }

  /// |----------------------------------------------------------------------
  /// | >> PRIVATE FUNCTION
  /// |----------------------------------------------------------------------

  /// |----------------------------------------------------------------------
  /// | >> PAGE LOAD FUNCTION
  /// |----------------------------------------------------------------------
  public function index()
  {
    $cur_kewenangan = $this->session->userdata('kewenangan');
    if (in_array($cur_kewenangan, ['00', '02'])) {
      $view = 'vw_dashboard_admin';
      $data_kepsek = [];
      $data_sekolah = [];
    } else {
      $view = 'vw_dashboard_sekolah';
      $kode_unor = $this->session->userdata('kode_unor');

      // set data kepsek
      $data_kepsek = [];
      $kepsek_simpeg = $this->db->from('v_pns')->where('kode_ukerja', $kode_unor)
        ->like('ket_jab', 'Kepala Sekolah')
        ->get()->row_array();
      $kepsek_profil = fetch_row_data('vm_profil_kepsek', ['kode_ukerja' => $kode_unor, 's_aktif' => '1'], false);
      if ($kepsek_profil !== false) {
        $data_kepsek = $kepsek_profil;
      } else if (check_var($kepsek_simpeg)) {
        normalisasi_data_profil_kepsek($data_kepsek, $kepsek_simpeg);
      }

      // set data sekolah
      $data_sekolah = [];
      $ukerja_simpeg = fetch_row_data('v_ukerja', ['kode_ukerja' => $kode_unor], false);
      $ukerja_profil = fetch_row_data('vm_profil_sekolah', ['kode_ukerja' => $kode_unor], false);
      if ($ukerja_profil !== false) {
        $data_sekolah = $ukerja_profil;
      } else if ($ukerja_simpeg !== false) {
        normalisasi_data_profil_sekolah($data_sekolah, $ukerja_simpeg);
      }
    }

    $data = array(
      'page_title' => "Dashboard Pangkalan Data | PROGURINDA",
      'module' => "pangkalan_data",
      'view' => $view,
      'data' =>  [
        'kepsek' => $data_kepsek,
        'sekolah' => $data_sekolah
      ]
    );
    echo Modules::run('layout/backend', $data);
  }

  /// |----------------------------------------------------------------------
  /// | >> AJAX REQUEST FUNCTIONS
  /// |----------------------------------------------------------------------
  public function get_riwayat_dokumen()
  {
    $encrypted_id = post_safe('id_dokumen');
    $jenis_dokumen = post_safe('jenis_dokumen');

    $decrypted_id = decrypt_id($encrypted_id);

    $html_riwayat = '<div class="col-12 text-center">Belum ada riwayat untuk dokumen ini.</div>';

    // CHECK PERMISSION
    if (!is_logged_in()) return output_json([
      'status' => true,
      'message' => "Riwayat dokumen retrieved",
      'html' => $html_riwayat
    ]);

    // tarik data utk log
    $dataset = $this->db->select('*')->from('v_log_dokumen')->where([
      'jenis_dokumen' => $jenis_dokumen,
      'id_dokumen' => $decrypted_id
    ])->order_by('datetime', 'ASC')->get()->result_array();

    if (check_var($dataset)) {
      $html_riwayat = '';
      foreach ($dataset as $key => $value) {
        $html_riwayat .= '
          <div class="col-12">
            <div class="desc_block">
              <ul class="mb-0">
                <li>
                  <div><b>' . $value['nama_user'] . '</b> (' . $value['ket_kewenangan'] . ')</div>
                  <label>' . em_date('j F Y, H:i:s', 'set', $value['datetime']) . '</label>
                  <div>
                    ' . $value['message'] . '
                  </div>
                </li>
              </ul>
            </div>
          </div>';
      }
    }

    return output_json([
      'status' => true,
      'message' => "Riwayat dokumen retrieved",
      'html' => $html_riwayat
    ]);
  }

  public function get_riwayat_update_sekolah()
  {
    $kode_ukerja = post_safe('kode_ukerja');

    $html_riwayat = '<div class="col-12 text-center">Belum ada riwayat untuk Sekolah.</div>';

    // CHECK PERMISSION
    if (!is_logged_in()) return output_json([
      'status' => true,
      'message' => "Riwayat sekolah retrieved",
      'html' => $html_riwayat
    ]);

    $dataset = $this->mdl_pkldata->get_riwayat_sekolah($kode_ukerja);
    if (check_var($dataset)) {
      $html_riwayat = '';
      foreach ($dataset as $key => $value) {
        $html_riwayat .= '<div class="col-12"><div class="desc_block hover">' .

          '<div>' .
          '<b>' . $value['verif_by'] . ' (' . $value['verif_by_kewenangan'] . ')</b><a target="_blank" href="' . site_url('pdt_profil_sekolah/detail/' . encrypt_id($value['id_dokumen'])) . '" class="badge text-light bg-info ms-1 clickable"><i class="fas fa-eye me-1"></i>Lihat Dokumen</a>' .
          '</div>' .

          '<label>' .
          '<span class="me-3"><i class="fas fa-file me-1"></i>' . em_date('j F Y, H:i:s', 'set', $value['create_on']) . '</span>' .
          '<span class="me-3"><i class="fas fa-check-square me-1"></i>' . em_date('j F Y, H:i:s', 'set', $value['verif_on']) . '</span> ' .
          '<span class="me-3"><i class="fas fa-sync me-1"></i>Update Periode ' . $value['periode_bln'] . '/' . $value['periode_thn'] . '</span>' .
          '</label>' .

          '<div>' .
          'Menyetujui Dokumen Update Sekolah ' . $value['ket_ukerja'] . ' untuk Periode <b>' . $value['periode_bln'] . '/' . $value['periode_thn'] . '</b>.' .
          '</div>' .

          '</div></div>';
      }
    }

    /// |----------------------------------------
    /// | TATA FORMAT HTMLNYA
    /// |----------------------------------------
    return output_json([
      'status' => true,
      'message' => "Riwayat sekolah retrieved",
      'html' => $html_riwayat
    ]);
  }

  public function get_riwayat_kepala_sekolah()
  {
    $nip = post_safe('nip');

    $html_riwayat = '<div class="col-12 text-center">Belum ada riwayat untuk Kepala Sekolah.</div>';

    // CHECK PERMISSION
    if (!is_logged_in()) return output_json([
      'status' => true,
      'message' => "Riwayat kepala sekolah retrieved",
      'html' => $html_riwayat
    ]);

    // TARIK DATASET DARI MODEL
    $dataset = $this->mdl_pkldata->get_riwayat_kepala_sekolah($nip);
    if (check_var($dataset)) {
      $html_riwayat = '';
      foreach ($dataset as $key => $value) {
        $html_riwayat .= '<div class="col-12"><div class="desc_block hover">' .

          '<div>' .
          '<b>' . $value['ket_ukerja'] . ' (' . $value['kode_ukerja'] . ')</b><a target="_blank" href="' . site_url('pdt_profil_kepsek/detail/' . encrypt_id($value['id_dokumen'])) . '" class="badge text-light bg-info ms-1 clickable"><i class="fas fa-eye me-1"></i>Lihat Dokumen</a>' .
          '</div>' .

          '<label>' .
          '<span class="me-3"><i class="fas fa-file me-1"></i>' . em_date('j F Y, H:i:s', 'set', $value['create_on']) . '</span>' .
          '<span class="me-3"><i class="fas fa-check-square me-1"></i>' . em_date('j F Y, H:i:s', 'set', $value['verif_on']) . '</span> ' .
          '<span class="me-3"><i class="fas fa-sync me-1"></i>Update Periode ' . $value['periode_bln'] . '/' . $value['periode_thn'] . '</span>' .
          '</label>' .

          '<div>' .
          'Menjabat sebagai Kepala Sekolah mulai dari <b>' . em_date('j F Y', 'set', $value['masa_penugasan_mulai']) . '</b> s/d <b>' . em_date('j F Y', 'set', $value['masa_penugasan_selesai']) . '</b>' .
          '</div>' .

          '</div></div>';
      }
    }

    return output_json([
      'status' => true,
      'message' => "Riwayat kepala sekolah retrieved",
      'html' => $html_riwayat
    ]);
  }

  public function get_riwayat_kepala_sekolah_by_ukerja()
  {
    $kode_ukerja = post_safe('kode_ukerja');

    $data_ukerja = fetch_row_data('v_ukerja', ['kode_ukerja' => $kode_ukerja], false);
    if ($data_ukerja == false) {
      return output_json([
        'status' => true,
        'message' => "Riwayat kepala sekolah retrieved",
        'html' => '<div class="col-12 text-center">Belum ada riwayat Kepala Sekolah.</div>'
      ]);
    }

    $html_riwayat = '<div class="col-12 text-center">Belum ada riwayat Kepala Sekolah di ' . $data_ukerja['ket_ukerja'] . '.</div>';

    // CHECK PERMISSION
    if (!is_logged_in()) return output_json([
      'status' => true,
      'message' => "Riwayat kepala sekolah retrieved",
      'html' => $html_riwayat
    ]);

    // TARIK DATASET DARI MODEL
    $dataset = $this->mdl_pkldata->get_riwayat_kepala_sekolah_by_ukerja($kode_ukerja);
    if (check_var($dataset)) {
      $html_riwayat = '';
      foreach ($dataset as $key => $value) {
        $html_riwayat .= '<div class="col-12"><div class="desc_block hover">' .

          '<div>' .
          '<b>' . $value['nama'] . ' (' . $value['nip'] . ')</b><a target="_blank" href="' . site_url('pdt_profil_kepsek/detail/' . encrypt_id($value['id_dokumen'])) . '" class="badge text-light bg-info ms-1 clickable"><i class="fas fa-eye me-1"></i>Lihat Dokumen</a>' .
          '</div>' .

          '<label>' .
          '<span class="me-3"><i class="fas fa-file me-1"></i>' . em_date('j F Y, H:i:s', 'set', $value['create_on']) . '</span>' .
          '<span class="me-3"><i class="fas fa-check-square me-1"></i>' . em_date('j F Y, H:i:s', 'set', $value['verif_on']) . '</span> ' .
          '<span class="me-3"><i class="fas fa-sync me-1"></i>Update Periode ' . $value['periode_bln'] . '/' . $value['periode_thn'] . '</span>' .
          '</label>' .

          '<div>' .
          'Menjabat sebagai Kepala Sekolah di ' . $value['ket_ukerja'] . ' mulai dari <b>' . em_date('j F Y', 'set', $value['masa_penugasan_mulai']) . '</b> s/d <b>' . em_date('j F Y', 'set', $value['masa_penugasan_selesai']) . '</b>' .
          '</div>' .

          '</div></div>';
      }
    }

    return output_json([
      'status' => true,
      'message' => "Riwayat kepala sekolah retrieved",
      'html' => $html_riwayat
    ]);
  }

  public function get_inventaris()
  {
    $id = decrypt_id(post_safe('id'));

    $is_master = (post_safe('is_master') == 'yes') ? true : false;
    $rearrange_data = true;

    $dataset = $this->mdl_pkldata->get_data_inventaris($id, $is_master, $rearrange_data);

    return output_json([
      'status' => true,
      'message' => 'Hasil request data inventaris',
      'data' => $dataset
    ]);
  }
}
