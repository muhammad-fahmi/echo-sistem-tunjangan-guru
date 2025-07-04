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
      if (!check_perm('read') || !is_logged_in()) {
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
      $sent_data = [];
    } else {
      $view = 'vw_dashboard_sekolah';
      $kode_unor = $this->session->userdata('kode_unor');
      $ukerja_simpeg = fetch_row_data('m_ukerja', ['kode_ukerja' => $kode_unor], false);
      $ukerja_profil = fetch_row_data('m_profil_sekolah', ['kode_ukerja' => $kode_unor], false);
      $sent_data = [];
      if ($ukerja_profil !== false) {
        $sent_data = $ukerja_profil;
      } else if ($ukerja_simpeg !== false) {
        $sent_data = $ukerja_simpeg;
      }
    }

    $data = array(
      'page_title' => "Dashboard Pangkalan Data | PROGURINDA",
      'module' => "pangkalan_data",
      'view' => $view,
      'data' => $sent_data
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
    if (!check_perm('read', 'PDT_Dashboard')) return output_json([
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
}
