<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pdt_ptk extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        // lakukan proses verifikasi user disini
        // lakukan proses verifikasi user disini
        $priv = $this->session->userdata('kewenangan');
        $log = $this->session->userdata('logged_in');
        if ($log != true) {
            redirect(site_url('login'));
        } else {
            $this->load->model('mdl_pdt_ptk', 'mdl_ptk');
        }
  }

  public function index()
  {
    // lakukan proses init halaman
    $sent_data = [];
    $data = array(
      'page_title' => "List PTK",
      'module' => "pdt_ptk",
      'view' => "vw_pdt_ptk",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  public function datalist(){
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
      'kode_ukerja' => $this->session->userdata("kode_unor")
      /* additional data can be declared here */
    );
    // move the db operation to the designated models
    $result = $this->mdl_ptk->get_datatable('v_progurinda_ptk', $param);    // return the data back to the views
    $data["recordsTotal"] = $result['total'];
    $data["recordsFiltered"] = $result['filtered'];
    $data["data"] = $result['data'];
    $data["draw"] = $result['draw'];
    // using common_helper function
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function edit($nip)
  {
    $decoded_nip = base64_decode($nip);
    $kode_ukerja = $this->session->userdata("kode_unor");
    $q_data_gtk  = $this->db->where(["nip" => $decoded_nip,"kode_ukerja" => $kode_ukerja,"s_aktif" => "-1"])->get("v_progurinda_ptk");
    //check apakah ada record dari nip yang dicari
    if ($q_data_gtk->num_rows() > 0){
      //siapkan data pegawai dan batasi hanya untuk OPD nya saja
      $sent_data["nip"] = base64_decode($nip);
      $sent_data["kode_ukerja"] = $kode_ukerja;
      $sent_data["data_gtk"] = $q_data_gtk->row_array();
      $data = array(
        'page_title' => "List PTK",
        'module' => "ptk",
        'view' => "vw_form",
        'data' => $sent_data
      );
      echo Modules::run('layout/backend', $data);
    }else{
      //return / redirect ke page sebelumnya
      echo "NIP tidak ditemukan";
    }
  }

  public function save_gtk() {
    //form validation
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
      case 'tambah_ptk': {
        /// |----------------------------------------
        /// | INSERT DATA
        /// |----------------------------------------
        $dataset = [
          'nip' => '',
          'nama_lengkap' => '',
          'kode_jab' => '',
          'kode_ukerja' => '',
          'kode_tgs_tambahan' => '',
          'ket_tugas_tambahan' => '',
          'tmt_mulai' => '',
          'tmt_selesai' => '',
          'id' => $id
        ];
        $data = [
          'modal_title' => "Tambah Data Guru / PTK",
          'data' => $dataset,
        ];
        $res = [
          'status' => true,
          'message' => "Modal Tambah Data Guru / PTK",
          'html' => $this->load->view('vw_tugas_tambahan_modal_save', $data, true)
        ];
        break;
      }
      case 'edit_ptk': {
        /// |----------------------------------------
        /// | EDIT DATA GURU / PTK
        /// |----------------------------------------
        $dataset = $this->mtt->get('v_progurinda_tugas_tambahan', "id = '$id'");
        $data = [
          'modal_title' => "Edit Tugas Tambahan",
          'data' => $dataset,
        ];
        $res = [
          'status' => true,
          'message' => "Modal Edit Tugas Tambahan",
          'html' => $this->load->view('vw_tugas_tambahan_modal_save', $data, true)
        ];
        break;
      }
      case 'delete_ptk': {
        /// |----------------------------------------
        /// | DELETE DATA
        /// |----------------------------------------
        $dataset = $this->mtt->get('v_progurinda_tugas_tambahan', "id = '$id'");
        if (isset_nn_nes($dataset)) {
            $data = [
                'modal_title' => "Delete Tugas Tambahan",
                'data' => $dataset,
            ];
            $res = [
                'status' => true,
                'message' => "Modal delete tugas tambahan",
                'html' => $this->load->view('vw_tugas_tambahan_modal_delete', $data, true)
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
}
