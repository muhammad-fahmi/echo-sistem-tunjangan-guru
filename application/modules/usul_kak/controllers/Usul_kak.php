<?php defined('BASEPATH') or exit('No direct script access allowed');

class Usul_kak extends MY_Controller
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
      $this->load->model('mdl_usul_kak', 'muk');
    }
  }

  public function index()
  {
    $this->session->set_userdata('menu', 'usul_kak');
    $sent_data = $this->db->get_where('v_pagu_realisasi', 'kode_unor IS NOT NULL')->row_array();
    $data = array(
      'page_title' => "Usul KAK",
      'module' => "usul_kak",
      'view' => "vw_usul_kak_list",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  public function get_datatable()
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
      'kode_ukerja' => $this->input->post('kode_ukerja'),
      'filter_tgl' => $this->input->post('filter_tgl'),
      'filter_tgl_akhir' => $this->input->post('filter_tgl_akhir'),
    );
    // move the db operation to the designated models
    $result = $this->muk->get_datatable('v_kak', $param);
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
      'message' => "Invalid Command"
    ];

    /// |----------------------------------------
    /// | COMMANDS
    /// |----------------------------------------
    switch ($type) {
      case 'save_usul_kak': {
          if ($id != 0) {
            /// |----------------------------------------
            /// | PROSES EDIT
            /// |----------------------------------------
            $dataset = $this->muk->get('v_kak', "id = '$id'");
            if (isset_nn_nes($dataset)) {

              $data = [
                'modal_title' => "Edit Usul KAK",
                'data' => $dataset
              ];
              $res = [
                'status' => true,
                'message' => "Modal Edit Usul KAK",
                'html' => $this->load->view('vw_usul_kak_modal_save_', $data, true)
              ];
            }
          } else {
            /// |----------------------------------------
            /// | PROSES TAMBAH
            /// |----------------------------------------
            $dataset = [
              'id_kak' => 0,
              'kode_unor' => '',
              'kode_kegiatan' => '',
              'tahun' => '',
              'tgl_susun' => '',
              'deskripsi' => '',
              'indikator' => '',
              'target' => '',
              'volume' => '',
              'satuan' => '',
              'indikator' => '',
              'target' => '',
              'volume' => '',
              'satuan' => '',
              'lokasi' => '',
              'metode' => '',
              'id_iku' => '',
              'var_iku' => '',
              'slock' => '',
              'slog' => '',
              'real_bln1' => '',
              'real_bln2' => '',
              'real_bln3' => '',
              'real_bln4' => '',
              'real_bln5' => '',
              'real_bln6' => '',
              'real_bln7' => '',
              'real_bln8' => '',
              'real_bln9' => '',
              'real_bln10' => '',
              'real_bln11' => '',
              'real_bln12' => '',
              'ket_unor' => '',
              'jenis_unor' => '',
              'target' => '',
              'pagu' => '',
              'ket_iku' => ''
            ];
            $data = [
              'modal_title' => "Tambah Usul KAK",
              'data' => $dataset
            ];
            $res = [
              'status' => true,
              'message' => "Modal Tambah Usul KAK",
              'html' => $this->load->view('vw_usul_kak_modal_save', $data, true)
            ];
          }
          break;
        }
      case 'delete_usul_kak': {
          /// |----------------------------------------
          /// | PROSES DELETE
          /// |----------------------------------------
          $dataset = $this->muk->get('v_kak', "id_kak = '$id'");
          if (isset_nn_nes($dataset)) {
            $data = [
              'modal_title' => "Hapus Usulan KAK",
              'data' => $dataset
            ];
            $res = [
              'status' => true,
              'message' => "Modal Hapus Usulan KAK",
              'html' => $this->load->view('vw_usul_kak_modal_delete', $data, true)
            ];
          }
          break;
        }

      default: {
          break;
        }
    }

    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }

  public function form($id_kak = "0", $type = "save_usul_kak")
  {
    $id = $id_kak;
    $pagu_realisasi = $this->db->get_where('v_pagu_realisasi', 'kode_unor IS NOT NULL')->row_array();
    /// |----------------------------------------
    /// | DEFAULT VALUE
    /// |----------------------------------------
    $res = [
      'status' => false,
      'message' => "Invalid Command"
    ];
    $dataset = false;

    /// |----------------------------------------
    /// | COMMANDS
    /// |----------------------------------------
    switch ($type) {
      case 'save_usul_kak': {
          //echo "apodfkapokd";
          if ($id_kak != "0") {
            /// |----------------------------------------
            /// | PROSES EDIT
            /// |----------------------------------------
            //echo "edit nih coy";
            $dataset = $this->muk->get('v_kak', "id_kak = '$id'");
            $get_program_kegiatan = $this->db->where("kode_sub_kegiatan = '" . $dataset["kode_kegiatan"] . "'")->get("v_kegiatan_program")->row_array();
            $dataset["ket_kegiatan"] = $get_program_kegiatan["kode_kegiatan"] . " - " . $get_program_kegiatan["uraian_kegiatan"];
            $dataset["ket_program"] = $get_program_kegiatan["kode_program"] . " - " . $get_program_kegiatan["uraian_program"];
            $dataset["uraian_kegiatan"] = $dataset["kode_kegiatan"] . " - " . $dataset["uraian_kegiatan"];
          } else {
            /// |----------------------------------------
            /// | PROSES TAMBAH
            /// |----------------------------------------
            //echo "tambah nih coy";
            $dataset = [
              'id_kak' => 0,
              'kode_unor' => '',
              'kode_kegiatan' => '',
              'ket_program' => '',
              'tahun' => $this->session->userdata("tahun_anggaran"),
              'tgl_susun' => date("Y-m-d"),
              'deskripsi' => '',
              'indikator' => '',
              'target' => '',
              'volume' => '',
              'satuan' => '',
              'indikator' => '',
              'target' => '',
              'volume' => '',
              'satuan' => '',
              'lokasi' => '',
              'metode' => '',
              'id_iku' => '',
              'var_iku' => '',
              'slock' => '',
              'slog' => '',
              'real_bln1' => '',
              'real_bln2' => '',
              'real_bln3' => '',
              'real_bln4' => '',
              'real_bln5' => '',
              'real_bln6' => '',
              'real_bln7' => '',
              'real_bln8' => '',
              'real_bln9' => '',
              'real_bln10' => '',
              'real_bln11' => '',
              'real_bln12' => '',
              'ket_unor' => '',
              'jenis_unor' => '',
              'target' => '',
              'pagu' => '',
              'ket_iku' => ''
            ];
          }
          break;
        }
      case 'delete_usul_kak': {
          /// |----------------------------------------
          /// | PROSES DELETE
          /// |----------------------------------------
          $dataset = $this->muk->get('v_kak', "id_kak = '$id'");
          break;
        }

      default: {
          //echo "tai kucing";
          break;
        }
    }
    $sent_data = $dataset;
    $data_view = array(
      'page_title' => "Usul KAK Form",
      'module' => "usul_kak",
      'view' => "vw_usul_kak_form",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data_view);
  }

  public function save()
  {
    /// |----------------------------------------
    /// | PHP WARNING SUPPRESSOR
    /// |----------------------------------------
    if (ob_get_contents() != false) {
      ob_get_contents();
      ob_end_clean();
    }

    $kewenangan = $this->session->userdata("kewenangan");
    $kode_unor = $this->session->userdata("kode_unor");

    /// |----------------------------------------
    /// | GET POST VALUES
    /// |----------------------------------------
    $dataset = [
      'id_kak' => $this->input->post('id_kak'),
      'kode_unor' => $this->input->post('kode_unor'),
      'kode_kegiatan' => $this->input->post('kode_sub_kegiatan'),
      'tahun' => $this->session->userdata("tahun_anggaran"),
      'tgl_susun' => tgl_mysql($this->input->post('tgl_susun')),
      'deskripsi' => $this->input->post('deskripsi'),
      'indikator' => $this->input->post('indikator'),
      'target' => $this->input->post('target'),
      'volume' => $this->input->post('volume'),
      'satuan' => $this->input->post('satuan'),
      'indikator' => $this->input->post('indikator'),
      'target' => $this->input->post('target'),
      'lokasi' => $this->input->post('lokasi'),
      'metode' => $this->input->post('metode'),
      'id_iku' => $this->input->post('id_iku'),
      'var_iku' => $this->input->post('var_iku'),
      'real_bln1' => (isset_nn_nes($this->input->post('real_bln1')) && $this->input->post('real_bln1') == "on") ? "1" : "0",
      'real_bln2' => (isset_nn_nes($this->input->post('real_bln2')) && $this->input->post('real_bln2') == "on") ? "1" : "0",
      'real_bln3' => (isset_nn_nes($this->input->post('real_bln3')) && $this->input->post('real_bln3') == "on") ? "1" : "0",
      'real_bln4' => (isset_nn_nes($this->input->post('real_bln4')) && $this->input->post('real_bln4') == "on") ? "1" : "0",
      'real_bln5' => (isset_nn_nes($this->input->post('real_bln5')) && $this->input->post('real_bln5') == "on") ? "1" : "0",
      'real_bln6' => (isset_nn_nes($this->input->post('real_bln6')) && $this->input->post('real_bln6') == "on") ? "1" : "0",
      'real_bln7' => (isset_nn_nes($this->input->post('real_bln7')) && $this->input->post('real_bln7') == "on") ? "1" : "0",
      'real_bln8' => (isset_nn_nes($this->input->post('real_bln8')) && $this->input->post('real_bln8') == "on") ? "1" : "0",
      'real_bln9' => (isset_nn_nes($this->input->post('real_bln9')) && $this->input->post('real_bln9') == "on") ? "1" : "0",
      'real_bln10' => (isset_nn_nes($this->input->post('real_bln10')) && $this->input->post('real_bln10') == "on") ? "1" : "0",
      'real_bln11' => (isset_nn_nes($this->input->post('real_bln11')) && $this->input->post('real_bln11') == "on") ? "1" : "0",
      'real_bln12' => (isset_nn_nes($this->input->post('real_bln12')) && $this->input->post('real_bln12') == "on") ? "1" : "0"
    ];

    /// |----------------------------------------
    /// | CEK Apakah Admin berhak input data kegiatan dibidang
    /// |----------------------------------------

    //jika bukan super admin lakukan pengecekan
    if ($kewenangan != '00') {
      if ($kode_unor != $dataset["kode_unor"]) {
        $fail_msg = "Hak userterbatas. Anda tidak bisa mengakses KAK diluar unit anda!";
        $res = [
          'status' => false,
          'message' => $fail_msg
        ];

        return $this->output
          ->set_content_type('application/json')
          ->set_output(json_encode($res));
      }
    }


    /// |----------------------------------------
    /// | LAKUKAN PROSES DB
    /// |----------------------------------------
    $this->db->trans_begin();

    if (isset_nn_nes($dataset["id_kak"]) && $dataset["id_kak"] != 0) {
      /// |----------------------------------------
      /// | PROSES UPDATE
      /// |----------------------------------------
      $where = "id_kak = '" . $dataset["id_kak"] . "'";
      $fail_msg = "Proses update data KAK gagal dilakukan.";
      $ok_msg = "Proses update data KAK berhasil dilakukan.";
      $this->db->update('r_kak', $dataset, $where);
    } else {
      /// |----------------------------------------
      /// | PROSES INSERT
      /// |----------------------------------------
      $fail_msg = "Proses penambahan data KAK gagal dilakukan.";
      $ok_msg = "Proses penambahan data KAK berhasil dilakukan.";
      $this->db->insert('r_kak', $dataset);
    }
    if ($this->db->trans_status() === FALSE) {
      // do your error handler here
      $this->db->trans_rollback();
      $res = [
        'status' => false,
        'message' => $fail_msg
      ];
    } else {
      // do your success handler here
      $this->db->trans_commit();
      $res = [
        'status' => true,
        'message' => $ok_msg
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
      'message' => "Maaf, proses penghapusan surat tugas gagal dilakukan."
    ];

    $id = $this->input->post('id');
    $where = "id = '$id'";
    $dataset = $this->muk->get('v_surat_tugas', $where);
    if (isset_nn_nes($id) && isset_nn_nes($dataset)) {
      $data = [
        'del_on' => datetime_now(),
        'del_by' => $this->session->userdata('username'),
        's_aktif' => 0
      ];
      $this->db->trans_begin();
      // do your db process here
      $this->db->update('r_surat_tugas', $data, $where);
      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
      } else {
        // do your success handler here
        $this->db->trans_commit();
        $res = [
          'status' => true,
          'message' => "Proses penghapusan surat tugas berhasil dilakukan."
        ];
      }
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }

  //fungsi untuk menampilkan daftar belanja dari KAK yang dibuat
  public function detail_belanja_list($id_kak = 0)
  {
    $this->session->set_userdata('menu', 'usul_kak');
    $sent_data["detail_kak"]     = $this->db->get_where('v_kak', array("id_kak" => $id_kak))->row_array();
    $sent_data["detail_kegiatan"]    = $this->db->get_where('v_kegiatan_program', array("kode_sub_kegiatan" => $sent_data["detail_kak"]["kode_kegiatan"]))->row_array();
    $sent_data["pagu_realisasi"] = $this->db->get_where('v_pagu_realisasi', 'kode_unor IS NOT NULL')->row_array();
    $data = array(
      'page_title' => "Rincian Belanja KAK",
      'module' => "usul_kak",
      'view' => "vw_usul_kak_belanja",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  //fungsi untuk menampilkan form untuk menambah/edit detail belanja
  public function detail_belanja_form($id_kak_belanja = 0)
  {
  }
}
