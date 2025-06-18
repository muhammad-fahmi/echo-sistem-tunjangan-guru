<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pangkalan_data extends MY_Controller
{
  /// |----------------------------------------------------------------------
  /// | >> CONSTRUCT
  /// |----------------------------------------------------------------------
  public function __construct()
  {
    parent::__construct();
    $log = $this->session->userdata('logged_in');
    $user = $this->session->userdata('username');
    $kewenangan = $this->session->userdata('kewenangan');
    // TODO : 
    // masih menunggu design kewenangan utk pangakalan data
    if ($log != true) {
      redirect(site_url('login'));
    } else {
      $this->load->model('mdl_pangkalan_data', 'mdl_pkldata');
    }
  }

  /// |----------------------------------------------------------------------
  /// | >> PRIVATE FUNCTION
  /// |----------------------------------------------------------------------
  private function list_ks()
  {
    $this->session->set_userdata('menu', 'pangkalan_data/ks');
    // TODO : 
    // array kosong aja dulu, belum ada static data yg diperlukan
    $sent_data = [];
    $data = array(
      'page_title' => "Data Kepala Sekolah | PROGURINDA",
      'module' => "pangkalan_data",
      'view' => "vw_list_ks",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  private function list_ptk()
  {
    $this->session->set_userdata('menu', 'pangkalan_data/ptk');
    // TODO : 
    // array kosong aja dulu, belum ada static data yg diperlukan
    $sent_data = [];
    $data = array(
      'page_title' => "Data Sekolah | PROGURINDA",
      'module' => "pangkalan_data",
      'view' => "vw_list_ks",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  /// |----------------------------------------------------------------------
  /// | >> PAGE LOAD FUNCTION
  /// |----------------------------------------------------------------------
  public function index($default_route = 'list_ks')
  {
    $route = sanitize_string($default_route);
    $perm = null; // nanti ditentukan akses ke route yg dtuju, nunggu design DB dari dharma

    switch ($route) {
      case 'list_ks':
        $this->display_list_ks();
        break;

      case 'list_ptk':
        $this->display_list_ptk();
        break;

      default:
        $this->display_list_ks();
        break;
    }
  }

  /// |----------------------------------------------------------------------
  /// | >> AJAX REQUEST FUNCTIONS
  /// |----------------------------------------------------------------------
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
}
