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

  /* fungsi untuk menarik data dari DB dan konversi ke dataset untuk jquery datatable */
  public function get_datatable($data)
  {
    // lakukan filtering data
    // deklarasi where condition
    $where_search = (isset_nn_nes($data['search']))
      ? "AND (ket_jenjang LIKE '%$data[search]%' 
      OR ket_kelas LIKE '%$data[search]%' 
      OR nama_rombel LIKE '%$data[search]%')"
      : "";

    /* kalau ada tambahan where condition bisa add lagi di atas */
    // deklarasi query yang digunakan
    $query_result = $this->db->query("SELECT * FROM `v_rombongan_belajar` 
      WHERE `id` IS NOT NULL $where_search 
      ORDER BY $data[order_column] $data[order_sort] 
      LIMIT $data[start], $data[length]");
    $query_total = $this->db->query("SELECT * FROM `v_rombongan_belajar` 
      WHERE `id` IS NOT NULL $where_search");
    // cari total hasil
    $total_count = 0;
    while ($row = $query_total->unbuffered_row()) {
      $total_count += 1;
    }
    // cari data result + penomoran
    $no = $data['start'] + 1;
    $index = 0;
    $data_result = array();
    while ($row = $query_result->unbuffered_row('array')) {
      /// |----------------------------------------------------------------------
      /// | PENATAAN DATA SEBELUM DIMASUKKAN KE DALAM RESULT_ARRAY
      /// |----------------------------------------------------------------------
      $data_result[$index] = $row;
      $data_result[$index]['no'] = $no;
      $data_result[$index]['jenjang'] = isset_nn_nes($row['jenjang'], '-');
      $data_result[$index]['kelas'] = isset_nn_nes($row['kelas'], '-');
      $data_result[$index]['id_sekolah'] = isset_nn_nes($row['id_sekolah'], '-');
      $data_result[$index]['ket_sekolah'] = isset_nn_nes($row['ket_sekolah'], '-');
      $data_result[$index]['ket_jenjang'] = isset_nn_nes($row['ket_jenjang'], '-');
      $data_result[$index]['ket_kelas'] = isset_nn_nes($row['ket_kelas'], '-');
      $data_result[$index]['nama_rombel'] = isset_nn_nes($row['nama_rombel'], '-');
      $data_result[$index]['id_tahun_ajaran'] = isset_nn_nes($row['id_tahun_ajaran'], '-');
      $data_result[$index]['id'] = isset_nn_nes(encrypt_id($row['id']), '-');

      $no += 1;
      $index += 1;
    }
    // kembalikan data yang didapat ke controller
    return array(
      'total' => $total_count,
      'filtered' => $total_count,
      'data' => $data_result,
      'draw' => $data['draw']
    );
  }

  public function get_datatable_siswa($data)
  {
    // lakukan filtering data
    // deklarasi where condition
    $where_search = (isset_nn_nes($data['search']))
      ? "AND (nama LIKE '%$data[search]%' 
      OR nisn LIKE '%$data[search]%' 
      OR ket_jns_kelamin LIKE '%$data[search]%' 
      OR ket_agama LIKE '%$data[search]%')"
      : "";

    /* kalau ada tambahan where condition bisa add lagi di atas */
    // deklarasi query yang digunakan
    $query_result = $this->db->query("SELECT * FROM `v_peserta_didik_rombel` 
      WHERE `id_siswa` IS NOT NULL $where_search 
      ORDER BY $data[order_column] $data[order_sort] 
      LIMIT $data[start], $data[length]");
    $query_total = $this->db->query("SELECT * FROM `v_peserta_didik_rombel` 
      WHERE `id_siswa` IS NOT NULL $where_search");
    // cari total hasil
    $total_count = 0;
    while ($row = $query_total->unbuffered_row()) {
      $total_count += 1;
    }
    // cari data result + penomoran
    $no = $data['start'] + 1;
    $index = 0;
    $data_result = array();
    while ($row = $query_result->unbuffered_row('array')) {
      /// |----------------------------------------------------------------------
      /// | PENATAAN DATA SEBELUM DIMASUKKAN KE DALAM RESULT_ARRAY
      /// |----------------------------------------------------------------------
      $data_result[$index] = $row;
      $data_result[$index]['no'] = $no;
      $data_result[$index]['id_siswa'] = isset_nn_nes(encrypt_id($row['id_siswa']), '-');
      $data_result[$index]['nama'] = isset_nn_nes($row['nama'], '-');
      $data_result[$index]['nisn'] = isset_nn_nes($row['nisn'], '-');
      $data_result[$index]['nik'] = isset_nn_nes($row['nik'], '-');
      $data_result[$index]['jenis_kelamin'] = isset_nn_nes($row['jenis_kelamin'], '-');
      $data_result[$index]['ket_jns_kelamin'] = isset_nn_nes($row['ket_jns_kelamin'], '-');
      $data_result[$index]['kode_agama'] = isset_nn_nes($row['kode_agama'], '-');
      $data_result[$index]['ket_agama'] = isset_nn_nes($row['ket_agama'], '-');
      $data_result[$index]['no_kk'] = isset_nn_nes($row['no_kk'], '-');
      $data_result[$index]['alamat'] = isset_nn_nes($row['alamat'], '-');
      $data_result[$index]['pdpd'] = isset_nn_nes($row['pdpd'], '-');
      $data_result[$index]['ket_disabilitas'] = isset_nn_nes($row['ket_disabilitas'], '-');
      $data_result[$index]['id_rombel'] = isset_nn_nes(encrypt_id($row['id_rombel']), '-');
      $data_result[$index]['jenjang'] = isset_nn_nes($row['jenjang'], '-');
      $data_result[$index]['ket_jenjang'] = isset_nn_nes($row['ket_jenjang'], '-');
      $data_result[$index]['kelas'] = isset_nn_nes($row['kelas'], '-');
      $data_result[$index]['ket_kelas'] = isset_nn_nes($row['ket_kelas'], '-');
      $data_result[$index]['id_sekolah'] = isset_nn_nes($row['id_sekolah'], '-');
      $data_result[$index]['ket_sekolah'] = isset_nn_nes($row['ket_sekolah'], '-');
      $data_result[$index]['nama_rombel'] = isset_nn_nes($row['nama_rombel'], '-');
      $data_result[$index]['id_tahun_ajaran'] = isset_nn_nes($row['id_tahun_ajaran'], '-');
      $data_result[$index]['ket_tahun_ajaran'] = isset_nn_nes($row['ket_tahun_ajaran'], '-');

      $no += 1;
      $index += 1;
    }
    // kembalikan data yang didapat ke controller
    return array(
      'total' => $total_count,
      'filtered' => $total_count,
      'data' => $data_result,
      'draw' => $data['draw']
    );
  }

  public function save_rombel($data)
  {
    // FORM VALIDATION
    $this->load->library('form_validation');

    // Define validation rules
    $this->form_validation->set_rules('id_sekolah', 'ID Sekolah', 'required');
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

      // BUATKAN LOG UTK SISTEM (DELETE)
      log_generator(
        $cur_user,
        'r_rombongan_belajar',
        $data['id'],
        "Melakukan penghapusan data rombongan belajar sebagai berikut :\n\n" . format_log_view($data)
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
