<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_pdt_profil_kepsek extends CI_Model
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
  /// | >> DATATABLE M PROFIL KEPSEK
  /// |----------------------------------------------------------------------
  private function query_m_profil_kepsek($data)
  {
    $cur_kewenangan = $this->session->userdata('kewenangan');
    $cur_unor = $this->session->userdata('kode_unor');

    // declare table
    $this->db->from('m_profil_kepsek');

    // where condition
    if (check_var($data, 'search')) {
      $this->db->group_start()
        ->like('nip', $data['search'])
        ->or_like('nama', $data['search'])
        ->or_like('alamat_saat_ini', $data['search'])
        ->group_end();
    }

    if ($cur_kewenangan == '10') {
      // tambah kondisi kode_ukerja karena yang login adalah admin sekolah
      $this->db->where(['kode_ukerja' => $cur_unor]);
    }
  }

  public function get_datatable_master($data)
  {
    // START DB BUILDER
    $this->query_m_profil_kepsek($data);

    // ORDER
    $order_col = $data['order_column'];
    $order_sort = strtolower($data['order_sort']) === 'desc' ? 'DESC' : 'ASC';
    $this->db->order_by($order_col, $order_sort);

    // LIMIT
    $this->db->limit((int)$data['length'], (int)$data['start']);

    // RESULT DATA
    $query_result = $this->db->get()->result_array();

    // RE-BUILD FOR TOTAL
    $this->query_m_profil_kepsek($data);
    $total_count = $this->db->get()->num_rows();

    // RE-ARRANGE RESULT DATA
    $no = $data['start'] + 1;
    $data_result = [];
    foreach ($query_result as $row) {
      $row['no'] = $no++;
      $row['something'] = 'something'; // Add your custom column
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
  /// | >> DATATABLE R PROFIL KEPSEK
  /// |----------------------------------------------------------------------
  private function query_r_profil_kepsek($data)
  {
    $cur_kewenangan = $this->session->userdata('kewenangan');
    $cur_unor = $this->session->userdata('kode_unor');

    // declare table
    $this->db->from('vr_profil_kepsek');

    // where condition
    if (check_var($data, 'search')) {
      $this->db->group_start()
        ->like('nip', $data['search'])
        ->or_like('nama', $data['search'])
        ->or_like('alamat_saat_ini', $data['search'])
        ->group_end();
    }

    if ($cur_kewenangan == '10') {
      // tambah kondisi kode_ukerja karena yang login adalah admin sekolah
      $this->db->where(['kode_ukerja' => $cur_unor]);
    }
  }

  public function get_datatable_usulan($data)
  {
    // START DB BUILDER
    $this->query_r_profil_kepsek($data);

    // ORDER
    $order_col = $data['order_column'];
    $order_sort = strtolower($data['order_sort']) === 'desc' ? 'DESC' : 'ASC';
    $this->db->order_by($order_col, $order_sort);

    // LIMIT
    $this->db->limit((int)$data['length'], (int)$data['start']);

    // RESULT DATA
    $query_result = $this->db->get()->result_array();

    // RE-BUILD FOR TOTAL
    $this->query_r_profil_kepsek($data);
    $total_count = $this->db->get()->num_rows();

    // RE-ARRANGE RESULT DATA
    $no = $data['start'] + 1;
    $data_result = [];

    $cur_kewenangan = $this->session->userdata('kewenangan');
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

      // tampilan kepsek
      $nip = '<div><small style="opacity: 0.65;">' . $row['nip'] . '</small></div>';
      $nama = '<div>' . $row['nama'] . '</div>';
      $row['kepsek_display'] = $nip . $nama;

      // tampilan status
      $row['status_display'] = '<div class="badge bg-' . $row['col_status_dokumen'] . '">' . $row['ket_status_dokumen'] . '</div>';

      // penentuan kondisi
      $is_draft = ($row['status_dokumen'] == 'DRAFT');
      $is_admin = ($cur_kewenangan == '00' || $cur_kewenangan == '02');
      $same_ukerja = ($row['kode_ukerja'] == $cur_unor);
      $is_allowed = ($is_admin || $same_ukerja);

      // tampilan tombol aksi
      $tombol_edit =  ($is_draft && $is_allowed)
        ? '<a href="' . site_url('pdt_profil_kepsek/edit/' . $row['id_dokumen']) . 'S" class="clickable text-white badge bg-primary"><i class="fas fa-edit me-1"></i>Edit</a>'
        : '';
      // $tombol_detail = '<a href="' . site_url('pdt_profil_kepsek/detail/' . $row['id_dokumen']) . '" class="clickable text-white badge bg-secondary"><i class="fas fa-file me-1"></i>Detail</a>';
      $tombol_detail = '<a href="#" onclick="on_dev()" class="clickable text-white badge bg-secondary"><i class="fas fa-file me-1"></i>Detail</a>';
      $tombol_delete = ($is_draft && $is_allowed)
        ? '<span class="clickable text-white badge bg-danger" onclick="modal(`hapus_usulan_profil`, `' . $row['id_dokumen'] . '`)"><i class="fas fa-trash me-1"></i>Hapus</span>'
        : '';
      $row['aksi_display'] = '<div class="d-grid gap-1">' .
        $tombol_edit . $tombol_detail . $tombol_delete .
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
  public function tambah_profil_kepsek($post)
  {
    // FORM VALIDATION
    $this->load->library('form_validation');

    // Define validation rules
    $this->form_validation->set_rules('nip', 'NIP', 'required|numeric');
    $this->form_validation->set_rules('kode_ukerja', 'Sekolah', 'required|numeric');
    $this->form_validation->set_rules('periode_bln', 'Periode (Bulan)', 'required|numeric');
    $this->form_validation->set_rules('periode_thn', 'Periode (Tahun)', 'required|numeric');

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

    // TARIK DATA PEGAWAI YG DIPILIH
    $data_pegawai = fetch_row_data('v_pns', ['nip' => $post['nip']], false);
    if ($data_pegawai === false) return [
      'status' => false,
      'message' => 'Maaf, NIP yang dipilih tidak valid lagi.'
    ];

    // NORMALISASI DATA DARI V_PNS KE FORMAT M_PROFIL
    $cur_user = $this->session->userdata('id_user');
    $data_to_save = [
      'periode_bln' => $post['periode_bln'],
      'periode_thn' => $post['periode_thn'],
      'create_on' => em_date('Y-m-d H:i:s'),
      'create_by' => $cur_user,
      'status_dokumen' => 'DRAFT',
      'kode_ukerja' => $post['kode_ukerja'],
      'nip' => $post['nip'],
      'nama' => trim($data_pegawai['nama_lengkap']),
      'nuptr' => null, /* sumber di v_pns (?) */
      'nurs' => null, /* sumber di v_pns (?) */
      'nrg' => null, /* sumber di v_pns (?) */
      'nik' => check_var($data_pegawai, 'nik', null),
      'tgl_lahir' => check_var($data_pegawai, 'tgl_lahir', null),
      'jenis_kelamin' => check_var($data_pegawai, 'j_kelamin', null),
      'alamat_saat_ini' => check_var($data_pegawai, 'tt_alamat', null),
      'status_pernikahan' => check_var($data_pegawai, 'ket_kawin', null),
      'kode_didik' => check_var($data_pegawai, 'kode_didik', null),
      'pendidikan' => check_var($data_pegawai, 'ket_didik', null),
      'no_sertifikat_pendidik' => null, /* sumber di v_pns (?) */
      'no_sertifikat_gp' => null, /* sumber di v_pns (?) */
      'no_sertifikat_crs' => null, /* sumber di v_pns (?) */
      'no_rek_bank' => null, /* sumber di v_pns (?) */
      'npwp' => check_var($data_pegawai, 'no_npwp', null),
      'menerima_ttp_insentif' => null, /* sumber di v_pns (?) */
      'status' => check_var($data_pegawai, 'kode_status', null),
      'email' => check_var($data_pegawai, 'email', null),
      'no_hp' => check_var($data_pegawai, 'no_hp', null),
      'kode_agama' => check_var($data_pegawai, 'kode_agama', null),
      'periode_ke' => null, /* sumber di v_pns (?) */
      'masa_penugasan_mulai' => null, /* sumber di v_pns (?) */
      'masa_penugasan_selesai' => null, /* sumber di v_pns (?) */
      's_aktif' => null /* sumber di v_pns (?) */
    ];

    try {
      // START DB OPERATION
      $this->db->trans_begin();

      // SIMPAN DATA BASELINE DOKUMEN USULAN KEPSEK BARU
      $proc = 1;
      $this->db->insert('r_profil_kepsek', $data_to_save);
      $insert_id = $this->db->insert_id();

      // BUAT LOG (KEPERLUAN SISTEM)
      $proc = 2;
      log_generator(
        $cur_user,
        'r_profil_kepsek',
        $insert_id,
        "Melakukan penambahan usulan profil kepsek dengan data sebagai berikut :\n\n" . format_log_view($data_to_save)
      );

      // BUAT LOG DOKUMEN (HISTORY YG DITAMPILKAN SAAT VERIFIKASI / HALAMAN DETAIL)
      $proc = 3;
      $this->db->insert('r_log_dokumen', [
        'jenis_dokumen' => 'PROFIL_KEPSEK',
        'id_dokumen' => $insert_id,
        'id_user' => $cur_user,
        'datetime' => em_date('Y-m-d H:i:s'),
        'message' => "Menambahkan Usulan Profil Kepsek dengan NIP : {$data_to_save['nip']} a/n {$data_to_save['nama']} untuk periode {$data_to_save['periode_bln']}/{$data_to_save['periode_thn']}."
      ]);

      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        return [
          'status' => false,
          'message' => "Maaf, proses mengalami error.\nROLLBACK ISSUE #{$proc}"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        return [
          'status' => true,
          'message' => "Proses tambah usulan profil kepala sekolah berhasil disimpan dengan status DRAFT. Anda akan di re-direct ke halaman dokumen form usulan profil kepala sekolah.",
          'ID' => encrypt_id($insert_id)
        ];
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
      'message' => 'DEBUG MDL : tambah_profil_kepsek',
      'data' => $post
    ];
  }

  public function edit_profil_kepsek($data)
  {
    // DEBUG
    return [
      'status' => false,
      'message' => 'DEBUG MDL : edit_profil_kepsek',
      'data' => $data
    ];
  }

  public function update_profil_kepsek($data)
  {
    // DEBUG
    return [
      'status' => false,
      'message' => 'DEBUG MDL : update_profil_kepsek',
      'data' => $data
    ];
  }

  public function submit_profil_kepsek($data)
  {
    // DEBUG
    return [
      'status' => false,
      'message' => 'DEBUG MDL : edit_profil_kepsek',
      'data' => $data
    ];
  }

  public function delete_profil_kepsek($data)
  {
    $cur_user = $this->session->userdata('id_user');
    $cur_unor = $this->session->userdata('kode_unor');

    // FORM VALIDATION
    $this->load->library('form_validation');

    // Define validation rules
    $this->form_validation->set_rules('id_dokumen', 'ID Dokumen Usulan Profil Kepala Sekolah', 'required');

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

    // VALIDASI DATA EXISTING
    $decryptedID = decrypt_id($data['id_dokumen']);
    $dataset = fetch_row_data('vr_profil_kepsek', ['id_dokumen' => $decryptedID], false);
    if ($dataset === false) return [
      'status' => false,
      'message' => "Maaf, data yang akan dihapus tidak valid lagi."
    ];

    // PASTIKAN BERHAK MENGHAPUS
    $same_ukerja = ($cur_unor == $dataset['kode_ukerja']);
    if (!(is_admin() || $same_ukerja)) return [
      'status' => false,
      'message' => "Maaf, Anda tidak memiliki ijin untuk menghapus dokumen ini."
    ];

    try {
      // START DB OPERATION
      $this->db->trans_begin();

      // HAPUS DATA 
      $proc = 1;
      $this->db->delete('r_profil_kepsek', [
        'id_dokumen' => $decryptedID
      ]);

      // BUAT LOG (KEPERLUAN SISTEM)
      $proc = 2;
      log_generator(
        $cur_user,
        'r_profil_kepsek',
        $decryptedID,
        "Melakukan penghapusan data sebagai berikut :\n\n" . format_log_view($dataset)
      );

      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        return [
          'status' => false,
          'message' => "Maaf, proses mengalami error.\nROLLBACK ISSUE #{$proc}"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        return [
          'status' => true,
          'message' => "Dokumen usulan profil kepala sekolah berhasil dihapus",
        ];
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
      'message' => 'DEBUG MDL : delete_profil_kepsek',
      'data' => $data
    ];
  }
}
