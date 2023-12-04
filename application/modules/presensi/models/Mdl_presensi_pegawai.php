<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_presensi_pegawai extends CI_Model
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

  /* fungsi untuk menarik data dari DB dan konversi ke dataset untuk jquery datatable */
  public function get_datatable_old($table, $data, $primary_key = 'id')
  {
    // lakukan filtering data
    // deklarasi where condition
    $where_search = (isset_nn_nes($data['search']))
      ? "WHERE (nama_lengkap LIKE '%$data[search]%' 
      OR mapel LIKE '%$data[search]%'
      OR nip LIKE '$data[search]%')"
      : "";

    /* kalau ada tambahan where condition bisa add lagi di atas */
    // deklarasi query yang digunakan
    $query_result = $this->db->query("SELECT * FROM v_progurinda_data_presensi
      $where_search
      ORDER BY $data[order_column] $data[order_sort]
      LIMIT $data[start], $data[length]");
    $query_total = $this->db->query("SELECT * FROM v_progurinda_data_presensi 
      $where_search");
    // cari total hasil
    $total_count = $query_total->num_rows();
    // cari data result + penomoran
    $no = $data['start'] + 1;
    $index = 0;
    $data_result = array();
    while ($row = $query_result->unbuffered_row('array')) {
      /// |----------------------------------------------------------------------
      /// | PENATAAN DATA SEBELUM DIMASUKKAN KE DALAM RESULT_ARRAY
      /// |----------------------------------------------------------------------
      $data_result[$index] = $row;
      $data_result[$index]['no'] = $no;
      $data_result[$index]['nip'] = isset_nn_nes($row['nip'], '-');
      $data_result[$index]['nama_lengkap'] = isset_nn_nes($row['nama_lengkap'], '-');
      $data_result[$index]['ket_jab'] = isset_nn_nes($row['ket_jab'], '-');
      $data_result[$index]['ket_ukerja'] = isset_nn_nes($row['ket_ukerja'], '-');
      $data_result[$index]['mapel'] = isset_nn_nes($row['mapel'], '-');
      $data_result[$index]['id'] = to_rp(isset_nn_nes($row['id'], '-'), false);
      $no += 1;
      $index += 1;
    }
    // kembalikan data yang didapat ke controller
    return array(
      'total' => $total_count,
      'filtered' => $total_count,
      'data' => $data_result,
      'draw' => $data['draw']
    );
  }

  /**Fungsi untuk generate datatable presensi pegawai */

  public function get_data_presensi($param)
  {
    $where_q = "kode_instansi = '" . $param["kode_ukerja"] . "'";
    $index = $this->input->post("order[0][column]");
    $dir = $this->input->post("order[0][dir]");
    //sorting data pegawai
    $order_by = " ORDER BY pns.kode_eselon,pns.kode_ukerja asc,pns.kode_jab asc, " . $index . " " . $dir;
    $limit = "";
    if ($param["length"] != "-1") {
      $limit = " LIMIT " . $param["start"] . "," . $param['length'];
    }

    if ($param["search"] != "") {
      $where_q .= " AND (pns.nama_lengkap LIKE \"%" . $param["search"] . "%\" OR pns.nip LIKE \"%" . $param["search"] . "%\")";
      /* $this->db->like("nama_lengkap", $search, "both");
      $this->db->or_like("nip", $search, "both"); */
    }

    $filter_guru = 'UPPER(LEFT(r_jab.ket_jab, 4)) = "GURU" OR r_jab.ket_jab LIKE "% GURU%" OR r_jab.ket_jab LIKE "%GURU %" OR LEFT(r_jab.ket_jab, 16) = "PENGAWAS SEKOLAH" OR LEFT(r_jab.ket_jab,8) = "PENGAWAS" ';
    $query = "SELECT 
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
        
        r_presensi.tahun, 
        r_presensi.bulan, 
        IFNULL(rekap_potongan_tpp.persen,0) AS persen_potongan_tpp,
        IFNULL(r_presensi.terlambat,0) AS  terlambat,
        IFNULL(r_presensi.pulang_cepat,0) AS pulang_cepat, 
        IFNULL(r_presensi.tidak_masuk,0) AS tidak_masuk, 
        IFNULL(r_presensi.tidak_apel,0) AS tidak_apel, 
        IFNULL(r_presensi.lupa_absen,0) AS lupa_absen, 
        IFNULL(r_presensi.potongan_persen,0) AS potongan_persen, 
        IFNULL(r_presensi.id,0) AS id
      FROM
        (
          SELECT * FROM
          progurinda_r_data_presensi
          WHERE tahun = " . $param["filter_thn"] . " AND bulan = " . (int)$param["filter_bln"] . "
        ) as r_presensi
      Right JOIN
        (  SELECT
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
        m_ukerja.kode_instansi        
      FROM
        (
      SELECT
        mp.nip,
        mp.nama_lengkap,
        mp.tgl_lahir,
        mp.tgl_pensiun,
        mp.tgl_keluar,
        mp.s_aktif,
        f_get_jab_per_period ( mp.nip, '" . $param["filter_thn"] . "-" . $param["filter_bln"] . "-02' ) AS nomor_jab 
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
        (".$filter_guru."
        AND (LEFT ( m_ukerja.unit_kepeg, 8 ) = '" . $param["kode_ukerja"] . "' OR m_ukerja.kode_instansi = '" . $param["kode_ukerja"] . "') 
        AND (m_pegawai.tgl_keluar is null OR (m_pegawai.tgl_keluar > '" . $param["filter_thn"] . "-" . $param["filter_bln"] . "-01' OR m_pegawai.s_aktif = \"-1\")))
      GROUP BY
        m_pegawai.nip 
        ) AS mp 
      WHERE
        mp.tgl_pensiun > '" . $param["filter_thn"] . "-" . $param["filter_bln"] . "-01' 
        ) AS list_peg
        JOIN r_jab ON list_peg.nomor_jab = r_jab.nomor 
        AND list_peg.nip = r_jab.nip
        JOIN m_jab ON r_jab.kode_jab = m_jab.kode_jab 
        AND r_jab.kode_ukerja = m_jab.kode_ukerja
        LEFT JOIN config_kelas_jab ON m_jab.kode_kelas_jab = config_kelas_jab.kode_kelas_jab
        JOIN m_ukerja ON r_jab.kode_ukerja = m_ukerja.kode_ukerja
      WHERE (".$filter_guru."
        AND (LEFT ( m_ukerja.unit_kepeg, 8 ) = '" . $param["kode_ukerja"] . "' OR m_ukerja.kode_instansi = '" . $param["kode_ukerja"] . "'))
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
      WHERE (
      '" . $param["filter_thn"] . "-" . $param["filter_bln"] . "-01' BETWEEN DATE( CONCAT( thn_mulai, '-', bln_mulai, '-01' ) ) 
      AND DATE( CONCAT( thn_selesai, '-', bln_selesai, '-01' ) ) ) OR ( DATE( CONCAT( thn_mulai, '-', bln_mulai, '-01' )) <= '" . $param["filter_thn"] . "-" . $param["filter_bln"] . "-01' AND thn_selesai is NULL)
      GROUP BY
      nip) AS rekap_potongan_tpp ON pns.nip = rekap_potongan_tpp.nip

      WHERE " . $where_q;
    // $table = "v_data_presensi";
    // $this->get_table($_TAG,$con,$search);
    $data["jml"] = $this->db->query($query)->num_rows();
    //$filter = $this->get_filter();
    //$this->db->where($where_q);
    $list = $this->db->query($query . $order_by . $limit)->result_array();
    $idx = 0;
    
    //get persentase tpp disiplin kerja
    $persentase_disiplin = dlookup("persen_kehadiran", "config_besaran_ttp", "id = 1");
    //cari persen potongan untuk tidak apel dan lupa/tidak absen
    $persentase_potongan_disiplin = $this->db->get("config_potongan_hukdis")->row_array();
    $ket_bln = (strlen($param["filter_bln"]) == 1) ? "0" . $param["filter_bln"] : $param["filter_bln"];

    foreach ($list as $r) {
      //get nominal tpp pegawai
      //$besaran_tpp_murni = $this->db->where("nip = '" . $r["nip"] . "' AND kode_ukerja = '" . $r["kode_ukerja"] . "' AND kode_jab = '" . $r["kode_jab"] . "'")->get("v_daftar_budgeting_tpp_pns")->row_array();
      $list[$idx]["besaran_tpp_murni"] = $r["total_tpp"];
      //cek potongan cuti 
      $q_check_cuti = $this->db->where("nip = '" . $list[$idx]["nip"] . "' 
      AND (LEFT(v_cuti.tgl_mulai,7) <= \"" . $param["filter_thn"] . "-" . $ket_bln . "\" AND LEFT(v_cuti.tgl_selesai,7) >= \"" . $param["filter_thn"] . "-" . $ket_bln . "-07\")
      AND jml_hari_cuti >= 30")->get("v_cuti");
      if ($q_check_cuti->num_rows() > 0) {
        //jika ada cuti yang sedang aktif dan jumlah cuti >= 30 hari
        $data_cuti = $q_check_cuti->row_array();
        $berlaku = false;
        $sisa_jml_hari = $data_cuti["jml_hari_cuti"];
        $bulan_berjalan = $param["filter_thn"] . "-" . $ket_bln;
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
          $list[$idx]["persen_potongan_tpp"] += 20;
        }
      }
      //cari potongan dari daftar potongan tpp
      $potongan_tpp_persen = ($list[$idx]["persen_potongan_tpp"] > 100) ? 100 : $list[$idx]["persen_potongan_tpp"];

      //rekap pada rentang waktu tersebut dari r_potongan berdasarkan nip

      //cek nilai tpp disiplin kerja pegawai
      $id_hari_kerja = ($r["id_hari_kerja"] == null) ? 1 : $r["id_hari_kerja"];
      $list[$idx]["id_hari_kerja"] = $id_hari_kerja;
      //potongan per menit pegawai
      $list[$idx]["no"] = $param["start"] + $idx + 1;
      //$list[$idx]["total_potongan"] = $r["terlambat"] + $r["pulang_cepat"] + $r["tidak_masuk"];
      //nilai potongan lupa absen
      //$list[$idx]["potongan_lupa_absen"] = round((float)($r["lupa_absen"] * $persentase_potongan_disiplin["persen_potongan_lupa"] * $tpp_disiplin_kerja / 100), 0, PHP_ROUND_HALF_UP);
      //nilai potongan tidak apel
      //$list[$idx]["potongan_tidak_apel"] = round((float)(($tpp_disiplin_kerja - $list[$idx]["potongan_terlambat"] - $list[$idx]["potongan_pulang_cepat"] - $list[$idx]["potongan_tidak_masuk"] - $list[$idx]["potongan_lupa_absen"]) * ($r["tidak_apel"] * $persentase_potongan_disiplin["persen_potongan_tidak_apel"] / 100)), 0, PHP_ROUND_HALF_UP);
      //$list[$idx]["potongan_tidak_apel"] = ($list[$idx]["potongan_tidak_apel"] < 0) ? 0 : $list[$idx]["potongan_tidak_apel"];

      // buat base64key untuk checkbox data
      // $raw_value = "$r[ket_jab]//" .
      //   "$r[nama_lengkap]//" .
      //   "$r[nip]//" .
      //   "$r[terlambat]\n(Rp. " . $list[$idx]['potongan_terlambat'] . ")//" .
      //   "$r[pulang_cepat]\n(Rp. " . $list[$idx]['potongan_pulang_cepat'] . ")//" .
      //   "$r[tidak_masuk]\n(Rp. " . $list[$idx]['potongan_tidak_masuk'] . ")//" .
      //   $list[$idx]['total_potongan'] . "\n(Rp. " . $list[$idx]['total_nilai_potongan'] . ")//" .
      //   "$r[tidak_apel]\n(Rp. " . $list[$idx]['potongan_tidak_apel'] . ")//" .
      //   "$r[lupa_absen]\n(Rp. " . $list[$idx]['potongan_lupa_absen'] . ")";
      // $enc_value = base64_encode($raw_value);
      //$list[$idx]['datakey'] = $enc_value;

      // tambah indexing nya
      $idx++;
    }
    $data["list"] = $list;
    return $data;
  }
}