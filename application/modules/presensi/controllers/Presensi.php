<?php defined('BASEPATH') or exit('No direct script access allowed');

class Presensi extends MY_Controller
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
      $this->load->model('mdl_presensi_pegawai', 'mpp');
    }
  }

  public function index()
  {
    // lakukan proses init halaman
    $this->session->set_userdata('menu', 'presensi');
    $sent_data = array();
    $data = array(
      'page_title' => "Presensi Pegawai",
      'module' => "presensi",
      'view' => "vw_presensi",
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
      'filter_bln' => $this->input->post('filter_bln'),
      'filter_thn' => $this->input->post('filter_thn'),
      'kode_ukerja' => $this->input->post('kode_ukerja')
      /* additional data can be declared here */
    );
    // move the db operation to the designated models
    //$result = $this->mpp->get_datatable('progurinda_r_data_presensi',$param);
    $result = $this->mpp->get_data_presensi($param);
    // return the data back to the views
    $data["recordsTotal"] = $result['jml'];
    $data["recordsFiltered"] = $result['jml'];
    $data["data"] = $result['list'];
    $data["draw"] = $result['draw'];
    // using common_helper function
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
  
  // Select2 utk unit kerja
  public function select2_ukerja()
  {
    // ambil data post
    $search = $this->input->post('search');
    // kondisi where
    $where_search = ($search != '')
      ? "AND (nama_lengkap LIKE '%$search%' 
      OR nip LIKE '%$search%')"
      : "";
    // query searching
    $result = $this->db->query("SELECT * FROM m_jab WHERE id IS NOT NULL $where_search 
      ORDER BY kode_ukerja DESC LIMIT 10")->result_array();
    $data = array();
    $index = 0;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $data[$index]['id'] = $r['id'];
        $data[$index]['text'] = $r['kode_ukerja'] . ' - ' . trim($r['ket_ukerja']);
  
        // additional param to send back
        $data[$index]['nip'] = $r['nip'];
        // $data[$index]['nama_lengkap'] = trim($r['nama_lengkap']);
        $data[$index]['kode_gol'] = $r['kode_gol'];
        $data[$index]['tmt_gol'] = $r['tmt_gol'];
        $data[$index]['kode_eselon'] = $r['kode_eselon'];
        $data[$index]['kode_jab'] = $r['kode_jab'];
        $data[$index]['kode_ukerja'] = $r['kode_ukerja'];
  
        $data[$index]['ket_jab'] = $r['ket_jab'];
        $data[$index]['ket_ukerja'] = $r['ket_ukerja'];
        $data[$index]['ket_uorg'] = $r['ket_uorg'];
  
        $index++;
      }
    } else {
      $data = $result;
    }
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function get_presensi()
  {
    $post = $this->input->post('');
    $bulan = $post['bulan'];
    $tahun = $tahun['tahun'];
    
    // Testing code sinkronisasi presensi data
  }

  public function modal_integrasi()
  {
    $filter_bln = $this->input->post('filter_bln');
    $filter_thn = $this->input->post('filter_thn');
    $kode_unor = $this->input->post('kode_unor');

    $data = [
      'modal_title' => "Integrasi Presensi",
      'data' => $dataset,
    ];
    $res = [
      'status' => true,
      'message' => "Proses Integrasi Presensi",
      'html' => $this->load->view('vw_modal_integrasi_presensi', $data, true)
    ];
    
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }

  //Fungsi untuk menarik data presensi dari aplikasi absensi_web_samarinda
  function integrasi_presensi()
  {
    $post = $this->input->post();
    $kode_ukerja = $post["kode_ukerja"];
    $filter_thn = $post["filter_thn"];
    $filter_bln = $post["filter_bln"];
    //cek apakah sudah difinalkan klo sudah tidak usah integrasi
    $check_final = isFinal($kode_ukerja, (int)$filter_bln, $filter_thn);
    $result["status"] = false;
    $result["message"] = "";
    if ($check_final["val"]) {
      //var_dump($check_final);
      $result["status"] = false;
      $result["message"] = "<div class='row'><div class='col-md-12'><h4>Integrasi gagal! DATA SUDAH FINAL!</h4></div></div>";
    } else {
      // Create a client with a base URI
      //$client = new GuzzleHttp\Client(['base_uri' => 'http://[::1]/absensi_samarinda_web/index.php/api/']);
      $client = new GuzzleHttp\Client(['base_uri' => 'http://36.66.236.83/absensi_samarinda_web/index.php/api/', 'verify' => false]);
      $response = $client->request('GET', 'export_ringkasan_opd/' . $kode_ukerja . '/' . (int)$filter_bln . '/' . $filter_thn.'/true');
      //using response
      $code = $response->getStatusCode();
      $reason = $response->getReasonPhrase();
      $body = json_decode($response->getBody());
      if ($code == '200') {
        //jika sukses
        if ($body->success) {
          //vardump list 
          //var_dump($body->attlog);
          $total = 0;
          $insert = 0;
          $update = 0;
          $list_sudah_masuk = false;
          $arr_data_presensi = array();
          try {
            // get list data presensi yang sudah masuk sesuai periode dan unit kerja filter
            if ($kode_ukerja == "69710345") {
              $where_ukerja = "(kode_ukerja like '" . $kode_ukerja . "%' OR kode_ukerja like '69710328%')";
            } else {
              $where_ukerja = "kode_instansi = '" . $kode_ukerja . "'";
            }
            $q_list_sudah_masuk = $this->db->where($where_ukerja . " AND tahun = '" . $filter_thn . "' AND bulan ='" . (int)$filter_bln . "'")->get("v_progurinda_data_presensi");
            if ($q_list_sudah_masuk->num_rows() > 0) {
              $list_sudah_masuk = $q_list_sudah_masuk->result_array();
              foreach ($list_sudah_masuk as $key => $value) {
                $arr_data_presensi[$value["nip"]] = true;
              }
            }
            //var_dump($arr_data_presensi);
            //var_dump($body->attlog);
            foreach ($body->attlog as $key => $value) {
              //echo $value->pegawai->nip . " - " . $value->pegawai->nama . " : " . $value->potongan . "<br>";
              //siapkan data presensi
              $persen_potongan = ((int)$value->potongan > 100) ? 100 : $value->potongan;
              $data_presensi = array(
                "nip" => $value->pegawai->nip,
                "kode_jab" => $value->pegawai->kode_jab,
                "kode_ukerja" => $value->pegawai->kode_ukerja,
                "tahun" => $filter_thn,
                "bulan" => (int)$filter_bln,
                "username_input" => $this->session->userdata("username"),
                "potongan_persen" => $persen_potongan,
                "last_update" => date("Y-m-d H:i:s"),
              );
              /* $message = "NIP : " . $value->pegawai->nip;
              if (isset($arr_data_presensi[$data_presensi["nip"]])) {
                $message .= "Array Index " . $data_presensi["nip"] . " is NOT EXIST <br>";
              } else {
                $message .= "Array Index " . $data_presensi["nip"] . " is NOT EXIST <br>";
              } */
              //echo $message;
              //cek riwayat presensi
              //$q_cek_presensi = $this->db->where(["nip" => $data_presensi["nip"], "tahun" => $tahun, "bulan" => (int)$bulan])->get("r_data_presensi");
              $data_exist =  (array_key_exists($value->pegawai->nip, $arr_data_presensi)) ? true : false;

              if ($data_exist) {
                //jika sudah ada maka update
                $this->db->where(["nip" => $data_presensi["nip"], "tahun" => $filter_thn, "bulan" => (int)$filter_bln])->update("progurinda_r_data_presensi", $data_presensi);
                $update++;
              } else {
                //jika belum maka insert data presensi
                $this->db->insert("progurinda_r_data_presensi", $data_presensi);
                $insert++;
              }
              $total++;
            }
            $result["status"] = true;
            $result["message"] = "<div class='row'><div class='col-md-12'><h4>Integrasi Data Berhasil!</h4><br>Data diproses : " . $total . " | Diupdate : " . $update . " | Ditambah : " . $insert . "</div></div>";
          } catch (\Throwable $th) {
            //throw $th;
            $result["status"] = false;
            $result["message"] = "ERROR!Process Message : " . $th->getMessage(); 
          }
        } else {
          //jika gagal
          $result["status"] = false;
          $result["message"] = "<div class='row'><div class='col-md-12'><h4>Integrasi gagal! " . $body->message . "</h4></div></div>";
        }
      }
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($result));
  }
}