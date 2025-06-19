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

  /// |----------------------------------------------------------------------
  /// | >> PAGE LOAD FUNCTION
  /// |----------------------------------------------------------------------
  public function index()
  {
    $this->session->set_userdata('menu', 'pangkalan_data');
    $cur_kewenangan = $this->session->userdata('kewenangan');
    if (in_array($cur_kewenangan, ['00', '02'])) {
      $view = 'vw_dashboard_admin';
      $sent_data = [];
    } else {
      $view = 'vw_dashboard_sekolah';
      $kode_unor = $this->session->userdata('kode_unor');
      $ukerja_simpeg = fetch_row_data('m_ukerja', ['kode_ukerja' => $kode_unor], false);
      $ukerja_profil = fetch_row_data('m_profil_sekolah', ['kode_ukerja' => $kode_unor], false);
      $sent_data = [];
      if ($ukerja_profil !== false) {
        $sent_data = $ukerja_profil;
      } else if ($ukerja_simpeg !== false) {
        $sent_data = $ukerja_simpeg;
      }
    }

    $data = array(
      'page_title' => "Dashboard Pangkalan Data | PROGURINDA",
      'module' => "pangkalan_data",
      'view' => $view,
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  /// |----------------------------------------------------------------------
  /// | >> AJAX REQUEST FUNCTIONS
  /// |----------------------------------------------------------------------
  public function datatable_sekolah()
  {
    // get index value
    $index = $this->input->post("order[0][column]");
    // insert datatable param to transfer
    $param = array(
      'start' => $this->input->post("start"),
      'length' => $this->input->post("length"),
      'order_column' => $this->input->post("columns[$index][data]"),
      'order_sort' => $this->input->post("order[0][dir]"),
      'search' => $this->input->post("search[value]"),
      'draw' => $this->input->post("draw"),
      /* additional data can be declared here */
    );
    // move the db operation to the designated models
    $result = $this->mdl_pkldata->get_datatable_sekolah($param);
    // return the data back to the views
    $data["recordsTotal"] = $result['total'];
    $data["recordsFiltered"] = $result['filtered'];
    $data["data"] = $result['data'];
    $data["draw"] = $result['draw'];
    // using common_helper function
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

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
