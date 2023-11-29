<?php defined('BASEPATH') or exit('No direct script access allowed');

class Jurnal_mengajar extends MY_Controller
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
      $this->load->model('mdl_jurnal_mengajar', 'mjm');
    }
  }

  public function index()
  {
    // lakukan proses init halaman
    $this->session->set_userdata('menu', 'jurnal_mengajar');
    $sent_data = array();
    $data = array(
      'page_title' => "List Jurnal Mengajar",
      'module' => "jurnal_mengajar",
      'view' => "vw_jurnal_mengajar",
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
    $result = $this->mjm->get_datatable('v_progurinda_jurnal_mengajar',$param);
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
      case 'tambah_jurnal_mengajar': {
        /// |----------------------------------------
        /// | INSERT DATA
        /// |----------------------------------------
        $dataset = [
          'nip' => '',
          'kode_jab' => '',
          'kode_ukerja' => '',
          'bulan' => '',
          'tahun' => '',
          'jam_mengajar' => '',
          'id' => $id
        ];
        $data = [
          'modal_title' => "Tambah Jurnal Mengajar",
          'data' => $dataset,
          'type' => 'insert'
        ];
        $res = [
          'status' => true,
          'message' => "Modal Tambah Jurnal Mengajar",
          'html' => $this->load->view('vw_jurnal_mengajar_modal_save', $data, true)
        ];
        break;
      }
      case 'edit_jurnal_mengajar': {
        /// |----------------------------------------
        /// | EDIT DATA
        /// |----------------------------------------
        $dataset = $this->mjm->get('v_progurinda_jurnal_mengajar', "id = '$id'");
        $data = [
          'modal_title' => "Edit Jurnal Mengajar Guru",
          'data' => $dataset,
        ];
        $res = [
          'status' => true,
          'message' => "Modal Edit Jurnal Mengajar Guru",
          'html' => $this->load->view('vw_jurnal_mengajar_modal_save', $data, true)
        ];
        break;
      }
      case 'delete_jurnal_mengajar': {
        /// |----------------------------------------
        /// | DELETE DATA
        /// |----------------------------------------
        $dataset = $this->mjm->get('v_progurinda_jurnal_mengajar', "id = '$id'");
        if (isset_nn_nes($dataset)) {
          $data = [
            'modal_title' => "Hapus Jurnal Mengajar Guru",
            'data' => $dataset,
          ];
          $res = [
            'status' => true,
            'message' => "Modal Hapus Jurnal Mengajar Guru",
            'html' => $this->load->view('vw_jurnal_mengajar_modal_delete', $data, true)
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
        'kode_jab' => $post['kode_jab'],
        'kode_ukerja' => $post['kode_ukerja'],
        'bulan' => $post['bulan'],
        'tahun' => $post['tahun'],
        'jam_mengajar' => $post['jam_mengajar'],
      );
      if ($id == 0) {
        // unset($data_to_save["id"]);
        // $data_to_save["insert_by"] = $this->session->userdata("username");
        // $data_to_save["insert_on"] = date("Y-m-d H:i:s");
        $this->db->insert('progurinda_r_jurnal_mengajar', $data_to_save);
      } else {
        // $data_to_save["update_by"] = $this->session->userdata("username");
        // $data_to_save["update_on"] = date("Y-m-d H:i:s");
        $this->db->where(["id" => $id])->update("progurinda_r_jurnal_mengajar", $data_to_save);
      }
    } catch (\Throwable $th) {
      $res = [
        'status' => false,
        'message' => "Maaf, proses penyimpanan data jurnal mengajar mengalami error.\n" . $th->getMessage()
      ];
    }

    if ($this->db->trans_status() === FALSE) {
      // do your error handler here
      $this->db->trans_rollback();
      $res = [
        'status' => false,
        'message' => "Maaf, proses penambahan data jurnal mengajar mengalami error.\n(error code: MPL_INST_RB)"
      ];
    } else {
      // do your success handler here
      $this->db->trans_commit();
      $res = [
        'status' => true,
        'message' => "Proses penambahan data jurnal mengajar berhasil dilakukan!"
      ];
    }
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }

  public function delete()
  {
    $res = [
      'status' => false,
      'message' => "Maaf, proses penghapusan data jurnal mengajar gagal dilakukan!"
    ];

    $data["id"] = $this->input->post('id');
    $res = $this->mjm->delete($data);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }
}