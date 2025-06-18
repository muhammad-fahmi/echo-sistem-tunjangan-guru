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
      $this->load->model('mdl_dashboard', 'mdbo');
    }
  }

  public function index()
  {
    $this->session->set_userdata('menu', 'dashboard');
    $sent_data = array();
    $data = array(
      'page_title' => "Dashboard",
      'module' => "dashboard",
      'view' => "vw_dashboard_admin",
      'data' => $sent_data
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
    $result = $this->mdbo->get_datatable_attlog('r_attlog', $param, 'id');
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
        // case 'tambah_mapel_guru': {
        //   /// |----------------------------------------
        //   /// | INSERT DATA
        //   /// |----------------------------------------
        //   $dataset = [
        //     'nip' => '',
        //     'nama_lengkap' => '',
        //     'ket_jab' => '',
        //     'unit_kerja' => '',
        //     'mapel' => '',
        //     'id' => $id
        //   ];
        //   $data = [
        //     'modal_title' => "Tambah Mapel Guru",
        //     'data' => $dataset,
        //   ];
        //   $res = [
        //     'status' => true,
        //     'message' => "Modal Tambah Mapel Guru",
        //     'html' => $this->load->view('vw_mapel_guru_modal_save', $data, true)
        //   ];
        //   break;
        // }
        // case 'edit_mapel_guru': {
        //   /// |----------------------------------------
        //   /// | EDIT DATA
        //   /// |----------------------------------------
        //   $dataset = $this->mmpg->get('v_progurinda_mapel', "id = '$id'");
        //   $data = [
        //     'modal_title' => "Edit Mapel Guru",
        //     'data' => $dataset,
        //   ];
        //   $res = [
        //     'status' => true,
        //     'message' => "Modal Edit Mapel Guru",
        //     'html' => $this->load->view('vw_mapel_guru_modal_save', $data, true)
        //   ];
        //   break;
        // }
      case 'delete_arsip_tpp': {
          /// |----------------------------------------
          /// | DELETE DATA
          /// |----------------------------------------
          $dataset = $this->mdbo->get('v_progurinda_jurnal_mengajar', "id = '$id'");
          if (isset_nn_nes($dataset)) {
            $data = [
              'modal_title' => "Batalkan Arsip TPP",
              'data' => $dataset,
            ];
            $res = [
              'status' => true,
              'message' => "Modal Batalkan Arsip TPP",
              'html' => $this->load->view('vw_arsip_tpp_modal_delete', $data, true)
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

  public function get_data_list()
  {
    $dummy_data = array(
      [
        "id" => "0",
        "kode_ukerja" => "",
        "ket_ukerja" => "SD N 016 Samarinda Seberang",
        "tgl_arsip" => null,
        "status" => 0
      ],
      [
        "id" => "1",
        "kode_ukerja" => "",
        "ket_ukerja" => "UPT SMP N 01",
        "tgl_arsip" => "2023-12-07",
        "status" => 1
      ],
      [
        "id" => "2",
        "kode_ukerja" => "",
        "ket_ukerja" => "UPT SMP N 02",
        "tgl_arsip" => "2023-12-05",
        "status" => 1
      ],
      [
        "id" => "3",
        "kode_ukerja" => "",
        "ket_ukerja" => "UPT SMP N 03",
        "tgl_arsip" => null,
        "status" => 0
      ],
    );
    $response = array(
      "draw" => "1",
      "data" => $dummy_data,
      "recordTotal" => 4,
      "recordFiltered" => 4
    );
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($response));
  }
}
