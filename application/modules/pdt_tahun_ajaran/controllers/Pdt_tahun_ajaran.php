<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pdt_tahun_ajaran extends MY_Controller
{
  public function __construct()
  {
    // lakukan proses verifikasi user disini
    parent::__construct();
    $priv = $this->session->userdata('kewenangan');
    $log = $this->session->userdata('logged_in');
    if ($log != true) {
      redirect(site_url('login'));
    } else {
      $this->load->model('mdl_pdt_tahun_ajaran', 'mdl_tahun_ajaran');
    }
  }

  public function index()
  {
    $sent_data = array();
    $data = array(
      'page_title' => "Data Tahun Ajaran | PROGURINDA",
      'module' => "pdt_tahun_ajaran",
      'view' => "vw_list_tahun_ajaran",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  public function get_data()
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
    $result = $this->mdl_tahun_ajaran->get_datatable($param);
    // return the data back to the views
    $data["recordsTotal"] = $result['total'];
    $data["recordsFiltered"] = $result['filtered'];
    $data["data"] = $result['data'];
    $data["draw"] = $result['draw'];
    // using common_helper function
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function modal()
  {
    $type = $this->input->post('type');
    $id = $this->input->post('id');
    $decryptedID = decrypt_id(sanitize_string($id));
    /// |----------------------------------------
    /// | DEFAULT VALUE
    /// |----------------------------------------
    $res = [
      'status' => false,
      'message' => "Sorry this feature is under development."
    ];

    /// |----------------------------------------
    /// | COMMANDS
    /// |----------------------------------------
    switch ($type) {
      case 'tambah_data_tahun_ajar': {
          /// |----------------------------------------
          /// | INSERT DATA
          /// |----------------------------------------
          $dataset = [];
          $data = [
            'modal_title' => "Tambah Data Tahun Ajaran",
            'type' => 'add',
            'data' => $dataset,
          ];
          $res = [
            'status' => true,
            'message' => "Modal Tambah Data Tahun Ajaran",
            'html' => $this->load->view('vwm_crud_tahun_ajaran', $data, true)
          ];
          break;
        }
      case 'update_data_tahun_ajar': {
          /// |----------------------------------------
          /// | EDIT DATA
          /// |----------------------------------------
          $dataset = $this->mdl_tahun_ajaran->get('v_progurinda_siswa', "id_siswa = '$decryptedID'");
          $data = [
            'modal_title' => "Update Data Tahun Ajaran",
            'type' => 'update',
            'data' => $dataset,
          ];
          $res = [
            'status' => true,
            'message' => "Modal Update Data Tahun Ajaran",
            'html' => $this->load->view('vwm_crud_tahun_ajaran', $data, true)
          ];
          break;
        }
      case 'delete_data_tahun_ajar': {
          /// |----------------------------------------
          /// | DELETE DATA
          /// |----------------------------------------
          $dataset = $this->mdl_tahun_ajaran->get('v_progurinda_siswa', "id_siswa = '$decryptedID'");
          if (isset_nn_nes($dataset)) {
            $data = [
              'modal_title' => "Hapus Data Tahun Ajaran",
              'type' => 'delete',
              'data' => $dataset,
            ];
            $res = [
              'status' => true,
              'message' => "Modal Hapus Data Tahun Ajaran",
              'html' => $this->load->view('vwm_crud_tahun_ajaran', $data, true)
            ];
          }
          break;
        }
      default: {
          break;
        }
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }
}
