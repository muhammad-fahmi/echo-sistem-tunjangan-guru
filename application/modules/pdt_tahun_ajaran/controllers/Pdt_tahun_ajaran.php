<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pdt_tahun_ajaran extends MY_Controller
{
  public function __construct()
  {
    // lakukan proses verifikasi user disini
    parent::__construct();

    $is_ajax = $this->input->is_ajax_request();
    if (!$is_ajax) {
      $this->session->set_userdata('menu', 'PDT_DTATahunAjaran');
      if (!check_perm('read') || !is_logged_in()) {
        redirect(site_url('pangkalan_data'));
      }
    }
    $this->load->model('mdl_pdt_tahun_ajaran', 'mdl_tahun_ajaran');
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

  public function detail($encryptedID = '')
  {
    $decryptedID = decrypt_id(sanitize_string($encryptedID));

    $dataset = fetch_row_data('v_tahun_ajaran', ['id_tahun_ajaran' => $decryptedID], false);
    if ($dataset == false) {
      $this->session->set_userdata('flash_data', "Maaf, data Tahun Ajaran yang akan dilihat detailnya tidak valid.");
      redirect(site_url('pdt_tahun_ajaran'));
      return;
    }

    // lakukan proses init halaman
    $data = array(
      'page_title' => "Detail Tahun Ajaran | PROGURINDA",
      'module' => "pdt_tahun_ajaran",
      'view' => "vw_detail_tahun_ajaran",
      'data' => $dataset
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
      'id_sekolah' => $this->session->userdata('kode_unor')
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

  public function get_data_rombel()
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
    $result = $this->mdl_tahun_ajaran->get_datatable_rombel($param);
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
