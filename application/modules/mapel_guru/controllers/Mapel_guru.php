<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mapel_guru extends MY_Controller
{
  //Class construction method
  public function __construct()
  {
    parent::__construct();
    $priv = $this->session->userdata('kewenangan');
    $log = $this->session->userdata('logged_in');
    if ($log != true) {
      redirect(site_url('login'));
    } else {
      $this->load->model('mdl_mapel_guru', 'mmpg');
    }
  }

  public function index()
  {
    $this->session->set_userdata('menu', 'mapel_guru');
    $sent_data = $this->db->get_where('r_mapel_progurinda', 'kode_unor IS NOT NULL')->row_array();
    $data = array(
      'page_title' => "Setup Mata Pelajaran Guru",
      'module' => "mapel_guru",
      'view' => "vw_mapel_guru_list",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  public function datalist()
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
    $result = $this->mmpg->get_datatable($param);
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
      case 'tambah_usul_ssh': {
          $select_volume = ssh_get_volume_selection();
          $dataset = [
            'tahun' => '',
            'kode_standar' => '',
            'uraian_standar' => '',
            'spesifikasi_standar' => '',
            'volume_standar' => '',
            'harga_standar' => '',
            'pdn_standar' => '',
            'jenis_standar' => '',
          ];
          $data = [
            'modal_title' => "Tambah Mapel Guru",
            'data' => $dataset,
            'type' => 'insert',
            'select_volume' => ($select_volume['count'] > 0) ? $select_volume['data'] : ''
          ];
          $res = [
            'status' => true,
            'message' => "Modal Tambah Mapel Guru",
            'html' => $this->load->view('vw_mapel_guru_modal_save', $data, true)
          ];
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

  public function save()
  {
    /// |----------------------------------------
    /// | AMBIL DATA POST
    /// |----------------------------------------
    $post = $this->input->post();

    /// |----------------------------------------
    /// | CEK TAHUN & KODE STANDAR
    /// |----------------------------------------
    $cek_tahun_kodeStandar = $this->db->get_where('r_standarharga', [
      'tahun' => $post['tahun'],
      'kode_standar' => $post['kode_standar'],
    ])->num_rows();
    if ($cek_tahun_kodeStandar > 0) {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => "Maaf, proses penambahan data usul SSH gagal dilakukan karena sudah ada data dengan Tahun dan Kode Standar yang sama dalam database."
        ]));
    }

    /// |----------------------------------------
    /// | DB PROCESS
    /// |----------------------------------------
    $this->db->trans_begin();
    // do your db process here

    try {

      $data_to_save = array(
        'tahun' => $post['tahun'],
        'kode_standar' => $post['kode_standar'],
        'uraian_standar' => $post['uraian_standar'],
        'spesifikasi_standar' => $post['spesifikasi_standar'],
        'volume_standar' => $post['volume_standar'],
        'harga_standar' => $post['harga_standar'],
        'pdn_standar' => $post['pdn_standar'],
        'jenis_standar' => $post['jenis_standar'],
      );

      $this->db->insert('r_standarharga', $data_to_save);
    } catch (\Throwable $th) {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => "Maaf, proses penambahan data usul SSH mengalami error.\n" . $th->getMessage()
        ]));
    }

    if ($this->db->trans_status() === FALSE) {
      // do your error handler here
      $this->db->trans_rollback();
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => "Maaf, proses penambahan data usul SSH mengalami error.\n(error code: GCGHC_TDTDJ_HGTJN)"
        ]));
    } else {
      // do your success handler here
      $this->db->trans_commit();
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => true,
          'message' => "Proses penambahan data Usul SSH berhasil dilakukan!"
        ]));
    }
  }
}
