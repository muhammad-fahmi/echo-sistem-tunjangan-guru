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

    switch ($triwulan) {
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
    $pdf->Output('laporan_tunjangan_produktifitas_guru_triwulan_IV_2023.pdf', 'I');
  }
}
