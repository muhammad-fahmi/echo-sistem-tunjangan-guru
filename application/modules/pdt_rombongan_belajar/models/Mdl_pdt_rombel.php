<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_pdt_rombel extends CI_Model
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

  /// |---------------------------------------------------------
  /// | >> QUERY MASTER DATATABLE
  /// |---------------------------------------------------------
  public function query_data_rombel($data)
  {
    // $cur_unor = $this->session->userdata('kode_unor');

    // declare table
    $this->db->from('v_rombongan_belajar');

    // where condition
    if (check_var($data, 'search')) {
      $this->db->group_start()
        ->like('ket_jenjang', $data['search'])
        ->or_like('ket_kelas', $data['search'])
        ->or_like('nama_rombel', $data['search'])
        ->group_end();
    }

    if (check_var($data['id_sekolah'])) {
      $this->db->where('id_sekolah', $data['id_sekolah']);
    }
  }

  public function query_data_siswa($data)
  {
    // $cur_unor = $this->session->userdata('kode_unor');

    // declare table
    $this->db->from('v_peserta_didik_rombel');

    // where condition
    if (check_var($data, 'search')) {
      $this->db->group_start()
        ->like('nama', $data['search'])
        ->or_like('nisn', $data['search'])
        ->or_like('ket_jns_kelamin', $data['search'])
        ->or_like('ket_agama', $data['search'])
        ->group_end();
    }

    if (check_var($data['id_rombel'])) {
      $this->db->where('id_rombel', $data['id_rombel']);
    }
  }

  /// |---------------------------------------------------------
  /// | >> PROSES MODEL GET DATA
  /// |---------------------------------------------------------
  public function get_datatable($data)
  {
    $this->query_data_rombel($data);

    // ORDER
    $order_col = $data['order_column'];
    $order_sort = strtolower($data['order_sort']) === 'desc' ? 'DESC' : 'ASC';
    $this->db->order_by($order_col, $order_sort);

    // LIMIT
    $this->db->limit((int)$data['length'], (int)$data['start']);

    // RESULT DATA
    $query_result = $this->db->get()->result_array();

    // RE-BUILD FOR TOTAL
    $this->query_data_rombel($data);
    $total_count = $this->db->get()->num_rows();

    $no = $data['start'] + 1;
    $data_result = [];
    foreach ($query_result as $row) {
      $row['no'] = $no++;

      // tampilan aksi
      $encrypt_id = encrypt_id($row['id']);
      $tombol_update = '<a href="' . site_url('pdt_rombongan_belajar/detail/') . $encrypt_id . '" class="badge bg-warning clickable text-white me-1 py-1"><i class="fas fa-upload"></i> Update</a>';
      $tombol_delete = ($this->session->userdata('kewenangan') == '10') ?
        '<div onclick="modal(`' . $encrypt_id . '`, `delete_rombongan_belajar`)" class="badge bg-danger clickable me-1 py-1" title="Hapus"><i class="fas fa-trash"></i> Hapus</div>'
        : '';

      $row['aksi_display'] = '<div class="d-grid gap-1">' .
        $tombol_update . $tombol_delete
        . '</div>';

      // store modified data into the result
      $data_result[] = $row;
    }

    // kembalikan data yang didapat ke controller
    return array(
      'total' => $total_count,
      'filtered' => $total_count,
      'data' => $data_result,
      'draw' => (int)$data['draw']
    );
  }

  public function get_datatable_siswa($data)
  {
    // START DB BUILDER
    $this->query_data_siswa($data);

    // ORDER
    $order_col = $data['order_column'];
    $order_sort = strtolower($data['order_sort']) === 'desc' ? 'DESC' : 'ASC';
    $this->db->order_by($order_col, $order_sort);

    // LIMIT
    $this->db->limit((int)$data['length'], (int)$data['start']);

    // RESULT DATA
    $query_result = $this->db->get()->result_array();

    // RE-BUILD FOR TOTAL
    $this->query_data_siswa($data);
    $total_count = $this->db->get()->num_rows();

    $no = $data['start'] + 1;
    $data_result = [];
    foreach ($query_result as $row) {
      $row['no'] = $no++;

      // tampilan aksi
      $encrypt_id = encrypt_id($row['id_siswa']);
      $tombol_detail = '<a href="' . site_url('pdt_peserta_didik/detail/') . $encrypt_id . '" class="badge bg-secondary clickable text-white me-1 py-1"><i class="fas fa-eye"></i> Detail</a>';
      $tombol_delete = ($this->session->userdata('kewenangan') == '10') ?
        '<div onclick="modal(`' . $encrypt_id . '`, `delete_siswa_rombel`)" class="badge bg-danger clickable me-1 py-1" title="Hapus"><i class="fas fa-trash"></i> Hapus</div>'
        : '';

      $row['aksi_display'] = '<div class="d-grid gap-1">' .
        $tombol_detail . $tombol_delete
        . '</div>';

      // store modified data into the result
      $data_result[] = $row;
    }

    // kembalikan data yang didapat ke controller
    return array(
      'total' => $total_count,
      'filtered' => $total_count,
      'data' => $data_result,
      'draw' => (int)$data['draw']
    );
  }

  /// |---------------------------------------------------------
  /// | >> PROSES MODEL CRUD
  /// |---------------------------------------------------------
  public function save_rombel($data)
  {
    // FORM VALIDATION
    $this->load->library('form_validation');

    // Define validation rules
    $this->form_validation->set_rules('id_sekolah', 'ID Sekolah', 'required');
    $this->form_validation->set_rules('ket_sekolah', 'Ket. Sekolah', 'required');
    $this->form_validation->set_rules('id_jenjang', 'ID Jenjang', 'required');
    $this->form_validation->set_rules('id_kelas', 'ID Kelas', 'required');
    $this->form_validation->set_rules('nama_rombel', 'Nama Rombel', 'required');

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

    // cek apakah data sudah ada di database
    $is_rombel_exist = fetch_row_data(
      'r_rombongan_belajar',
      [
        'kelas' => $data['kelas'],
        'nama_rombel' => $data['nama_rombel']
      ],
      false
    );
    if ($is_rombel_exist) {
      return [
        'status' => false,
        'message' => 'Maaf, rombongan belajar sudah terdaftar dalam database.'
      ];
    }

    $cur_user = $this->session->userdata('id_user');
    try {
      //start db transaction
      $this->db->trans_begin();
      //cek apakah insert atau update
      if (!$is_rombel_exist) {
        //insert data
        $this->db->insert("r_rombongan_belajar", $data);
        $insert_id = $this->db->insert_id();

        // BUATKAN LOG UTK SISTEM (INSERT)
        log_generator(
          $cur_user,
          'r_rombongan_belajar',
          $insert_id,
          "Melakukan penambahan data rombongan belajar baru dengan data sebagai berikut :\n\n" . format_log_view($data)
        );
      } else {
        //update data
        $this->db->where(["id" => $data["id"]])->update("r_rombongan_belajar", $data);

        // BUATKAN LOG UTK SISTEM (UPDATE)
        log_generator(
          $cur_user,
          'r_rombongan_belajar',
          $data['id'],
          "Melakukan perubahan data rombongan belajar dengan data sebagai berikut :\n\n" . format_log_view($data)
        );
      }

      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        $res = [
          'status' => false,
          'message' => "Data rombongan belajar gagal disimpan!"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        $res = [
          'status' => true,
          'message' => "Data rombongan belajar berhasil disimpan!"
        ];
      }
    } catch (\Throwable $th) {
      $res = [
        'status' => false,
        'message' => "Proses simpan rombongan belajar Error! Error message : " . $th->getMessage()
      ];
    }
    return $res;
  }

  public function save_siswa_rombel($data)
  {
    // FORM VALIDATION
    $this->load->library('form_validation');

    // Define validation rules
    $this->form_validation->set_rules('id_rombel', 'ID Rombel', 'required');
    $this->form_validation->set_rules('id_siswa', 'ID Siswa', 'required');

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

    // cek apakah data sudah ada di database
    $is_siswa_exist = fetch_row_data(
      'r_peserta_didik_rombel',
      [
        'id_siswa' => $data['id_siswa'],
        'id_rombel' => $data['id_rombel']
      ],
      false
    );
    if ($is_siswa_exist) {
      return [
        'status' => false,
        // 'message' => 'Maaf, siswa di rombongan belajar ' . $data['id_rombel'] . ' sudah terdaftar dalam database.'
        'message' => 'Maaf, Siswa (Peserta Didik) sudah terdaftar di rombongan belajar dalam database.'
      ];
    }

    $cur_user = $this->session->userdata('id_user');
    try {
      //start db transaction
      $this->db->trans_begin();
      //cek apakah insert atau update
      if (!$is_siswa_exist) {
        //insert data
        $this->db->insert("r_peserta_didik_rombel", $data);
        $insert_id = $this->db->insert_id();

        // BUATKAN LOG UTK SISTEM (INSERT)
        log_generator(
          $cur_user,
          'r_peserta_didik_rombel',
          $insert_id,
          "Melakukan penambahan data siswa baru di rombel dengan data sebagai berikut :\n\n" . format_log_view($data)
        );
      } else {
        //update data
        $this->db->where(["id_siswa" => $data["id_siswa"]])->update("r_peserta_didik_rombel", $data);

        // BUATKAN LOG UTK SISTEM (UPDATE)
        log_generator(
          $cur_user,
          'r_peserta_didik_rombel',
          $data['id_siswa'],
          "Melakukan perubahan data siswa di rombel dengan data sebagai berikut :\n\n" . format_log_view($data)
        );
      }

      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        $res = [
          'status' => false,
          'message' => "Data siswa di rombel gagal disimpan!"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        $res = [
          'status' => true,
          'message' => "Data siswa di rombel berhasil disimpan!"
        ];
      }
    } catch (\Throwable $th) {
      $res = [
        'status' => false,
        'message' => "Proses simpan rombongan belajar Error! Error message : " . $th->getMessage()
      ];
    }
    return $res;
  }

  public function delete_rombel($data)
  {
    // FORM VALIDATION
    $this->load->library('form_validation');

    // Define validation rules
    $this->form_validation->set_rules('id', 'ID Rombel', 'required');

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

    $cur_user = $this->session->userdata('id_user');
    try {
      $this->db->trans_begin();
      $this->db->where(["id" => $data["id"]])->delete("r_rombongan_belajar");
      $this->db->where(["id_rombel" => $data["id"]])->delete("r_peserta_didik_rombel");

      // BUATKAN LOG UTK SISTEM (DELETE)
      // LOG UTK ROMBEL
      log_generator(
        $cur_user,
        'r_rombongan_belajar',
        $data['id'],
        "Melakukan penghapusan data rombongan belajar sebagai berikut :\n\n" . format_log_view($data)
      );
      // LOG UTK PESERTA DIDIK
      log_generator(
        $cur_user,
        'r_peserta_didik_rombel',
        $data['id'],
        "Melakukan penghapusan data peserta didik di rombongan belajar sebagai berikut :\n\n" . format_log_view($data)
      );
      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        $res = [
          'status' => false,
          'message' => "Data Rombongan Belajar gagal dihapus!"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        $res = [
          'status' => true,
          'message' => "Data Rombongan Belajar berhasil dihapus!"
        ];
      }
    } catch (\Throwable $th) {
      $res = [
        'status' => false,
        'message' => "Proses hapus rombongan belajar error! Error message : " . $th->getMessage()
      ];
    }
    return $res;
  }

  public function delete_siswa_rombel($data)
  {
    // FORM VALIDATION
    $this->load->library('form_validation');

    // Define validation rules
    $this->form_validation->set_rules('id_siswa', 'ID Siswa', 'required');

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

    $cur_user = $this->session->userdata('id_user');
    try {
      $this->db->trans_begin();
      $this->db->where(["id_siswa" => $data["id_siswa"]])->delete("r_peserta_didik_rombel");

      // BUATKAN LOG UTK SISTEM (DELETE)
      log_generator(
        $cur_user,
        'r_peserta_didik_rombel',
        $data['id_siswa'],
        "Melakukan penghapusan data Peserta Didik " . $data['id_siswa'] . " di rombongan belajar sebagai berikut :\n\n" . format_log_view($data)
      );
      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        $res = [
          'status' => false,
          'message' => "Data Peserta Didik di rombel gagal dihapus!"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        $res = [
          'status' => true,
          'message' => "Data Peserta Didik di rombel berhasil dihapus!"
        ];
      }
    } catch (\Throwable $th) {
      $res = [
        'status' => false,
        'message' => "Proses hapus Peserta Didik di rombel error! Error message : " . $th->getMessage()
      ];
    }
    return $res;
  }
}
