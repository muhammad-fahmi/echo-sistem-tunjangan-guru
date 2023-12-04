<?php defined('BASEPATH') or exit('No direct script access allowed');

class Presensi extends MY_Controller
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
      $this->load->model('mdl_presensi_pegawai', 'mpp');
    }
  }

  public function index()
  {
    // lakukan proses init halaman
    $this->session->set_userdata('menu', 'presensi');
    $sent_data = array();
    $data = array(
      'page_title' => "Presensi Pegawai",
      'module' => "presensi",
      'view' => "vw_presensi",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  public function datalist() {
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
      'filter_bln' => $this->input->post('filter_bln'),
      'filter_thn' => $this->input->post('filter_thn'),
      'kode_ukerja' => $this->input->post('kode_ukerja')
      /* additional data can be declared here */
    );
    // move the db operation to the designated models
    //$result = $this->mpp->get_datatable('progurinda_r_data_presensi',$param);
    $result = $this->mpp->get_data_presensi($param);
    // return the data back to the views
    $data["recordsTotal"] = $result['jml'];
    $data["recordsFiltered"] = $result['list'];
    $data["data"] = $result['data'];
    $data["draw"] = $result['draw'];
    // using common_helper function
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  // Select2 utk unit kerja
  public function select2_ukerja()
  {
    // ambil data post
    $search = $this->input->post('search');
    // kondisi where
    $where_search = ($search != '')
      ? "AND (nama_lengkap LIKE '%$search%' 
      OR nip LIKE '%$search%')"
      : "";
    // query searching
    $result = $this->db->query("SELECT * FROM m_jab WHERE id IS NOT NULL $where_search 
      ORDER BY kode_ukerja DESC LIMIT 10")->result_array();
    $data = array();
    $index = 0;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $data[$index]['id'] = $r['id'];
        $data[$index]['text'] = $r['kode_ukerja'] . ' - ' . trim($r['ket_ukerja']);
  
        // additional param to send back
        $data[$index]['nip'] = $r['nip'];
        // $data[$index]['nama_lengkap'] = trim($r['nama_lengkap']);
        $data[$index]['kode_gol'] = $r['kode_gol'];
        $data[$index]['tmt_gol'] = $r['tmt_gol'];
        $data[$index]['kode_eselon'] = $r['kode_eselon'];
        $data[$index]['kode_jab'] = $r['kode_jab'];
        $data[$index]['kode_ukerja'] = $r['kode_ukerja'];
  
        $data[$index]['ket_jab'] = $r['ket_jab'];
        $data[$index]['ket_ukerja'] = $r['ket_ukerja'];
        $data[$index]['ket_uorg'] = $r['ket_uorg'];
  
        $index++;
      }
    } else {
      $data = $result;
    }
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function get_presensi()
  {
    $post = $this->input->post('');
    $bulan = $post['bulan'];
    $tahun = $tahun['tahun'];
    
    // Testing code sinkronisasi presensi data
  }
}