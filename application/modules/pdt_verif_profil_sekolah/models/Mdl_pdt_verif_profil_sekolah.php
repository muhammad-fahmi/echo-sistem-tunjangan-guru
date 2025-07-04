<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_pdt_verif_profil_sekolah extends CI_Model
{
  /** fungsi untuk menarik data dari database */
  public function get($table, $where = null, $result_array = false)
  {
    if ($where != null) {
      if ($result_array) {
        $result = $this->db->get_where($table, $where)->result_array();
      } else {
        $result = $this->db->get_where($table, $where)->row_array();
      }
    } else {
      $result = $this->db->select('*')->from($table)->get()->result_array();
    }
    return $result;
  }

  /** fungsi untuk mengecek num_rows return int */
  public function check($table, $where = null)
  {
    if ($where != null) {
      $result = $this->db->get_where($table, $where)->num_rows();
    } else {
      $result = $this->db->select('*')->from($table)->get()->num_rows();
    }
    return $result;
  }

  /// |----------------------------------------------------------------------
  /// | >> DATATABLE R PROFIL SEKOLAH
  /// |----------------------------------------------------------------------
  private function query_r_profil_sekolah($data)
  {
    $cur_unor = $this->session->userdata('kode_unor');
    $cur_user = $this->session->userdata('id_user');

    // declare table
    $this->db->from('vr_profil_sekolah');

    // where condition
    if (check_var($data, 'search')) {
      $this->db->group_start()
        ->like('kode_ukerja', $data['search'])
        ->or_like('ket_ukerja', $data['search'])
        ->or_like('alamat', $data['search'])
        ->or_like('website', $data['search'])
        ->or_like('email', $data['search'])
        ->or_like('telepon', $data['search'])
        ->group_end();
    }

    if (!is_admin()) {
      // tambah kondisi kode_ukerja karena yang login adalah admin sekolah
      $this->db->where(['kode_ukerja' => $cur_unor]);
    }

    if (check_var($data, 'is_history', 'NO') == 'YES') {
      $this->db->where('verif_by', $cur_user);
    } else {
      $this->db->where('status_dokumen', 'VRFDD');
    }
  }

  public function get_datatable($data)
  {
    // START DB BUILDER
    $this->query_r_profil_sekolah($data);

    // ORDER
    $order_col = $data['order_column'];
    $order_sort = strtolower($data['order_sort']) === 'desc' ? 'DESC' : 'ASC';
    $this->db->order_by($order_col, $order_sort);

    // LIMIT
    $this->db->limit((int)$data['length'], (int)$data['start']);

    // RESULT DATA
    $query_result = $this->db->get()->result_array();

    // RE-BUILD FOR TOTAL
    $this->query_r_profil_sekolah($data);
    $total_count = $this->db->get()->num_rows();

    // RE-ARRANGE RESULT DATA
    $no = $data['start'] + 1;
    $data_result = [];

    $cur_unor = $this->session->userdata('kode_unor');

    foreach ($query_result as $row) {
      $row['no'] = $no++;

      // encrypt ID dokumen
      $row['id_dokumen'] = encrypt_id($row['id_dokumen']);

      // tampilan periode
      $row['periode_display'] = $row['periode_bln'] . '/' . $row['periode_thn'];

      // tampilan dibuat pada
      $row['create_on_display'] =  em_date('j M Y, H:i:s', 'set', $row['create_on']);

      // tampilan sekolah
      $kode_sekolah = '<div><small style="opacity: 0.65;">' . $row['kode_ukerja'] . '</small></div>';
      $nama_sekolah = '<div>' . $row['ket_ukerja'] . '</div>';
      $row['sekolah_display'] = $kode_sekolah . $nama_sekolah;

      // tampilan alamat
      $kec = '<div><small style="opacity: 0.6;">KEC: ' . check_var($row, 'nama_kecamatan', '-') . '</small></div>';
      $kel = '<div><small style="opacity: 0.6;">KEL: ' . check_var($row, 'nama_kelurahan', '-') . '</small></div>';
      $row['alamat_display'] = '<div>' . $kec . $kel . '</div>' .
        '<div>' . check_var($row, 'alamat', '-') . '</div>';

      // tampilan status
      $row['status_display'] = '<div class="badge bg-' . $row['col_status_dokumen'] . '">' . $row['ket_status_dokumen'] . '</div>';

      // penentuan kondisi
      $is_verif = ($row['status_dokumen'] == 'VRFDD');
      $same_ukerja = ($row['kode_ukerja'] == $cur_unor);
      $is_allowed = (is_admin() || $same_ukerja);

      // tampilan tombol aksi
      $tombol_verif =  ($is_verif && $is_allowed)
        ? '<a href="' . site_url('pdt_verif_profil_sekolah/verif/' . $row['id_dokumen']) . '" class="clickable text-white badge bg-info"><i class="fas fa-check-square me-1"></i>Verifikasi</a>'
        : '';
      $tombol_detail = '<a href="' . site_url('pdt_verif_profil_sekolah/detail/' . $row['id_dokumen']) . '" class="clickable text-white  badge bg-secondary"><i class="fas fa-file me-1"></i>Detail</a>';
      $row['aksi_display'] = '<div class="d-grid gap-1">' .
        $tombol_verif . $tombol_detail .
        '</div>';

      $data_result[] = $row;
    }

    return array(
      'total' => $total_count,         // total after search
      'filtered' => $total_count,      // assuming no global filter for now
      'data' => $data_result,
      'draw' => (int)$data['draw']
    );
  }

  /// |----------------------------------------------------------------------
  /// | >> FUNGSI CRUD
  /// |----------------------------------------------------------------------
  /** fungsi untuk menyetujui verifikasi disdik return row_array (status / message) */
  private function setuju_vrfdd($data_dokumen, $post_data, &$proc_vrfdd)
  {
    $cur_user = $this->session->userdata('id_user');

    // BUAT DATA YANG AKAN DI SAVE 
    // unset kolom yang ga ada di m_profil_sekolah
    $proc_vrfdd = 2;
    $save_m_profil = $data_dokumen;
    $unset_key = [
      'id_dokumen', 'periode_bln', 'periode_thn',
      'create_on', 'create_by', 'create_by_nama', 'create_by_kewenangan',
      'update_on', 'update_by', 'update_by_nama', 'update_by_kewenangan',
      'verif_on', 'verif_by', 'verif_by_nama', 'verif_by_kewenangan',
      'status_dokumen', 'ket_status_dokumen', 'col_status_dokumen',
      'ket_ukerja', 'ket_status_sekolah', 'nama_kelurahan', 'nama_kecamatan'
    ];
    foreach ($unset_key as $key_value) {
      unset($save_m_profil[$key_value]);
    }

    // UPDATE M_PROFIL_SEKOLAH
    $proc_vrfdd = 3;
    $data_awal = fetch_row_data('m_profil_sekolah', [
      'kode_ukerja' => $save_m_profil['kode_ukerja']
    ], []);
    $changelog = get_changed_data($data_awal, $save_m_profil);

    // cek apakah data awal exist, kalau tidak lakukan insert
    // kalau exist lakukan update
    if (check_var($data_awal)) {
      // PROSES UPDATE
      $this->db->update('m_profil_sekolah', $save_m_profil, ['kode_ukerja' => $data_dokumen['kode_ukerja']]);
      $proc_vrfdd = 4;
      log_generator(
        $cur_user,
        'm_profil_sekolah',
        $data_dokumen['kode_ukerja'],
        "Melakukan update data master profil sekolah berdasarkan verifikasi profil dengan perubahan sebagai berikut :" .
          "\n\nBEFORE:\n" . format_log_view($changelog['before']) .
          "\n\nAFTER:\n" . format_log_view($changelog['after'])
      );
    } else {
      // PROSES INSERT
      $this->db->insert('m_profil_sekolah', $save_m_profil);
      $proc_vrfdd = 5;
      log_generator(
        $cur_user,
        'm_profil_sekolah',
        $data_dokumen['kode_ukerja'],
        "Melakukan insert data master profil sekolah berdasarkan verifikasi profil dengan data sebagai berikut :" .
          "\n\n" . format_log_view($save_m_profil)
      );
    }

    // UPDATE R_PROFIL_SEKOLAH (GANTI STATUS JADI DITERIMA)
    $proc_vrfdd = 6;
    $data_update_dok = [
      'verif_by' => $cur_user,
      'verif_on' => em_date('Y-m-d H:i:s'),
      'status_dokumen' => 'DITRM'
    ];
    $this->db->update('r_profil_sekolah', $data_update_dok, ['id_dokumen' => $data_dokumen['id_dokumen']]);

    // BUAT LOG SISTEM
    $proc_vrfdd = 7;
    log_generator(
      $cur_user,
      'r_profil_sekolah',
      $data_dokumen['id_dokumen'],
      "Menyetujui usulan profil sekolah dengan data sebagai berikut :\n\n" . format_log_view($save_m_profil)
    );

    // BUAT RIWAYAT DOKUMEN
    $proc_vrfdd = 8;
    $this->db->insert('r_log_dokumen', [
      'jenis_dokumen' => 'PROFIL_SEKOLAH',
      'id_dokumen' => $data_dokumen['id_dokumen'],
      'id_user' => $cur_user,
      'datetime' => em_date('Y-m-d H:i:s'),
      'message' => "Menyetujui Usulan Profil Sekolah ({$data_dokumen['ket_ukerja']}) dengan jenjang {$data_dokumen['jenjang']} untuk periode {$data_dokumen['periode_bln']}/{$data_dokumen['periode_thn']}."
    ]);

    // KEMBALIKAN RESPON
    return [
      'status' => true,
      'message' => "Anda menyetujui dokumen usulan profil sekolah ({$data_dokumen['ket_ukerja']}) untuk periode {$data_dokumen['periode_bln']}/{$data_dokumen['periode_thn']}.",
      'ID' => $post_data['id_dokumen']
    ];
  }

  /** fungsi untuk menolak verifikasi disdik, return row_array (status / message) */
  private function tolak_vrfdd($data_dokumen, $post_data, &$proc_vrfdd)
  {
    $cur_user = $this->session->userdata('id_user');

    // UPDATE R_PROFIL_SEKOLAH (GANTI STATUS JADI DITOLAK)
    $proc_vrfdd = 9;
    $data_update_dok = [
      'verif_by' => $cur_user,
      'verif_on' => em_date('Y-m-d H:i:s'),
      'status_dokumen' => 'DITLK'
    ];
    $this->db->update('r_profil_sekolah', $data_update_dok, ['id_dokumen' => $data_dokumen['id_dokumen']]);

    // BUAT LOG SISTEM
    $proc_vrfdd = 10;
    log_generator(
      $cur_user,
      'r_profil_sekolah',
      $data_dokumen['id_dokumen'],
      "Menolak usulan profil sekolah dengan data sebagai berikut :\n\n" . format_log_view($data_dokumen)
    );

    // BUAT RIWAYAT DOKUMEN
    $proc_vrfdd = 11;
    $this->db->insert('r_log_dokumen', [
      'jenis_dokumen' => 'PROFIL_SEKOLAH',
      'id_dokumen' => $data_dokumen['id_dokumen'],
      'id_user' => $cur_user,
      'datetime' => em_date('Y-m-d H:i:s'),
      'message' => "Menolak Usulan Profil Sekolah ({$data_dokumen['ket_ukerja']}) dengan jenjang {$data_dokumen['jenjang']} untuk periode {$data_dokumen['periode_bln']}/{$data_dokumen['periode_thn']}. Adapun alasan penolakan dokumen ini antara lain:\n" .
        "\"{$post_data['alasan']}\""
    ]);

    // KEMBALIKAN RESPON
    return [
      'status' => true,
      'message' => "Anda menolak dokumen usulan profil sekolah ({$data_dokumen['ket_ukerja']}) untuk periode {$data_dokumen['periode_bln']}/{$data_dokumen['periode_thn']}.",
      'ID' => $post_data['id_dokumen']
    ];
  }

  public function verif_profil_sekolah($post)
  {
    // FORM VALIDATION
    $this->load->library('form_validation');

    $tindak_lanjut = check_var($post, 'tindak_lanjut', '');

    // Define validation rules
    $this->form_validation->set_rules('tindak_lanjut', 'Tindak Lanjut', 'required');
    if ($tindak_lanjut == 'tolak') $this->form_validation->set_rules('alasan', 'Alasan / Pesan', 'required');

    // Validate the input data
    if ($this->form_validation->run() === FALSE) {
      // Collect errors
      $errors = validation_errors('<li>', '</li>'); // This will return a string with errors formatted as HTML

      // Build error list
      $error_list = '<ul class="mb-0">';
      $error_list .= $errors;
      $error_list .= '</ul>';

      // Return response with error details
      return [
        'status' => false,
        'message' => 'Proses tidak bisa dilanjutkan karena form tidak valid.<br>' . $error_list
      ];
    }

    // pastikan dokumen usulan exist
    $id_dokumen = decrypt_id($post['id_dokumen']);
    $data_dokumen = fetch_row_data('vr_profil_sekolah', [
      'id_dokumen' => $id_dokumen
    ], false);
    if ($data_dokumen === false) return [
      'status' => false,
      'message' => "Maaf, dokumen yang akan di-verifikasi tidak valid lagi. coba refresh halaman."
    ];

    try {
      // START DB OPERATION
      $this->db->trans_begin();

      $proc_vrfdd = 1;
      if ($tindak_lanjut == 'setuju') {
        $result = $this->setuju_vrfdd($data_dokumen, $post, $proc_vrfdd);
      } else {
        $result = $this->tolak_vrfdd($data_dokumen, $post, $proc_vrfdd);
      }

      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        return [
          'status' => false,
          'message' => "Maaf, proses mengalami error.\nROLLBACK ISSUE #{$proc_vrfdd}"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        return $result;
      }
    } catch (\Throwable $th) {
      $catch_error = sanitize_string($th->getMessage());
      return [
        'status' => false,
        'message' => "Maaf, proses mengalami error.\n{$catch_error}"
      ];
    }

    // DEBUG
    return [
      'status' => false,
      'message' => 'DEBUG MDL : tambah_profil_sekolah',
      'data' => $post
    ];
  }
}
