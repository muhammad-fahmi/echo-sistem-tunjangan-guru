<?php defined('BASEPATH') or exit('No direct script access allowed');

class Peserta_didik extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    // lakukan proses verifikasi user disini
    parent::__construct();
    $priv = $this->session->userdata('kewenangan');
    $log = $this->session->userdata('logged_in');
    if ($log != true) {
      redirect(site_url('login'));
    } else {
      $this->load->model('mdl_peserta_didik', 'mpd');
    }
  }

  public function index()
  {
    // lakukan proses init halaman
    $sent_data = array();
    $this->session->set_userdata('menu', 'peserta_didik');
    // $sent_data = $this->db->get_where('progurinda_r_siswa', 'nisn IS NOT NULL')->row_array();
    $data = array(
      'page_title' => "Manajemen Peserta Didik",
      'module' => "peserta_didik",
      'view' => "vw_peserta_didik_list",
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
    $result = $this->mpd->get_datatable($param);
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
    $id_siswa = $this->input->post('id_siswa');

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
      case 'tambah_peserta_didik': {
          /// |----------------------------------------
          /// | INSERT DATA
          /// |----------------------------------------
          $dataset = [
            'nama' => '',
            'nisn' => '',
            'nia' => '',
            'jenis_kelamin' => '',
            'kode_agama' => '',
            'nama_ayah' => '',
            'nama_ibu' => '',
            'no_kk' => '',
            'alamat' => '',
            'id_siswa' => $id_siswa
          ];
          $data = [
            'modal_title' => "Tambah Peserta Didik",
            'data' => $dataset,
          ];
          $res = [
            'status' => true,
            'message' => "Modal Tambah Peserta Didik",
            'html' => $this->load->view('vw_peserta_didik_modal_save', $data, true)
          ];
          break;
        }
      case 'edit_peserta_didik': {
          /// |----------------------------------------
          /// | EDIT DATA
          /// |----------------------------------------
          $dataset = $this->mpd->get('progurinda_r_siswa', "id_siswa = '$id_siswa'");
          $data = [
            'modal_title' => "Edit Peserta Didik",
            'data' => $dataset,
          ];
          $res = [
            'status' => true,
            'message' => "Modal Edit Peserta Didik",
            'html' => $this->load->view('vw_peserta_didik_modal_save', $data, true)
          ];
          break;
        }
      case 'delete_peserta_didik': {
          /// |----------------------------------------
          /// | DELETE DATA
          /// |----------------------------------------
          $dataset = $this->mpd->get('progurinda_r_siswa', "id_siswa = '$id_siswa'");
          if (isset_nn_nes($dataset)) {
            $data = [
              'modal_title' => "Hapus Peserta Didik",
              'data' => $dataset,
            ];
            $res = [
              'status' => true,
              'message' => "Modal Hapus Peserta Didik",
              'html' => $this->load->view('vw_peserta_didik_modal_delete', $data, true)
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
      'id_siswa' => $post['id_siswa'],
      'nama_lengkap' => $post['nama_lengkap'],
      'nisn' => $post['nisn'],
      'nia' => $post['nia'],
      'jenis_kelamin' => $post['jenis_kelamin'],
      'kode_agama' => $post['kode_agama'],
      'nama_ayah' => $post['nama_ayah'],
      'nama_ibu' => $post['nama_ibu'],
      'no_kk' => $post['no_kk'],
      'alamat' => $post['alamat'],
      's_aktif' => 'Y'
    );

    $res = $this->mpd->save($data_to_save);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }

  public function delete()
  {
    $res = [
      'status' => false,
      'message' => "Maaf, proses penghapusan data peserta didik gagal dilakukan!"
    ];

    $data["id_siswa"] = $this->input->post('id_siswa');
    $res = $this->mpd->delete($data);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }
}
