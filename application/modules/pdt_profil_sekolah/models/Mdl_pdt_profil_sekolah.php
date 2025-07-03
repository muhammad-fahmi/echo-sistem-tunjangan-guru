<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_pdt_profil_sekolah extends CI_Model
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
  private function query_m_profil_sekolah($data)
  {
    $cur_unor = $this->session->userdata('kode_unor');

    // declare table
    $this->db->from('vm_profil_sekolah');

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
  }

  public function get_datatable_master($data)
  {
    // START DB BUILDER
    $this->query_m_profil_sekolah($data);

    // ORDER
    $order_col = $data['order_column'];
    $order_sort = strtolower($data['order_sort']) === 'desc' ? 'DESC' : 'ASC';
    $this->db->order_by($order_col, $order_sort);

    // LIMIT
    $this->db->limit((int)$data['length'], (int)$data['start']);

    // RESULT DATA
    $query_result = $this->db->get()->result_array();

    // RE-BUILD FOR TOTAL
    $this->query_m_profil_sekolah($data);
    $total_count = $this->db->get()->num_rows();

    // RE-ARRANGE RESULT DATA
    $no = $data['start'] + 1;
    $data_result = [];
    foreach ($query_result as $row) {
      $row['no'] = $no++;

      // tampilan sekolah
      $kode_sekolah = '<div><small style="opacity: 0.65;">' . $row['kode_ukerja'] . '</small></div>';
      $nama_sekolah = '<div>' . $row['ket_ukerja'] . '</div>';
      $row['sekolah_display'] = $kode_sekolah . $nama_sekolah;

      // tampilan alamat
      $kec = '<div><small style="opacity: 0.6;">KEC: ' . check_var($row, 'nama_kecamatan', '-') . '</small></div>';
      $kel = '<div><small style="opacity: 0.6;">KEL: ' . check_var($row, 'nama_kelurahan', '-') . '</small></div>';
      $row['alamat_display'] = '<div>' . $kec . $kel . '</div>' .
        '<div>' . check_var($row, 'alamat', '-') . '</div>';

      // tampilan kontak
      $telp = check_var($row, 'telepon', '-');
      $email = check_var($row, 'email', '-');
      $website = check_var($row, 'website', '-');
      $row['kontak_display'] = '<div><small style="opacity: 0.6;"><i class="fas fa-phone me-1"></i>' . $telp . '</small></div>' .
        '<div>' . $email . '</div>' .
        '<div><small style="opacity: 0.6;"><i class="fas fa-globe me-1"></i>' . $website . '</small></div>';

      // tampilan aksi
      $tombol_update = '<div class="badge bg-warning clickable" onclick="modal(`update_existing_profil`, `' . $row['kode_ukerja'] . '`)"><i class="fas fa-sync me-1"></i>Update</div>';
      $tombol_detail = '<a href="' . site_url('pdt_profil_sekolah/detail_master/' . $row['kode_ukerja']) . '" class="clickable text-white badge bg-secondary"><i class="fas fa-file me-1"></i>Detail</a>';

      $row['aksi_display'] = '<div class="d-grid gap-1">' .
        $tombol_update . $tombol_detail .
        '</div>';

      // store modified data into the result
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
  private function query_r_profil_sekolah($data)
  {
    $cur_unor = $this->session->userdata('kode_unor');

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
  }

  public function get_datatable_usulan($data)
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

      // tampilan alamat
      $kec = '<div><small style="opacity: 0.6;">KEC: ' . check_var($row, 'nama_kecamatan', '-') . '</small></div>';
      $kel = '<div><small style="opacity: 0.6;">KEL: ' . check_var($row, 'nama_kelurahan', '-') . '</small></div>';
      $row['alamat_display'] = '<div>' . $kec . $kel . '</div>' .
        '<div>' . check_var($row, 'alamat', '-') . '</div>';

      // tampilan status
      $row['status_display'] = '<div class="badge bg-' . $row['col_status_dokumen'] . '">' . $row['ket_status_dokumen'] . '</div>';

      // penentuan kondisi
      $is_draft = ($row['status_dokumen'] == 'DRAFT');
      $is_admin = ($cur_kewenangan == '00' || $cur_kewenangan == '02');
      $same_ukerja = ($row['kode_ukerja'] == $cur_unor);
      $is_allowed = ($is_admin || $same_ukerja);

      // tampilan tombol aksi
      $tombol_edit =  ($is_draft && $is_allowed)
        ? '<a href="' . site_url('pdt_profil_sekolah/edit/' . $row['id_dokumen']) . '" class="clickable text-white badge bg-primary"><i class="fas fa-edit me-1"></i>Edit</a>'
        : '';
      $tombol_detail = '<a href="' . site_url('pdt_profil_sekolah/detail/' . $row['id_dokumen']) . '" class="clickable text-white badge bg-secondary"><i class="fas fa-file me-1"></i>Detail</a>';
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
  public function tambah_profil_sekolah($post)
  {
    // FORM VALIDATION
    $this->load->library('form_validation');

    // Define validation rules
    $this->form_validation->set_rules('jenjang', 'Jenjang', 'required');
    $this->form_validation->set_rules('kode_ukerja', 'Nama Sekolah', 'required|numeric');
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

    // CEK EXISTING PROFIL YANG TERVERIFIKASI
    $data_existing  = fetch_num_rows('m_profil_sekolah', [
      'kode_ukerja' => $post['kode_ukerja']
    ]);
    if ($data_existing > 0) return [
      'status' => false,
      'message' => "Sudah ada profil yang terverifikasi untuk sekolah yang dipilih, silahkan lakukan update pada profil tersebut."
    ];


    // TARIK DATA SEKOLAH YG DIPILIH
    $data_sekolah = fetch_row_data('v_ukerja', ['kode_ukerja' => $post['kode_ukerja']], false);
    if ($data_sekolah === false) return [
      'status' => false,
      'message' => 'Maaf, NIP yang dipilih tidak valid lagi.'
    ];

    // CEK DULU APA SUDAH ADA USULAN DGN PERIODE YG SAMA DAN STATUSNYA
    // BUKAN DITOLAK / DITERIMA?
    $existing_usulan = $this->db->from('vr_profil_sekolah')
      ->where('kode_ukerja', $post['kode_ukerja'])
      ->where('status_dokumen <>', 'DITRM')
      ->where('status_dokumen <>', 'DITLK')
      ->where('periode_bln', $post['periode_bln'])
      ->where('periode_thn', $post['periode_thn'])
      ->get()->row_array();

    if (check_var($existing_usulan)) {
      // sudah ada dokumen usulan, output error
      return [
        'status' => false,
        'message' => "Maaf, sudah ada dokumen usulan profil sekolah untuk Periode {$post['periode_bln']}/{$post['periode_thn']} dengan status : {$existing_usulan['ket_status_dokumen']}."
      ];
    }

    // NORMALISASI DATA DARI V_UKERJA KE FORMAT M_PROFIL
    $cur_user = $this->session->userdata('id_user');
    $data_to_save = [
      'periode_bln' => $post['periode_bln'],
      'periode_thn' => $post['periode_thn'],
      'create_on' => em_date('Y-m-d H:i:s'),
      'create_by' => $cur_user,
      'status_dokumen' => 'DRAFT',
      'kode_ukerja' => $post['kode_ukerja'],

      'jenjang' => $post['jenjang'],
      'status' => null, /* data ini tidak ada di m_ukerja */
      'npsn' => null, /* data ini tidak ada di m_ukerja */
      'nss' => null, /* data ini tidak ada di m_ukerja */
      'no_statistik_bangunan' => null, /* data ini tidak ada di m_ukerja */
      'akreditasi' => null, /* data ini tidak ada di m_ukerja */
      'inklusif' => null, /* data ini tidak ada di m_ukerja */
      'alamat' => check_var($data_sekolah, 'alamat_ukerja', null),
      'id_kelurahan' => null, /* data ini tidak ada di m_ukerja */
      'id_kecamatan' => null, /* data ini tidak ada di m_ukerja */
      'kode_pos' => null, /* data ini tidak ada di m_ukerja */
      'lat' => null, /* data ini tidak ada di m_ukerja */
      'long' => null, /* data ini tidak ada di m_ukerja */
      'telepon' => check_var($data_sekolah, 'telp_ukerja', null),
      'website' => check_var($data_sekolah, 'website_ukerja', null),
      'email' => check_var($data_sekolah, 'email_ukerja', null),
      'no_rek_bank' => null, /* data ini tidak ada di m_ukerja */
      'nama_bank' => null, /* data ini tidak ada di m_ukerja */
      'cabang_kcp_unit' => null, /* data ini tidak ada di m_ukerja */
      'nama_wajib_pajak' => null, /* data ini tidak ada di m_ukerja */
      'npwp' => null, /* data ini tidak ada di m_ukerja */
      'no_sk_pendirian' => null, /* data ini tidak ada di m_ukerja */
      'tgl_sk_pendirian' => null, /* data ini tidak ada di m_ukerja */
      'no_sk_izin_operasional' => null, /* data ini tidak ada di m_ukerja */
      'tgl_sk_izin_operasional' => null, /* data ini tidak ada di m_ukerja */
      'luas_tanah' => null, /* data ini tidak ada di m_ukerja */
      'kepemilikan_tanah' => null, /* MILIK / SEWA / PINJAM */ /* data ini tidak ada di m_ukerja */
    ];

    try {
      // START DB OPERATION
      $this->db->trans_begin();

      // SIMPAN DATA BASELINE DOKUMEN USULAN PROFIL SEKOLAH BARU
      $proc = 1;
      $this->db->insert('r_profil_sekolah', $data_to_save);
      $insert_id = $this->db->insert_id();

      // BUAT LOG (KEPERLUAN SISTEM)
      $proc = 2;
      log_generator(
        $cur_user,
        'r_profil_sekolah',
        $insert_id,
        "Melakukan penambahan usulan profil sekolah dengan data sebagai berikut :\n\n" . format_log_view($data_to_save)
      );

      // BUAT LOG DOKUMEN (HISTORY YG DITAMPILKAN SAAT VERIFIKASI / HALAMAN DETAIL)
      $proc = 3;
      $this->db->insert('r_log_dokumen', [
        'jenis_dokumen' => 'PROFIL_SEKOLAH',
        'id_dokumen' => $insert_id,
        'id_user' => $cur_user,
        'datetime' => em_date('Y-m-d H:i:s'),
        'message' => "Menambahkan Usulan Profil Sekolah ({$data_sekolah['ket_ukerja']}) dengan jenjang {$post['jenjang']} untuk periode {$data_to_save['periode_bln']}/{$data_to_save['periode_thn']}."
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
          'message' => "Proses tambah usulan profil sekolah berhasil disimpan dengan status DRAFT.",
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
      'message' => 'DEBUG MDL : tambah_profil_sekolah',
      'data' => $post
    ];
  }

  public function edit_profil_sekolah($data)
  {
    $cur_unor = $this->session->userdata('kode_unor');
    $cur_user = $this->session->userdata('id_user');

    $decryptedID = decrypt_id($data['id_dokumen']);
    $dataset = fetch_row_data('vr_profil_sekolah', ['id_dokumen' => $decryptedID], false);
    if ($dataset === false) return [
      'status' => "Maaf, data yang akan di-edit tidak valid lagi."
    ];

    // CEK STATUS DOKUMEN
    $is_valid = ($dataset['status_dokumen'] == 'DRAFT');
    if (!$is_valid) return [
      'status' => false,
      'message' => "Maaf, Dokumen ini tidak dalam status Draft."
    ];

    // CEK KEWENANGAN
    $same_ukerja = ($dataset['kode_ukerja'] == $cur_unor);
    if (!((is_admin() || $same_ukerja))) return [
      'status' => false,
      'message' => "Maaf, Anda tidak memiliki ijin untuk meng-edit draft dokumen profil sekolah ini."
    ];

    // BANDINGKAN DATA LAMA DENGAN DATA YANG DI POST UTK KEPERLUAN LOG
    $old_data = $dataset;
    $old_data['id_dokumen'] = encrypt_id($old_data['id_dokumen']);
    $new_data = $data;

    // tambah update on dan update by
    $new_data['update_on'] = em_date('Y-m-d H:i:s');
    $new_data['update_by'] = $cur_user;

    $comparison = get_changed_data($old_data, $new_data);

    try {
      $this->db->trans_begin();
      // do your db process here
      if (check_var($comparison, 'after')) {
        // hanya lakukan update apabila ada data yang berubah pada data yang lama
        $proc = 1;
        $this->db->update('r_profil_sekolah', $comparison['after'], [
          'id_dokumen' => $decryptedID
        ]);

        // BUAT LOG SISTEM
        $proc = 2;
        $before_text = format_log_view($comparison['before']);
        $after_text = format_log_view($comparison['after']);
        log_generator(
          $cur_user,
          'r_profil_sekolah',
          $decryptedID,
          "Melakukan update data profil sekolah dengan perubahan data sebagai berikut :\n\n" .
            "BEFORE:\n{$before_text}\n\n" .
            "AFTER:\n{$after_text}"
        );
      }

      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        return [
          'status' => false,
          'message' => "Maaf, terjadi kesalahan dalam proses.\nROLLBACK ISSUE #{$proc}"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        return [
          'status' => true,
          'message' => "Proses simpan draft profil sekolah berhasil.",
          'redirect' => 'edit'
        ];
      }
    } catch (\Throwable $th) {
      $catch_error = sanitize_string($th->getMessage());
      return [
        'status' => false,
        'message' => "Maaf, terjadi kesalahan dalam proses.<br>{$catch_error}"
      ];
    }

    // DEBUG
    return [
      'status' => false,
      'message' => 'DEBUG MDL : edit_profil_sekolah',
      'data' => $data
    ];
  }

  public function update_profil_sekolah($data)
  {
    // VALIDASI DATASET
    $data_existing = fetch_row_data('vm_profil_sekolah', [
      'kode_ukerja' => $data['kode_ukerja']
    ], false);
    if ($data_existing === false) return [
      'status' => false,
      'message' => "Maaf, data yang akan di-update tidak valid lagi."
    ];

    // VALIDASI PERM
    $cur_unor = $this->session->userdata('kode_unor');
    if (!is_admin() && $cur_unor != $data_existing['kode_ukerja']) {
      return [
        'status' => false,
        'message' => "Maaf, Anda tidak memiliki ijin untuk meng-update data profil sekolah ini."
      ];
    }

    // VALIDASI ONGOING USULAN
    $existing_usulan = $this->db->from('vr_profil_sekolah')
      ->where('kode_ukerja', $data_existing['kode_ukerja'])
      ->where('status_dokumen <>', 'DITRM')
      ->where('status_dokumen <>', 'DITLK')
      ->where('periode_bln', $data['periode_bln'])
      ->where('periode_thn', $data['periode_thn'])
      ->order_by('periode_thn', 'DESC')
      ->order_by('periode_bln', 'DESC')
      ->limit(1)->get()->row_array();

    if (check_var($existing_usulan)) return [
      'status' => false,
      'message' => "Maaf, tidak bisa melakukan update karena sudah ada usulan dokumen untuk sekolah yang dipilih ({$existing_usulan['ket_ukerja']}) untuk periode {$existing_usulan['periode_bln']}/{$existing_usulan['periode_thn']} dengan status {$existing_usulan['ket_status_dokumen']}"
    ];

    try {
      $this->db->trans_begin();

      // sesuaikan data utk usulan dokumen baru
      $proc = 1;
      $cur_user = $this->session->userdata('id_user');

      // unset key that do not exist on r_profil_sekolah
      $filtered_data_existing = $data_existing;
      unset($filtered_data_existing['ket_ukerja']);
      unset($filtered_data_existing['ket_status_sekolah']);
      unset($filtered_data_existing['nama_kelurahan']);
      unset($filtered_data_existing['nama_kecamatan']);

      // add additional data that was required to set on r_profil_sekolah
      $new_r_profil_sekolah = $filtered_data_existing;
      $new_r_profil_sekolah['periode_bln'] = $data['periode_bln'];
      $new_r_profil_sekolah['periode_thn'] = $data['periode_thn'];
      $new_r_profil_sekolah['create_on'] = em_date('Y-m-d H:i:s');
      $new_r_profil_sekolah['create_by'] = $cur_user;
      $new_r_profil_sekolah['status_dokumen'] = 'DRAFT';
      $this->db->insert('r_profil_sekolah', $new_r_profil_sekolah);
      $insert_id = $this->db->insert_id();

      // buat log sistem
      $proc = 2;
      $text_insert = format_log_view($new_r_profil_sekolah);
      log_generator(
        $cur_user,
        'r_profil_sekolah',
        $insert_id,
        "Menambahkan dokumen usulan profil sekolah untuk meng-update data yang sudah ada dengan detail sebagai berikut:\n\n{$text_insert}"
      );

      // buat riwayat dokumen
      $proc = 3;
      $periode_text = check_var($data, 'periode_bln', '-') . '/' . check_var($data, 'periode_thn', '-');
      $this->db->insert('r_log_dokumen', [
        'jenis_dokumen' => 'PROFIL_SEKOLAH',
        'id_dokumen' => $insert_id,
        'id_user' => $cur_user,
        'datetime' => em_date('Y-m-d H:i:s'),
        'message' => "Mengajukan usulan update data pada Profil Sekolah ({$data_existing['ket_ukerja']}) dengan jenjang {$data['jenjang']} untuk periode {$periode_text}."
      ]);

      if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return [
          'status' => false,
          'message' => "Maaf, terjadi kesalahan dalam proses.\nROLLBACK ISSUE #{$proc}"
        ];
      } else {
        $this->db->trans_commit();
        return [
          'status' => true,
          'message' => "Usulan Update Profil Sekolah berhasil dibuat dengan status Draft."
        ];
      }
    } catch (\Throwable $th) {
      $catch_error = sanitize_string($th->getMessage());
      return [
        'status' => false,
        'message' => "Maaf, terjadi kesalahan saat proses.\n{$catch_error}"
      ];
    }

    // DEBUG
    return [
      'status' => false,
      'message' => 'DEBUG MDL : update_profil_sekolah',
      'data' => $data
    ];
  }

  public function submit_profil_sekolah($data)
  {
    $this->load->library('form_validation');

    // Define validation rules
    $this->form_validation->set_rules('jenjang', 'Jenjang', 'required');
    $this->form_validation->set_rules('status', 'Status', 'required');
    $this->form_validation->set_rules('npsn', 'NPSN', 'required');
    $this->form_validation->set_rules('nss', 'NSS', 'required');
    $this->form_validation->set_rules('no_statistik_bangunan', 'No. Statistik Bangunan', 'required');
    $this->form_validation->set_rules('akreditasi', 'Akreaditasi', 'required');
    $this->form_validation->set_rules('inklusif', 'Inklusif', 'required');
    $this->form_validation->set_rules('alamat', 'Alamat', 'required');
    $this->form_validation->set_rules('id_kelurahan', 'Kelurahan', 'required');
    $this->form_validation->set_rules('id_kecamatan', 'Kecamatan', 'required');
    $this->form_validation->set_rules('kode_pos', 'Kode POS', 'required');
    $this->form_validation->set_rules('lat', 'Latitude', 'required');
    $this->form_validation->set_rules('long', 'Longitude', 'required');
    $this->form_validation->set_rules('telepon', 'No. Telp', 'required');
    $this->form_validation->set_rules('website', 'Website', 'required');
    $this->form_validation->set_rules('email', 'E-mail', 'required');
    $this->form_validation->set_rules('no_rek_bank', 'No. Rekening Bank', 'required');
    $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'required');
    $this->form_validation->set_rules('cabang_kcp_unit', 'Cabang KCP Unit', 'required');
    $this->form_validation->set_rules('nama_wajib_pajak', 'Nama Wajib Pajak', 'required');
    $this->form_validation->set_rules('npwp', 'NPWP', 'required');
    $this->form_validation->set_rules('no_sk_pendirian', 'No. SK Pendirian', 'required');
    $this->form_validation->set_rules('tgl_sk_pendirian', 'Tgl. SK Pendirian', 'required');
    $this->form_validation->set_rules('no_sk_izin_operasional', 'No. SK Izin Operasional', 'required');
    $this->form_validation->set_rules('tgl_sk_izin_operasional', 'Tgl. SK Izin Operasional', 'required');
    $this->form_validation->set_rules('no_sk_pendirian', 'No. SK Pendirian', 'required');
    $this->form_validation->set_rules('luas_tanah', 'Luas Tanah', 'required');
    $this->form_validation->set_rules('kepemilikan_tanah', 'Kepemilikan Tanah', 'required');

    // Validate the input data
    if ($this->form_validation->run() === FALSE) {
      // Get raw error array (field => message)
      $error_value = $this->form_validation->error_array();

      // Optional: Also format for general display
      $error_text = '<ul class="mb-0">';
      foreach ($error_value as $field => $error) {
        $error_text .= "<li>{$error}</li>";
      }
      $error_text .= '</ul>';

      // Return response with error details
      return [
        'status' => false,
        'message' => "Maaf, tidak bisa melakukan submit karena form tidak valid.\n{$error_text}",
        'error_value' => $error_value
      ];
    }

    $cur_unor = $this->session->userdata('kode_unor');
    $cur_user = $this->session->userdata('id_user');

    $decryptedID = decrypt_id($data['id_dokumen']);
    $dataset = fetch_row_data('vr_profil_sekolah', ['id_dokumen' => $decryptedID], false);
    if ($dataset === false) return [
      'status' => "Maaf, data yang akan di-edit tidak valid lagi."
    ];

    // CEK STATUS DOKUMEN
    $is_valid = ($dataset['status_dokumen'] == 'DRAFT');
    if (!$is_valid) return [
      'status' => false,
      'message' => "Maaf, Dokumen ini tidak dalam status Draft. Tidak bisa melakukan submit."
    ];

    // CEK KEWENANGAN
    $same_ukerja = ($dataset['kode_ukerja'] == $cur_unor);
    if (!((is_admin() || $same_ukerja))) return [
      'status' => false,
      'message' => "Maaf, Anda tidak memiliki ijin untuk submit draft dokumen profil sekolah ini."
    ];

    // BANDINGKAN DATA LAMA DENGAN DATA YANG DI POST UTK KEPERLUAN LOG
    $old_data = $dataset;
    $old_data['id_dokumen'] = encrypt_id($old_data['id_dokumen']);
    $new_data = $data;

    // tambah status baru
    $new_data['status_dokumen'] = 'VRFDD';

    // tambah update on dan update by
    $new_data['update_on'] = em_date('Y-m-d H:i:s');
    $new_data['update_by'] = $cur_user;

    $comparison = get_changed_data($old_data, $new_data);

    try {
      $this->db->trans_begin();
      // do your db process here
      if (check_var($comparison, 'after')) {
        // hanya lakukan update apabila ada data yang berubah pada data yang lama
        $proc = 1;
        $this->db->update('r_profil_sekolah', $comparison['after'], [
          'id_dokumen' => $decryptedID
        ]);

        // BUAT LOG SISTEM
        $proc = 2;
        $before_text = format_log_view($comparison['before']);
        $after_text = format_log_view($comparison['after']);
        log_generator(
          $cur_user,
          'r_profil_sekolah',
          $decryptedID,
          "Melakukan submit data profil sekolah dengan perubahan data sebagai berikut :\n\n" .
            "BEFORE:\n{$before_text}\n\n" .
            "AFTER:\n{$after_text}"
        );

        // BUAT RIWAYAT DOKUMEN
        $proc = 3;
        $periode_text = check_var($dataset, 'periode_bln', '-') . '/' . check_var($dataset, 'periode_thn', '-');
        $this->db->insert('r_log_dokumen', [
          'jenis_dokumen' => 'PROFIL_SEKOLAH',
          'id_dokumen' => $decryptedID,
          'id_user' => $cur_user,
          'datetime' => em_date('Y-m-d H:i:s'),
          'message' => "Melakukan Submit Usulan Profil Sekolah ({$dataset['ket_ukerja']}) dengan jenjang {$data['jenjang']} untuk periode {$periode_text}."
        ]);
      }

      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        return [
          'status' => false,
          'message' => "Maaf, terjadi kesalahan dalam proses.\nROLLBACK ISSUE #{$proc}"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        return [
          'status' => true,
          'message' => "Proses submit draft profil sekolah berhasil.",
          'redirect' => 'detail'
        ];
      }
    } catch (\Throwable $th) {
      $catch_error = sanitize_string($th->getMessage());
      return [
        'status' => false,
        'message' => "Maaf, terjadi kesalahan dalam proses.<br>{$catch_error}"
      ];
    }

    // DEBUG
    return [
      'status' => false,
      'message' => 'DEBUG MDL : submit_profil_sekolah',
      'data' => $data
    ];
  }

  public function delete_profil_sekolah($data)
  {
    $cur_user = $this->session->userdata('id_user');
    $cur_unor = $this->session->userdata('kode_unor');

    // FORM VALIDATION
    $this->load->library('form_validation');

    // Define validation rules
    $this->form_validation->set_rules('id_dokumen', 'ID Dokumen Usulan Profil Sekolah', 'required');

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
    $dataset = fetch_row_data('vr_profil_sekolah', ['id_dokumen' => $decryptedID], false);
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
      $this->db->delete('r_profil_sekolah', [
        'id_dokumen' => $decryptedID
      ]);

      // BUAT LOG (KEPERLUAN SISTEM)
      $proc = 2;
      log_generator(
        $cur_user,
        'r_profil_sekolah',
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
          'message' => "Dokumen usulan profil sekolah berhasil dihapus",
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
      'message' => 'DEBUG MDL : delete_profil_sekolah',
      'data' => $data
    ];
  }
}
