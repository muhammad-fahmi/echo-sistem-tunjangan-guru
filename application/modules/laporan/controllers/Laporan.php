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
    $result = $this->mlp->get_datatable('progurinda_r_jurnal_mengajar',$param);
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

  public function LoadData($file)
  {
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line) {
        $data[] = explode(';', chop($line));
    }
    return $data;
  }

  // public function ColoredTable($header,$data)
  // {
  //   // Colors, line width and bold font
  //   $this->SetFillColor(255, 0, 0);
  //   $this->SetTextColor(255);
  //   $this->SetDrawColor(128, 0, 0);
  //   $this->SetLineWidth(0.3);
  //   $this->SetFont('', 'B');
  //   // Header
  //   $w = array(40, 35, 40, 45);
  //   $num_headers = count($header);
  //   for($i = 0; $i < $num_headers; ++$i) {
  //       $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
  //   }
  //   $this->Ln();
  //   // Color and font restoration
  //   $this->SetFillColor(224, 235, 255);
  //   $this->SetTextColor(0);
  //   $this->SetFont('');
  //   // Data
  //   $fill = 0;
  //   foreach($data as $row) {
  //       $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
  //       $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
  //       $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
  //       $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
  //       $this->Ln();
  //       $fill=!$fill;
  //   }
  //   $this->Cell(array_sum($w), 0, '', 'T');
  // }

  public function generate_pdf_jurnal_bulanan($array_of_data = false)
  {
    // create new PDF document
    $pdf = new Tcpdf_lib('L', PDF_UNIT, 'F4', true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('SMPN 3 SAMARINDA');
    $pdf->SetTitle('Laporan Tunjangan Produktifitas Guru Triwulan');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // $logo_samarinda = base_url("theme/assets/images/logo/logo_pemkot.png");
    $logo_path = FCPATH . 'theme\assets\images\logo\logo_pemkot.jpg';
    // set default header data
    $pdf->SetHeaderData($logo_path, 19, 'DINAS PENDIDIKAN DAN KEBUDAYAAN PEMERINTAH KOTA SAMARINDA', "SMP NEGERI 3 SAMARINDA\nTunjangan Produktifitas Guru Triwulan I Tahun 2023");

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
    $html_table_open = '<table border="1" cellpadding="6">'.
    '<thead>'.
    '<tr>'.
    '<th style="'. $style_header . $border_thin . $width_num .'">No</th>'.
    '<th style="'. $style_header . $border_thin .'">NAMA</th>'.
    '<th style="'. $style_header . $border_thin .'">NIP</th>'.
    '<th style="'. $style_header . $border_thin .'">GOL</th>'.
    '<th style="'. $style_header . $border_thin .'">UNIT KERJA</th>'.
    '<th style="'. $style_header . $border_thin .'">INSENTIF</th>'.
    '<th style="'. $style_header . $border_thin .'">JUMLAH BULAN</th>'.
    '<th style="'. $style_header . $border_thin .'">JUMLAH KOTOR</th>'.
    '<th style="'. $style_header . $border_thin .'">JUMLAH PPh 5%</th>'.
    '<th style="'. $style_header . $border_thin .'">JUMLAH PPh 15%</th>'.
    '<th style="'. $style_header . $border_thin .'">JUMLAH INFAQ 2,5%</th>'.
    '<th style="'. $style_header . $border_thin .'">JUMLAH BERSIH</th>'.
    '<th style="'. $style_header . $border_thin .'">NO REKENING</th>'.
    '<th style="'. $style_header . $border_thin .'">NIK</th>'.
    '<th style="'. $style_header . $border_thin .'">NPWP</th>'.
    '</tr>'.
    '</thead>'.
    '<tbody>';

    $html_table_close = '</tbody>'.
    '</table>';
    $html_content = '';
    
    // sebagai contoh pake for aja dulu ya karena datanya kosong
    for ($i=0; $i < 10; $i++) { 
      $no = $i+1;
      $randomText = strtoupper(md5($i . rand(1000, 9999)));
      $content2 = substr($randomText,2,8);
      $content3 = substr($randomText,4,10);
      $content4 = substr($randomText,6,12);
      $content5 = substr($randomText,8,14);

      $html_content .= '<tr>'.
      '<td style="'. $style_content_1 . $border_thin . $width_num .'">'. $no .'</td>'.
      '<td style="'. $style_content_2 . $border_thin .'">'. $content2 .'</td>'.
      '<td style="'. $style_content_2 . $border_thin .'">'. $content3 .'</td>'.
      '<td style="'. $style_content_2 . $border_thin .'">'. $content4 .'</td>'.
      '<td style="'. $style_content_2 . $border_thin .'">'. $content5 .'</td>'.
      '<td style="'. $style_content_2 . $border_thin .'">'. $content5 .'</td>'.
      '<td style="'. $style_content_2 . $border_thin .'">'. $content5 .'</td>'.
      '<td style="'. $style_content_2 . $border_thin .'">'. $content5 .'</td>'.
      '<td style="'. $style_content_2 . $border_thin .'">'. $content5 .'</td>'.
      '<td style="'. $style_content_2 . $border_thin .'">'. $content5 .'</td>'.
      '<td style="'. $style_content_2 . $border_thin .'">'. $content5 .'</td>'.
      '<td style="'. $style_content_2 . $border_thin .'">'. $content5 .'</td>'.
      '<td style="'. $style_content_2 . $border_thin .'">'. $content5 .'</td>'.
      '<td style="'. $style_content_2 . $border_thin .'">'. $content5 .'</td>'.
      '<td style="'. $style_content_2 . $border_thin .'">'. $content5 .'</td>'.
      '</tr>';
    }

    // Jumlah Final (Last Row)
    $html_content_2 = '<tr style="'. $style_header .'">'.
      '<td colspan="5" style="'. $border_thin .'">JUMLAH </td>'.
      '<td style="'. $border_thin .'"> </td>'.
      '<td style="'. $border_thin .'"> </td>'.
      '<td style="'. $border_thin .'"> </td>'.
      '<td style="'. $border_thin .'"> </td>'.
      '<td style="'. $border_thin .'"> </td>'.
      '<td style="'. $border_thin .'"> </td>'.
      '<td style="'. $border_thin .'"> </td>'.
      '<td style="'. $border_thin .'"> </td>'.
      '<td style="'. $border_thin .'"> </td>'.
      '<td style="'. $border_thin .'"> </td>'.
      '</tr>';

    // jadikan satu semuanya
    $html_full_table = $html_table_open . $html_content . $html_content_2 . $html_table_close;

    // output the HTML content
    $pdf->writeHTML($html_full_table, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();

    //Close and output PDF document
    $pdf->Output('laporan_tunjangan_produktifitas_guru_triwulan_I_2023.pdf', 'I');
  }
}