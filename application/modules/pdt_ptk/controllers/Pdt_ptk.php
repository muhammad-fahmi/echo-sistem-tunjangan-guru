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
            $this->load->model('mdl_pdt_ptk', 'mptk');
        }
  }

  public function index()
  {
    // lakukan proses init halaman

    $data = array(
      'page_title' => "List PTK",
      'module' => "pdt_ptk",
      'view' => "vw_ptk",
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
    //$result = $this->mptk->get_datatable('v_progurinda_ptk', $param);
    $result = $this->mptk->get_datatable('m_gtk_asn_p3k', $param);
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

  public function edit($id_gtk)
  {
    $decoded_id_gtk = base64_decode($id_gtk);
    $kode_ukerja = $this->session->userdata("kode_unor");
    $q_data_gtk  = $this->db->where(["id_gtk" => $decoded_id_gtk,"kode_ukerja" => $kode_ukerja,"status_aktif" => "-1"])->get("m_gtk_asn_p3k");
    //check apakah ada record dari nip yang dicari
    if ($q_data_gtk->num_rows() > 0){
      //siapkan data pegawai dan batasi hanya untuk OPD nya saja
      $data_gtk = $q_data_gtk->row_array();
      $sent_data["nip"] = $data_gtk["nip"];
      $sent_data["kode_ukerja"] = $kode_ukerja;
      $sent_data["data_gtk"] = $data_gtk;
      $data = array(
        'page_title' => "List PTK",
        'module' => "pdt_ptk",
        'view' => "vw_form",
        'data' => $sent_data
      );
      echo Modules::run('layout/backend', $data);
    }else{
      //return / redirect ke page sebelumnya
      echo "NIP tidak ditemukan";
    }
  }

  public function save_update_pns_p3k(){
    //form validation read only tidak perlu diinputkan
    $data_gtk["nip"] = $this->input->post("nip");
    $data_gtk["nik"] = $this->input->post("nik");
    $data_gtk["id_gtk"] = $this->input->post("id_gtk");
    $data_gtk["jns_kelamin"] = $this->input->post("jns_kelamin");
    $data_gtk["kode_kawin"] = $this->input->post("kode_kawin");
    $data_gtk["tmt_jab"] = $this->input->post("tmt_jab");
    $data_gtk["status_kepegawaian"] = $this->input->post("status_kepegawaian");
    $data_gtk["kode_kawin"] = $this->input->post("kode_kawin");
    $data_gtk["pangkat_golongan"] = $this->input->post("pangkat_golongan");
    $data_gtk["jenjang_jf_guru"] = $this->input->post("jenjang_jf_guru");
    $data_gtk["status_gtk"] = $this->input->post("status_gtk");
    $data_gtk["jabatan_ptk"] = $this->input->post("jabatan_ptk");
    $data_gtk["pembimbing_pdpd"] = $this->input->post("pembimbing_pdpd");
    $data_gtk["agama"] = $this->input->post("agama");
    $data_gtk["nuptk"] = $this->input->post("nuptk");
    $data_gtk["nuks"] = $this->input->post("nuks");
    $data_gtk["nrg"] = $this->input->post("nrg");
    $data_gtk["no_serdik"] = $this->input->post("no_serdik");
    $data_gtk["no_sergp"] = $this->input->post("no_sergp");
    $data_gtk["no_crs"] = $this->input->post("no_crs");
    $data_gtk["alamat"] = $this->input->post("alamat");
    $data_gtk["pendidikan"] = $this->input->post("pendidikan");
    $data_gtk["bidang_studi_pendidikan"] = $this->input->post("bidang_studi_pendidikan");
    $data_gtk["tunjangan_pusat"] = $this->input->post("tunjangan_pusat");
    $data_gtk["tunjangan_pemkot"] = $this->input->post("tunjangan_pemkot");
    $data_gtk["no_rek_bank"] = $this->input->post("no_rek_bank");
    $data_gtk["nama_rek_bank"] = $this->input->post("nama_rek_bank");
    $data_gtk["nama_bank"] = $this->input->post("nama_bank");
    $data_gtk["npwp"] = $this->input->post("npwp");
    $data_gtk["dapodik"] = $this->input->post("dapodik");
    $data_gtk["tmt_masuk_dapodik"] = $this->input->post("tmt_masuk_dapodik");
    //var_dump($data_gtk);
    $result=$this->mptk->update_pns_p3k($data_gtk);
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($result));
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
