<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tugas_tambahan extends MY_Controller
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
      $this->load->model('mdl_tugas_tambahan', 'mtt');
    }
  }

  public function index()
  {
    // lakukan proses init halaman
    $this->session->set_userdata('menu', 'tugas_tambahan');
    $sent_data = array();
    $data = array(
      'page_title' => "Tugas Tambahan",
      'module' => "tugas_tambahan",
      'view' => "vw_tugas_tambahan",
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
      /* additional data can be declared here */
    );
    // move the db operation to the designated models
    $result = $this->mtt->get_datatable('progurinda_r_tugas_tambahan',$param);
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
      case 'tambah_tugas_tambahan': {
          $dataset = [
            'nip' => '',
            'nama_lengkap' => '',
            'ket_jab' => '',
            'unit_kerja' => '',
            'mapel' => '',
            'tugas_tambahan' => '',
            'id' => $id
          ];
          $data = [
            'modal_title' => "Tambah Tugas Tambahan Guru",
            'data' => $dataset,
            'type' => 'insert'
          ];
          $res = [
            'status' => true,
            'message' => "Modal Tambah Tugas Tambahan Guru",
            'html' => $this->load->view('vw_tugas_tambahan_modal_save', $data, true)
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
    /// | DB PROCESS
    /// |----------------------------------------
    $this->db->trans_begin();
    // do your db process here

    try {
      $id = $post["id"];
      $data_to_save = array(
        'id' => $post['id'],
        'nip' => $post['nip'],
        'mapel' => $post['mapel'],
      );
      if ($id == 0) {
        unset($data_to_save["id"]);
        $data_to_save["insert_by"] = $this->session->userdata("username");
        $data_to_save["insert_on"] = date("Y-m-d H:i:s");
        $this->db->insert('progurinda_r_mapel', $data_to_save);
      } else {
        $data_to_save["update_by"] = $this->session->userdata("username");
        $data_to_save["update_on"] = date("Y-m-d H:i:s");
        $this->db->where(["id" => $id])->update("progurinda_r_mapel", $data_to_save);
      }
    } catch (\Throwable $th) {
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => "Maaf, proses penyimpanan data mapel mengalami error.\n" . $th->getMessage()
        ]));
    }

    if ($this->db->trans_status() === FALSE) {
      // do your error handler here
      $this->db->trans_rollback();
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => false,
          'message' => "Maaf, proses penambahan data mapel mengalami error.\n(error code: MPL_INST_RB)"
        ]));
    } else {
      // do your success handler here
      $this->db->trans_commit();
      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => true,
          'message' => "Proses penambahan data mapel berhasil dilakukan!"
        ]));
    }
  }
}