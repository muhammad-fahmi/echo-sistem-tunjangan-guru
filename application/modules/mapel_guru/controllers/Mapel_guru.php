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
    $sent_data = $this->db->get_where('progurinda_r_mapel', 'nip IS NOT NULL')->row_array();
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
      case 'tambah_mapel_guru': {
        /// |----------------------------------------
        /// | INSERT DATA
        /// |----------------------------------------
        $dataset = [
          'nip' => '',
          'nama_lengkap' => '',
          'ket_jab' => '',
          'unit_kerja' => '',
          'mapel' => '',
          'id' => $id
        ];
        $data = [
          'modal_title' => "Tambah Mapel Guru",
          'data' => $dataset,
        ];
        $res = [
          'status' => true,
          'message' => "Modal Tambah Mapel Guru",
          'html' => $this->load->view('vw_mapel_guru_modal_save', $data, true)
        ];
        break;
      }
      case 'edit_mapel_guru': {
        /// |----------------------------------------
        /// | EDIT DATA
        /// |----------------------------------------
        $dataset = $this->mmpg->get('v_progurinda_mapel', "id = '$id'");
        $data = [
          'modal_title' => "Edit Mapel Guru",
          'data' => $dataset,
        ];
        $res = [
          'status' => true,
          'message' => "Modal Edit Mapel Guru",
          'html' => $this->load->view('vw_mapel_guru_modal_save', $data, true)
        ];
        break;
      }
      case 'delete_mapel_guru': {
        /// |----------------------------------------
        /// | DELETE DATA
        /// |----------------------------------------
        $dataset = $this->mmpg->get('v_progurinda_mapel', "id = '$id'");
        if (isset_nn_nes($dataset)) {
          $data = [
            'modal_title' => "Hapus Mapel Guru",
            'data' => $dataset,
          ];
          $res = [
            'status' => true,
            'message' => "Modal Hapus Mapel Guru",
            'html' => $this->load->view('vw_mapel_guru_modal_delete', $data, true)
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
    $data_to_save = array(
      'id' => $post['id'],
      'nip' => $post['nip'],
      'kode_jab' => $post['kode_jab'],
      'kode_ukerja' => $post['kode_ukerja'],
      'mapel' => $post['mapel'],
    );

    $res = $this->mmpg->save($data_to_save);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));

    /// |----------------------------------------
    /// | DB PROCESS
    /// |----------------------------------------
    // $this->db->trans_begin();
    // try {
    //   $id = $post["id"];
      
    //   if ($id == 0) {
    //     unset($data_to_save["id"]);
    //     // $data_to_save["insert_by"] = $this->session->userdata("username");
    //     // $data_to_save["insert_on"] = date("Y-m-d H:i:s");
    //     $this->db->insert('progurinda_r_mapel', $data_to_save);
    //   } else {
    //     // $data_to_save["update_by"] = $this->session->userdata("username");
    //     // $data_to_save["update_on"] = date("Y-m-d H:i:s");
    //     $this->db->where(["id" => $id])->update("progurinda_r_mapel", $data_to_save);
    //   }
    // } catch (\Throwable $th) {
    //   return $this->output
    //     ->set_content_type('application/json')
    //     ->set_output(json_encode([
    //       'status' => false,
    //       'message' => "Maaf, proses penyimpanan data mapel mengalami error.\n" . $th->getMessage()
    //     ]));
    // }

    // if ($this->db->trans_status() === FALSE) {
    //   // do your error handler here
    //   $this->db->trans_rollback();
    //   return $this->output
    //     ->set_content_type('application/json')
    //     ->set_output(json_encode([
    //       'status' => false,
    //       'message' => "Maaf, proses penambahan data mapel mengalami error.\n(error code: MPL_INST_RB)"
    //     ]));
    // } else {
    //   // do your success handler here
    //   $this->db->trans_commit();
    //   return $this->output
    //     ->set_content_type('application/json')
    //     ->set_output(json_encode([
    //       'status' => true,
    //       'message' => "Proses penambahan data mapel berhasil dilakukan!"
    //     ]));
    // }
  }

  public function delete()
  {
    $res = [
      'status' => false,
      'message' => "Maaf, proses penghapusan data mapel gagal dilakukan!"
    ];

    $data["id"] = $this->input->post('id');
    $res = $this->mmpg->delete($data);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }
}
