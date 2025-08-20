<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ganti_password extends MY_Controller
{
  // core control data untuk manajemen user
  public function __construct()
  {
    parent::__construct();

    $is_ajax = $this->input->is_ajax_request();
    if (!$is_ajax) {
      $this->session->set_userdata('menu', 'ganti_password');
      if (!is_logged_in()) {
        redirect(site_url('login'));
      }
    }

    $this->load->model('mdl_ganti_password', 'mdl_gp');
  }

  // fungsi untuk tampilan halaman manajemen user
  public function index()
  {
    $data = array(
      'page_title' => "Ganti Password",
      'module' => "ganti_password",
      'view' => "vw_index",
    );
    echo Modules::run('layout/backend', $data);
  }

  public function action()
  {
    if (!is_logged_in()) return output_json([
      'status' => false,
      'message' => "Maaf, tidak bisa melakukan ganti password apabila belum login."
    ]);

    $old = $this->input->post('password_old');
    $new = $this->input->post('password_new');
    $salt = micin();

    $username = $this->session->userdata('id_user');
    /// |----------------------------------------
    /// | CEK APAKAH USER AKTIF
    /// |----------------------------------------
    $data_user = $this->db->get_where(
      'progurinda_m_user',
      "id_user = '$username' AND aktif = 'Y'"
    )->row_array();
    if (!isset_nn_nes($data_user)) {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => "User tidak valid / tidak terdaftar (ERRxGPA002)"
        ]));
    }
    /// |----------------------------------------
    /// | CEK APAKAH PASSWORD LAMA SESUAI
    /// |----------------------------------------
    $verif = verify_pwd($old, $data_user['password']);
    if (!$verif) {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => "Password lama tidak sesuai (ERRxGPA003)"
        ]));
    }

    try {
      /// |----------------------------------------
      /// | UPDATE DATA PASSWORD
      /// |----------------------------------------
      $where = [
        'id_user' => $username
      ];
      $data = [
        'password' => encrypt_pwd($new),
        'salt' => $salt
      ];
      $this->db->update('progurinda_m_user', $data, $where);
    } catch (\Throwable $th) {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => "Proses penggantian password gagal dilakukan (ERRxGPA001)",
          'info' => "" . $th->getMessage()
        ]));
    }

    /// |----------------------------------------
    /// | PROSES BERHASIL
    /// |----------------------------------------
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode([
        'status' => true,
        'message' => "Password berhasil di ganti"
      ]));
  }
}
