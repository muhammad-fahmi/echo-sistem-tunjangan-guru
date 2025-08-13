<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai_off extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    // lakukan proses verifikasi user disini
    $priv = $this->session->userdata('kewenangan');
    $log = $this->session->userdata('logged_in');
    $this->session->set_userdata('menu', 'pegawai_off');
    if ($log != true) {
      redirect(site_url('login'));
    } else {
      $this->load->model('mdl_pegawai_off', 'pgo');
    }
  }

  public function index()
  {
    // lakukan proses init halaman
    $this->session->set_userdata('menu', 'pegawai_off');
    $sent_data = array();
    $data = array(
      'page_title' => "Non Aktifkan Pegawai",
      'module' => "pegawai_off",
      'view' => "vw_pegawai_off",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  public function datalist()
  {
    // get index value
    $index = $this->input->post("order[0][column]");
    $ukerja = $this->input->post("select_ukerja");
    if ($this->session->userdata("kewenangan") != "00") {
      $ukerja = $this->session->userdata("kode_unor");
    }
    // insert datatable param to transfer
    $param = array(
      'start' => $this->input->post("start"),
      'length' => $this->input->post("length"),
      'order_column' => $this->input->post("columns[$index][data]"),
      'order_sort' => $this->input->post("order[0][dir]"),
      'search' => $this->input->post("search[value]"),
      'draw' => $this->input->post("draw"),
      /* additional data can be declared here */
      'kode_ukerja' => $ukerja
    );
    // move the db operation to the designated models
    $result = $this->pgo->get_datatable('v_progurinda_pegawai_out', $param);
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

  public function select2_tgs_tambahan()
  {
    // ambil data post
    $search = $this->input->post('search');
    // kondisi where
    $where_search = ($search != '')
      ? "AND (ket_tugas_tambahan LIKE '%$search%' 
      OR kode_tugas_tambahan LIKE '%$search%')"
      : "";
    // query searching
    $result = $this->db->query("SELECT * FROM progurinda_m_tugas_tambahan WHERE kode_tugas_tambahan IS NOT NULL $where_search 
      ORDER BY bonus_jam_mengajar DESC LIMIT 10")->result_array();
    $data = array();
    $index = 0;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $data[$index]['id'] = $r['kode_tugas_tambahan'];
        $data[$index]['text'] = $r['kode_tugas_tambahan'] . ' - ' . trim($r['ket_tugas_tambahan']);

        // additional param to send back
        $data[$index]['kode_tugas_tambahan'] = $r['kode_tugas_tambahan'];
        $data[$index]['bonus_jam_mengajar'] = $r['bonus_jam_mengajar'];
        $data[$index]['ket_tugas_tambahan'] = $r['ket_tugas_tambahan'];

        $index++;
      }
    } else {
      $data = $result;
    }
    return $this->output
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
      case 'tambah_pegawai_out': {
          /// |----------------------------------------
          /// | INSERT DATA
          /// |----------------------------------------
          $dataset = [
            'nip' => '',
            'nama_lengkap' => '',
            'ket_jab' => '',
            'ket_ukerja' => '',
            'keterangan_out' => '',
            'tmt_out' => '',
            'tmt_aktif_kembali' => '',
            'id' => $id
          ];
          $data = [
            'modal_title' => "Tambah Pegawai Non Aktif",
            'data' => $dataset,
          ];
          $res = [
            'status' => true,
            'message' => "Modal Tambah Pegawai Non Aktif",
            'html' => $this->load->view('vw_pegawai_off_modal_save', $data, true)
          ];
          break;
        }
      case 'edit_pegawai_out': {
          /// |----------------------------------------
          /// | EDIT DATA
          /// |----------------------------------------
          $dataset = $this->pgo->get('v_progurinda_pegawai_out', "id = '$id'");
          $data = [
            'modal_title' => "Edit Pegawai Out",
            'data' => $dataset,
          ];
          $res = [
            'status' => true,
            'message' => "Modal Edit Pegawai OUT",
            'html' => $this->load->view('vw_pegawai_off_modal_save', $data, true)
          ];
          break;
        }
      case 'delete_pegawai_out': {
          /// |----------------------------------------
          /// | DELETE DATA
          /// |----------------------------------------
          $dataset = $this->pgo->get('v_progurinda_pegawai_out', "id = '$id'");
          if (isset_nn_nes($dataset)) {
            $data = [
              'modal_title' => "Delete pegawai non aktif",
              'data' => $dataset,
            ];
            $res = [
              'status' => true,
              'message' => "Modal delete pegawai non aktif",
              'html' => $this->load->view('vw_pegawai_off_modal_delete', $data, true)
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
        'keterangan_out' => $post['keterangan_out'],
        'tmt_out' => $post['tmt_out'],
        'tmt_aktif_kembali' => $post['tmt_aktif_kembali']
      );
      if ($id == 0) {
        unset($data_to_save["id"]);
        $data_to_save["insert_by"] = $this->session->userdata("username");
        $data_to_save["insert_on"] = date("Y-m-d H:i:s");
        $this->db->insert('progurinda_pegawai_out', $data_to_save);
      } else {
        $data_to_save["update_by"] = $this->session->userdata("username");
        $data_to_save["update_on"] = date("Y-m-d H:i:s");
        $this->db->where(["id" => $id])->update("progurinda_pegawai_out", $data_to_save);
      }
    } catch (\Throwable $th) {
      $res = [
        'status' => false,
        'message' => "Maaf, proses penyimpanan data pegawai non-aktif mengalami ERROR!\n" . $th->getMessage()
      ];
    }

    if ($this->db->trans_status() === FALSE) {
      // do your error handler here
      $this->db->trans_rollback();
      $res = [
        'status' => false,
        'message' => "Maaf, proses penambahan data pegawai non-aktif mengalami error.\n(error code: MPL_INST_RB)"
      ];
    } else {
      // do your success handler here
      $this->db->trans_commit();
      $res = [
        'status' => true,
        'message' => "Proses penambahan data pegawai non-aktif berhasil dilakukan!"
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
      'message' => "Maaf, proses penghapusan data pegawai non-aktif gagal dilakukan!"
    ];

    $data["id"] = $this->input->post('id');
    $res = $this->pgo->delete($data);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }
}
