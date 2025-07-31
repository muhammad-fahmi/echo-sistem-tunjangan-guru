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
    $query_result = $this->db->query("SELECT * FROM r_rombongan_belajar 
      WHERE id IS NOT NULL $where_search 
      ORDER BY $data[order_column] $data[order_sort] 
      LIMIT $data[start], $data[length]");
    $query_total = $this->db->query("SELECT * FROM r_rombongan_belajar 
      WHERE id IS NOT NULL $where_search");
    // cari total hasil
    $total_count = 0;
    while ($row = $query_total->unbuffered_row()) {
      $total_count += 1;
    }
    // cari data result + penomoran
    $no = $data['start'] + 1;
    $index = 0;
    $data_result = array();
    while ($row = $query_result->unbuffered_row()) {
      /// |----------------------------------------------------------------------
      /// | PENATAAN DATA SEBELUM DIMASUKKAN KE DALAM RESULT_ARRAY
      /// |----------------------------------------------------------------------
      $data_result[$index]['no'] = $no;
      // $data_result[$index]['jenjang'] = isset_nn_nes($row['jenjang'], '-');
      // $data_result[$index]['kelas'] = isset_nn_nes($row['kelas'], '-');
      // $data_result[$index]['ket_kelas'] = isset_nn_nes($row['ket_kelas'], '-');
      // $data_result[$index]['rombel'] = isset_nn_nes($row['rombel'], '-');

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
    // $this->form_validation->set_rules('id', 'ID Riwayat Rombel', 'required');
    $this->form_validation->set_rules('id_jenjang', 'ID Jenjang', 'required');
    $this->form_validation->set_rules('id_kelas', 'ID Kelas', 'required');
    $this->form_validation->set_rules('id_rombel', 'ID Rombel', 'required');
    // $this->form_validation->set_rules('ket_jenjang', 'Jenjang', 'required');
    // $this->form_validation->set_rules('ket_kelas', 'Kelas', 'required');
    // $this->form_validation->set_rules('nama_rombel', 'Nama Rombel', 'required');

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
    $is_rombel_exist = fetch_row_data('r_rombongan_belajar', ['nama_rombel' => $data['nama_rombel']], '');
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
      if ($data["id"] == 0) {
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
        "Melakukan penghapusan data sebagai berikut :\n\n" . format_log_view($data)
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
}
