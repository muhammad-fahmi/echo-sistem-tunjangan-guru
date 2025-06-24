<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_dashboard extends CI_Model
{
  /** fungsi untuk menarik data dari database */
  public function get($table, $where = null, $result_array = false)
  {
    if ($where != null) {
      if ($result_array) {
        $result = $this->db->get_where($table, $where)->result_array();
      } else {
        $result = $this->db->get_where($table, $where)->row_array();
      }
    } else {
      $result = $this->db->select('*')->from($table)->get()->result_array();
    }
    return $result;
  }

  /** fungsi untuk mengecek num_rows return int */
  public function check($table, $where = null)
  {
    if ($where != null) {
      $result = $this->db->get_where($table, $where)->num_rows();
    } else {
      $result = $this->db->select('*')->from($table)->get()->num_rows();
    }
    return $result;
  }

  /* fungsi untuk menarik data dari DB dan konversi ke dataset untuk jquery datatable attlog*/
  // public function get_datatable_attlog($table, $data, $primary_key = 'id')
  // {
  //   // lakukan filtering data
  //   // deklarasi where condition
  //   $where_search = (isset_nn_nes($data['search']))
  //     ? "AND (r_attlog.pin LIKE '%$data[search]%' 
  //     OR nama LIKE '%$data[search]%' OR pin_peg LIKE '%$data[search]%')"
  //     : "";
  //   $where_tgl = (isset_nn_nes($data['filter_tgl']) && isset_nn_nes($data['filter_tgl_akhir']))
  //     ? " AND (r_attlog.scan_date >= '" . $data["filter_tgl"] . " 00:00:00' AND r_attlog.scan_date <= '" . $data["filter_tgl_akhir"] . " 23:59:59' )"
  //     : "";

  //   $where_cloud_id = ($data["cloud_id"] != "all") ? " AND (r_attlog.cloud_id = '" . $data["cloud_id"] . "' OR r_attlog.cloud_id = 'MOBILEAPP' OR r_attlog.cloud_id = 'QRSCAN') " : "";
  //   $where_jnspeg = ($data["filter_jnspeg"] != "all") ? " AND (jns_pegawai = '" . $data["filter_jnspeg"] . "') " : "";
  //   /* kalau ada tambahan where condition bisa add lagi di atas */
  //   // deklarasi query yang digunakan
  //   /* $query_result = $this->db->query("SELECT
  //             `r_attlog`.`id` AS `id`,
  //         `r_attlog`.`cloud_id` AS `cloud_id`,
  //         `r_attlog`.`pin` AS `pin`,
  //         `r_attlog`.`scan_date` AS `scan_date`,
  //         `r_attlog`.`verify` AS `verify`,
  //         `r_attlog`.`status_scan` AS `status_scan`,
  //         `r_attlog`.`status_verifikasi_atasan` AS `status_verifikasi_atasan`,
  //         v_attlog_pegawai.nama AS `nama`,
  //         v_attlog_pegawai.kode_ukerja,
  //         v_attlog_pegawai.jns_pegawai AS jns_pegawai
  //             FROM r_attlog
  //             JOIN
  //             v_attlog_pegawai ON r_attlog.pin = v_attlog_pegawai.pin
  //             WHERE $primary_key IS NOT NULL $where_search 
  //             ORDER BY $data[order_column] $data[order_sort]
  //             LIMIT $data[start], $data[length]"); */

  //   /* $query_total = $this->db->query("SELECT
  //           `r_attlog`.`id` AS `id`,
  //       `r_attlog`.`cloud_id` AS `cloud_id`,
  //       `r_attlog`.`pin` AS `pin`,
  //       `r_attlog`.`scan_date` AS `scan_date`,
  //       `r_attlog`.`verify` AS `verify`,
  //       `r_attlog`.`status_scan` AS `status_scan`,
  //       `r_attlog`.`status_verifikasi_atasan` AS `status_verifikasi_atasan`,
  //       v_attlog_pegawai.nama AS `nama`,
  //       v_attlog_pegawai.kode_ukerja,
  //       v_attlog_pegawai.jns_pegawai AS jns_pegawai
  //           FROM r_attlog
  //           JOIN
  //           v_attlog_pegawai ON r_attlog.pin = v_attlog_pegawai.pin
  //           WHERE $primary_key IS NOT NULL $where_search"); */
  //   // get all defined constant
  //   $constval = get_defined_constants();
  //   if (isset($constval['environment_server'])) {
  //     if ($constval['environment_server'] == "development") {
  //       $simpegdb_name = "simpegdbv2_samarinda";
  //     } else {
  //       $simpegdb_name = "simpegdbv2";
  //     }
  //   } else {
  //     $simpegdb_name = "simpegdbv2_samarinda";
  //   }
  //   $temp_table_name = "temp_pegawai_" . $this->session->userdata("username") . "_" . strtotime(date("Y-m-d H:i:s"));
  //   //transaction start
  //   $this->db->trans_start();
  //   $this->db->query("DROP TEMPORARY TABLE IF EXISTS $temp_table_name;");
  //   $this->db->query("CREATE TEMPORARY TABLE $temp_table_name 
  //       (PRIMARY KEY pktemp (pin),
  //       INDEX idx_temp (pin, jns_pegawai),pin varchar(20),pin_peg varchar(20),nama varchar(255),kode_ukerja VARCHAR(25),kode_instansi VARCHAR(25),jns_pegawai varchar(10));
  //       ");
  //   $this->db->query("INSERT INTO $temp_table_name 
  //       SELECT IFNULL($simpegdb_name.m_pegawai.pin_mesin,$simpegdb_name.m_pegawai.nip) AS pin,
  //       $simpegdb_name.m_pegawai.nip AS pin_peg,
  //       $simpegdb_name.m_pegawai.nama,
  //       $simpegdb_name.m_pegawai.kode_ukerja,
  //       $simpegdb_name.m_ukerja.kode_instansi,
  //       'PNS' AS jns_pegawai
  //       FROM 
  //       $simpegdb_name.m_pegawai
  //       INNER JOIN 
  //       $simpegdb_name.m_ukerja ON $simpegdb_name.m_pegawai.kode_ukerja = $simpegdb_name.m_ukerja.kode_ukerja
  //       UNION ALL
  //       SELECT
  //       IFNULL($simpegdb_name.m_ptt.pin_mesin,$simpegdb_name.m_ptt.niptt) AS pin,
  //       $simpegdb_name.m_ptt.niptt AS pin_peg,
  //       $simpegdb_name.m_ptt.nama,
  //       $simpegdb_name.m_ptt.kode_ukerja,
  //       $simpegdb_name.m_ukerja.kode_instansi,
  //       'PTT' AS jns_pegawai
  //       FROM
  //       $simpegdb_name.m_ptt
  //       INNER JOIN 
  //       $simpegdb_name.m_ukerja ON $simpegdb_name.m_ptt.kode_ukerja = $simpegdb_name.m_ukerja.kode_ukerja;
  //       ");
  //   //query_result
  //   $query_result = $this->db->query("SELECT
  //       `r_attlog`.`id` AS `id`,
  //       `r_attlog`.`cloud_id` AS `cloud_id`,
  //       `m_setup_mesin`.`nama_mesin` AS `nama_mesin`,
  //       `r_attlog`.`pin` AS `pin`,
  //       `r_attlog`.`scan_date` AS `scan_date`,
  //       `r_attlog`.`verify` AS `verify`,
  //       `r_attlog`.`status_scan` AS `status_scan`,
  //       `r_attlog`.`status_verifikasi_atasan` AS `status_verifikasi_atasan`,
  //       $temp_table_name.pin_peg AS `pin_peg`,
  //       $temp_table_name.nama AS `nama`,
  //       $temp_table_name.kode_ukerja AS kode_ukerja,
  //       $temp_table_name.kode_instansi AS kode_instansi,
  //       $temp_table_name.jns_pegawai AS jns_pegawai 
  //     FROM
  //       r_attlog 
  //       INNER JOIN $temp_table_name ON r_attlog.pin = $temp_table_name.pin  
  //       LEFT JOIN m_setup_mesin ON r_attlog.cloud_id = m_setup_mesin.cloud_id
  //       WHERE $primary_key IS NOT NULL $where_search $where_tgl AND LEFT($temp_table_name.kode_instansi, " . strlen($data["kode_ukerja"]) . ") = '" . $data["kode_ukerja"] . "'
  //        " . $where_cloud_id . " " . $where_jnspeg . "
  //       ORDER BY $data[order_column] $data[order_sort]
  //       LIMIT $data[start], $data[length];");

  //   //query total
  //   $query_total = $this->db->query("SELECT
  //       `r_attlog`.`id` AS `id`,
  //       `r_attlog`.`cloud_id` AS `cloud_id`,
  //       `r_attlog`.`pin` AS `pin`,
  //       `r_attlog`.`scan_date` AS `scan_date`,
  //       `r_attlog`.`verify` AS `verify`,
  //       `r_attlog`.`status_scan` AS `status_scan`,
  //       `r_attlog`.`status_verifikasi_atasan` AS `status_verifikasi_atasan`,
  //       $temp_table_name.nama AS `nama`,
  //       $temp_table_name.kode_ukerja AS kode_ukerja,
  //       $temp_table_name.kode_instansi AS kode_instansi,
  //       $temp_table_name.jns_pegawai AS jns_pegawai 
  //     FROM 
  //       r_attlog
  //       INNER JOIN $temp_table_name ON r_attlog.pin = $temp_table_name.pin 
  //       WHERE $primary_key IS NOT NULL $where_search $where_tgl AND LEFT($temp_table_name.kode_instansi, " . strlen($data["kode_ukerja"]) . ") = '" . $data["kode_ukerja"] . "'
  //       " . $where_cloud_id . " " . $where_jnspeg);
  //   $this->db->query("DROP TEMPORARY TABLE IF EXISTS $temp_table_name;");
  //   $this->db->trans_complete();




  //   // cari total hasil
  //   $total_count = $query_total->num_rows();
  //   /* while ($row = $query_total->unbuffered_row()) {
  //     $total_count += 1;
  //   } */
  //   // cari data result + penomoran
  //   $no = $data['start'] + 1;
  //   $index = 0;
  //   $data_result = array();
  //   while ($row = $query_result->unbuffered_row()) {
  //     /// |----------------------------------------------------------------------
  //     /// | PENATAAN DATA SEBELUM DIMASUKKAN KE DALAM RESULT_ARRAY
  //     /// |----------------------------------------------------------------------
  //     $ket_verify = "";
  //     $ket_status_scan = "";
  //     switch ($row->verify) {
  //       case '1':
  //         $ket_verify = "Finger";
  //         break;
  //       case '2':
  //         $ket_verify = "Password";
  //         break;
  //       case '3':
  //         $ket_verify = "Card";
  //         break;
  //       case '4':
  //         $ket_verify = "Face";
  //         break;
  //       case '5':
  //         $ket_verify = "GPS";
  //         break;
  //       case '6':
  //         $ket_verify = "Vein";
  //         break;

  //       default:
  //         $ket_verify = "";
  //         break;
  //     }
  //     switch ($row->status_scan) {
  //       case '0':
  //         $ket_status_scan = "Scan IN";
  //         break;
  //       case '1':
  //         $ket_status_scan = "Scan OUT";
  //         break;
  //       case '2':
  //         $ket_status_scan = "Break IN";
  //         break;
  //       case '3':
  //         $ket_status_scan = "Break OUT";
  //         break;
  //       case '4':
  //         $ket_status_scan = "Overtime IN";
  //         break;
  //       case '5':
  //         $ket_status_scan = "Overtime OUT";
  //         break;
  //       case '6':
  //         $ket_status_scan = "Rapat IN";
  //         break;
  //       case '7':
  //         $ket_status_scan = "Rapat OUT";
  //         break;
  //       case '8':
  //         $ket_status_scan = "Custome1";
  //         break;
  //       case '9':
  //         $ket_status_scan = "Custome2";
  //         break;

  //       default:
  //         $ket_status_scan = "";
  //         break;
  //     }


  //     if ($row->jns_pegawai == "PNS") {
  //       $detail_pegawai = $this->db->where("nip = '" . $row->pin_peg . "'")->get("v_pns")->row_array();
  //       $ket_jab = $detail_pegawai["ket_jab"];
  //     } else {
  //       $detail_pegawai = $this->db->where("niptt = '" . $row->pin_peg . "'")->get("v_ptt")->row_array();
  //       $ket_jab = ($detail_pegawai["kode_tugas"] != 99) ? $detail_pegawai["ket_tugas"] : $detail_pegawai["ket_jabtgs"];
  //     }
  //     $data_result[$index]['no'] = $no;
  //     $data_result[$index]['cloud_id'] = $row->nama_mesin . "<br>( " . $row->cloud_id . " )";
  //     $data_result[$index]['pin'] = $row->pin;
  //     $data_result[$index]['nama'] = $row->nama;
  //     $data_result[$index]['ket_jab'] = $ket_jab;
  //     $data_result[$index]['ket_ukerja'] = $detail_pegawai["ket_ukerja"];
  //     $data_result[$index]['scan_date'] = $row->scan_date;
  //     $data_result[$index]['ket_verify'] = $ket_verify;
  //     $data_result[$index]['ket_status_scan'] = $ket_status_scan;
  //     $no += 1;
  //     $index += 1;
  //   }
  //   // kembalikan data yang didapat ke controller
  //   return array(
  //     'total' => $total_count,
  //     'filtered' => $total_count,
  //     'data' => $data_result,
  //     'draw' => $data['draw']
  //   );
  // }

  /* fungsi untuk menarik data dari DB dan diexport ke Excel atau PDF*/
  // public function get_export_attlog($data)
  // {
  //   // lakukan filtering data
  //   // deklarasi where condition
  //   $where_search = (isset_nn_nes($data['search']))
  //     ? "AND (r_attlog.pin LIKE '%$data[search]%' 
  //     OR nama LIKE '%$data[search]%' OR pin_peg LIKE '%$data[search]%')"
  //     : "";
  //   $where_tgl = (isset_nn_nes($data['filter_tgl']) && isset_nn_nes($data['filter_tgl_akhir']))
  //     ? " AND (r_attlog.scan_date >= '" . $data["filter_tgl"] . " 00:00:00' AND r_attlog.scan_date <= '" . $data["filter_tgl_akhir"] . " 23:59:59' )"
  //     : "";

  //   $where_cloud_id = ($data["cloud_id"] != "all") ? " AND (r_attlog.cloud_id = '" . $data["cloud_id"] . "' OR r_attlog.cloud_id = 'MOBILEAPP' OR r_attlog.cloud_id = 'QRSCAN') " : "";

  //   $where_jnspeg = ($data["filter_jnspeg"] != "all") ? " AND (jns_pegawai = '" . $data["filter_jnspeg"] . "') " : "";
  //   // get all defined constant
  //   $constval = get_defined_constants();
  //   if (isset($constval['environment_server'])) {
  //     if ($constval['environment_server'] == "development") {
  //       $simpegdb_name = "simpegdbv2_samarinda";
  //     } else {
  //       $simpegdb_name = "simpegdbv2";
  //     }
  //   } else {
  //     $simpegdb_name = "simpegdbv2_samarinda";
  //   }
  //   $temp_table_name = "temp_pegawai_" . $this->session->userdata("username") . "_" . strtotime(date("Y-m-d H:i:s"));
  //   //transaction start
  //   $this->db->trans_start();
  //   $this->db->query("DROP TEMPORARY TABLE IF EXISTS $temp_table_name;");
  //   $this->db->query("CREATE TEMPORARY TABLE $temp_table_name 
  //       (PRIMARY KEY pktemp (pin),
  //       INDEX idx_temp (pin, jns_pegawai),pin varchar(20),pin_peg varchar(20),nama varchar(255),kode_ukerja VARCHAR(25),kode_eselon VARCHAR(3),kode_gol VARCHAR(2),kode_instansi VARCHAR(25),jns_pegawai varchar(10));
  //       ");
  //   $this->db->query("INSERT INTO $temp_table_name 
  //       SELECT IFNULL($simpegdb_name.m_pegawai.pin_mesin,$simpegdb_name.m_pegawai.nip) AS pin,
  //       $simpegdb_name.m_pegawai.nip AS pin_peg,
  //       $simpegdb_name.m_pegawai.nama,
  //       $simpegdb_name.m_pegawai.kode_ukerja,
  //       $simpegdb_name.m_pegawai.kode_eselon,
  //       $simpegdb_name.m_pegawai.kode_gol,
  //       $simpegdb_name.m_ukerja.kode_instansi,
  //       'PNS' AS jns_pegawai
  //       FROM 
  //       $simpegdb_name.m_pegawai
  //       INNER JOIN 
  //       $simpegdb_name.m_ukerja ON $simpegdb_name.m_pegawai.kode_ukerja = $simpegdb_name.m_ukerja.kode_ukerja
  //       UNION ALL
  //       SELECT
  //       IFNULL($simpegdb_name.m_ptt.pin_mesin,$simpegdb_name.m_ptt.niptt) AS pin,
  //       $simpegdb_name.m_ptt.niptt AS pin_peg,
  //       $simpegdb_name.m_ptt.nama,
  //       $simpegdb_name.m_ptt.kode_ukerja,
  //       '999' AS kode_eselon,
  //       '0' AS kode_gol,
  //       $simpegdb_name.m_ukerja.kode_instansi,
  //       'PTT' AS jns_pegawai
  //       FROM
  //       $simpegdb_name.m_ptt
  //       INNER JOIN 
  //       $simpegdb_name.m_ukerja ON $simpegdb_name.m_ptt.kode_ukerja = $simpegdb_name.m_ukerja.kode_ukerja;
  //       ");
  //   //query_result
  //   $query_result = $this->db->query("SELECT
  //       `r_attlog`.`id` AS `id`,
  //       `r_attlog`.`cloud_id` AS `cloud_id`,
  //       `m_setup_mesin`.`nama_mesin` AS `nama_mesin`,
  //       `r_attlog`.`pin` AS `pin`,
  //       `r_attlog`.`scan_date` AS `scan_date`,
  //       `r_attlog`.`verify` AS `verify`,
  //       `r_attlog`.`status_scan` AS `status_scan`,
  //       `r_attlog`.`status_verifikasi_atasan` AS `status_verifikasi_atasan`,
  //       $temp_table_name.pin_peg AS `pin_peg`,
  //       $temp_table_name.nama AS `nama`,
  //       $temp_table_name.kode_ukerja AS kode_ukerja,
  //       $temp_table_name.kode_instansi AS kode_instansi,
  //       $temp_table_name.kode_eselon AS kode_eselon,
  //       $temp_table_name.kode_gol AS kode_gol,
  //       $temp_table_name.jns_pegawai AS jns_pegawai 
  //     FROM
  //       r_attlog
  //       INNER JOIN $temp_table_name ON r_attlog.pin = $temp_table_name.pin  
  //       LEFT JOIN m_setup_mesin ON r_attlog.cloud_id = m_setup_mesin.cloud_id
  //       WHERE id IS NOT NULL $where_search $where_tgl AND LEFT($temp_table_name.kode_instansi, " . strlen($data["kode_ukerja"]) . ") = '" . $data["kode_ukerja"] . "'
  //        " . $where_cloud_id . " " . $where_jnspeg . "
  //       ORDER BY kode_eselon asc, kode_gol desc,pin asc,scan_date asc;");

  //   $this->db->query("DROP TEMPORARY TABLE IF EXISTS $temp_table_name;");
  //   $this->db->trans_complete();

  //   // cari data result + penomoran
  //   $no = 1;
  //   $index = 0;
  //   $data_result = array();
  //   while ($row = $query_result->unbuffered_row()) {
  //     /// |----------------------------------------------------------------------
  //     /// | PENATAAN DATA SEBELUM DIMASUKKAN KE DALAM RESULT_ARRAY
  //     /// |----------------------------------------------------------------------
  //     $ket_verify = "";
  //     $ket_status_scan = "";
  //     switch ($row->verify) {
  //       case '1':
  //         $ket_verify = "Finger";
  //         break;
  //       case '2':
  //         $ket_verify = "Password";
  //         break;
  //       case '3':
  //         $ket_verify = "Card";
  //         break;
  //       case '4':
  //         $ket_verify = "Face";
  //         break;
  //       case '5':
  //         $ket_verify = "GPS";
  //         break;
  //       case '6':
  //         $ket_verify = "Vein";
  //         break;

  //       default:
  //         $ket_verify = "";
  //         break;
  //     }
  //     switch ($row->status_scan) {
  //       case '0':
  //         $ket_status_scan = "Scan IN";
  //         break;
  //       case '1':
  //         $ket_status_scan = "Scan OUT";
  //         break;
  //       case '2':
  //         $ket_status_scan = "Break IN";
  //         break;
  //       case '3':
  //         $ket_status_scan = "Break OUT";
  //         break;
  //       case '4':
  //         $ket_status_scan = "Overtime IN";
  //         break;
  //       case '5':
  //         $ket_status_scan = "Overtime OUT";
  //         break;
  //       case '6':
  //         $ket_status_scan = "Rapat IN";
  //         break;
  //       case '7':
  //         $ket_status_scan = "Rapat OUT";
  //         break;
  //       case '8':
  //         $ket_status_scan = "Custome1";
  //         break;
  //       case '9':
  //         $ket_status_scan = "Custome2";
  //         break;

  //       default:
  //         $ket_status_scan = "";
  //         break;
  //     }
  //     if ($row->jns_pegawai == "PNS") {
  //       $detail_pegawai = $this->db->where("nip = '" . $row->pin . "'")->get("v_pns")->row_array();
  //       $ket_jab = $detail_pegawai["ket_jab"];
  //     } else {
  //       $detail_pegawai = $this->db->where("niptt = '" . $row->pin . "'")->get("v_ptt")->row_array();
  //       $ket_jab = ($detail_pegawai["kode_tugas"] != 99) ? $detail_pegawai["ket_tugas"] : $detail_pegawai["ket_jabtgs"];
  //     }
  //     $data_result[$index]['no'] = $no;
  //     $data_result[$index]['cloud_id'] = $row->nama_mesin . " ( " . $row->cloud_id . " )";
  //     $data_result[$index]['pin'] = $row->pin;
  //     $data_result[$index]['nama'] = $row->nama;
  //     $data_result[$index]['ket_jab'] = $ket_jab;
  //     $data_result[$index]['ket_ukerja'] = $detail_pegawai["ket_ukerja"];
  //     $data_result[$index]['scan_date'] = $row->scan_date;
  //     $data_result[$index]['ket_verify'] = $ket_verify;
  //     $data_result[$index]['ket_status_scan'] = $ket_status_scan;
  //     $no += 1;
  //     $index += 1;
  //   }
  //   // kembalikan data yang didapat ke controller
  //   return $data_result;
  // }

  /** fungsi untuk nambah transaksi baru */
  // public function add_transaksi($data)
  // {
  //   // inisiasi response
  //   $res = array(
  //     'status' => false,
  //     'message' => "Maaf, proses menambahkan transaksi gagal. (ERRxMTR01)"
  //   );
  //   // ambil dan tata data yang akan diinsert
  //   $subject = $this->session->userdata('username');
  //   $table = "r_dok_sewa";
  //   $inserted_data = $data;
  //   $inserted_data['tgl_mulai_manfaat'] = datetime_to_sql($data['tgl_mulai_manfaat']);
  //   $inserted_data['tgl_selesai_manfaat'] = datetime_to_sql($data['tgl_selesai_manfaat']);
  //   $inserted_data['no_dok'] = generate_no_dok();
  //   $inserted_data['s_aktif'] = '1';
  //   $inserted_data['s_proses'] = '00';
  //   $inserted_data['tgl_dok'] = datetime_now();
  //   $hpl_text = ($data['hpl'] == 'Y') ? 'HPL' : 'Non-HPL';
  //   unset($inserted_data['id']);
  //   // lakukan proses insert
  //   $this->db->trans_begin();
  //   // do your db process here
  //   // insert ke r_dok_sewa
  //   $this->db->insert('r_dok_sewa', $inserted_data);
  //   $object = $this->db->insert_id();
  //   // buat log
  //   log_generator(
  //     $subject,
  //     '|' . $table . '|',
  //     '|' . $object . '|',
  //     'Menambahkan permohonan baru (' . $inserted_data['no_dok'] . ') dengan jenis ' . $hpl_text . ' ' . $data['jns_dok'] . '.'
  //   );
  //   if ($this->db->trans_status() === FALSE) {
  //     // do your error handler here
  //     $this->db->trans_rollback();
  //   } else {
  //     $res['status'] = true;
  //     $res['message'] = "Dokumen transaksi berhasil disimpan sebagai draft.";
  //     $this->db->trans_commit();
  //   }
  //   return $res;
  // }

  /** fungsi untuk nambah transaksi baru */
  // public function edit_transaksi($data)
  // {
  //   // inisiasi response
  //   $res = array(
  //     'status' => false,
  //     'message' => "Maaf, proses menambahkan transaksi gagal. (ERRxMTR02)"
  //   );
  //   // ambil dan tata data yang akan di-update
  //   $subject = $this->session->userdata('username');
  //   $table = "r_dok_sewa";
  //   $updated_data = $data;
  //   $updated_data['tgl_mulai_manfaat'] = datetime_to_sql($data['tgl_mulai_manfaat']);
  //   $updated_data['tgl_selesai_manfaat'] = datetime_to_sql($data['tgl_selesai_manfaat']);
  //   $hpl_text = ($data['hpl'] == 'Y') ? 'HPL' : 'Non-HPL';
  //   unset($updated_data['id']);
  //   // buat where condition
  //   $where = array(
  //     'id' => $data['id']
  //   );
  //   // lakukan proses update
  //   $this->db->trans_begin();
  //   // do your db process here
  //   // update ke r_dok_sewa
  //   $this->db->update('r_dok_sewa', $updated_data, $where);
  //   $object = $data['id'];
  //   // buat log
  //   log_generator(
  //     $subject,
  //     '|' . $table . '|',
  //     '|' . $object . '|',
  //     'Meng-update dokumen permohonan (' . $updated_data['no_dok'] . ') dengan jenis ' . $hpl_text . ' ' . $data['jns_dok'] . '.'
  //   );
  //   if ($this->db->trans_status() === FALSE) {
  //     // do your error handler here
  //     $this->db->trans_rollback();
  //   } else {
  //     $res['status'] = true;
  //     $res['message'] = "Dokumen transaksi berhasil di-update.";
  //     $this->db->trans_commit();
  //   }
  //   return $res;
  // }

  /** fungsi untuk nambah transaksi baru */
  // public function delete_transaksi($data)
  // {
  //   // inisiasi response
  //   $res = array(
  //     'status' => false,
  //     'message' => "Maaf, proses menambahkan transaksi gagal. (ERRxMTR03)"
  //   );
  //   // ambil dan tata data yang akan dihapus
  //   $subject = $this->session->userdata('username');
  //   $table = "r_dok_sewa";
  //   // kondisi where
  //   $where = array(
  //     'id' => $data['id']
  //   );
  //   // lakukan proses delete
  //   $this->db->trans_begin();
  //   // do your db process here
  //   // delete dari r_dok_sewa
  //   $this->db->delete('r_dok_sewa', $where);
  //   $object = $data['id'];
  //   // buat log
  //   log_generator(
  //     $subject,
  //     '|' . $table . '|',
  //     '|' . $object . '|',
  //     'Menghapus dokumen permohonan (' . $data['no_dok'] . ').'
  //   );
  //   if ($this->db->trans_status() === FALSE) {
  //     // do your error handler here
  //     $this->db->trans_rollback();
  //   } else {
  //     $res['status'] = true;
  //     $res['message'] = "Dokumen transaksi berhasil dihapus.";
  //     $this->db->trans_commit();
  //   }
  //   return $res;
  // }

  public function delete($data)
  {
    try {
      $this->db->trans_begin();
      $this->db->where(["id" => $data["id"]])->delete("progurinda_r_jurnal_mengajar");
      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        $res = [
          'status' => false,
          'message' => "Data Arsip TPP gagal dibatalkan!"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        $res = [
          'status' => true,
          'message' => "Data Arsip TPP berhasil dibatalkan!"
        ];
      }
    } catch (\Throwable $th) {
      $res = [
        'status' => false,
        'message' => "Proses hapus kamar kost error! Error message : " . $th->getMessage()
      ];
    }
    return $res;
  }
}
