<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_tpp_per_bulan extends CI_Model
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

  public function get_data_tpp($con){
    //----------=========----------------------------------------//
    // START - query untuk dapat list pegawainya di periode itu //
    //-------------------=========-----------------------------//

    //init nama temp table
    $name_temp_pegawai_jab = "temp_pegawai_jab".time();
    $name_temp_pegawai_pensiun = "temp_pegawai_pensiun".time();
    $name_temp_pegawai_aktif = "temp_pegawai_aktif".time();
    $name_temp_presensi_pegawai = "temp_presensi_pegawai".time();
   
    $where_q = "kode_instansi = '" . $param["kode_ukerja"] . "'";
    //$index = $this->input->post("order[0][column]");
    //$dir = $this->input->post("order[0][dir]");
    //sorting data pegawai
    //$order_by = " ORDER BY pns.kode_eselon,pns.kode_ukerja asc,pns.kode_jab asc, " . $index . " " . $dir;
    $order_by = " ORDER BY pns.kode_eselon,pns.kode_ukerja asc,pns.kode_jab asc ";
    $limit = "";
    if ($param["length"] != "-1") {
      $limit = " LIMIT " . $param["start"] . "," . $param['length'];
    }

    if ($param["search"] != "") {
      $where_q .= " AND (nama LIKE \"%" . $param["search"] . "%\" OR nip LIKE \"%" . $param["search"] . "%\")";
      /* $this->db->like("nama_lengkap", $search, "both");
      $this->db->or_like("nip", $search, "both"); */
    }

    $filter_guru = 'UPPER(LEFT(r_jab.ket_jab, 4)) = "GURU" OR r_jab.ket_jab LIKE "% GURU%" OR r_jab.ket_jab LIKE "%GURU %" OR LEFT(r_jab.ket_jab, 16) = "PENGAWAS SEKOLAH" OR LEFT(r_jab.ket_jab,8) = "PENGAWAS" ';

    //mulai query untuk presensi
    $this->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_jab);
    $this->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_gol);
    $this->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_pensiun);
    $this->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_aktif);
    $this->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_presensi_pegawai);
    $this->db->query("CREATE TEMPORARY TABLE ".$name_temp_pegawai_jab." 
    (PRIMARY KEY pktemp (nip),
    INDEX idx_temp (nip),
    nip varchar(18),
    nama varchar(255),
    ket_ukerja varchar(255),
    ket_jab varchar(255)
    )");

    $this->db->query("INSERT INTO ".$name_temp_pegawai_jab." SELECT r_jab.nip AS nip,m_pegawai.nama,r_jab.ket_ukerja,r_jab.ket_jab FROM r_jab 
    JOIN m_pegawai ON r_jab.nip = m_pegawai.nip
    JOIN m_ukerja ON r_jab.kode_ukerja = m_ukerja.kode_ukerja
    JOIN m_jab ON r_jab.kode_jab = m_jab.kode_jab AND r_jab.kode_ukerja = m_jab.kode_ukerja
    WHERE (
              (UPPER(
              LEFT ( r_jab.ket_jab, 4 )) = \"GURU\" 
              OR r_jab.ket_jab LIKE \"% GURU%\" 
              OR r_jab.ket_jab LIKE \"%GURU %\" 
              OR LEFT ( r_jab.ket_jab, 16 ) = \"PENGAWAS SEKOLAH\" 
              OR LEFT ( r_jab.ket_jab, 8 ) = \"PENGAWAS\" 
              )
              AND ( LEFT ( m_ukerja.unit_kepeg, 8 ) = '".$param["kode_ukerja"]."' OR m_ukerja.kode_instansi = '".$param["kode_ukerja"]."' ) 
              AND (
                m_pegawai.tgl_keluar IS NULL 
              OR ( m_pegawai.tgl_keluar > '".$param["filter_thn"]."-".$param["filter_bln"]."-01' OR m_pegawai.s_aktif = \"-1\" ))
              AND r_jab.tmt_jab <= '".$param["filter_thn"]."-".$param["filter_bln"]."-01')
     GROUP BY r_jab.nip");
    
     $this->db->query("CREATE TEMPORARY TABLE ".$name_temp_pegawai_pensiun."
     (PRIMARY KEY pktemp (nip),
      INDEX idx_temp (nip),
      nip varchar(18),
      tgl_pensiun date
     )");
			
     $this->db->query("INSERT INTO ".$name_temp_pegawai_pensiun." SELECT ".$name_temp_pegawai_jab.".nip,f_get_tgl_pensiun( m_pegawai.tgl_lahir, m_jab.jns_jab, m_pegawai.kode_gol, m_pegawai.kode_eselon)
     FROM ".$name_temp_pegawai_jab." JOIN m_pegawai ON m_pegawai.nip = ".$name_temp_pegawai_jab.".nip 
     JOIN m_jab ON m_pegawai.kode_ukerja = m_jab.kode_ukerja AND m_pegawai.kode_jab = m_jab.kode_jab"); 
     
     $this->db->query("CREATE TEMPORARY TABLE ".$name_temp_pegawai_aktif."
     (PRIMARY KEY pktemp (nip),
      INDEX idx_temp (nip),
      nip varchar(18),
      tgl_pensiun date,
      nomor_jab bigint(20)
     )");
		 
     $this->db->query(
      "INSERT INTO ".$name_temp_pegawai_aktif." SELECT ".$name_temp_pegawai_pensiun.".nip as nip,".$name_temp_pegawai_pensiun.".tgl_pensiun as tgl_pensiun,f_get_jab_per_period(".$name_temp_pegawai_pensiun.".nip, '".$param["filter_thn"]."-".$param["filter_bln"]."-02') AS nomor_jab FROM ".$name_temp_pegawai_pensiun." WHERE ".$name_temp_pegawai_pensiun.".tgl_pensiun > '".$param["filter_thn"]."-".$param["filter_bln"]."-01'"
     );

     $this->db->query(
      "CREATE TEMPORARY TABLE ".$name_temp_presensi_pegawai." 
      (PRIMARY KEY pktemp (nip,tahun,bulan),
       INDEX idx_temp (nip),
       id int(11),
       nip varchar(18),
       nama varchar(255),
       kode_jab varchar(20),
       kode_ukerja varchar(20),
       ket_jab varchar(100),
       ket_uorg varchar(200),
       ket_ukerja varchar(100),
       jns_jab varchar(6),
       kode_eselon varchar(2),
       tahun int(4),
       bulan int(2),
       terlambat int(11),
       pulang_cepat int(11),
       tidak_masuk int(11),
       tidak_apel int(11),
       lupa_absen int(11),
       potongan_persen decimal(5,2),
       potongan_persen_harian decimal(5,2),
       last_update timestamp,
       username_input varchar(255),
       input_time datetime
      )"
     );
      //tanggal maximum dibulan filter
      $periode_filter = $param["filter_thn"]."-".$param["filter_bln"]."-".date("t");

      //query untuk mendapat list data pegawai
      $this->db->query("INSERT INTO ".$name_temp_presensi_pegawai." SELECT 
      r_presensi.id as id,
      ".$name_temp_pegawai_aktif.".nip as nip,
      m_pegawai.nama AS nama,
      r_jab.kode_jab AS kode_jab,
      r_jab.kode_ukerja AS kode_ukerja,
      r_jab.ket_jab AS ket_jab,
      r_jab.ket_uorg AS ket_uorg,
      r_jab.ket_ukerja AS ket_ukerja,
      r_jab.jns_jab AS jns_jab,
      r_jab.kode_eselon AS kode_eselon,
      f_get_gol_per_period(".$name_temp_pegawai_aktif.".nip,'".$periode_filter."') AS kode_gol,
      r_presensi.tahun AS tahun,
      r_presensi.bulan AS bulan,
      r_presensi.terlambat AS terlambat,
      r_presensi.pulang_cepat AS pulang_cepat,
      r_presensi.tidak_masuk AS tidak_masuk,
      r_presensi.tidak_apel AS tidak_apel,
      r_presensi.lupa_absen AS lupa_absen,
      IFNULL(r_presensi.potongan_persen,'Data Tidak Ditemukan') AS potongan_persen,
      r_presensi.potongan_persen_harian AS potongan_persen_harian,
      r_presensi.last_update AS last_update,
      r_presensi.username_input AS username_input,
      r_presensi.input_time AS input_time
        FROM ".$name_temp_pegawai_aktif." LEFT JOIN 
        (
        SELECT * FROM progurinda_r_data_presensi WHERE tahun = ".$param["filter_thn"]." AND bulan = ".$param["filter_bln"]."
        ) AS r_presensi ON ".$name_temp_pegawai_aktif.".nip = r_presensi.nip
        LEFT JOIN m_pegawai ON ".$name_temp_pegawai_aktif.".nip = m_pegawai.nip
        LEFT JOIN r_jab ON ".$name_temp_pegawai_aktif.".nomor_jab = r_jab.nomor
        JOIN m_ukerja ON r_jab.kode_ukerja = m_ukerja.kode_ukerja
        WHERE (UPPER(
                LEFT ( r_jab.ket_jab, 4 )) = \"GURU\" 
                OR r_jab.ket_jab LIKE \"% GURU%\" 
                OR r_jab.ket_jab LIKE \"%GURU %\" 
                OR LEFT ( r_jab.ket_jab, 16 ) = \"PENGAWAS SEKOLAH\" 
                OR LEFT ( r_jab.ket_jab, 8 ) = \"PENGAWAS\" 
                )
                AND ( LEFT ( m_ukerja.unit_kepeg, 8 ) = '".$param["kode_ukerja"]."' OR m_ukerja.kode_instansi = '".$param["kode_ukerja"]."' )
      ");
                
      $data["jml"] = $this->db->query("SELECT * FROM ".$name_temp_presensi_pegawai)->num_rows();
      $list = $this->db->query("SELECT * FROM ".$name_temp_presensi_pegawai." ORDER BY ".$name_temp_presensi_pegawai.".kode_eselon,".$name_temp_presensi_pegawai.".kode_ukerja asc,".$name_temp_presensi_pegawai.".kode_jab asc ".$limit)->result_array();

      $this->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_jab);
      $this->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_pensiun);
      $this->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_pegawai_aktif);
      $this->db->query("DROP TEMPORARY TABLE IF EXISTS ".$name_temp_presensi_pegawai);

    //----------=========---------------------------------------//
   //   END - query untuk dapat list pegawainya di periode itu //
  //-----------------=--=========-----------------------------//
      //loop lengkapi field2 nya
      //tentukan nilai tpp berdasarkan golongan
      //tentukan potongannya
      //potongan dari disiplin
      //potongan dari jurnal mengajar
      //susun list untuk ditampilkan di front end
  }

  public function get_data_tpp_copy($con)
  {
    if ($con["kode_ukerja"] == "69710328" || $con["kode_ukerja"] == "69710345") {
      $where_q = "kode_instansi LIKE '" . $con["kode_ukerja"] . "%' OR unit_kepeg = '" . $con["kode_ukerja"] . "'";
    } else {
      $where_q = "kode_instansi = '" . $con["kode_ukerja"] . "'";
    }

    $order_by = " ORDER BY pns.kode_eselon,pns.kode_ukerja asc,pns.kode_jab asc ";
    $limit = "";

    $query = "
    SELECT
    pns.nip, 
    pns.nama_lengkap, 
    pns.kode_ukerja, 
    pns.kode_instansi, 
    pns.unit_kepeg, 
    pns.ket_uorg, 
    pns.ket_ukerja, 
    pns.kode_jab, 
    pns.id_hari_kerja, 
    pns.ket_jab, 
    pns.jns_jab, 
    pns.kode_eselon, 
    pns.persen_beban_kerja,
    pns.prestasi_kerja,
    pns.prestasi_kerja_nominal,
    pns.kondisi_kerja,
    pns.kelangkaan_profesi,
    pns.penilaian_obyektif,
    (pns.persen_beban_kerja + pns.prestasi_kerja + pns.kondisi_kerja + pns.kelangkaan_profesi + pns.penilaian_obyektif) AS total_persen_tpp,
    pns.total_tpp,
    r_presensi.tahun, 
    r_presensi.bulan, 
    IFNULL(rekap_potongan_tpp.persen,0) AS persen_potongan_tpp,
    IFNULL(r_presensi.terlambat,0) AS  terlambat,
    IFNULL(r_presensi.pulang_cepat,0) AS pulang_cepat, 
    IFNULL(r_presensi.tidak_masuk,0) AS tidak_masuk,
    (IFNULL(r_presensi.terlambat,0) + IFNULL(r_presensi.pulang_cepat,0) + IFNULL(r_presensi.tidak_masuk,0)) AS total_menit_lalai, 
    IFNULL(r_presensi.tidak_apel,0) AS tidak_apel, 
    IFNULL(r_presensi.lupa_absen,0) AS lupa_absen, 
    IFNULL(r_presensi.potongan_persen,0) AS potongan_persen, 
    IFNULL(r_presensi.potongan_persen_harian,0) AS potongan_persen_harian, 
    IFNULL(r_presensi.id,0) AS id
  FROM
    (
      SELECT * FROM
      r_data_presensi
      WHERE tahun = " . $con["filter_thn"] . " AND bulan = " . (int)$con["filter_bln"] . "
    ) as r_presensi
  Right JOIN
    (
      SELECT
    list_peg.nip,
    list_peg.nama_lengkap,
    list_peg.tgl_pensiun,
    list_peg.tgl_keluar,
    list_peg.s_aktif,
    list_peg.nomor_jab,
    r_jab.tmt_jab,
    r_jab.tgl_sk,
    m_jab.ket_jab,
    m_jab.id_hari_kerja,
    m_ukerja.ket_uorg,
    m_ukerja.ket_ukerja,
    r_jab.kode_eselon,
    r_jab.jns_jab,
    r_jab.kode_ukerja,
    r_jab.kode_jab,
    m_jab.kode_kelas_jab,
    IFNULL(config_kelas_jab.nominal_ttp,0) AS nominal_ttp,
    m_ukerja.unit_kepeg,
    m_ukerja.kode_instansi,
    f_get_beban_kerja2 (list_peg.nip, r_jab.jns_jab, r_jab.kode_eselon, r_jab.kode_ukerja, r_jab.kode_jab, m_jab.kode_kelas_jab ) AS persen_beban_kerja,
    (IFNULL(config_kelas_jab.nominal_ttp,0) * (f_get_beban_kerja2 (list_peg.nip, r_jab.jns_jab, r_jab.kode_eselon, r_jab.kode_ukerja, r_jab.kode_jab, m_jab.kode_kelas_jab )/100)) AS beban_kerja,
    f_get_tambahan_tpp(list_peg.nip, r_jab.jns_jab, r_jab.kode_eselon, r_jab.kode_ukerja, r_jab.kode_jab, m_jab.kode_kelas_jab,\"PK\") AS prestasi_kerja,
    f_get_tambahan_tpp(list_peg.nip, r_jab.jns_jab, r_jab.kode_eselon, r_jab.kode_ukerja, r_jab.kode_jab, m_jab.kode_kelas_jab,\"PKN\") AS prestasi_kerja_nominal,
    f_get_tambahan_tpp(list_peg.nip, r_jab.jns_jab, r_jab.kode_eselon, r_jab.kode_ukerja, r_jab.kode_jab, m_jab.kode_kelas_jab,\"KK\") AS kondisi_kerja,
    f_get_tambahan_tpp(list_peg.nip, r_jab.jns_jab, r_jab.kode_eselon, r_jab.kode_ukerja, r_jab.kode_jab, m_jab.kode_kelas_jab,\"KP\") AS kelangkaan_profesi,
    f_get_tambahan_tpp(list_peg.nip, r_jab.jns_jab, r_jab.kode_eselon, r_jab.kode_ukerja, r_jab.kode_jab, m_jab.kode_kelas_jab,\"PO\") AS penilaian_obyektif,
    (
      (IFNULL( config_kelas_jab.nominal_ttp, 0 ) * (
      f_get_beban_kerja2 ( list_peg.nip, r_jab.jns_jab, r_jab.kode_eselon, r_jab.kode_ukerja, r_jab.kode_jab, m_jab.kode_kelas_jab ) / 100 
      )) + (
      (
      (
      f_get_tambahan_tpp ( list_peg.nip, r_jab.jns_jab, r_jab.kode_eselon, r_jab.kode_ukerja, r_jab.kode_jab, m_jab.kode_kelas_jab, \"PK\" ) + f_get_tambahan_tpp ( list_peg.nip, r_jab.jns_jab, r_jab.kode_eselon, r_jab.kode_ukerja, r_jab.kode_jab, m_jab.kode_kelas_jab, \"KK\" ) + f_get_tambahan_tpp ( list_peg.nip, r_jab.jns_jab, r_jab.kode_eselon, r_jab.kode_ukerja, r_jab.kode_jab, m_jab.kode_kelas_jab, \"KP\" ) + f_get_tambahan_tpp ( list_peg.nip, r_jab.jns_jab, r_jab.kode_eselon, r_jab.kode_ukerja, r_jab.kode_jab, m_jab.kode_kelas_jab, \"PO\" ) 
      ) / 100 
      ) * (
      IFNULL( config_kelas_jab.nominal_ttp, 0 ) 
      )))
      +  f_get_tambahan_tpp(list_peg.nip, r_jab.jns_jab, r_jab.kode_eselon, r_jab.kode_ukerja, r_jab.kode_jab, m_jab.kode_kelas_jab,\"PKN\") AS total_tpp
  FROM
    (
  SELECT
    mp.nip,
    mp.nama_lengkap,
    mp.tgl_lahir,
    mp.tgl_pensiun,
    mp.tgl_keluar,
    mp.s_aktif,
    f_get_jab_per_period ( mp.nip, '" . $con["filter_thn"] . "-" . $con["filter_bln"] . "-02' ) AS nomor_jab 
  FROM
    (
  SELECT
    m_pegawai.nip,
    CONCAT(
  IF
    ( m_pegawai.gelar_dpn IS NULL OR m_pegawai.gelar_dpn = \" \", \"\", CONCAT( m_pegawai.gelar_dpn, \" \" ) ),
    m_pegawai.nama,
  IF
    ( m_pegawai.gelar_blk IS NULL, \"\", CONCAT( \",\", m_pegawai.gelar_blk ) ) 
    ) AS nama_lengkap,
    m_pegawai.tgl_lahir,
    m_pegawai.tgl_keluar,
    m_pegawai.s_aktif,
    m_ukerja.unit_kepeg,
    f_get_tgl_pensiun ( m_pegawai.tgl_lahir, m_jab.jns_jab, m_pegawai.kode_gol, m_pegawai.kode_eselon ) AS tgl_pensiun
  FROM
    m_pegawai
    LEFT JOIN m_jab ON m_pegawai.kode_ukerja = m_jab.kode_ukerja 
    AND m_pegawai.kode_jab = m_jab.kode_jab
    RIGHT JOIN r_jab ON m_pegawai.nip = r_jab.nip	
    LEFT JOIN m_ukerja ON r_jab.kode_ukerja = m_ukerja.kode_ukerja
  WHERE
  (LEFT ( r_jab.ket_jab, 4 ) <> \"Guru\" AND LEFT ( r_jab.jns_jab, 4 ) <> \"2200\")
	  AND LEFT ( r_jab.ket_jab, LENGTH( \"Pengawas Sekolah\" ) ) <> \"Pengawas Sekolah\" 
    AND (LEFT ( m_ukerja.unit_kepeg, 8 ) = '" . $con["kode_ukerja"] . "' OR m_ukerja.kode_instansi = '" . $con["kode_ukerja"] . "' OR m_ukerja.unit_kepeg = '" . $con["kode_ukerja"] . "') 
    AND (m_pegawai.tgl_keluar is null OR (m_pegawai.tgl_keluar > '" . $con["filter_thn"] . "-" . $con["filter_bln"] . "-01' OR m_pegawai.s_aktif = \"-1\"))
  GROUP BY
    m_pegawai.nip 
    ) AS mp 
  WHERE
    mp.tgl_pensiun > '" . $con["filter_thn"] . "-" . $con["filter_bln"] . "-01' 
    ) AS list_peg
    JOIN r_jab ON list_peg.nomor_jab = r_jab.nomor 
    AND list_peg.nip = r_jab.nip
    JOIN m_jab ON r_jab.kode_jab = m_jab.kode_jab 
    AND r_jab.kode_ukerja = m_jab.kode_ukerja
    LEFT JOIN config_kelas_jab ON m_jab.kode_kelas_jab = config_kelas_jab.kode_kelas_jab
    JOIN m_ukerja ON r_jab.kode_ukerja = m_ukerja.kode_ukerja
  WHERE (LEFT ( r_jab.ket_jab, 4 ) <> \"Guru\" AND LEFT ( r_jab.jns_jab, 4 ) <> \"2200\")
    AND LEFT ( r_jab.ket_jab, LENGTH( \"Pengawas Sekolah\" ) ) <> \"Pengawas Sekolah\"
    AND (LEFT ( m_ukerja.unit_kepeg, 8 ) = '" . $con["kode_ukerja"] . "' OR m_ukerja.kode_instansi = '" . $con["kode_ukerja"] . "' OR m_ukerja.unit_kepeg = '" . $con["kode_ukerja"] . "')
  ORDER BY kode_ukerja,kode_eselon asc
    ) AS pns
    ON 
      r_presensi.nip = pns.nip AND
      r_presensi.kode_ukerja = pns.kode_ukerja AND
      r_presensi.kode_jab = pns.kode_jab 
  LEFT JOIN (SELECT
  nip,
  sum( persen_potongan ) AS persen 
  FROM
  `v_potongan_ttp` 
  WHERE jns_potongan <> 'mutasi' AND ((
  '" . $con["filter_thn"] . "-" . $con["filter_bln"] . "-01' BETWEEN DATE( CONCAT( thn_mulai, '-', bln_mulai, '-01' ) ) 
  AND DATE( CONCAT( thn_selesai, '-', bln_selesai, '-01' ) ) ) OR ( DATE( CONCAT( thn_mulai, '-', bln_mulai, '-01' )) <= '" . $con["filter_thn"] . "-" . $con["filter_bln"] . "-01' AND thn_selesai is NULL))
  GROUP BY
  nip) AS rekap_potongan_tpp ON pns.nip = rekap_potongan_tpp.nip
    WHERE
    " . $where_q . " AND LEFT ( pns.ket_jab, 4 ) <> 'Guru' AND
    pns.jns_jab <> '2010' ";
    // $table = "v_data_presensi";
    // $this->get_table($_TAG,$con,$search);
    $data["jml"] = $this->db->query($query)->num_rows();
    //$filter = $this->get_filter();
    //$this->db->where($where_q);
    $list = $this->db->query($query . $order_by . $limit)->result_array();
    $idx = 0;
    //get jumlah hari senin-kamis , hari jumat dan sabtu untuk 6 hari kerja
    $hari_kerja = get_jml_hari_kerja_per_bulan($con["filter_thn"], (int)$con["filter_bln"]);
    //cari nilai potongan permenit untuk masing-masing
    //menit per hari 5 hari kerja
    $menit_harian_5 = get_jumlah_menit(1, $con["filter_thn"] . "-" . $con["filter_bln"] . "-01");
    //menit per hari 6 hari kerja
    $menit_harian_6 = get_jumlah_menit(2, $con["filter_thn"] . "-" . $con["filter_bln"] . "-01");
    //menit per hari sistem shift
    $menit_harian_shift = 321;
    //untuk 5 hari kerja
    $max_menit[1] = ($menit_harian_5["menit_senin_kamis"] * ($hari_kerja["senin_kamis"] + $hari_kerja["senin_kamis_khusus"])) + ($menit_harian_5["menit_jumat"] * ($hari_kerja["jumat"] + $hari_kerja["jumat_khusus"]));
    //untuk 6 hari kerja
    $max_menit[2] = ($menit_harian_6["menit_senin_kamis"] *  ($hari_kerja["senin_kamis"] + $hari_kerja["senin_kamis_khusus"])) + ($menit_harian_6["menit_jumat"] * ($hari_kerja["jumat"] + $hari_kerja["jumat_khusus"])) + ($menit_harian_6["menit_sabtu"] * ($hari_kerja["sabtu"] + $hari_kerja["sabtu_khusus"])); //untuk sistem shift
    //untuk sistem shift
    $max_menit[99] = $menit_harian_shift * date('t', mktime(0, 0, 0, (int)$con["filter_bln"], 1, $con["filter_thn"]));
    //get persentase tpp disiplin kerja
    $persentase_disiplin = dlookup("persen_kehadiran", "config_besaran_ttp", "id = 1");
    $tmt_baru = "2023-03-01";
    $filter_periode = $con["filter_thn"] . "-" . $con["filter_bln"] . "-01";
    if (strtotime($filter_periode) >= strtotime($tmt_baru)) {
      //aturan baru
      $menit_harian_elogbook_5 = 315;
      $menit_harian_elogbook_6 = 262;
      $menit_harian_elogbook_99 = 225;
    } else {
      //aturan lama    
      $menit_harian_elogbook_5 = 300;
      $menit_harian_elogbook_6 = 250;
      $menit_harian_elogbook_99 = 215;
    }

    $menit_harian_elogbook_5_khusus = 0;
    $menit_harian_elogbook_6_khusus = 0;
    $menit_harian_elogbook_99_khusus = 0;
    $get_data_khusus = $this->db->where('DATE_FORMAT(tgl_mulai,"%Y-%m") <= "' . $con["filter_thn"] . '-' . $con["filter_bln"] . '" AND DATE_FORMAT(tgl_selesai,"%Y-%m") >= "' . $con["filter_thn"] . '-' . $con["filter_bln"] . '"')->get("config_menit_efektif");
    $menit_khusus = ($get_data_khusus->num_rows() > 0) ? $get_data_khusus->row_array() : false;
    if ($menit_khusus != false) {
      $menit_harian_elogbook_5_khusus = $menit_khusus["menit_efektif_5"];
      $menit_harian_elogbook_6_khusus = $menit_khusus["menit_efektif_6"];
      $menit_harian_elogbook_99_khusus = $menit_khusus["menit_efektif_shift"];
      $time_khusus_mulai = strtotime($menit_khusus["tgl_mulai"]);
      $time_khusus_selesai = strtotime($menit_khusus["tgl_selesai"]);
    }
    //untuk 5 hari_kerja
    //$max_menit_logbook[1] = ($menit_harian_elogbook_5 * ($hari_kerja["senin_kamis"] + $hari_kerja["jumat"])) + ($menit_harian_elogbook_5_khusus * ($hari_kerja["senin_kamis_khusus"] + $hari_kerja["jumat_khusus"])) ." || ". ($menit_harian_elogbook_5." x ($hari_kerja[senin_kamis] + $hari_kerja[jumat] ) || (".$menit_harian_elogbook_5_khusus." x ($hari_kerja[senin_kamis_khusus] + $hari_kerja[jumat_khusus])))");

    $max_menit_logbook[1] = ($menit_harian_elogbook_5 * ($hari_kerja["senin_kamis"] + $hari_kerja["jumat"])) + ($menit_harian_elogbook_5_khusus * ($hari_kerja["senin_kamis_khusus"] + $hari_kerja["jumat_khusus"]));
    //untuk 6 hari kerja
    $max_menit_logbook[2] = ($menit_harian_elogbook_6 * ($hari_kerja["senin_kamis"] + $hari_kerja["jumat"] + $hari_kerja["sabtu"])) + ($menit_harian_elogbook_6_khusus * ($hari_kerja["senin_kamis_khusus"] + $hari_kerja["jumat_khusus"] + $hari_kerja["sabtu_khusus"]));
    //untuk sistem shift
    //$max_menit_logbook[99] = $menit_harian_elogbook_99 * date('t', mktime(0, 0, 0, (int)$con["filter_bln"], 1, $con["filter_thn"]));
    $max_menit_logbook[99] = ($menit_harian_elogbook_99 * $hari_kerja["shift"]) + ($menit_harian_elogbook_99_khusus * $hari_kerja["shift_khusus"]);

    //get persentase tpp elognook
    $persentase_elogbook = dlookup("persen_elogbook", "config_besaran_ttp", "id = 1");
    //cari persen potongan untuk tidak apel dan lupa/tidak absen
    $persentase_potongan_disiplin = $this->db->get("config_potongan_hukdis")->row_array();
    $ket_bln = (strlen($con["filter_bln"]) == 1) ? "0" . $con["filter_bln"] : $con["filter_bln"];
    //min date
    $min_date = $con["filter_thn"] . "-" . $con["filter_bln"] . "-01";

    //max date
    $max_date = (new DateTime($con["filter_thn"] . "-" . $con["filter_bln"] . "-01"))->modify('last day of');

    foreach ($list as $r) {
      //jika instansi tidak sama dengan kode ukerja filter (misal smp dan sekolah)
      if ($r["kode_instansi"] != $con["kode_ukerja"])
        $list[$idx]["ket_jab"] = $r["ket_jab"] . " " . $r["ket_ukerja"];
      //get nominal tpp pegawai
      //$besaran_tpp_murni = $this->db->where("nip = '" . $r["nip"] . "' AND kode_ukerja = '" . $r["kode_ukerja"] . "' AND kode_jab = '" . $r["kode_jab"] . "'")->get("v_daftar_budgeting_tpp_pns")->row_array();
      $list[$idx]["besaran_tpp_murni"] = $r["total_tpp"];
      //id hari kerja pegawai
      $id_hari_kerja = ($r["id_hari_kerja"] == null) ? 1 : $r["id_hari_kerja"];
      //cek potongan akibat mutasi dari daerah lain
      $q_check_mutasi = $this->db->where("nip = '" . $list[$idx]["nip"] . "' AND jns_potongan = 'mutasi' AND DATE_FORMAT(tgl_mulai,\"%Y-%m\") <= '" . $con["filter_thn"] . '-' . $con["filter_bln"] . "' AND DATE_FORMAT(tgl_selesai,\"%Y-%m\") >= '" . $con["filter_thn"] . '-' . $con["filter_bln"] . "'")->get("v_potongan_ttp");
      //menit capaian ditambah dengan menit yang di dapat saat cuti
      //menghitung menit capaian

      $menit_efektif = 0;
      $tmt_baru = "2023-03-01";
      $filter_periode = $con["filter_thn"] . "-" . $con["filter_bln"] . "-01";
      if (strtotime($filter_periode) >= strtotime($tmt_baru)) {
        //aturan baru
        switch ($id_hari_kerja) {
          case "1":
            $menit_efektif = "315";
            break;
          case "2":
            $menit_efektif = "262";
            break;
          default:
            $menit_efektif = "225";
            break;
        }
      } else {
        //aturan lama    
        switch ($id_hari_kerja) {
          case "1":
            $menit_efektif = "300";
            break;
          case "2":
            $menit_efektif = "250";
            break;
          default:
            $menit_efektif = "215";
            break;
        }
      }
      //potongan menit capaian untuk potongan mutasi berakhir di bulan ini
      $potongan_mutasi_menit_capaian = 0;
      //cek jika ada 
      if ($q_check_mutasi->num_rows() > 0) {
        $data_potongan = $q_check_mutasi->row_array();
        //cek apakah tanggal berakhir ada di bulan dan tahun filter
        if (substr($data_potongan["tgl_selesai"], 0, 7) == $con["filter_thn"] . "-" . $con["filter_bln"]) {
          //jika iya maka cek tgl yang tidak dihitung untuk tunjangan, dengan mengecek dari tgl 1 sampai == tgl berakhir potongan
          $tgl_berakhir_potongan = substr($data_potongan["tgl_selesai"], 8, 2);
          for ($d = 1; $d <= $tgl_berakhir_potongan; $d++) {
            //check apakah hari libur
            $libur = false;
            $ket_tgl = ($d < 10) ? "0" . $d : $d;
            $ket_tgl_lengkap = $con["filter_thn"] . "-" . $con["filter_bln"] .  "-" . $ket_tgl;
            //check hari apa tgl ini
            $n = date("N", mktime(0, 0, 0, $con["filter_bln"], $d, $con["filter_thn"]));

            $q_check_libur = $this->db->where("tgl_mulai = '" . $con["filter_thn"] . "-" . $con["filter_bln"] .  "-" . $ket_tgl . "'")->get("config_hari_libur");
            if ($q_check_libur->num_rows() > 0) {
              $libur = true;
            }
            //jika 5 hari kerja
            if ($id_hari_kerja == "1") {
              //  jika tidak libur
              if (!$libur) {
                //    check apakah hari senin-kamis
                if ($n >= 1 && $n <= 4) {
                  //       tambah menit tidak hadir sejumlah menit kerja
                  $r["tidak_masuk"] += $menit_harian_5["menit_senin_kamis"];
                } elseif ($n == 5) {
                  //    check apakah hari jumat
                  //       tambah menit tidak hadir sejumlah menit kerja
                  $r["tidak_masuk"] += $menit_harian_5["menit_jumat"];
                }
                //    tambah menit yang akan dikurangkan ke capaian elogbook
                if ($n >= 1 && $n <= 5) {
                  $potongan_mutasi_menit_capaian += $menit_efektif;
                }
              }
            }
            //jika 6 hari kerja
            elseif ($id_hari_kerja == "2") {
              //  jika tidak libur
              if (!$libur) {
                //    check apakah hari senin-kamis
                if ($n >= 1 && $n <= 4) {
                  //       tambah menit tidak hadir sejumlah menit kerja
                  $r["tidak_masuk"] += $menit_harian_6["menit_senin_kamis"];
                } elseif ($n == 5) {
                  //    check apakah hari jumat
                  //       tambah menit tidak hadir sejumlah menit kerja
                  $r["tidak_masuk"] += $menit_harian_6["menit_jumat"];
                } elseif ($n == 6) {
                  //    check apakah hari sabtu
                  //       tambah menit tidak hadir sejumlah menit kerja
                  $r["tidak_masuk"] += $menit_harian_6["menit_sabtu"];
                }
                //    tambah menit yang akan dikurangkan ke capaian elogbook
                if ($n >= 1 && $n <= 6) {
                  $potongan_mutasi_menit_capaian += $menit_efektif;
                }
              }
            } else {
              //jika sistem shift
              //   tambah menit tidak hadir sejumlah menit kerja
              $r["tidak_masuk"] += $menit_harian_shift;
              $potongan_mutasi_menit_capaian += $menit_efektif;
            }
          }
        } else {
          //ybs tidak dapat tpp
          $list[$idx]["persen_potongan_tpp"] = 100;
        }
      }
      $list[$idx]["persen_potongan_produktivitas"] = 0;
      //cek potongan cuti 
      $q_check_cuti = $this->db->where("nip = '" . $list[$idx]["nip"] . "' 
      AND (LEFT(v_cuti.tgl_mulai,7) <= \"" . $con["filter_thn"] . "-" . $ket_bln . "\" AND v_cuti.tgl_selesai >= \"" . $con["filter_thn"] . "-" . $ket_bln . "-07\")
      AND jml_hari_cuti >= 30")->get("v_cuti");
      if ($q_check_cuti->num_rows() > 0) {
        //jika ada cuti yang sedang aktif dan jumlah cuti >= 30 hari
        $data_cuti = $q_check_cuti->row_array();
        $berlaku = false;
        $sisa_jml_hari = $data_cuti["jml_hari_cuti"];
        $bulan_berjalan = $con["filter_thn"] . "-" . $ket_bln;
        $tgl_mulai = $data_cuti["tgl_mulai"];
        $tmp_start = new DateTime($data_cuti["tgl_mulai"]);
        $tmp_end = new DateTime($data_cuti["tgl_selesai"]);
        while ($sisa_jml_hari >= 30 && !$berlaku) {
          $interval = DateInterval::createFromDateString('29 day');
          $tmp_start->add($interval); //menambahkan 30 hari ke tanggal mulai
          $tmp_berlaku = new DateTime($tmp_start->format("Y-m-d"));
          //cek apakah tanggal berakhirnya <= 6 
          if ((int) $tmp_start->format("j") <= 6) {
            $interval = DateInterval::createFromDateString('1 month');
            $tmp_berlaku->sub($interval);
          }
          if ($bulan_berjalan == $tmp_berlaku->format("Y-m")) {
            $berlaku = true;
          }
          $tmp_start->add(DateInterval::createFromDateString('1 day')); //maju ke hari berikutnya
          $sisa_jml_hari -= 30;
        }
        if ($berlaku) {
          //jika bukan cuti tahunan maka lakukan potongan
          if ($data_cuti["kode_cuti"] != 1) {
            //Perwali 2022
            if ($con["perwali22"]) {
              //karena cuti akan memotong nilai tpp produktivitas sebesar 20%
              $list[$idx]["persen_potongan_produktivitas"] = 20;
            } else {
              //aturan lama tidak mengurangi tpp produktivitas, tapi tpp keseluruhan
              $list[$idx]["persen_potongan_tpp"] += 20;
            }
          }
        }
      }
      //cari potongan dari daftar potongan tpp
      $potongan_tpp_persen = ($list[$idx]["persen_potongan_tpp"] > 100) ? 100 : $list[$idx]["persen_potongan_tpp"];

      //rekap pada rentang waktu tersebut dari r_potongan berdasarkan nip
      $besaran_tpp = round((float)($r["total_tpp"] - ($r["total_tpp"] * $potongan_tpp_persen / 100)), 0, PHP_ROUND_HALF_UP);

      $list[$idx]["besaran_tpp"] = (int)$besaran_tpp;

      //cek nilai tpp disiplin kerja pegawai
      $tpp_disiplin_kerja = round((float)($besaran_tpp * $persentase_disiplin / 100), 0, PHP_ROUND_HALF_UP);
      $list[$idx]["tpp_disiplin_kerja"] = $tpp_disiplin_kerja;

      $list[$idx]["id_hari_kerja"] = $id_hari_kerja;
      /*********************************
       *Potongan terhadap disiplin kerja
       **********************************/
      //ATURAN LAMA
      if (!$con["perwali22"]) {
        //potongan per menit pegawai
        $potongan_per_menit = round((float)($tpp_disiplin_kerja / $max_menit[$id_hari_kerja]), 4, PHP_ROUND_HALF_UP);
        $list[$idx]["max_menit"] = $max_menit[$id_hari_kerja];
        $list[$idx]["potongan_per_menit"] = round($potongan_per_menit, 0, PHP_ROUND_HALF_UP);
        //potongan terlambat
        $list[$idx]["potongan_terlambat"] = round((float)($r["terlambat"] * $potongan_per_menit), 0, PHP_ROUND_HALF_UP);
        $list[$idx]["potongan_pulang_cepat"] = round((float)($r["pulang_cepat"] * $potongan_per_menit), 0, PHP_ROUND_HALF_UP);
        $list[$idx]["potongan_tidak_masuk"] = round((float)($r["tidak_masuk"] * $potongan_per_menit), 0, PHP_ROUND_HALF_UP);
        $list[$idx]["menit_tidak_masuk"] = $r["tidak_masuk"];
        //$list[$idx]["no"] = $offset + $idx + 1;
        $list[$idx]["total_potongan"] = $r["terlambat"] + $r["pulang_cepat"] + $r["tidak_masuk"];
        $list[$idx]["total_nilai_potongan"] = ($list[$idx]["potongan_terlambat"] + $list[$idx]["potongan_pulang_cepat"] + $list[$idx]["potongan_tidak_masuk"]);
        //nilai potongan lupa absen
        $list[$idx]["potongan_lupa_absen"] = round((float)($r["lupa_absen"] * $persentase_potongan_disiplin["persen_potongan_lupa"] * $tpp_disiplin_kerja / 100), 0, PHP_ROUND_HALF_UP);
        //nilai potongan tidak apel
        $list[$idx]["potongan_tidak_apel"] = round((float)(($tpp_disiplin_kerja - $list[$idx]["potongan_terlambat"] - $list[$idx]["potongan_pulang_cepat"] - $list[$idx]["potongan_tidak_masuk"] - $list[$idx]["potongan_lupa_absen"]) * ($r["tidak_apel"] * $persentase_potongan_disiplin["persen_potongan_tidak_apel"] / 100)), 0, PHP_ROUND_HALF_UP);
        $list[$idx]["potongan_tidak_apel"] = ($list[$idx]["potongan_tidak_apel"] < 0) ? 0 : $list[$idx]["potongan_tidak_apel"];
        //nilai total potongan disiplin kerja
        $list[$idx]["total_potongan_disiplin"] = $list[$idx]["potongan_terlambat"]  + $list[$idx]["potongan_pulang_cepat"] + $list[$idx]["potongan_tidak_masuk"] + $list[$idx]["potongan_lupa_absen"] + $list[$idx]["potongan_tidak_apel"];
        $list[$idx]["status_tpp"] = true;
      } else {
        //PERWALI 2022
        //langsung potong nilai tpp disiplin kerja sesuai dengan jumlah potongan persen yang diinput di r_data_presensi
        if ($r["potongan_persen"] != 0) {
          $list[$idx]["potongan_kehadiran"] = round((float)$tpp_disiplin_kerja * $r["potongan_persen"] / 100, 0, PHP_ROUND_HALF_UP);
        } else {
          $list[$idx]["potongan_kehadiran"] = round((float)$tpp_disiplin_kerja * $r["potongan_persen_harian"] / 100, 0, PHP_ROUND_HALF_UP);
        }
        //hitung potongan karena tidak apel, persen potongan langsung diambil dari  tpp disiplin kerja tanpa dikurangi oleh potongan kehadiran
        $list[$idx]["potongan_tidak_apel"] = round((float)(($tpp_disiplin_kerja) * ($r["tidak_apel"] * $persentase_potongan_disiplin["persen_potongan_tidak_apel"] / 100)), 0, PHP_ROUND_HALF_UP);
        //hitung total potongan disiplin
        $list[$idx]["total_potongan_disiplin"] = $list[$idx]["potongan_kehadiran"] + $list[$idx]["potongan_tidak_apel"];
        //lampirkan status tpp apakah dibayarkan atau tidak berdasarkan maksimal menit kelalaian > 800 = DITUNDA!
        $list[$idx]["status_tpp"] = ($r["total_menit_lalai"] > 800) ? false : true;
      }
      //jika nilainya melebihi nilai tpp disiplin kerja set nilainya sama agar tidak minus
      $list[$idx]["total_potongan_disiplin"] = ($list[$idx]["total_potongan_disiplin"] > $tpp_disiplin_kerja) ? $tpp_disiplin_kerja : $list[$idx]["total_potongan_disiplin"];

      //total penghasilan tpp disiplin
      $list[$idx]["penghasilan_tpp_disiplin"] = (int) ($tpp_disiplin_kerja - $list[$idx]["total_potongan_disiplin"]);

      //nilai tpp elogbook
      $tpp_elogbook = round((float)($besaran_tpp * $persentase_elogbook / 100), 0, PHP_ROUND_HALF_UP);
      $list[$idx]["tpp_elogbook"] = $tpp_elogbook;
      //cari capaian pegawai
      //$capaian = dlookup("persentase_capaian", "r_persentase_elogbook", "nip = '" . $list[$idx]["nip"] . "' AND kode_ukerja = '" . $list[$idx]["kode_ukerja"] . "' AND kode_jab = '" . $list[$idx]["kode_jab"] . "' AND periode_thn = " . $con["filter_thn"] . "  AND periode_bln = '" . $ket_bln . "'"); //100; //untuk testing
      //$menit_capaian = $this->db->query("SELECT f_get_menit_elogbook(\"" . $list[$idx]["nip"] . "\",\"" . $con["filter_bln"] . "\"," . $con["filter_thn"] . ") AS menit_capaian;")->row()->menit_capaian;
      //query lama
      //$menit_capaian = $this->db->query("SELECT nip,sum(durasi) AS menit_capaian FROM v_aktivitas WHERE v_aktivitas.nip = \"" . $r["nip"] . "\" AND MONTH(tgl_aktivitas) = \"" . $con["filter_bln"] . "\" AND YEAR(tgl_aktivitas) = " . $con["filter_thn"] . " AND s_verifikasi = '-1'")->row()->menit_capaian;



      $jml_hari = date('t', mktime(0, 0, 0, $con["filter_bln"], 1, $con["filter_thn"]));
      //$max_menit = $max_menit_logbook[$id_hari_kerja];
      $menit_capaian = 0;
      $hari_kena_cuti = 0;
      //cek ada cuti atau tidak
      $q_check_cuti = $this->db->where("nip = '" . $r["nip"] . "' AND (LEFT(tgl_mulai,7) <= '" . $con["filter_thn"] . "-" . $con["filter_bln"] . "' AND LEFT(tgl_selesai,7) >= '" . $con["filter_thn"] . "-" . $con["filter_bln"] . "')")->get("r_cuti");
      $tmpe = 0;
      //jika di bulan itu ada cuti
      if ($q_check_cuti->num_rows() > 0 && $q_check_cuti) {

        for ($d = 1; $d <= $jml_hari; $d++) {
          //jika termasuk hari dengan menit khusus set menit efektif = menit khusus

          $ket_tgl = ($d < 10) ? "0" . $d : $d;
          $days_of_week = date("w", strtotime($con["filter_thn"] . "-" . $con["filter_bln"] . "-" . $ket_tgl));
          $cuti = false;
          $libur = false;
          $khusus = false;
          //check_apakah hari ini termasuk cuti
          $q_check_cuti_tgl = $this->db->where("nip = '" . $r["nip"] . "' AND (tgl_mulai <= '" . $con["filter_thn"] . "-" . $con["filter_bln"] .  "-" . $ket_tgl . "' AND tgl_selesai >= '" . $con["filter_thn"] . "-" . $con["filter_bln"] .  "-" . $ket_tgl . "')")->get("r_cuti");
          if ($q_check_cuti_tgl->num_rows() > 0) {
            $cuti = true;
          }
          $q_check_libur = $this->db->where("tgl_mulai = '" . $con["filter_thn"] . "-" . $con["filter_bln"] .  "-" . $ket_tgl . "'")->get("config_hari_libur");
          if ($q_check_libur->num_rows() > 0) {
            $libur = true;
          }
          if ($menit_khusus != false) {
            if ($time_khusus_mulai <= strtotime($con["filter_thn"] . "-" . $con["filter_bln"] . "-" . $ket_tgl) && $time_khusus_selesai >= strtotime($con["filter_thn"] . "-" . $con["filter_bln"] . "-" . $ket_tgl)) {
              $khusus = true;
            }
          }

          //Jika !libur & !cuti
          if (!$libur && !$cuti) {
            //jika 5/6 hari kerja
            if ($id_hari_kerja <= 2) {
              $hari_kerja = true;
              //jika hari sabtu
              if ($days_of_week == 6) {
                //jika 5 hari kerja
                if ($id_hari_kerja == 1) {
                  //libur
                  $hari_kerja = false;
                }
              }
              //jika hari minggu
              if ($days_of_week == 0) {

                $hari_kerja = false;
              }
              //      jika hari kerja
              // update diperbolehkan input aktivitas walau hari libur, tapi tidak cuti
              //if ($hari_kerja) {
              //          menit per hari -> rekap menit capaian sehari group by tgl
              $where_q = "nip = '" . $r["nip"] . "' AND tgl_aktivitas =  '" . $con["filter_thn"] . "-" . $con["filter_bln"] .  "-" . $ket_tgl . "' AND s_verifikasi = '-1'";
              $q_sum_menit = $this->db->query("SELECT sum(durasi) as total_menit,nip from v_aktivitas WHERE " . $where_q . " GROUP BY nip,tgl_aktivitas");

              if ($q_sum_menit->num_rows() > 0) :
                $menit_capaian += $q_sum_menit->row()->total_menit;
              endif;
              //          set menit per hari di array sesuai tanggal

              //}
              //      jika bukan hari kerja
              //          set menit per hari = 0
            } else {
              //      jika sistem shift
              // 	    menit per hari -> rekap menit capaian sehari group by tgl
              $where_q = "nip = '" . $r["nip"] . "' AND tgl_aktivitas =  '" . $con["filter_thn"] . "-" . $con["filter_bln"] .  "-" . $ket_tgl . "' AND s_verifikasi = '-1'";

              $q_sum_menit = $this->db->query("SELECT sum(durasi) as total_menit,nip from v_aktivitas WHERE " . $where_q . " GROUP BY nip,tgl_aktivitas");

              if ($q_sum_menit->num_rows() > 0) :
                $menit_capaian += $q_sum_menit->row()->total_menit;
              endif;
            }
          }
          // Jika libur 
          elseif ($libur) {
            //      jika 5 hari kerja atau 6 hari kerja
            //           set menit = 0
            //      jika sistem shift 
            //lakukan perubahan walau di hari libur untuk 5/6 hari kerja tetap mengecek riwayat aktivitas
            //if ($id_hari_kerja > 2) {
            $where_q = "nip = '" . $r["nip"] . "' AND tgl_aktivitas =  '" . $con["filter_thn"] . "-" . $con["filter_bln"] .  "-" . $ket_tgl . "' AND s_verifikasi = '-1'";

            $q_sum_menit = $this->db->query("SELECT sum(durasi) as total_menit,nip from v_aktivitas WHERE " . $where_q . " GROUP BY nip,tgl_aktivitas");

            if ($q_sum_menit->num_rows() > 0) :
              $menit_capaian += $q_sum_menit->row()->total_menit;
            endif;
            //}
            //           set menit = total menit per hari untuk sistem shift
          }
          // jika cuti
          elseif ($cuti) {
            //jika 5/6 hari kerja
            if ($id_hari_kerja <= 2) {
              $hari_kerja = true;
              //jika hari sabtu
              if ($days_of_week == 6) {
                //jika 5 hari kerja
                if ($id_hari_kerja == 1) {
                  //libur
                  $hari_kerja = false;
                }
              }
              //jika hari minggu
              if ($days_of_week == 0) {
                $hari_kerja = false;
              }
              //      jika hari kerja
              if ($hari_kerja) {
                if ($khusus) {
                  switch ($id_hari_kerja) {
                    case '1':
                      $menit_capaian += $menit_harian_elogbook_5_khusus;
                      break;
                    case '2':
                      $menit_capaian += $menit_harian_elogbook_6_khusus;
                      break;

                    default:
                      $menit_capaian += $menit_harian_elogbook_5_khusus;
                      break;
                  }
                } else {
                  $menit_capaian += $menit_efektif;
                }
                $hari_kena_cuti++;
                //          set menit per hari di array sesuai tanggal
              }
              //      jika bukan hari kerja
              //          set menit per hari = 0
            } else {
              //      jika sistem shift
              // 	    menit per hari -> rekap menit capaian sehari group by tgl
              if ($khusus) {
                $menit_capaian += $menit_harian_elogbook_99_khusus;
              } else {
                $menit_capaian += $menit_efektif;
              }
              $hari_kena_cuti++;
            }
          }
          $tmpe++;
        }
      }
      //jika tidak ada cuti
      else {
        $where_q = "nip = '" . $r["nip"] . "' AND tgl_aktivitas BETWEEN '" . $con["filter_thn"] . "-" . $con["filter_bln"] .  "-01' AND '" . $con["filter_thn"] . "-" . $con["filter_bln"] .  "-" . $jml_hari . "' AND s_verifikasi = '-1'";
        $q_sum_menit = $this->db->query("SELECT sum(durasi) as total_menit,nip from v_aktivitas WHERE " . $where_q . " GROUP BY nip,LEFT(tgl_aktivitas,7)");

        if ($q_sum_menit->num_rows() > 0) :
          $menit_capaian = $q_sum_menit->row()->total_menit;
        endif;
      }



      //menit capaian dikurangi potongan menit karena mutasi dari luar
      $menit_capaian = $menit_capaian - $potongan_mutasi_menit_capaian;
      $list[$idx]["menit_capaian_elogbook"] = $menit_capaian;
      $list[$idx]["potongan_mutasi_menit_capaian"] = $potongan_mutasi_menit_capaian;
      $list[$idx]["max_menit_elogbook"] = $max_menit_logbook[$id_hari_kerja];
      $capaian = round((float) $menit_capaian * 100 / $max_menit_logbook[$id_hari_kerja], 2, PHP_ROUND_HALF_UP);
      $list[$idx]["capaian_elogbook"] = ($capaian > 100) ? 100 : round((float)$capaian, 2, PHP_ROUND_HALF_UP);
      //nilai tpp elogbook
      //PERWALI 2022
      $nilai_potongan_produktivitas = round((float)$tpp_elogbook * $list[$idx]["persen_potongan_produktivitas"] / 100, 0, PHP_ROUND_HALF_UP);
      $nilai_capaian = round((float)($list[$idx]["capaian_elogbook"] * ($tpp_elogbook - $nilai_potongan_produktivitas) / 100), 0, PHP_ROUND_HALF_DOWN);
      $list[$idx]["nilai_capaian"] = $nilai_capaian;

      //total penghasilan tpp
      $list[$idx]["total_penghasilan_tpp"] =  $nilai_capaian + $list[$idx]["penghasilan_tpp_disiplin"];
      $list[$idx]["menit_khusus"] =  json_encode($menit_khusus);
      $list[$idx]["hari_kerja"] =  json_encode($hari_kerja);

      //detail persentase tpp     
      $idx++;
    }
    $data["list"] = $list;
    return $data;
  }
}