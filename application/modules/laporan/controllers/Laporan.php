<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . "third_party/TCPDF/tcpdf.php";
class Laporan extends MY_Controller
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
      $this->load->model('mdl_laporan', 'mlp');
    }
  }

  public function tpp_3_bln()
  {
    // lakukan proses init halaman
    $sent_data = array();
    $data = array(
      'page_title' => "TPP 3 Bulan",
      'module' => "laporan",
      'view' => "vw_tpp_3_bulan",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  public function jurnal_bulanan()
  {
    // lakukan proses init halaman
    $sent_data = array();
    $data = array(
      'page_title' => "Jurnal Bulanan",
      'module' => "laporan",
      'view' => "vw_jurnal_bulanan",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  public function datalist()
  {
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
      /* additional data can be declared here */
    );
    // move the db operation to the designated models
    $result = $this->mlp->get_datatable('progurinda_r_jurnal_mengajar', $param);
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

  public function tpp_3_bln_datalist()
  {
    $dummy_data = array(
      [
        "nip" => "196805151990102004",
        "nama" => "ERNI SUHARTINI",
        "ket_gol" => "IV/b",
        "kode_gol" => "42",
        "ket_jab" => "Guru Madya /Kepala Sekolah",
        "kode_jab" => "",
        "kode_ukerja" => "",
        "ket_ukerja" => "SD N 016 Samarinda Seberang",
        "tpp_per_bln" => "1.000.000",
        "jumlah_bln" => 3,
        "jumlah_kotor" => "3.000.000",
        "pph5" => 0,
        "pph15" => "450.000",
        "infaq" => "63.750",
        "jumlah_bersih" => "2.486.750",
        "no_rekening" => "1252213925",
        "nik" => "",
        "npwp" => "79.064.892.7-722.001"
      ],
      [
        "nip" => "197204192014082002",
        "nama" => "HUSNIATI",
        "ket_gol" => "III/b",
        "kode_gol" => "32",
        "ket_jab" => "Guru Pertama",
        "kode_jab" => "",
        "kode_ukerja" => "",
        "ket_ukerja" => "SD N 016 Samarinda Seberang",
        "tpp_per_bln" => "850.000",
        "jumlah_bln" => 3,
        "jumlah_kotor" => "2.550.000",
        "pph5" => 0,
        "pph15" => "127.500",
        "infaq" => "60.563",
        "jumlah_bersih" => "2.361.937",
        "no_rekening" => "1253333925",
        "nik" => "",
        "npwp" => "77.146.776.8-722.001"
      ],
    );
    $data["recordsTotal"] = 12;
    $data["recordsFiltered"] = 12;
    $data["data"] = $dummy_data;
    $data["draw"] = 1;
    // using common_helper function
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  public function generate_pdf_jurnal_bulanan($array_of_data = false)
  {
    // create new PDF document
    $pdf = new Tcpdf_lib('L', PDF_UNIT, 'F4', true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('SD N 016 SAMARINDA SEBERANG');
    $pdf->SetTitle('Laporan Tunjangan Produktifitas Guru Triwulan');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // $logo_samarinda = base_url("theme/assets/images/logo/logo_pemkot.png");
    $logo_path = FCPATH . 'theme\assets\images\logo\logo_pemkot.jpg';
    // set default header data
    $pdf->SetHeaderData($logo_path, 19, 'DINAS PENDIDIKAN DAN KEBUDAYAAN PEMERINTAH KOTA SAMARINDA', "SD NEGERI 016 SAMARINDA\nTunjangan Produktifitas Guru Triwulan IV Tahun 2023");

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

    //dummy data
    $data_dummy = array(
      [
        "nama" => "ERNI SUHARTINI,S.Pd.SD",
        "nip" => "196805151990102004",
        "ket_jab" => "Guru Madya /Kepala Sekolah",
        "ket_ukerja" => "SD N 016 Samarinda Seberang",
        "ket_gol" => "IV/a",
        "insentif" => "1.000.000",
        "jumlah_bulan" => 3,
        "jumlah_kotor" => "3.000.000",
        "jumlah_pph_5" => "0",
        "jumlah_pph_15" => "450.000",
        "jumlah_infaq" => "63.750",
        "jumlah_bersih" => "2.486.250",
        "no_rekening" => "",
        "nik" => "",
        "npwp" => ""
      ],
      [
        "nama" => "M ABIDINSYAH",
        "nip" => "196503091992031011",
        "ket_jab" => "Guru Madya",
        "ket_ukerja" => "SD N 016 Samarinda Seberang",
        "ket_gol" => "IV/a",
        "insentif" => "1.000.000",
        "jumlah_bulan" => 3,
        "jumlah_kotor" => "3.000.000",
        "jumlah_pph_5" => "0",
        "jumlah_pph_15" => "450.000",
        "jumlah_infaq" => "63.750",
        "jumlah_bersih" => "2.486.250",
        "no_rekening" => "",
        "nik" => "",
        "npwp" => ""
      ], [
        "nama" => "	Hj. ALIANTI MALLU, A.Md.Pd",
        "nip" => "196507141988042004",
        "ket_jab" => "Guru Madya",
        "ket_ukerja" => "SD N 016 Samarinda Seberang",
        "ket_gol" => "IV/b",
        "insentif" => "1.000.000",
        "jumlah_bulan" => 3,
        "jumlah_kotor" => "3.000.000",
        "jumlah_pph_5" => "0",
        "jumlah_pph_15" => "450.000",
        "jumlah_infaq" => "63.750",
        "jumlah_bersih" => "2.486.250",
        "no_rekening" => "",
        "nik" => "",
        "npwp" => ""
      ], [
        "nama" => "KRISMI PUJIASTUTI, S.Pd,",
        "nip" => "196805182008012017",
        "ket_jab" => "Guru Pertama",
        "ket_ukerja" => "SD N 016 Samarinda Seberang",
        "ket_gol" => "III/b",
        "insentif" => "850.000",
        "jumlah_bulan" => 3,
        "jumlah_kotor" => "2.550.000",
        "jumlah_pph_5" => "127.500",
        "jumlah_pph_15" => "0",
        "jumlah_infaq" => "60.563",
        "jumlah_bersih" => "2.361.937",
        "no_rekening" => "",
        "nik" => "",
        "npwp" => ""
      ], [
        "nama" => "NURHAYATI",
        "nip" => "196808202007012026",
        "ket_jab" => "Guru",
        "ket_ukerja" => "SD N 016 Samarinda Seberang",
        "ket_gol" => "II/d",
        "insentif" => "800.000",
        "jumlah_bulan" => 3,
        "jumlah_kotor" => "2.400.000",
        "jumlah_pph_5" => "0",
        "jumlah_pph_15" => "0",
        "jumlah_infaq" => "60.000",
        "jumlah_bersih" => "2.340.000",
        "no_rekening" => "",
        "nik" => "",
        "npwp" => ""
      ],
    );

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
    $pdf->Output('laporan_tunjangan_produktifitas_guru_triwulan_IV_2023.pdf', 'I');
  }

  public function cetak_ttp_3_bln($unit_kerja, $triwulan, $tahun)
  {
    $unit_kerja = clean_string($unit_kerja);
    $triwulan = clean_string($triwulan);
    $tahun = clean_string($tahun);

    // echo "UNIT KERJA: $unit_kerja // TRIWULAN: $triwulan // TAHUN: $tahun";
    // return;

    $start_date = '9999';
    $end_date = '9999';
    $triwulanTitle = 'I';

    switch ($triwulan) {
      case '1': {
          $start_date = $tahun . '-01';
          $end_date = $tahun . '-03';
          $triwulanTitle = 'I';
          break;
        }
      case '2': {
          $start_date = $tahun . '-04';
          $end_date = $tahun . '-06';
          $triwulanTitle = 'II';
          break;
        }
      case '3': {
          $start_date = $tahun . '-07';
          $end_date = $tahun . '-09';
          $triwulanTitle = 'III';
          break;
        }
      case '4': {
          $start_date = $tahun . '-10';
          $end_date = $tahun . '-12';
          $triwulanTitle = 'IV';
          break;
        }

      default:
        echo '<h4>ERROR: Triwulan tidak valid / belum di-set.</h4>';
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
    $pdf->SetTitle('Laporan Tunjangan Produktifitas Guru Triwulan');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // $logo_samarinda = base_url("theme/assets/images/logo/logo_pemkot.png");
    $logo_path = FCPATH . 'theme\assets\images\logo\logo_pemkot.jpg';
    // set default header data
    $pdf->SetHeaderData($logo_path, 19, 'DINAS PENDIDIKAN DAN KEBUDAYAAN PEMERINTAH KOTA SAMARINDA', "$data_ukerja[ket_ukerja]\nTunjangan Produktifitas Guru Triwulan IV Tahun 2023");

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
    $style_header = 'color: black; background-color: #d9d9d9; font-size: 9px; text-align: center;';

    $style_content_1 =  "color: green; font-size: 7px; text-align: right;";
    $style_content_2 =  "color: black; font-size: 7px; text-align: justify;";
    $style_content_3 =  "color: black; font-size: 7px; text-align: left;";
    $style_content_4 =  "color: black; font-size: 7px; text-align: right;";

    $w50 = "width: 50px;";
    $w75 = "width: 75px;";
    $w100 = "width: 100px;";
    $w125 = "width: 125px;";
    $w150 = "width: 150px;";
    $w175 = "width: 175px;";
    $w200 = "width: 200px;";
    $w225 = "width: 225px;";
    $w250 = "width: 250px;";
    $w275 = "width: 275px;";
    $w300 = "width: 300px;";
    $w325 = "width: 325px;";
    $w350 = "width: 350px;";
    $w375 = "width: 375px;";
    $w400 = "width: 400px;";

    $width_num =  "width: 30px";
    $border_thin = "border: 1px solid #999696;";
    $tebel = "font-weight: bold;";

    /// |----------------------------------------
    /// | #1ST TABLE OPENER
    /// |----------------------------------------
    // untuk heading sama pembukaan tabel
    $html_table_open = '<table border="1" cellpadding="6">' .
      '<thead>' .
      '<tr>' .
      '<th style="' . $style_header . $tebel . $border_thin . $width_num . '">No.</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . '">NAMA</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . '">NIP</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . '">GOL</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . '">UNIT KERJA</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . '">(TPP) 1 BULAN</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . '">JUMLAH BULAN</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . '">JUMLAH KOTOR</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . '">JUMLAH PPh 5%</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . '">JUMLAH PPh 15%</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . '">JUMLAH INFAQ 2,5%</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . '">JUMLAH BERSIH</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . '">NO. REKENING</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . '">NIK</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . '">NPWP</th>' .
      '</tr>' .
      '</thead>' .
      '<tbody>';

    /// |----------------------------------------
    /// | #1ST TABLE CLOSER
    /// |----------------------------------------
    $html_table_close = '</tbody>' .
      '</table>';

    /// |----------------------------------------
    /// | #1ST TABLE CONTENT LOOP
    /// |----------------------------------------
    $html_content = '';
    for ($i = 0; $i < 10; $i++) {
      $html_content .= '<tr>' .
        '<td style="' . $style_content_3 . $border_thin . $width_num . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . '">XXX</td>' .
        '</tr>';
    }

    /// |----------------------------------------
    /// | #2ND TABLE OPENER
    /// |----------------------------------------
    // untuk heading sama pembukaan tabel
    $html_table_open_2 = '<table border="1" cellpadding="6">' .
      '<thead>' .
      '<tr>' .
      '<th style="' . $style_header . $w150 . $tebel . $border_thin . '">NAMA</th>' .
      '<th style="' . $style_header . $w100 . $tebel . $border_thin . '">GOL</th>' .
      '<th style="' . $style_header . $w200 . $tebel . $border_thin . '">INSENTIF (TPP) 1 BULAN</th>' .
      '</tr>' .
      '</thead>' .
      '<tbody>';

    /// |----------------------------------------
    /// | #2ND TABLE CLOSER
    /// |----------------------------------------
    $html_table_close_2 = '</tbody>' .
      '</table>';

    /// |----------------------------------------
    /// | #2ND TABLE CONTENT LOOP
    /// |----------------------------------------
    $html_content_2 = '';
    for ($i = 0; $i < 6; $i++) {
      $html_content_2 .= '<tr>' .
        '<td style="' . $style_content_3 . $w150 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $w100 . $border_thin . '">XXX</td>' .
        '<td style="' . $style_content_3 . $w200 . $border_thin . '">XXX</td>' .
        '</tr>';
    }

    /// |----------------------------------------
    /// | #2ND TABLE NOTES
    /// |----------------------------------------
    $html_keterangan = '<h6> </h6>' .
      '<span>' .
      'Catatan : ' .
      '<ul>' .
      '<li style="' . $style_content_3 . '">Guru TERIMA PER BULAN Rp. 1.050.000 TIDAK ADA POTONGAN PAJAK, POTONGAN INFAQ BAGI YANG MUSLIM</li>' .
      '<li style="' . $style_content_3 . '">Guru Pertama / PPPK TERIMA PER BULAN Rp. 1.000.000 TIDAK ADA POTONGAN PAJAK DAN POTONGAN INFAQ BAGI YANG MUSLIM</li>' .
      '<li style="' . $style_content_3 . '">Guru Ahli Pertama TERIMA PER BULAN Rp. 1.100.000 POTONGAN PAJAK PPh 21 5%, DAN POTONGAN INFAQ BAGI YANG MUSLIM</li>' .
      '<li style="' . $style_content_3 . '">Guru Ahli Muda TERIMA PER BULAN Rp. 1.200.000 POTONGAN PAJAK PPh 21 5%, DAN POTONGAN INFAQ BAGI YANG MUSLIM</li>' .
      '<li style="' . $style_content_3 . '">Guru Ahli Madya/ Pengawas Ahli Madya TERIMA PER BULAN Rp. 1.300.000 POTONGAN PAJAK PPh 21 15%, DAN POTONGAN INFAQ BAGI YANG MUSLIM</li>' .
      '</ul>' .
      '</span>';

    /// |----------------------------------------
    /// | COMPILE ALL HTML
    /// |----------------------------------------
    // jadikan satu semuanya
    // $html_full_table = $html_table_open . $html_content . $html_table_close . '<h5> </h5>' .
    //   '<span>Keterangan : </span><span>' . $html_table_open_2 . $html_content_2 . $html_table_close_2 . '</span>' .
    //   $html_keterangan;
    // ga isi tabel keterangan dan catatan katanya
    $html_full_table = $html_table_open . $html_content . $html_table_close;

    // output the HTML content
    $pdf->writeHTML($html_full_table, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();

    /// |----------------------------------------
    /// | OUTPUT TO THE PAGE
    /// |----------------------------------------
    //Close and output PDF document
    $pdf->Output('laporan_tunjangan_produktifitas_guru_triwulan_' . $triwulanTitle . '_' . $tahun . '.pdf', 'I');
  }

  public function cetak_rekapitulasi_mengajar($unit_kerja, $triwulan, $tahun)
  {
    $unit_kerja = clean_string($unit_kerja);
    $triwulan = clean_string($triwulan);
    $tahun = clean_string($tahun);

    // echo "UNIT KERJA: $unit_kerja // TRIWULAN: $triwulan // TAHUN: $tahun";
    // return;

    $start_date = '9999';
    $end_date = '9999';
    $triwulanTitle = 'I';

    switch ($triwulan) {
      case '1': {
          $start_date = $tahun . '-01';
          $end_date = $tahun . '-03';
          $triwulanTitle = 'I';
          break;
        }
      case '2': {
          $start_date = $tahun . '-04';
          $end_date = $tahun . '-06';
          $triwulanTitle = 'II';
          break;
        }
      case '3': {
          $start_date = $tahun . '-07';
          $end_date = $tahun . '-09';
          $triwulanTitle = 'III';
          break;
        }
      case '4': {
          $start_date = $tahun . '-10';
          $end_date = $tahun . '-12';
          $triwulanTitle = 'IV';
          break;
        }

      default:
        echo '<h4>ERROR: Triwulan tidak valid / belum di-set.</h4>';
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
    $pdf->SetTitle('Laporan Rekapitulasi Jurnal Mengajar Guru Triwulan');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // $logo_samarinda = base_url("theme/assets/images/logo/logo_pemkot.png");
    $logo_path = FCPATH . 'theme\assets\images\logo\logo_pemkot.jpg';
    // set default header data
    $pdf->SetHeaderData($logo_path, 19, 'DINAS PENDIDIKAN DAN KEBUDAYAAN PEMERINTAH KOTA SAMARINDA', "$data_ukerja[ket_ukerja]\nRekapitulasi Jurnal Mengajar Guru Triwulan IV Tahun 2023");

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
    $style_header = 'color: black; background-color: #d9d9d9; font-size: 9px; text-align: center;';

    $style_content_1 =  "color: green; font-size: 7px; text-align: right;";
    $style_content_2 =  "color: black; font-size: 7px; text-align: justify;";
    $style_content_3 =  "color: black; font-size: 7px; text-align: left;";
    $style_content_4 =  "color: black; font-size: 7px; text-align: right;";
    $style_content_5 =  "color: black; font-size: 7px; text-align: center;";

    $w50 = "width: 50px;";
    $w75 = "width: 75px;";
    $w100 = "width: 100px;";
    $w125 = "width: 125px;";
    $w150 = "width: 150px;";
    $w175 = "width: 175px;";
    $w200 = "width: 200px;";
    $w225 = "width: 225px;";
    $w250 = "width: 250px;";
    $w275 = "width: 275px;";
    $w300 = "width: 300px;";
    $w325 = "width: 325px;";
    $w350 = "width: 350px;";
    $w375 = "width: 375px;";
    $w400 = "width: 400px;";

    $width_num =  "width: 30px";
    $border_thin = "border: 1px solid #999696;";
    $tebel = "font-weight: bold;";

    /// |----------------------------------------
    /// | #1ST TABLE OPENER
    /// |----------------------------------------
    // untuk heading sama pembukaan tabel
    $html_table_open = '<table border="1" cellpadding="6">' .
      '<thead>' .
      '<tr>' .
      '<th style="' . $style_header . $tebel . $border_thin . $width_num . '">No.</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . $w225 . '">NAMA GURU</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . $w150 . '">TUGAS YANG DIAMPU</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . $w100 . '">JURNAL JAM/BULAN</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . $w100 . '">KETIDAKHADIRAN DALAM JAM</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . $w100 . '">JUMLAH JAM MINIMAL/BULAN</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . $w250 . '">VALIDASI KEPSEK</th>' .
      '<th style="' . $style_header . $tebel . $border_thin . $w100 . '">KETERANGAN</th>' .
      '</tr>' .
      '</thead>' .
      '<tbody>';

    /// |----------------------------------------
    /// | #1ST TABLE CLOSER
    /// |----------------------------------------
    $html_table_close = '</tbody>' .
      '</table>';

    /// |----------------------------------------
    /// | #1ST TABLE CONTENT LOOP
    /// |----------------------------------------
    $html_content = '';
    for ($i = 0; $i < 15; $i++) {
      $html_content .= '<tr>' .
        '<td style="' . $style_content_5 . $border_thin . $width_num . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . $w225 . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . $w150 . '">XXX</td>' .
        '<td style="' . $style_content_5 . $border_thin . $w100 . '">XXX</td>' .
        '<td style="' . $style_content_5 . $border_thin . $w100 . '">XXX</td>' .
        '<td style="' . $style_content_5 . $border_thin . $w100 . '">XXX</td>' .
        '<td style="' . $style_content_3 . $border_thin . $w250 . '">XXX</td>' .
        '<td style="' . $style_content_5 . $border_thin . $w100 . '">XXX</td>' .
        '</tr>';
    }

    /// |----------------------------------------
    /// | COMPILE ALL HTML
    /// |----------------------------------------
    // jadikan satu semuanya
    $html_full_table = $html_table_open . $html_content . $html_table_close;

    // output the HTML content
    $pdf->writeHTML($html_full_table, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();

    /// |----------------------------------------
    /// | OUTPUT TO THE PAGE
    /// |----------------------------------------
    //Close and output PDF document
    $pdf->Output('laporan_rekapitulasi_jurnal_mengajar_triwulan_' . $triwulanTitle . '_' . $tahun . '.pdf', 'I');
  }
}
