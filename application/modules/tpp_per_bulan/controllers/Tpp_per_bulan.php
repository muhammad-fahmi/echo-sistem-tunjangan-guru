<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tpp_per_bulan extends MY_Controller
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
      $this->load->model('mdl_tpp_per_bulan', 'mpp');
    }
  }

  public function index()
  {
    // lakukan proses init halaman
    $bulan_now = date('n');
    $tahun_now = date('Y');
    if ($bulan_filter == 1) {
      $sent_data = array(
        "bln_filter" => 12,
        "thn_filter" => (int)$tahun_now - 1
      );
    } else {
      $sent_data = array(
        "bln_filter" => (int)$bulan_now - 1,
        "thn_filter" => (int)$tahun_now
      );
    }

    $data = array(
      'page_title' => "List TPP Per Bulan",
      'module' => "pp_per_bulan",
      'view' => "vw_list_tpp_per_bulan",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  function gen_tabel_ttp()
  {
    $con["kode_ukerja"] = $this->input->post("kode_ukerja");
    $con["filter_bln"] = $this->input->post("filter_bln");
    $con["filter_thn"] = $this->input->post("filter_thn");
    //Perwali 2022 check apakah periode sudah implementasi perwali baru
    $con["perwali22"]  = check_periode($con["filter_thn"], $con["filter_bln"]);
    $pegawai = $this->mdl_ttp->get_data_tpp($con);
    $tabel = "";
    foreach ($pegawai["list"] as $key => $value) {
      // store semua data yang ditampilkan menjadi 1 value untuk di pass ke modul laporan nantinya
      $ket_jab                  = $value["ket_jab"];
      $nama_lengkap             = $value["nama_lengkap"];
      $nip                      = $value["nip"];
      $besaran_tpp              = 'Rp. ' . konversi_counting($value["besaran_tpp"]);
      $tpp_disiplin_kerja       = 'Rp. ' . konversi_counting($value["tpp_disiplin_kerja"]);
      $total_potongan_disiplin  = 'Rp. ' . konversi_counting($value["total_potongan_disiplin"]);
      $penghasilan_tpp_disiplin = 'Rp. ' . konversi_counting($value["penghasilan_tpp_disiplin"]);
      $tpp_elogbook             = 'Rp. ' . konversi_counting($value["tpp_elogbook"]);
      $capaian_elogbook         = $value["capaian_elogbook"] . ' %';
      //$capaian_elogbook         = $value["capaian_elogbook"] . ' % ' . '\ ' . $value["capaian_elogbook"] . ' \ ' . $value["max_menit_elogbook"] . '\ ' . $value["menit_capaian_elogbook"];
      $nilai_capaian            = 'Rp. ' . konversi_counting($value["nilai_capaian"]);
      $total_penghasilan_tpp    = 'Rp. ' . konversi_counting($value["total_penghasilan_tpp"]);
      $status_tpp               = ($value["status_tpp"]) ? "Dibayarkan" : "Ditunda 1 Bulan";
      $total_persen_tpp         = $value["total_persen_tpp"];
      $persen_beban_kerja       = $value["persen_beban_kerja"];
      $prestasi_kerja           = $value["prestasi_kerja"];
      $prestasi_kerja_nominal   = $value["prestasi_kerja_nominal"];
      $kondisi_kerja            = $value["kondisi_kerja"];
      $kelangkaan_profesi       = $value["kelangkaan_profesi"];
      $penilaian_obyektif       = $value["penilaian_obyektif"];

      // raw data sebelum di base 64
      $rawData = "$ket_jab//$nama_lengkap//$nip//$besaran_tpp//$tpp_disiplin_kerja//$total_potongan_disiplin//$penghasilan_tpp_disiplin//$tpp_elogbook//$capaian_elogbook//$nilai_capaian//$total_penghasilan_tpp//$total_persen_tpp//$persen_beban_kerja//$kondisi_kerja//$kelangkaan_profesi//$value[total_penghasilan_tpp]";

      // encoded data setelah di base 64
      $encData = base64_encode($rawData);
      /*
        for debugging
        <td align="right">' . $tpp_elogbook . ' ' . $value["hari_kerja"] . '</td>
        <td align="right">' . $capaian_elogbook . ' (' . $value["menit_capaian_elogbook"] . '/' . $value["max_menit_elogbook"] . ') menit_khusus : ' . $value["menit_khusus"] . '</td>
      */
      if ($con["perwali22"]) {
        $tabel .= '
        <tr>
          <td><input type="checkbox" class="cetakCheckBox" attr-enc="' . $encData . '"></td>
          <td>' . $ket_jab . '</td>
          <td>' . $nama_lengkap . '</td>
          <td>' . $nip . '</td>
          <td align="right">' . $besaran_tpp . '</td>
          <td align="right">' . $tpp_disiplin_kerja . '</td>
          <td align="right">' . $total_potongan_disiplin . '</td>
          <td align="right">' . $penghasilan_tpp_disiplin . '</td>
          <td align="right">' . $tpp_elogbook . '</td>
          <td align="right"><a href="#" title="(' . $value["menit_capaian_elogbook"] . '/' . $value["max_menit_elogbook"] . ')">' . $capaian_elogbook . ' </a><input type="hidden" name="potongan_mutasi_menit_capaian" value="' . $value["potongan_mutasi_menit_capaian"] . '"/></td>
          <td align="right">' . $nilai_capaian . '</td>
          <td align="right">' . $total_penghasilan_tpp . '</td>
          
        </tr>
      ';
      } else {
        $tabel .= '
        <tr>
          <td><input type="checkbox" class="cetakCheckBox" attr-enc="' . $encData . '"></td>
          <td>' . $ket_jab . '</td>
          <td>' . $nama_lengkap . '</td>
          <td>' . $nip . '</td>
          <td align="right">' . $besaran_tpp . '</td>
          <td align="right">' . $tpp_disiplin_kerja . '</td>
          <td align="right">' . $total_potongan_disiplin . '<input type="hidden" name="menit_tidak_masuk" value="' . $value["menit_tidak_masuk"] . '"/><input type="hidden" name="potongan_per_menit" value="' . $value["potongan_per_menit"] . '"/> </td>
          <td align="right">' . $penghasilan_tpp_disiplin . '</td>
          <td align="right">' . $tpp_elogbook . '</td>
          <td align="right"><a href="#" title="(' . $value["menit_capaian_elogbook"] . '/' . $value["max_menit_elogbook"] . ')">' . $capaian_elogbook . ' </a><input type="hidden" name="potongan_mutasi_menit_capaian" value="' . $value["potongan_mutasi_menit_capaian"] . '"/></td>
          <td align="right">' . $nilai_capaian . '</td>
          <td align="right">' . $total_penghasilan_tpp . '</td>
          
        </tr>
      ';
      }
    }

    echo $tabel;
  }

  function hitung_ttp()
  {
  }

  function cek_finalisasi()
  {
    $kode_ukerja = $this->input->post("kode_ukerja");
    $tahun = $this->input->post("filter_thn");
    $bulan = $this->input->post("filter_bln");
    //cek arsip ttp
    $q_check_arsip = $this->db->where("kode_ukerja = '" . $kode_ukerja . "' AND tahun = '" . $tahun . "' AND bulan ='" . $bulan . "'")->get("r_arsip_tpp");
    if ($q_check_arsip->num_rows() > 0) {
      $data_arsip = $q_check_arsip->row_array();
      $res["success"] = true;
      $res["message"] = "Laporan TPP sudah difinalisasi pada tanggal <b>" . tglFormat($data_arsip["tgl_arsip"], "d M yyyy T") . "</b>";
    } else {
      $res["success"] = false;
      $res["message"] = "Laporan TPP <b>BELUM</b> difinalkan!";
    }
    $this->return_json($res);
  }
}
