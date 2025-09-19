<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pdt_rombongan_belajar extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    $is_ajax = $this->input->is_ajax_request();
    if (!$is_ajax) {
      $this->session->set_userdata('menu', 'PDT_DTARombel');
      if (!check_perm('read') || !is_logged_in()) {
        redirect(site_url('pangkalan_data'));
      }
    }
    $this->load->model('mdl_pdt_rombel', 'mdl_rombongan_belajar');
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

  public function detail($encryptedID = '')
  {
    $decryptedID = decrypt_id(sanitize_string($encryptedID));

    $dataset = fetch_row_data('v_rombongan_belajar', ['id' => $decryptedID], false);
    if ($dataset == false) {
      $this->session->set_userdata('flash_data', "Maaf, data Rombongan Belajar yang akan dilihat detailnya tidak valid.");
      redirect(site_url('pdt_rombongan_belajar'));
      return;
    }

    // lakukan proses init halaman
    $data = array(
      'page_title' => "Update Rombongan Belajar | PROGURINDA",
      'module' => "pdt_rombongan_belajar",
      'view' => "vw_update_rombongan_belajar",
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
    $result = $this->mdl_rombongan_belajar->get_datatable($param);
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

  public function get_data_siswa()
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
      'id_siswa' => $this->input->post('id_siswa'),
      'id_rombel' => $this->input->post('id_rombel'),
    );
    // move the db operation to the designated models
    $result = $this->mdl_rombongan_belajar->get_datatable_siswa($param);
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
    $decryptedID = decrypt_id(sanitize_string($id));
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
      case 'tambah_rombongan_belajar': {
          /// |----------------------------------------
          /// | INSERT DATA
          /// |----------------------------------------
          $dataset = [];
          $data = [
            'modal_title' => "Tambah Rombongan Belajar",
            'type' => 'add',
            'data' => $dataset,
          ];
          $res = [
            'status' => true,
            'message' => "Modal Tambah Rombongan Belajar",
            'html' => $this->load->view('vwm_add_rombongan_belajar', $data, true)
          ];
          break;
        }
      case 'tambah_siswa_rombel': {
          /// |----------------------------------------
          /// | INSERT DATA SISWA ROMBEL
          /// |----------------------------------------
          $dataset = $this->mdl_rombongan_belajar->get('v_rombongan_belajar', "id = '$id'");
          $data = [
            'modal_title' => "Tambah Peserta Didik",
            'type' => 'add',
            'data' => $dataset,
          ];
          $res = [
            'status' => true,
            'message' => "Modal Tambah Peserta Didik",
            'html' => $this->load->view('vwm_add_siswa_rombel', $data, true)
          ];
          break;
        }
      case 'delete_rombongan_belajar': {
          /// |----------------------------------------
          /// | DELETE DATA
          /// |----------------------------------------
          $dataset = $this->mdl_rombongan_belajar->get('v_rombongan_belajar', "id = '$decryptedID'");
          if (isset_nn_nes($dataset)) {
            $data = [
              'modal_title' => "Hapus Rombongan Belajar",
              'type' => 'delete',
              'data' => $dataset,
            ];
            $res = [
              'status' => true,
              'message' => "Modal Hapus Rombongan Belajar",
              'html' => $this->load->view('vwm_delete_rombongan_belajar', $data, true)
            ];
          }
          break;
        }
      case 'delete_siswa_rombel': {
          /// |----------------------------------------
          /// | DELETE DATA
          /// |----------------------------------------
          $dataset = $this->mdl_rombongan_belajar->get('v_peserta_didik_rombel', "id_siswa = '$decryptedID'");
          if (isset_nn_nes($dataset)) {
            $data = [
              'modal_title' => "Hapus Peserta Didik Rombel",
              'type' => 'delete',
              'data' => $dataset,
            ];
            $res = [
              'status' => true,
              'message' => "Modal Hapus Peserta Didik Rombel",
              'html' => $this->load->view('vwm_delete_siswa_rombel', $data, true)
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
    $post = post_safe();

    // set data array utk proses insert
    $data_to_save = array(
      'id' => $post['id'],
      'jenjang' => $post['id_jenjang'],
      'kelas' => $post['id_kelas'],
      'id_sekolah' => $post['id_sekolah'],
      'ket_sekolah' => $post['ket_sekolah'],
      'nama_rombel' => $post['nama_rombel'],
      'id_tahun_ajaran' => $post['id_tahun_ajaran'],
      'created_by' => $this->session->userdata('username'),
      'created_at' => em_date('Y-m-d'),
    );

    $res = $this->mdl_rombongan_belajar->save_rombel($data_to_save);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }

  public function save_siswa()
  {
    /// |----------------------------------------
    /// | AMBIL DATA POST
    /// |----------------------------------------
    $post = post_safe();

    // set data array utk proses insert
    $data_to_save = array(
      'id_siswa' => $post['id_siswa'],
      'id_rombel' => $post['id_rombel'],
      'tgl_masuk_rombel' => em_date('Y-m-d'),
      'insert_by' => $this->session->userdata("username")
    );

    $res = $this->mdl_rombongan_belajar->save_siswa_rombel($data_to_save);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }

  public function delete()
  {
    $res = [
      'status' => false,
      'message' => "Maaf, proses penghapusan data rombongan belajar gagal dilakukan!"
    ];

    $data["id"] = $this->input->post('id');
    $res = $this->mdl_rombongan_belajar->delete_rombel($data);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }

  public function delete_siswa()
  {
    $res = [
      'status' => false,
      'message' => "Maaf, proses penghapusan data Peserta Didik di rombongan belajar gagal dilakukan!"
    ];

    $data["id_siswa"] = $this->input->post('id_siswa');
    $res = $this->mdl_rombongan_belajar->delete_siswa_rombel($data);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }
}
