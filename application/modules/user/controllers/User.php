<?php defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{
  // core control data untuk manajemen user
  public function __construct()
  {
    parent::__construct();
    $log = $this->session->userdata('logged_in');
    $user = $this->session->userdata('username');
    $kewenangan = $this->session->userdata('kewenangan');
    $this->session->set_userdata('menu', 'user');
    if ($log != true) {
      redirect(site_url('login'));
    } else {
      $this->load->model('mdl_user', 'user');
    }
  }

  // fungsi untuk menarik semua data user
  public function get_data()
  {
    $index = ($this->input->post("order[0][column]") == null) ? 0 : $this->input->post("order[0][column]");
    // insert datatable param to transfer
    $param = array(
      'start' => ($this->input->post("start") == null) ? 0 : $this->input->post("start"),
      'length' => ($this->input->post("length") == null) ? 10 : $this->input->post("length"),
      'order_column' => $this->input->post("columns[$index][data]"),
      'order_sort' => ($this->input->post("order[0][dir]") == null) ? 'asc' : $this->input->post("order[0][dir]"),
      'search' => $this->input->post("search[value]"),
      'draw' => ($this->input->post("draw") == null) ? 1 : $this->input->post("draw")
    );

    $result = $this->user->get_datatable('v_progurinda_user', $param, 'id_user');

    $data["recordsTotal"] = $result['total'];
    $data["recordsFiltered"] = $result['filtered'];
    $data["data"] = $result['data'];
    $data["draw"] = $result['draw'];

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  // fungsi untuk tampilan halaman manajemen user
  public function index()
  {
    $sent_data = array(
      'm_user' => $this->user->get('m_user'),
    );
    $data = array(
      'page_title' => "Manajemen User",
      'module' => "user",
      'view' => "vw_user",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }
  /** fungsi untuk modal pada button tambah (add), ubah (edit), hapus (delete), dan ubah hak akses menu */
  public function modal()
  {
    $username = $this->input->post('username');
    $type = $this->input->post('type');

    // default response
    $response = [
      'status' => false,
      'message' => 'Maaf, proses ini masih dalam tahap development.',
      'html' => ''
    ];

    switch ($type) {
      case 'edit': {
          $data = $this->user->get("v_progurinda_user", "id_user = '$username'");
          $sent = array('data' => $data);
          // update response
          $response['status'] = true;
          $response['message'] = "Proses Edit.";
          $response['html'] = $this->load->view('vw_modal_edit', $sent, TRUE);
          break;
        }
      case 'hapus': {
          $data = $this->user->get("v_progurinda_user", "id_user = '$username'");
          $sent = array('data' => $data);
          // update response
          $response['status'] = true;
          $response['message'] = "Proses Hapus.";
          $response['html'] = $this->load->view('vw_modal_hapus', $sent, TRUE);
          break;
        }
      default: {
          $sent = array('data' => array());
          // update response
          $response['status'] = true;
          $response['message'] = "Proses Tambah.";
          $response['html'] = $this->load->view('vw_modal_tambah', $sent, TRUE);
          break;
        }
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }

  /** fungsi untuk menambah data user (ADD) */
  public function add_user()
  {
    $this->form_validation->set_rules('id_user', 'Username', 'required|trim');
    $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]');
    $this->form_validation->set_rules('username', 'Nama User', 'required|trim');
    $this->form_validation->set_rules('kewenangan', 'Kewenangan', 'required');
    $this->form_validation->set_rules('kode_unor', 'Unit Kerja', 'required');
    $this->form_validation->set_rules('email_user', 'NO. HP', 'required');

    $response = array();

    if ($this->form_validation->run() == FALSE) {
      $response['status'] = false;
      $response['message'] = "Form Validasi Error!";
    } else {
      // DEBUG
      // $post = $this->input->post();
      // return $this->output
      //   ->set_content_type('application/json')
      //   ->set_output(json_encode([
      //     'status' => false,
      //     'message' => 'Maaf, proses ini masih dalam tahap development.',
      //     'dara' => $post
      //   ]));

      $response = $this->user->add_userdata();
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }

  /** fungsi untuk mengubah data user (EDIT) */
  public function edit_user()
  {
    $this->form_validation->set_rules('id_user', 'Username', 'required|trim');
    $this->form_validation->set_rules('username', 'Nama User', 'required|trim');
    $this->form_validation->set_rules('kewenangan', 'Kewenangan', 'required');
    $this->form_validation->set_rules('kode_unor', 'Unit Kerja', 'required');
    $this->form_validation->set_rules('email_user', 'NO. HP', 'required');

    $response = array();

    if ($this->form_validation->run() == FALSE) {
      $response['status'] = false;
      $response['message'] = "Form Validasi Error!";
    } else {
      // DEBUG
      // $post = $this->input->post();
      // return $this->output
      //   ->set_content_type('application/json')
      //   ->set_output(json_encode([
      //     'status' => false,
      //     'message' => "Maaf, proses masih dalam tahap development.",
      //     'data' => $post
      //   ]));

      $response = $this->user->edit_userdata();
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }

  /** fungsi untuk menghapus data user (DELETE) */
  public function delete_user()
  {
    $id_user = $this->input->post('id_user');
    $response = $this->user->delete_userdata($id_user);

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }

  public function update_password($username)
  {
    $data = [
      'username' => htmlspecialchars($username),
      'password' => encrypt_pwd("presensi2022")
    ];

    $this->db->trans_start();
    // Proses query update ke database
    $this->db->update('m_user', $data, array('username' => $username));
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      // Jika proses query gagal     
      echo "Proses Update ke Database Gagal!";
    } else {
      echo "Proses Update ke Database Berhasil!";
    }
  }

  /** fungsi untuk display menu untuk menentukan user tertentu bisa mengakses yang mana saja  */
  public function menu_management($username = '')
  {
    $this->session->set_userdata('menu', 'user');
    // kalau username tidak di berikan, 404
    if ($username == '') {
      show_404();
      return;
    }
    $data_user = $this->user->get('v_user', "username = '$username'");
    $data_menu = $this->user->get('m_user_modul');
    $data_preview = $this->user->get('v_user_menu', "username = '$username'", true);
    $sent_data = array(
      'data_user' => $data_user,
      'data_menu' => $data_menu,
      'data_preview' => $data_preview
    );
    // kalau salah satu data user tidak ditemukan, 404
    if (!isset_nn_nes($data_user) || !isset_nn_nes($data_menu)) {
      show_404();
      return;
    }
    $data = array(
      'page_title' => "Hak Akses Menu",
      'module' => "user",
      'view' => "vw_hak_akses_user",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  /** fungsi untuk get data menu sesuai dengan tipe dan id yang di post */
  public function get_menu_data()
  {
    $post = $this->input->post();

    // cek dulu apakah semua data inputnya sudah ada
    if (!isset_nn_nes($post['id'])) {
      $msg = ($post['type'] == 'user') ? 'User' : 'Kewenangan';
      $res['status'] = false;
      $res['message'] = "Harap pilih terlebih dahulu $msg yang akan ditiru menu-nya. (ERRxGMD002)";
      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($res));
      return;
    }

    // lakukan operasi db
    $res = $this->user->get_menu($post['id'], $post['type']);

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }

  /** fungsi untuk menyimpan daftar menu yang baru */
  public function save_akses_menu()
  {
    $post = $this->input->post();
    $res = array();
    if (!isset_nn_nes($post['module_id']) || !isset_nn_nes('username')) {
      $res['status'] = false;
      $res['message'] = "Maaf, terjadi kesalahan saat akan menyimpan data hak akses menu yang baru. (ERRxSAM001)";
      return;
    }

    // masuk ke proses db
    $res = $this->user->save_akses_menu($post['username'], $post['module_id']);

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }
}
