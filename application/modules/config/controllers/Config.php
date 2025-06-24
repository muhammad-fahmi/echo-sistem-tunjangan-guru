<?php defined('BASEPATH') or exit('No direct script access allowed');

class Config extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    // lakukan proses verifikasi user disini
  }

  public function index()
  {
    // lakukan proses init halaman
    show_404();
  }

  public function select2_sub_kegiatan()
  {
    // ambil data post
    $search = $_REQUEST["q"];
    $kewenangan_user = $this->session->userdata("kewenangan_user");
    $kode_unor_user = $this->session->userdata("kode_unor");
    $tahun_anggaran = $this->session->userdata("tahun_anggaran");
    if ($kewenangan_user == 10 || $kewenangan_user == 11) {
      //jika kepala bidang atau operator bidang
      $where_unor = " AND kode_unor = '" . $kode_unor_user . "'";
    } else {
      $where_unor = " AND kode_unor LIKE '" . $kode_unor_user . "%'";
    }
    // kondisi where
    $where_search = ($search != '') ? "AND uraian_sub_kegiatan LIKE '%$search%'" : "";
    // query searching
    $result = $this->db->query("SELECT * FROM v_kegiatan_program
      WHERE tahun = '" . $tahun_anggaran . "' $where_unor $where_search 
      ORDER BY kode_kegiatan ASC 
      LIMIT 30")->result_array();
    $data["items"] = array();
    $index = 0;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $data["items"][$index]['id'] = $r['kode_sub_kegiatan'];
        $data["items"][$index]['text'] = $r['kode_sub_kegiatan'] . " - " . $r["uraian_sub_kegiatan"];
        $data["items"][$index]['kode_unor'] = $r['kode_unor'];
        $data["items"][$index]['kode_kegiatan'] = $r['kode_kegiatan'];
        $data["items"][$index]['uraian_kegiatan'] = $r['kode_kegiatan'] . " - " . $r["uraian_kegiatan"];
        $data["items"][$index]['kode_program'] = $r['kode_program'];
        $data["items"][$index]['uraian_program'] = $r['kode_program'] . " - " . $r["uraian_program"];
        $index++;
      }
    } else {
      $data = $result;
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function select2_iku()
  {
    // ambil data post
    $search = $_REQUEST["q"];
    $kewenangan_user = $this->session->userdata("kewenangan_user");
    $kode_unor_user = $this->session->userdata("kode_unor");
    $tahun_anggaran = $this->session->userdata("tahun_anggaran");

    // kondisi where
    $where_search = ($search != '') ? " ket_iku LIKE '%$search%'" : "";
    // query searching
    $result = $this->db->query("SELECT * FROM m_iku
      WHERE $where_search 
      ORDER BY id_iku ASC 
      LIMIT 30")->result_array();
    $data["items"] = array();
    $index = 0;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $data["items"][$index]['id'] = $r['id_iku'];
        $data["items"][$index]['text'] = $r["ket_iku"];
        $index++;
      }
    } else {
      $data = $result;
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }


  public function select2_user()
  {
    // ambil data post
    $search = post_safe('search');
    // kondisi where
    $where_search = ($search != '') ? "AND nama_lengkap LIKE '%$search%'" : "";
    // query searching
    $result = $this->db->query("SELECT * FROM v_user 
      WHERE username IS NOT NULL $where_search 
      ORDER BY kewenangan ASC 
      LIMIT 10")->result_array();
    $data = array();
    $index = 0;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $data[$index]['id'] = $r['username'];
        $data[$index]['text'] = $r['nama_lengkap'] . ' [' . $r['ket_kewenangan'] . ']';
        $index++;
      }
    } else {
      $data = $result;
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function select2_sekolah()
  {
    //session userdata
    $session_ukerja = $this->session->userdata("kode_unor");
    $session_kewenangan = $this->session->userdata("kewenangan");
    // ambil data post
    $search = post_safe('search');

    // kondisi where
    $where_search = ($search != '') ? "AND (ket_ukerja LIKE '%$search%' OR kode_ukerja LIKE '%$search%' OR ket_uorg LIKE '%$search%' OR kode_ukerja LIKE '%$search%')" : "";
    $where_admin = ($session_kewenangan != '00')
      ? "AND kode_ukerja = kode_instansi AND (LEFT(kode_instansi," . strlen($session_ukerja) . ") = '" . $session_ukerja . "' OR unit_kepeg = '" . $session_ukerja . "') AND (kode_ukerja LIKE '69710328%' OR kode_ukerja LIKE '69710345%')"
      : "AND kode_ukerja = kode_instansi AND (kode_ukerja LIKE '69710328%' OR kode_ukerja LIKE '69710345%')";
    // query searching
    $result = $this->db->query("SELECT * FROM v_ukerja 
      WHERE kode_ukerja IS NOT NULL $where_admin $where_search AND s_ukerja = '-1' 
      ORDER BY kode_instansi ASC 
      LIMIT 20")->result_array();
    $data = array();
    $index = 0;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $s_aktif = ($r["s_ukerja"] == 0) ? "[NON-AKTIF]" : "";
        $data[$index]['id'] = $r['kode_instansi'];
        $data[$index]['text'] = $s_aktif . " " . $r['ket_ukerja'] . ' [' . $r['kode_instansi'] . ']';
        $index++;
      }
    } else {
      $data = $result;
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function select2_instansi()
  {
    //session userdata
    $session_ukerja = $this->session->userdata("kode_unor");
    $session_kewenangan = $this->session->userdata("kewenangan");
    // ambil data post
    $search = post_safe('search');

    //kondisi apakah menampilkan yang aktif saja
    $aktif = (post_safe('aktif') != "Y") ? "" : " AND s_ukerja = '-1' ";
    // kondisi where
    $where_search = ($search != '') ? "AND (ket_ukerja LIKE '%$search%' OR kode_ukerja LIKE '%$search%' OR ket_uorg LIKE '%$search%' OR kode_ukerja LIKE '%$search%')" : "";
    $where_admin = ($session_kewenangan != '00') ? "AND kode_ukerja = kode_instansi AND (LEFT(kode_instansi," . strlen($session_ukerja) . ") = '" . $session_ukerja . "' OR unit_kepeg = '" . $session_ukerja . "') AND (kode_ukerja LIKE '69710328%' OR kode_ukerja LIKE '69710345%')" : "AND kode_ukerja = kode_instansi AND (kode_ukerja LIKE '69710328%' OR kode_ukerja LIKE '69710345%')";
    // query searching
    $result = $this->db->query("SELECT * FROM v_ukerja 
      WHERE kode_ukerja IS NOT NULL $where_admin $aktif $where_search 
      ORDER BY kode_instansi ASC 
      LIMIT 20")->result_array();
    $data = array();
    $index = 0;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $s_aktif = ($r["s_ukerja"] == 0) ? "[NON-AKTIF]" : "";
        $data[$index]['id'] = $r['kode_instansi'];
        $data[$index]['text'] = $s_aktif . " " . $r['ket_ukerja'] . ' [' . $r['kode_instansi'] . ']';
        $index++;
      }
    } else {
      $data = $result;
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function select2_shift()
  {
    // ambil data post
    $search = post_safe('search');
    $instansi = post_safe('instansi');
    // kondisi where
    $where_search = isset(($search)) ? "AND keterangan LIKE '%$search%'" : "";
    $where_instansi = (isset($instansi)) ? "AND kode_instansi = '$instansi'" : "";
    // query searching
    $result = $this->db->query("SELECT * FROM v_shift 
      WHERE id IS NOT NULL $where_search $where_instansi
      ORDER BY 'start' ASC 
      LIMIT 10")->result_array();
    $data = array();
    $index = 0;
    $data[$index]['id'] = 0;
    $data[$index]['text'] = '-LIBUR-';
    $index++;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $jam_kerja = min_to_jam_kerja($r['start'], $r['durasi']);
        $data[$index]['id'] = $r['id'];
        $data[$index]['text'] = "( $jam_kerja ) $r[keterangan]";
        $index++;
      }
    } else {
      $data = $result;
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function select2_pegawai()
  {
    // ambil data post
    $search = post_safe('search');
    $kode_instansi = post_safe('kode_instansi');
    // kondisi where
    $where_search = isset(($search)) ? "AND (nip LIKE '%$search%' OR nama_lengkap LIKE '%$search%')" : "";
    // $where_aktif = "AND s_aktif = '-1'";
    $where_aktif = "";
    $where_instansi = "";
    if ($this->session->userdata("kewenangan") != "00") {
      $kode_instansi = $this->session->userdata("kode_unor");
      $where_instansi = " AND (kode_instansi LIKE '" . $kode_instansi . "%' OR unit_kepeg LIKE '" . $kode_instansi . "%') ";
    } else {
      $kode_instansi = (isset_nn_nes($kode_instansi))
        ? $kode_instansi
        : $this->session->userdata("kode_unor");
      $where_instansi = " AND (kode_instansi LIKE '" . $kode_instansi . "%' OR unit_kepeg LIKE '" . $kode_instansi . "%')";
    }
    // query searching
    $result = $this->db->query("SELECT nip, nama_lengkap, kode_ukerja,kode_jab,ket_jab, ket_ukerja FROM v_pns 
      WHERE nip IS NOT NULL $where_search $where_aktif $where_instansi 
      ORDER BY 'nip' ASC 
      LIMIT 10")->result_array();
    $data = array();
    $index = 0;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $nip = $r['nip'];
        $nama_lengkap = trim($r['nama_lengkap']);
        $data[$index]['id'] = $nip;
        $data[$index]['text'] = "$nip - $nama_lengkap";
        $data[$index]['ket_jab'] = $r['ket_jab'];
        $data[$index]['kode_jab'] = $r['kode_jab'];
        $data[$index]['ket_ukerja'] = $r['ket_ukerja'];
        $data[$index]['kode_ukerja'] = $r['kode_ukerja'];
        $data[$index]['nama_lengkap'] = $r['nama_lengkap'];
        $index++;
      }
    } else {
      $data = $result;
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function select2_pegawai_jab()
  {
    // ambil data post
    $search = post_safe('search');
    $kode_instansi = post_safe('kode_instansi');
    // kondisi where
    $where_search = isset(($search)) ? "AND (nip LIKE '%$search%' OR nama_lengkap LIKE '%$search%')" : "";
    // $where_aktif = "AND s_aktif = '-1'";
    $where_aktif = "";
    $where_instansi = "";
    if ($this->session->userdata("kewenangan") != "00") {
      $kode_instansi = $this->session->userdata("kode_unor");
      $where_instansi = " AND (kode_instansi LIKE '" . $kode_instansi . "%' OR unit_kepeg LIKE '" . $kode_instansi . "%') ";
    } else {
      $kode_instansi = (isset_nn_nes($kode_instansi))
        ? $kode_instansi
        : $this->session->userdata("kode_unor");
      $where_instansi = " AND (kode_instansi LIKE '" . $kode_instansi . "%' OR unit_kepeg LIKE '" . $kode_instansi . "%')";
    }
    // query searching
    $result = $this->db->query("SELECT nip, nama_lengkap,kode_jab, ket_jab,kode_ukerja, ket_ukerja FROM v_pns_jab 
      WHERE nip IS NOT NULL $where_search $where_aktif $where_instansi 
      ORDER BY 'nip' ASC 
      LIMIT 10")->result_array();
    $data = array();
    $index = 0;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $nip = $r['nip'];
        $nama_lengkap = trim($r['nama_lengkap']);
        $data[$index]['id'] = $nip;
        $data[$index]['text'] = "$nip - $nama_lengkap";
        $data[$index]['ket_jab'] = $r['ket_jab'];
        $data[$index]['kode_jab'] = $r['kode_jab'];
        $data[$index]['ket_ukerja'] = $r['ket_ukerja'];
        $data[$index]['kode_ukerja'] = $r['kode_ukerja'];
        $data[$index]['nama_lengkap'] = $r['nama_lengkap'];
        $index++;
      }
    } else {
      $data = $result;
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function select2_mesin()
  {
    //session userdata
    $session_ukerja = $this->session->userdata("kode_ukerja");
    $kode_ukerja = post_safe("kode_ukerja");
    // ambil data post
    $search = post_safe('search');
    // kondisi where
    $where_search = ($search != '') ? "AND (ket_ukerja LIKE '%$search%' OR kode_ukerja LIKE '%$search%' OR nama_mesin LIKE '%$search%')" : "";
    // query searching
    $result = $this->db->query("SELECT * FROM v_master_mesin
      WHERE kode_ukerja IS NOT NULL AND LEFT(kode_ukerja," . strlen($kode_ukerja) . ") = '" . $kode_ukerja . "' $where_search 
      ORDER BY kode_ukerja ASC 
      LIMIT 50")->result_array();
    $data = array();
    $index = 0;
    $data[$index]['id'] = "all";
    $data[$index]['text'] = " - - - Semua Mesin - - - ";
    $index++;
    $data[$index]['id'] = "QRSCAN";
    $data[$index]['text'] = " - - - QR SCAN - - - ";
    $index++;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $data[$index]['id'] = $r['cloud_id'];
        $data[$index]['text'] = $r['nama_mesin'] . ' [' . $r['cloud_id'] . ']';
        $index++;
      }
    } else {
      $data = $result;
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function select2_pegawai_transfer()
  {
    $constval = get_defined_constants();
    if (isset($constval['environment_server'])) {
      if ($constval['environment_server'] == "development") {
        $simpegdb_name = "simpegdbv2_samarinda";
      } else {
        $simpegdb_name = "simpegdbv2";
      }
    } else {
      $simpegdb_name = "simpegdbv2_samarinda";
    }
    $kode_ukerja = post_safe("kode_ukerja_sumber");
    // ambil data post
    $search = post_safe('search');
    $jns_peg = post_safe('jns_peg');
    // kondisi where
    $where_search = ($search != '') ? " AND (pin LIKE '%$search%' OR nama LIKE '%$search%')" : "";
    $where_jns_peg = "jns_pegawai = '" . $jns_peg . "'";
    $where_ukerja =  " AND LEFT(kode_instansi," . strlen($kode_ukerja) . ") = '" . $kode_ukerja . "'";
    $temp_table_name = "temp_pegawai_" . $this->session->userdata("username") . "_" . strtotime(date("Y-m-d H:i:s"));
    //transaction start
    $this->db->trans_start();
    $this->db->query("DROP TEMPORARY TABLE IF EXISTS $temp_table_name;");
    $this->db->query("CREATE TEMPORARY TABLE $temp_table_name 
        (PRIMARY KEY pktemp (pin),
        INDEX idx_temp (pin, jns_pegawai),pin varchar(20),pin_peg varchar(20),nama varchar(255),kode_ukerja VARCHAR(25),kode_instansi VARCHAR(25),jns_pegawai varchar(10));
        ");
    $this->db->query("INSERT INTO $temp_table_name 
        SELECT IFNULL($simpegdb_name.m_pegawai.pin_mesin,$simpegdb_name.m_pegawai.nip) AS pin,
        $simpegdb_name.m_pegawai.nip AS pin_peg,
        $simpegdb_name.m_pegawai.nama,
        $simpegdb_name.m_pegawai.kode_ukerja,
        $simpegdb_name.m_ukerja.kode_instansi,
        'PNS' AS jns_pegawai
        FROM 
        $simpegdb_name.m_pegawai
        INNER JOIN 
        $simpegdb_name.m_ukerja ON $simpegdb_name.m_pegawai.kode_ukerja = $simpegdb_name.m_ukerja.kode_ukerja
        UNION ALL
        SELECT
        IFNULL($simpegdb_name.m_ptt.pin_mesin,$simpegdb_name.m_ptt.niptt) AS pin,
        $simpegdb_name.m_ptt.niptt AS pin_peg,
        $simpegdb_name.m_ptt.nama,
        $simpegdb_name.m_ptt.kode_ukerja,
        $simpegdb_name.m_ukerja.kode_instansi,
        'PTT' AS jns_pegawai
        FROM
        $simpegdb_name.m_ptt
        INNER JOIN 
        $simpegdb_name.m_ukerja ON $simpegdb_name.m_ptt.kode_ukerja = $simpegdb_name.m_ukerja.kode_ukerja;
        ");
    //query_result
    $query_result = $this->db->query("SELECT
    * FROM $temp_table_name WHERE " . $where_jns_peg . " " . $where_search . " " . $where_ukerja . " LIMIT 10");
    $this->db->query("DROP TEMPORARY TABLE IF EXISTS $temp_table_name;");
    $this->db->trans_complete();
    $data = array();
    $index = 0;
    $result = $query_result->result_array();
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        if ($r["jns_pegawai"] == "PNS") {
          $detail_pegawai = $this->db->where("nip = '" . $r["pin_peg"] . "'")->get("v_pns")->row_array();
          $ket_jab = $detail_pegawai["ket_jab"];
          $ket_ukerja = $detail_pegawai["ket_ukerja"];
        } else {
          $detail_pegawai = $this->db->where("niptt = '" . $r["pin_peg"] . "'")->get("v_ptt")->row_array();
          $ket_jab = ($detail_pegawai["kode_tugas"] != 99) ? $detail_pegawai["ket_tugas"] : $detail_pegawai["ket_jabtgs"];
          $ket_ukerja = $detail_pegawai["ket_ukerja"];
        }
        $data[$index]['id'] = $r['pin'];
        $data[$index]['text'] = $r['pin'] . ' - ' . $r['nama'] . '';
        $data[$index]['ket_ukerja'] = $ket_ukerja;
        $data[$index]['ket_jab'] = $ket_jab;
        $index++;
      }
    } else {
      $data = $result;
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function select2_mesin_transfer()
  {
    // ambil data post
    $search = post_safe('search');
    // kondisi where
    $where_search = ($search != '') ? "AND (ket_ukerja LIKE '%$search%' OR kode_ukerja LIKE '%$search%' OR nama_mesin LIKE '%$search%')" : "";
    // query searching
    $result = $this->db->query("SELECT * FROM v_master_mesin
      WHERE kode_ukerja IS NOT NULL $where_search 
      ORDER BY kode_ukerja ASC 
      LIMIT 50")->result_array();
    $data = array();
    $index = 0;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $data[$index]['id'] = $r['cloud_id'];
        $data[$index]['text'] = $r['nama_mesin'] . ' [' . $r['cloud_id'] . ']';
        $index++;
      }
    } else {
      $data = $result;
    }
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  /// |----------------------------------------------------------------------
  /// | >> PROGURINDA
  /// |----------------------------------------------------------------------

  public function select2_agama()
  {
    // ambil data post
    $search = $this->input->post('search');
    // kondisi where
    $where_search = ($search != '')
      ? "AND (ket_agama LIKE '%$search%' 
      OR kode_agama LIKE '%$search%')"
      : "";
    // query searching
    $result = $this->db->query("SELECT * FROM m_agama WHERE kode_agama IS NOT NULL $where_search 
      ORDER BY ket_agama DESC")->result_array();
    $data = array();
    $index = 0;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $data[$index]['id'] = $r['kode_agama'];
        $data[$index]['text'] = trim($r['ket_agama']);

        // additional param to send back
        $data[$index]['kode_agama'] = $r['kode_agama'];
        $data[$index]['ket_agama'] = trim($r['ket_agama']);
        $index++;
      }
    } else {
      $data = $result;
    }
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function select2_disabilitas()
  {
    // ambil data post
    $search = $this->input->post('search');
    // kondisi where
    $where_search = ($search != '')
      ? "AND (ket_disabilitas LIKE '%$search%' 
      OR id_pd LIKE '%$search%')"
      : "";
    // query searching
    $result = $this->db->query("SELECT * FROM m_penyandang_disabilitas WHERE id_pd IS NOT NULL $where_search 
      ORDER BY id_pd DESC")->result_array();
    $data = array();
    $index = 0;
    if (isset_nn_nes($result)) {
      foreach ($result as $r) {
        $data[$index]['id'] = $r['id_pd'];
        $data[$index]['text'] = trim($r['ket_disabilitas']);

        // additional param to send back
        $data[$index]['id_pd'] = $r['id_pd'];
        $data[$index]['ket_disabilitas'] = trim($r['ket_disabilitas']);

        $index++;
      }
    } else {
      $data = $result;
    }
    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }
}
