<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pdt_rombongan_belajar extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    // lakukan proses verifikasi user disini
    $priv = $this->session->userdata('kewenangan');
    $log = $this->session->userdata('logged_in');
    if ($log != true) {
      redirect(site_url('login'));
    } else {
      $this->load->model('mdl_pdt_rombel', 'mdl_rombel');
    }
  }

  public function index()
  {
    // lakukan proses init halaman
    $sent_data = array();
    $data = array(
      'page_title' => "Rombongan Belajar | PROGURINDA",
      'module' => "pdt_rombongan_belajar",
      'view' => "vw_list_rombongan_belajar",
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
    $result = $this->mdl_rombel->get_datatable($param);
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
