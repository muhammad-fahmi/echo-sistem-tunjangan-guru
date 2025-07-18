<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_pdt_profile extends CI_Model
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

  public function update_profile($post_data)
  {
    $this->load->library('form_validation');

    // Define validation rules
    $this->form_validation->set_rules('username', 'Nama / Instansi', 'required|min_length[3]');
    $this->form_validation->set_rules('email_user', 'E-mail', 'required|valid_email');
    $this->form_validation->set_rules('no_hp', 'No. HP', 'required|numeric');

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
        'message' => "Maaf, tidak bisa melanjutkan proses karena form tidak valid.<br>" . $error_list
      ];
    }

    // pastikan username belum digunakan
    $username_taken = fetch_row_data('v_progurinda_user', [
      'username' => $post_data['username'],
      'id_user <>' => $post_data['id_user']
    ], false);
    if ($username_taken) return [
      'status' => false,
      'message' => "Maaf, Nama / Instansi yang di-input sudah terdaftar, Mohon gunakan Nama / Instansi lainnya."
    ];

    // tarik data awal
    $old_data = fetch_row_data('progurinda_m_user', ['id_user' => $post_data['id_user']], false);
    if (!$old_data) return [
      'status' => false,
      'message' => "Maaf, data profil yang akan di-update tidak valid."
    ];

    $changes = get_changed_data($old_data, $post_data);
    $old_data_log = format_log_view($changes['before']);
    $new_data_log = format_log_view($changes['after']);

    try {
      $this->db->trans_begin();
      // do your db process here
      // update DB
      $proc = 1;
      $this->db->update('progurinda_m_user', $changes['after'], [
        'id_user' => $post_data['id_user']
      ]);

      // buat log
      $proc = 2;
      log_generator(
        $this->session->userdata('id_user'),
        'progurinda_m_user',
        $post_data['id_user'],
        "Melakukan update profil dengan perubahan sebagai berikut:\n\nBEFORE:\n{$old_data_log}\n\nAFTER:\n{$new_data_log}"
      );
      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        return [
          'status' => false,
          'message' => "Maaf, terjadi kesalahan saat proses update profil.\nROLLBACK ISSUE #{$proc}"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        return [
          'status' => true,
          'message' => "Proses update profil berhasil dilakukan."
        ];
      }
    } catch (\Throwable $th) {
      $em = sanitize_string($th->getMessage());
      return [
        'status' => false,
        'message' => "Maaf, terjadi kesalahan dalam proses update profile.\n{$em}"
      ];
    }
  }

  public function update_profile_img_to_DB($new_filename)
  {
    $id_user = $this->session->userdata('id_user');
    $old_filename = fetch_single_data('v_progurinda_user', 'profile_img', ['id_user' => $id_user], 'XXX');

    try {
      $this->db->update('progurinda_m_user', ['profile_img' => $new_filename], ['id_user' => $id_user]);

      log_generator($id_user, 'progurinda_m_user', $id_user, "Meng-update profile image.");

      $upload_path = $this->config->item('upload_path');
      $old_file_path = $upload_path . 'profile_image/' . $old_filename;
      if (file_exists($old_file_path)) unlink($old_file_path);

      return [
        'status' => true,
        'message' => "Update data profile image berhasil.",
        'filename' => $new_filename
      ];
    } catch (\Throwable $th) {
      $em = sanitize_string($th->getMessage());
      return [
        'status' => false,
        'message' => "Maaf, terjadi kesalahan saat update data profile image.\n{$em}"
      ];
    }
  }
}
