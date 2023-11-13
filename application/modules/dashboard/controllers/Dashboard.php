<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    $priv = $this->session->userdata('kewenangan');
    $log = $this->session->userdata('logged_in');
    if ($log != true) {
      redirect(site_url('login'));
    } else {
      $this->load->model('mdl_dashboard');
    }
  }

  public function index()
  {
    $this->session->set_userdata('menu', 'dashboard');
    $sent_data = array(
      'm_iku' => $this->db->get_where('m_iku', [
        'id_iku' => "IS NOT NULL",
      ])->result_array()
    );
    $data = array(
      'page_title' => "Dashboard",
      'module' => "dashboard",
      'view' => "vw_dashboard",
      'data' => ''
    );
    echo Modules::run('layout/backend', $data);
  }

  // fungsi untuk menarik semua data attlog
  public function get_data_attlog()
  {
    // return $this->output
    //   ->set_content_type('application/json')
    //   ->set_output(json_encode([
    //     'recordsTotal' => 0,
    //     'recordsFiltered' => 0,
    //     'data' => [],
    //     'draw' => 1
    //   ]));
    // ambil data transaksi
    // get index value
    $index = $this->input->post("order[0][column]") ?? 0;
    // insert datatable param to transfer
    $param = array(
      'start' => $this->input->post("start") ?? 0,
      'length' => $this->input->post("length") ?? 10,
      'order_column' => $this->input->post("columns[$index][data]"),
      'order_sort' => $this->input->post("order[0][dir]") ?? 'asc',
      'search' => $this->input->post("search[value]"),
      'draw' => $this->input->post("draw") ?? 1,
      /* additional data can be declared here */
      'kode_ukerja' => $this->input->post("kode_ukerja") ?? $this->session->userdata("kode_ukerja"),
      'cloud_id' => $this->input->post("cloud_id"),
      'filter_tgl' => $this->input->post("filter_tgl") ?? "",
      'filter_tgl_akhir' => $this->input->post("filter_tgl_akhir") ?? "",
      'filter_jnspeg' => $this->input->post("filter_jnspeg") ?? "all"
    );
    // move the db operation to the designated models
    $result = $this->mdl_dashboard->get_datatable_attlog('r_attlog', $param, 'id');
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

  public function export_attlog_pdf($kode_ukerja = "", $cloud_id = "all", $filter_jnspeg = "all", $filter_tgl = "", $filter_tgl_akhir = "")
  {
    $params = array(
      "kode_ukerja" => $kode_ukerja,
      "cloud_id" => $cloud_id,
      "filter_tgl" => $filter_tgl,
      "filter_tgl_akhir" => $filter_tgl_akhir,
      "filter_jnspeg" => $filter_jnspeg
    );
    $data_export["ket_ukerja"] = $this->db->where("kode_ukerja = '" . $kode_ukerja . "'")->get("v_ukerja")->row()->ket_ukerja;
    $data_export["attlog"] = $this->mdl_dashboard->get_export_attlog($params);
    $this->load->view("vw_export_pdf", $data_export);
  }

  public function export_attlog_excel()
  {
  }
}
