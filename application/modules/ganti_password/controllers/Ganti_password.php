<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ganti_password extends MY_Controller
{
  // core control data untuk manajemen user
  public function __construct()
  {
    parent::__construct();
    $log = $this->session->userdata('logged_in');
    $user = $this->session->userdata('username');
    $kewenangan = $this->session->userdata('kewenangan');
    if ($log != true || !menu_auth_sipedal($user, 'ganti_password', $kewenangan)) {
      redirect(site_url('login'));
    } else {
      $this->load->model('mdl_ganti_password', 'mdl_gp');
    }
  }

  // fungsi untuk tampilan halaman manajemen user
  public function index()
  {
    $this->session->set_userdata('menu', 'ganti_password');
    $data = array(
      'page_title' => "Ganti Password",
      'module' => "ganti_password",
      'view' => "vw_index",
    );
    echo Modules::run('layout/backend', $data);
  }

  public function action()
  {
    $old = $this->input->post('password_old');
    $new = $this->input->post('password_new');
    $salt = micin();

    $username = $this->session->userdata('username');
    /// |----------------------------------------
    /// | CEK APAKAH USER AKTIF
    /// |----------------------------------------
    $data_user = $this->db->get_where('m_user', "username = '$username' AND aktif = 'Y'")->row_array();
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
        'username' => $username
      ];
      $data = [
        'password' => encrypt_pwd($new),
        'salt' => $salt
      ];
      $this->db->update('m_user', $data, $where);
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
