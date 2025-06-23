<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pdt_profil_sekolah extends MY_Controller
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
      $this->load->model('mdl_pdt_profil_sekolah', 'mpdtps');
    }
  }

  public function index()
  {
    // lakukan proses init halaman
    $sent_data = array();
    $data = array(
      'page_title' => "Profil Sekolah | Pangkalan Data Progurinda",
      'module' => "pdt_profil_sekolah",
      'view' => "vw_list_profil_sekolah",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  public function crud_profil_sekolah()
  {
    // lakukan proses init halaman
    $sent_data = array();
    $data = array(
      'page_title' => "Profil Sekolah | Pangkalan Data Progurinda",
      'module' => "pdt_profil_sekolah",
      'view' => "vw_form_profil_sekolah",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  /// |----------------------------------------------------------------------
  /// | >> AJAX REQUEST FUNCTIONS
  /// |----------------------------------------------------------------------
  public function get_data_master()
  {
    /// |----------------------------------------
    /// | CEK PERMISSION
    /// |----------------------------------------
    if (!check_perm('read', 'PDT_ProfilSekolah')) return output_json([
      'status' => false,
      'message' => 'Maaf, tidak memiliki permission utk membaca daftar profil sekolah'
    ], 403);

    /// |----------------------------------------
    /// | DATATABLE PARAMS
    /// |----------------------------------------
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
    $result = $this->mpdtps->get_datatable_master($param);
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

  public function get_data_usulan()
  {
    /// |----------------------------------------
    /// | CEK PERMISSION
    /// |----------------------------------------
    if (!check_perm('read', 'PDT_ProfilSekolah')) return output_json([
      'status' => false,
      'message' => 'Maaf, tidak memiliki permission utk membaca daftar profil sekolah'
    ], 403);

    /// |----------------------------------------
    /// | DATATABLE PARAMS
    /// |----------------------------------------
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
    $result = $this->mpdtps->get_datatable_usulan($param);
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
}
