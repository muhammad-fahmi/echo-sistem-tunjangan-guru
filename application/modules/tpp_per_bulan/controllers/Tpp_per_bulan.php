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
      'module' => "tpp_per_bulan",
      'view' => "vw_list_tpp_per_bulan",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  function gen_tabel_tpp()
  {
    $con["kode_ukerja"] = $this->input->post("kode_ukerja");
    $con["filter_bln"] = $this->input->post("filter_bln");
    $con["filter_thn"] = $this->input->post("filter_thn");
    //Perwali 2022 check apakah periode sudah implementasi perwali baru
    //$con["perwali22"]  = check_periode($con["filter_thn"], $con["filter_bln"]);
    $pegawai = $this->mpp->get_data_tpp($con);
    $tabel = "";
    $no = 1;
    foreach ($pegawai as $key => $value) {
      // store semua data yang ditampilkan menjadi 1 value untuk di pass ke modul laporan nantinya
      $ket_jab                  = $value["ket_jab"];
      $nama_lengkap             = $value["nama"];
      $nip                      = $value["nip"];
      $ket_gol                  = $value["ket_gol"];
      $ket_gol_pppk             = $value["ket_gol_pppk"];
      $kode_status              = $value["kode_status"];
      $besaran_tpp              = 'Rp. ' . konversi_counting($value["besaran_tpp"]);
      $tpp_disiplin_kerja       = 'Rp. ' . konversi_counting($value["tpp_disiplin_kerja"]);
      $total_potongan_disiplin  = 'Rp. ' . konversi_counting($value["total_potongan_disiplin"]);
      $penghasilan_tpp_disiplin = 'Rp. ' . konversi_counting($value["penghasilan_tpp_disiplin"]);
      $tpp_produktivitas        = 'Rp. ' . konversi_counting($value["tpp_produktivitas"]);
      $capaian_produktivitas    = $value["capaian_produktivitas"];
      //$capaian_elogbook       = $value["capaian_elogbook"] . ' % ' . '\ ' . $value["capaian_elogbook"] . ' \ ' . $value["max_menit_elogbook"] . '\ ' . $value["menit_capaian_elogbook"];
      $nilai_capaian            = 'Rp. ' . konversi_counting($value["nilai_capaian"]);
      $total_tpp_guru           = 'Rp. ' . konversi_counting($value["total_tpp_guru"]);
      //$status_tpp             = ($value["status_tpp"]) ? "Dibayarkan" : "Ditunda 1 Bulan";
      $display_gol              = ($kode_status < 3) ? $ket_gol : $ket_gol_pppk;
      switch ($kode_status) {
        case '1':
          $display_status = "CPNS";
          break;
        case '2':
          $display_status = "PNS";
          break;
        case '3':
          $display_status = "PPPK";
          break;        
        default:
          $display_status = "-";
          break;
      }

      // raw data sebelum di base 64
      $rawData = "$ket_jab//$nama_lengkap//$nip//$besaran_tpp//$tpp_disiplin_kerja//$total_potongan_disiplin//$penghasilan_tpp_disiplin//$tpp_produktivitas//$capaian_produktivitas//$nilai_capaian//$total_tpp_guru";

      // encoded data setelah di base 64
      $encData = base64_encode($rawData);
      /*
        for debugging
        <td align="right">' . $tpp_elogbook . ' ' . $value["hari_kerja"] . '</td>
        <td align="right">' . $capaian_elogbook . ' (' . $value["menit_capaian_elogbook"] . '/' . $value["max_menit_elogbook"] . ') menit_khusus : ' . $value["menit_khusus"] . '</td>
      */
      
        $tabel .= '
        <tr>
          <td>'.$no.'</td>
          <td>' . $ket_jab . '<br>Golongan : ( <b> '.$display_gol.' </b> )'. '<br>Status : ( <b> '.$display_status.' </b> )</td>
          <td>' . $nama_lengkap . '<br>'.$nip.'</td>
          <td>' . $besaran_tpp  .'</td>
          <td align="right">' . $tpp_disiplin_kerja. '</td>
          <td align="right">' . $total_potongan_disiplin . '</td>
          <td align="right">' . $penghasilan_tpp_disiplin . '</td>
          <td align="right">' . $tpp_produktivitas . '</td>
          <td align="right"><a href="#" title="(' . $value["jam_mengajar"] . '/' . $value["max_jam_mengajar"] . ')">' . $capaian_produktivitas . ' %</a></td>
          <td align="right">' . $nilai_capaian . '</td>
          <td align="right">' . $total_tpp_guru . '</td>
        </tr>
      ';
      $no++;
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

  public function cetak_list_tpp($unit_kerja, $bulan, $tahun){
    $unit_kerja = clean_string($unit_kerja);
    $bulan = clean_string($bulan);
    $tahun = clean_string($tahun);
    $nama_bulan = getBulan($bulan);

    $con["kode_ukerja"] = $unit_kerja;
    $con["filter_bln"] = $bulan;
    $con["filter_thn"] = $tahun;

    // echo "UNIT KERJA: $unit_kerja // bulan: $bulan // TAHUN: $tahun";
    // return;

    $start_date = '9999';
    $end_date = '9999';

    
    $cek_ukerja = $this->db->get_where('v_ukerja', ['kode_ukerja' => $unit_kerja]);
    if ($cek_ukerja->num_rows() < 1) {
      echo '<h4>ERROR: Unit Kerja tidak valid / belum di-set.</h4>';
      return;
    }

    $data_ukerja = $cek_ukerja->row_array();

    //get data pegawai
    $pegawai = $this->mpp->get_data_tpp($con);

    // create new PDF document
    $pdf = new Tcpdf_lib('L', PDF_UNIT, 'F4', true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor($data_ukerja['ket_ukerja']);
    $pdf->SetTitle('Laporan Tunjangan Produktifitas Guru Bulan '.$nama_bulan.' '.$tahun);
    $pdf->SetSubject('List TPP');
    $pdf->SetKeywords('TPP, Guru, example, test, guide');

    // $logo_samarinda = base_url("theme/assets/images/logo/logo_pemkot.png");
    $logo_path = FCPATH . 'theme\assets\images\logo\logo_pemkot.jpg';
    // set default header data
    $pdf->SetHeaderData($logo_path, 19, 'DINAS PENDIDIKAN DAN KEBUDAYAAN PEMERINTAH KOTA SAMARINDA', "$data_ukerja[ket_ukerja]\nTunjangan Produktifitas Guru bulan $nama_bulan Tahun $tahun");

    // set header and footer fonts
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('dejavusans', '', 8);

    // add a page
    $pdf->AddPage();

    // create some HTML content
    $html = '<h4>THIS IS JUST A TEST!</h4>';

    /// |----------------------------------------
    /// | DISINI BUAT FORMAT HTML
    /// |----------------------------------------

    // kalau mau bikin warna styling table bikin terpisah
    // misalkan style utk header
    $style_header = 'color:black; background-color:#d9d9d9; font-size:7px; text-align: center;';
    $style_content_1 =  "color:green; font-size: 7px; text-align: right;";
    $style_content_2 =  "color:black; font-size: 7px; text-align: justify;";
    $width_num =  "width: 30px";
    $border_thin = "border: 1px solid #999696;";
    $tebel = "font-weight: 700;";

    // untuk heading sama pembukaan tabel
    $html_table_open = '<table border="1" cellpadding="6">' .
      '<thead>' .
      '<tr>' .
        '<th rowspan="2" style="' . $style_header . $border_thin . $width_num . '">No</th>' .
        '<th rowspan="2" style="' . $style_header . $border_thin . '">JABATAN</th>' .
        '<th rowspan="2" style="' . $style_header . $border_thin . '">NAMA</th>' .
        '<th rowspan="2" style="' . $style_header . $border_thin . '">NIP</th>' .
        '<th rowspan="2" style="' . $style_header . $border_thin . '">GOL</th>' .
        '<th rowspan="2" style="' . $style_header . $border_thin . '">UNIT KERJA</th>' .
        '<th rowspan="2" style="' . $style_header . $border_thin . '">BESARAN TPP</th>' .
        '<th colspan="3" style="' . $style_header . $border_thin . '">TPP DISIPLIN KERJA</th>' .
        '<th colspan="3" style="' . $style_header . $border_thin . '">TPP PRODUKTIVITAS KERJA</th>' .
        '<th rowspan="2" style="' . $style_header . $border_thin . '">TOTAL TPP</th>' .
      '</tr>' .
      '<tr>'.
        '<th style="' . $style_header . $border_thin . '">BESARAN</th>' .
        '<th style="' . $style_header . $border_thin . '">POTONGAN</th>' .
        '<th style="' . $style_header . $border_thin . '">PENGHASILAN</th>' .
        '<th style="' . $style_header . $border_thin . '">BESARAN</th>' .
        '<th style="' . $style_header . $border_thin . '">CAPAIAN</th>' .
        '<th style="' . $style_header . $border_thin . '">PENGHASILAN</th>' .
      '</tr>'.
      '</thead>' .
      '<tbody>';

    $html_table_close = '</tbody>' .
      '</table>';
    $html_content = '';
    $total_besaran_full = 0;
    $total_tpp_disiplin = 0;
    $total_potongan_disiplin = 0;
    $total_perolehan_disiplin = 0;
    $total_tpp_produktivitas = 0;
    //$total_potongan_disiplin = 0;
    $total_perolehan_produktivitas = 0;
    $total_tpp = 0;
    $no = 1;
    // sebagai contoh pake for aja dulu ya karena datanya kosong
    foreach ($pegawai as $key => $value) {
      $besaran_tpp              = 'Rp. ' . konversi_counting($value["besaran_tpp"]);
      $tpp_disiplin_kerja       = 'Rp. ' . konversi_counting($value["tpp_disiplin_kerja"]);
      $potongan_disiplin        = 'Rp. ' . konversi_counting($value["total_potongan_disiplin"]);
      $penghasilan_tpp_disiplin = 'Rp. ' . konversi_counting($value["penghasilan_tpp_disiplin"]);
      $tpp_produktivitas        = 'Rp. ' . konversi_counting($value["tpp_produktivitas"]);
      $capaian_produktivitas    = $value["capaian_produktivitas"];
      //$capaian_elogbook       = $value["capaian_elogbook"] . ' % ' . '\ ' . $value["capaian_elogbook"] . ' \ ' . $value["max_menit_elogbook"] . '\ ' . $value["menit_capaian_elogbook"];
      $nilai_capaian            = 'Rp. ' . konversi_counting($value["nilai_capaian"]);
      $total_tpp_perorangan     = 'Rp. ' . konversi_counting($value["total_tpp_guru"]);
      $display_golongan = ($value["kode_status"] < 3) ? $value["ket_gol"] : $value["ket_gol_pppk"];
      $html_content .= '<tr>' .
        '<td style="' . $style_content_1 . $border_thin . $width_num . '">' . $no . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $value["ket_jab"] . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $value["nama"] . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $value["nip"] . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $display_golongan . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $value["ket_ukerja"] . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $besaran_tpp . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $tpp_disiplin_kerja . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $potongan_disiplin . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $penghasilan_tpp_disiplin . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $tpp_produktivitas . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $capaian_produktivitas . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $nilai_capaian . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $total_tpp_perorangan . '</td>' .
        '</tr>';
      
      $total_besaran_full += (float)$value["besaran_tpp"];
      $total_tpp_disiplin += (float)$value["tpp_disiplin_kerja"];
      //var_dump($value["total_potongan_disiplin"]);
      $total_potongan_disiplin += (float)$value["total_potongan_disiplin"];
      $total_perolehan_disiplin += (float)$value["penghasilan_tpp_disiplin"];
      $total_tpp_produktivitas += (float)$value["tpp_produktivitas"];
      $total_perolehan_produktivitas += (float)$value["nilai_capaian"];
      $total_tpp += (float)$value["total_tpp_guru"];
      $no++;
    }

    // Jumlah Final (Last Row)
    $html_content_2 = '<tr style="' . $style_header . '">' .
      '<td colspan="6" style="' . $border_thin . '">JUMLAH </td>' .
      '<td style="' . $border_thin . '">Rp. '.konversi_counting($total_besaran_full).'</td>' .
      '<td style="' . $border_thin . '">Rp. '.konversi_counting($total_tpp_disiplin).'</td>' .
      '<td style="' . $border_thin . '">Rp. '.konversi_counting($total_potongan_disiplin).'</td>' .
      '<td style="' . $border_thin . '">Rp. '.konversi_counting($total_perolehan_disiplin).'</td>' .
      '<td style="' . $border_thin . '">Rp. '.konversi_counting($total_tpp_produktivitas).'</td>' .
      '<td style="' . $border_thin . '"></td>' .
      '<td style="' . $border_thin . '">Rp. '.konversi_counting($total_perolehan_produktivitas).'</td>' .
      '<td style="' . $border_thin . '">Rp. '.konversi_counting($total_tpp).'</td>' .
      '</tr>';

    // jadikan satu semuanya
    $html_full_table = $html_table_open . $html_content . $html_content_2 . $html_table_close;

    // output the HTML content
    $pdf->writeHTML($html_full_table, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();

    //Close and output PDF document
    $pdf->Output('Daftar TPP Guru - $nama_bulan $tahun - $data_ukerja[ket_ukerja].pdf', 'I');
  }

  public function cetak_list_tpp_old($unit_kerja, $bulan, $tahun){
    $unit_kerja = clean_string($unit_kerja);
    $bulan = clean_string($bulan);
    $tahun = clean_string($tahun);

    // echo "UNIT KERJA: $unit_kerja // bulan: $bulan // TAHUN: $tahun";
    // return;

    $start_date = '9999';
    $end_date = '9999';

    switch ($bulan) {
      case '1': {
          $start_date = $tahun . '-01';
          $end_date = $tahun . '-03';
          break;
        }
      case '2': {
          $start_date = $tahun . '-04';
          $end_date = $tahun . '-06';
          break;
        }
      case '3': {
          $start_date = $tahun . '-07';
          $end_date = $tahun . '-09';
          break;
        }
      case '4': {
          $start_date = $tahun . '-10';
          $end_date = $tahun . '-12';
          break;
        }

      default:
        echo '<h4>ERROR: bulan tidak valid / belum di-set.</h4>';
        return;
        break;
    }

    $cek_ukerja = $this->db->get_where('v_ukerja', ['kode_ukerja' => $unit_kerja]);
    if ($cek_ukerja->num_rows() < 1) {
      echo '<h4>ERROR: Unit Kerja tidak valid / belum di-set.</h4>';
      return;
    }

    $data_ukerja = $cek_ukerja->row_array();

    // create new PDF document
    $pdf = new Tcpdf_lib('L', PDF_UNIT, 'F4', true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor($data_ukerja['ket_ukerja']);
    $pdf->SetTitle('Laporan Tunjangan Produktifitas Guru Bulan ');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // $logo_samarinda = base_url("theme/assets/images/logo/logo_pemkot.png");
    $logo_path = FCPATH . 'theme\assets\images\logo\logo_pemkot.jpg';
    // set default header data
    $pdf->SetHeaderData($logo_path, 19, 'DINAS PENDIDIKAN DAN KEBUDAYAAN PEMERINTAH KOTA SAMARINDA', "$data_ukerja[ket_ukerja]\nTunjangan Produktifitas Guru bulan IV Tahun 2023");

    // set header and footer fonts
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // ---------------------------------------------------------

    // set font
    $pdf->SetFont('dejavusans', '', 8);

    // add a page
    $pdf->AddPage();

    // create some HTML content
    $html = '<h4>THIS IS JUST A TEST!</h4>';

    /// |----------------------------------------
    /// | DISINI BUAT FORMAT HTML
    /// |----------------------------------------

    // kalau mau bikin warna styling table bikin terpisah
    // misalkan style utk header
    $style_header = 'color:black; background-color:#d9d9d9; font-size:9px; text-align: center;';
    $style_content_1 =  "color:green; font-size: 7px; text-align: right;";
    $style_content_2 =  "color:black; font-size: 7px; text-align: justify;";
    $width_num =  "width: 30px";
    $border_thin = "border: 1px solid #999696;";
    $tebel = "font-weight: 700;";

    // untuk heading sama pembukaan tabel
    $html_table_open = '<table border="1" cellpadding="6">' .
      '<thead>' .
      '<tr>' .
      '<th style="' . $style_header . $border_thin . $width_num . '">No</th>' .
      '<th style="' . $style_header . $border_thin . '">NAMA</th>' .
      '<th style="' . $style_header . $border_thin . '">NIP</th>' .
      '<th style="' . $style_header . $border_thin . '">GOL</th>' .
      '<th style="' . $style_header . $border_thin . '">UNIT KERJA</th>' .
      '<th style="' . $style_header . $border_thin . '">INSENTIF</th>' .
      '<th style="' . $style_header . $border_thin . '">JUMLAH BULAN</th>' .
      '<th style="' . $style_header . $border_thin . '">JUMLAH KOTOR</th>' .
      '<th style="' . $style_header . $border_thin . '">JUMLAH PPh 5%</th>' .
      '<th style="' . $style_header . $border_thin . '">JUMLAH PPh 15%</th>' .
      '<th style="' . $style_header . $border_thin . '">JUMLAH INFAQ 2,5%</th>' .
      '<th style="' . $style_header . $border_thin . '">JUMLAH BERSIH</th>' .
      '<th style="' . $style_header . $border_thin . '">NO REKENING</th>' .
      '<th style="' . $style_header . $border_thin . '">NIK</th>' .
      '<th style="' . $style_header . $border_thin . '">NPWP</th>' .
      '</tr>' .
      '</thead>' .
      '<tbody>';

    $html_table_close = '</tbody>' .
      '</table>';
    $html_content = '';

    // sebagai contoh pake for aja dulu ya karena datanya kosong
    for ($i = 0; $i < 10; $i++) {
      $no = $i + 1;
      $randomText = strtoupper(md5($i . rand(1000, 9999)));
      $content2 = substr($randomText, 2, 8);
      $content3 = substr($randomText, 4, 10);
      $content4 = substr($randomText, 6, 12);
      $content5 = substr($randomText, 8, 14);

      $html_content .= '<tr>' .
        '<td style="' . $style_content_1 . $border_thin . $width_num . '">' . $no . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $content2 . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $content3 . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $content4 . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $content5 . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $content5 . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $content5 . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $content5 . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $content5 . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $content5 . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $content5 . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $content5 . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $content5 . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $content5 . '</td>' .
        '<td style="' . $style_content_2 . $border_thin . '">' . $content5 . '</td>' .
        '</tr>';
    }

    // Jumlah Final (Last Row)
    $html_content_2 = '<tr style="' . $style_header . '">' .
      '<td colspan="5" style="' . $border_thin . '">JUMLAH </td>' .
      '<td style="' . $border_thin . '"> </td>' .
      '<td style="' . $border_thin . '"> </td>' .
      '<td style="' . $border_thin . '"> </td>' .
      '<td style="' . $border_thin . '"> </td>' .
      '<td style="' . $border_thin . '"> </td>' .
      '<td style="' . $border_thin . '"> </td>' .
      '<td style="' . $border_thin . '"> </td>' .
      '<td style="' . $border_thin . '"> </td>' .
      '<td style="' . $border_thin . '"> </td>' .
      '<td style="' . $border_thin . '"> </td>' .
      '</tr>';

    // jadikan satu semuanya
    $html_full_table = $html_table_open . $html_content . $html_content_2 . $html_table_close;

    // output the HTML content
    $pdf->writeHTML($html_full_table, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();

    //Close and output PDF document
    $pdf->Output('laporan_tunjangan_produktifitas_guru - .pdf', 'I');
  }
}
