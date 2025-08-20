<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_pdt_peserta_didik extends CI_Model
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
  /// |----------------------------------------------------------
  /// | >> QUERY MODEL DATATABLE
  /// |----------------------------------------------------------
  public function query_data_peserta_didik($data)
  {
    // $cur_unor = $this->session->userdata('kode_unor');

    // declare table
    $this->db->from('v_progurinda_siswa');

    // where condition
    if (check_var($data, 'search')) {
      $this->db->group_start()
        ->like('nama', $data['search'])
        ->or_like('nisn', $data['search'])
        ->or_like('ket_jns_kelamin', $data['search'])
        ->or_like('ket_agama', $data['search'])
        ->group_end();
    }
  }

  /// |----------------------------------------------------------
  /// | >> PROSES MODEL GET DATA
  /// |----------------------------------------------------------
  public function get_datatable($data)
  {
    $this->query_data_peserta_didik($data);

    // ORDER
    $order_col = $data['order_column'];
    $order_sort = strtolower($data['order_sort']) === 'desc' ? 'DESC' : 'ASC';
    $this->db->order_by($order_col, $order_sort);

    // LIMIT
    $this->db->limit((int)$data['length'], (int)$data['start']);

    // RESULT DATA
    $query_result = $this->db->get()->result_array();

    // RE-BUILD FOR TOTAL
    $this->query_data_peserta_didik($data);
    $total_count = $this->db->get()->num_rows();

    $no = $data['start'] + 1;
    $data_result = [];
    foreach ($query_result as $row) {
      $row['no'] = $no++;

      // tampilan aksi
      $encrypt_id = encrypt_id($row['id_siswa']); // enkrip rowData `id_siswa`
      $tombol_edit = '<div onclick="modal(`' . $encrypt_id . '`, `edit_peserta_didik`)" class="badge bg-primary clickable me-1" title="Edit"><i class="fas fa-edit"></i> Edit</div>';
      $tombol_detail = '<a href="' . site_url('pdt_peserta_didik/detail/') . $encrypt_id . '" class="badge bg-info clickable text-white me-1 py-1"><i class="fas fa-upload"></i> Update</a>';
      $tombol_delete = ($this->session->userdata('kewenangan') == '00') ?
        '<div onclick="modal(`' . $encrypt_id . '`, `delete_peserta_didik`)" class="badge bg-danger clickable me-1 py-1" title="Hapus"><i class="fas fa-trash"></i> Hapus</div>'
        : '';

      $row['aksi_display'] = '<div class="d-grid gap-1">' .
        $tombol_edit . $tombol_detail . $tombol_delete
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

  public function generate_id_siswa()
  {
    do {
      $prefix = rand(100000, 999999); // 6-digit random
      $id_siswa = $prefix . '2025';

      $exists = $this->db->get_where('progurinda_r_siswa', ['id_siswa' => $id_siswa])->num_rows() > 0;
    } while ($exists);

    return $id_siswa;
  }

  /// |----------------------------------------------------------
  /// | >> PROSES MODEL CRUD
  /// |----------------------------------------------------------
  public function save_peserta_didik($data)
  {
    // FORM VALIDATION
    $this->load->library('form_validation');

    // Define validation rules
    // $this->form_validation->set_rules('id_siswa', 'ID Siswa', 'required');
    $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
    $this->form_validation->set_rules('nisn', 'NISN', 'required|numeric');
    $this->form_validation->set_rules('nik', 'NIK', 'required|numeric');
    $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
    $this->form_validation->set_rules('kode_agama', 'Agama', 'required|numeric');
    $this->form_validation->set_rules('nama_ibu', 'Nama Ibu', 'required');
    $this->form_validation->set_rules('no_kk', 'No. KK', 'required|numeric');
    $this->form_validation->set_rules('alamat', 'Alamat', 'required');

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

    if ($this->input->post('type') != 'edit_peserta_didik') {
      // cek apakah data sudah ada di database
      $is_siswa_exist = fetch_row_data('progurinda_r_siswa', ['nama' => $data['nama']], '');
      if ($is_siswa_exist) {
        return [
          'status' => false,
          'message' => 'Maaf, Peserta Didik (Siswa) sudah terdaftar dalam database.'
        ];
      }
    }

    $cur_user = $this->session->userdata('id_user');
    try {
      //start db transaction
      $this->db->trans_begin();
      //cek apakah insert atau update
      if ($data["id_siswa"] == 0) {
        //insert data
        $this->db->insert("progurinda_r_siswa", $data);
        $insert_id = $this->db->insert_id();

        // BUATKAN LOG UTK SISTEM (INSERT)
        log_generator(
          $cur_user,
          'progurinda_r_siswa',
          $insert_id,
          "Melakukan penambahan data peserta didik (siswa) baru dengan data sebagai berikut :\n\n" . format_log_view($data)
        );
      } else {
        //update data
        $this->db->where(["id_siswa" => $data["id_siswa"]])->update("progurinda_r_siswa", $data);

        // BUATKAN LOG UTK SISTEM (UPDATE)
        log_generator(
          $cur_user,
          'progurinda_r_siswa',
          $data['id_siswa'],
          "Melakukan perubahan data peserta didik (siswa) dengan data sebagai berikut :\n\n" . format_log_view($data)
        );
      }

      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        $res = [
          'status' => false,
          'message' => "Data peserta didik (siswa) gagal disimpan!"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        $res = [
          'status' => true,
          'message' => "Data peserta didik (siswa) berhasil disimpan!"
        ];
      }
    } catch (\Throwable $th) {
      $res = [
        'status' => false,
        'message' => "Proses simpan peserta didik (siswa) Error! Error message : " . $th->getMessage()
      ];
    }
    return $res;
  }

  public function delete_peserta_didik($data)
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
      $this->db->where(["id_siswa" => $data["id_siswa"]])->delete("progurinda_r_siswa");

      // BUATKAN LOG UTK SISTEM (DELETE)
      log_generator(
        $cur_user,
        'progurinda_r_siswa',
        $data['id_siswa'],
        "Melakukan penghapusan data sebagai berikut :\n\n" . format_log_view($data)
      );
      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        $res = [
          'status' => false,
          'message' => "Data Peserta Didik (Siswa) gagal dihapus!"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        $res = [
          'status' => true,
          'message' => "Data Peserta Didik (Siswa) berhasil dihapus!"
        ];
      }
    } catch (\Throwable $th) {
      $res = [
        'status' => false,
        'message' => "Proses hapus peserta didik error! Error message : " . $th->getMessage()
      ];
    }
    return $res;
  }

  public function import_data($data)
  {
    $this->db->trans_start();
    $this->db->insert("progurinda_r_siswa", $data);
    $this->db->trans_complete();
  }
}
