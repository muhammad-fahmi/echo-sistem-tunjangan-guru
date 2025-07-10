<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pdt_peserta_didik extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();

    $is_ajax = $this->input->is_ajax_request();
    if (!$is_ajax) {
      $this->session->set_userdata('menu', 'PDT_PesertaDidik');
      if (!check_perm('read') || !is_logged_in()) {
        redirect(site_url('pangkalan_data'));
      }
    }

    $this->load->model('mdl_pdt_peserta_didik', 'mdl_peserta_didik');
  }

  public function index()
  {
    // lakukan proses init halaman
    $sent_data = array();
    $data = array(
      'page_title' => "Peserta Didik | PROGURINDA",
      'module' => "pdt_peserta_didik",
      'view' => "vw_peserta_didik_list",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  public function detail($encryptedID = '')
  {
    $decryptedID = decrypt_id(sanitize_string($encryptedID));

    // CEK VALIDASI DATA
    $dataset = fetch_row_data('v_progurinda_siswa', ['id_siswa' => $decryptedID], false);
    if ($dataset == false) {
      $this->session->set_userdata('flash_data', "Maaf, data Peserta Didik yang akan dilihat detailnya tidak valid.");
      redirect(site_url('pdt_peserta_didik'));
      return;
    }

    $dataset['id_siswa'] = encrypt_id($dataset['id_siswa']);

    $data = array(
      'page_title' => "Detail Data Peserta Didik | PROGURINDA",
      'module' => "pdt_peserta_didik",
      'view' => 'vw_peserta_didik_detail',
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
    );
    // move the db operation to the designated models
    $result = $this->mdl_peserta_didik->get_datatable($param);
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
      case 'tambah_peserta_didik': {
          /// |----------------------------------------
          /// | INSERT DATA
          /// |----------------------------------------
          $dataset = [
            // 'id_siswa' => $this->mdl_peserta_didik->generate_id_siswa(),
            'id_siswa' => '',
            'nama' => '',
            'nisn' => '',
            'nik' => '',
            'jenis_kelamin' => '',
            'kode_agama' => '',
            'nama_ayah' => '',
            'nama_ibu' => '',
            'no_kk' => '',
            'alamat' => '',
            's_aktif' => 1,
            'pdpd' => '',
          ];
          $data = [
            'modal_title' => "Tambah Data Siswa",
            'data' => $dataset,
          ];
          $res = [
            'status' => true,
            'message' => "Modal Tambah Data Siswa",
            'html' => $this->load->view('vw_peserta_didik_modal_save', $data, true)
          ];
          break;
        }
      case 'edit_peserta_didik': {
          /// |----------------------------------------
          /// | EDIT DATA
          /// |----------------------------------------
          $dataset = $this->mdl_peserta_didik->get('v_progurinda_siswa', "id_siswa = '$decryptedID'");
          $data = [
            'modal_title' => "Edit Data Siswa",
            'type' => $type,
            'data' => $dataset,
          ];
          $res = [
            'status' => true,
            'message' => "Modal Edit Data Siswa",
            'html' => $this->load->view('vw_peserta_didik_modal_save', $data, true)
          ];
          break;
        }
      case 'delete_peserta_didik': {
          /// |----------------------------------------
          /// | DELETE DATA
          /// |----------------------------------------
          $dataset = $this->mdl_peserta_didik->get('v_progurinda_siswa', "id_siswa = '$decryptedID'");
          if (isset_nn_nes($dataset)) {
            $data = [
              'modal_title' => "Hapus Data Siswa",
              'data' => $dataset,
            ];
            $res = [
              'status' => true,
              'message' => "Modal Hapus Data Siswa",
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

    // set data array utk proses insert
    $data_to_save = array(
      'id_siswa' => $post['id_siswa'],
      'nama' => $post['nama'],
      'nisn' => $post['nisn'],
      'nik' => $post['nik'],
      'jenis_kelamin' => $post['jenis_kelamin'],
      'kode_agama' => $post['kode_agama'],
      'nama_ayah' => $post['nama_ayah'],
      'nama_ibu' => $post['nama_ibu'],
      'no_kk' => $post['no_kk'],
      'alamat' => $post['alamat'],
      's_aktif' => $post['s_aktif'],
      'tgl_masuk' => em_date('Y-m-d'),
      'pdpd' => $post['pdpd_options'],
    );

    // Jika peserta didik di non-aktifkan, lanjutkan proses insert data
    if ($data_to_save['s_aktif'] == 0) {
      $data_to_save['alasan_keluar'] = $post['alasan_keluar'];
      $data_to_save['tgl_keluar'] = em_date('Y-m-d');
    }

    $res = $this->mdl_peserta_didik->save_peserta_didik($data_to_save);

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
    $res = $this->mdl_peserta_didik->delete_peserta_didik($data);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }
}
