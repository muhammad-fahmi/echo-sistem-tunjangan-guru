<?php
$init_par = array(
  'orientation' => 'L',
  'unit' => 'mm',
  'format' => 'A4',
  'unicode' => true,
  'encoding' => 'UTF-8',
  'diskcache' => true,
  'pdfa' => false
);
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$this->load->library('tcpdf_lib', $init_par);
// set document information
$this->tcpdf_lib->SetCreator("SISTEM PRESENSI SAMARINDA");
$this->tcpdf_lib->SetAuthor('SISTEM PRESENSI KOTA SAMARINDA');
$this->tcpdf_lib->SetTitle('EXPORT DATA ATTLOG');
$this->tcpdf_lib->SetSubject('EXPORT DATA ATTLOG');
//$this->tcpdf_lib->SetKeywords('TCPDF, PDF, example, test, guide');

$this->tcpdf_lib->SetPrintHeader(false);
// set default header data
// $this->tcpdf_lib->SetHeaderData("", "", "","", "", "", "", array(0,0,0), array(0,0,0));
// $this->tcpdf_lib->setFooterData(array(0,0,0), array(0,0,0));

// // set header and footer fonts
// $this->tcpdf_lib->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $this->tcpdf_lib->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$this->tcpdf_lib->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$this->tcpdf_lib->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$this->tcpdf_lib->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT);
$this->tcpdf_lib->SetHeaderMargin(PDF_MARGIN_HEADER);
//$this->tcpdf_lib->SetHeaderMargin(0);
$this->tcpdf_lib->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$this->tcpdf_lib->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
//$this->tcpdf_lib->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  require_once(dirname(__FILE__) . '/lang/eng.php');
  $this->tcpdf_lib->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$this->tcpdf_lib->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$this->tcpdf_lib->SetFont('dejavusans', '', 11, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$this->tcpdf_lib->AddPage();
$this->tcpdf_lib->SetFont('dejavusans', 'B', 9, '', true);

/**
 * Prints a cell (rectangular area) with optional borders, background color and character string. The upper-left corner of the cell corresponds to the current position. The text can be aligned or centered. After the call, the current position moves to the right or to the next line. It is possible to put a link on the text.<br />
 * If automatic page breaking is enabled and the cell goes beyond the limit, a page break is done before outputting.
 * @param $w (float) Cell width. If 0, the cell extends up to the right margin.
 * @param $h (float) Cell height. Default value: 0.
 * @param $txt (string) String to print. Default value: empty string.
 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
 * @param $ln (int) Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right (or left for RTL languages)</li><li>1: to the beginning of the next line</li><li>2: below</li></ul> Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0.
 * @param $align (string) Allows to center or align the text. Possible values are:<ul><li>L or empty string: left align (default value)</li><li>C: center</li><li>R: right align</li><li>J: justify</li></ul>
 * @param $fill (boolean) Indicates if the cell background must be painted (true) or transparent (false).
 * @param $link (mixed) URL or identifier returned by AddLink().
 * @param $stretch (int) font stretch mode: <ul><li>0 = disabled</li><li>1 = horizontal scaling only if text is larger than cell width</li><li>2 = forced horizontal scaling to fit cell width</li><li>3 = character spacing only if text is larger than cell width</li><li>4 = forced character spacing to fit cell width</li></ul> General font stretching and scaling values will be preserved when possible.
 * @param $ignore_min_height (boolean) if true ignore automatic minimum height value.
 * @param $calign (string) cell vertical alignment relative to the specified Y value. Possible values are:<ul><li>T : cell top</li><li>C : center</li><li>B : cell bottom</li><li>A : font top</li><li>L : font baseline</li><li>D : font bottom</li></ul>
 * @param $valign (string) text vertical alignment inside the cell. Possible values are:<ul><li>T : top</li><li>C : center</li><li>B : bottom</li></ul>
 * @public
 * @since 1.0
 * @see SetFont(), SetDrawColor(), SetFillColor(), SetTextColor(), SetLineWidth(), AddLink(), Ln(), MultiCell(), Write(), SetAutoPageBreak()
 */

//$this->tcpdf_lib->Cell(0, 5, strtoupper("BIODATA PEGAWAI"), 0, 1, 'C', 0, '', 0);
//$this->tcpdf_lib->Cell(0, 5, '', 0, 1, 'C', 0, '', 0);
//$this->tcpdf_lib->SetFont('dejavusans', '', 8, '', true);
//$this->tcpdf_lib->Cell(0, 6, "Dicetak Tgl : ".date("d-m-Y"), 0, 1, 'L', 0, '', 0);
// set text shadow effect
$this->tcpdf_lib->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

//set font size
$this->tcpdf_lib->setFont('dejavusans', '', 9, '', true);
// Set some content to print


$tabel_heading =
  "
<table cellspacing=\"1\" cellpadding=\"1\" style=\"font-size:9px\">
<tr>
  <td colspan=\"4\" align=\"center\" style=\"font-size:12px\">EXPORT DATA ATTLOG</td>
</tr>
<tr>
  <td colspan=\"4\" align=\"center\" style=\"font-size:12px\">" . $ket_ukerja . "</td>
</tr>
<tr>
  <td colspan=\"4\" align=\"left\" style=\"font-size:9px\">Dicetak Tanggal:" . em_date("d-m-Y H:i:s") . "</td>
</tr>
</table>";

$this->tcpdf_lib->writeHTMLCell(0, 0, '', 25, $tabel_heading, 0, 1, 0, true, '', true);

$tabel_attlog = "
<table border=\"1\" cellspacing=\"1\" cellpadding=\"2\" style=\"font-size:7px\">
<tr>
  <th style=\"width:50px\" align=\"center\">No</th>
  <th style=\"width:80px\" align=\"center\">CLOUD ID</th>
  <th style=\"width:100px\" align=\"center\">NIP</th>
  <th style=\"width:100px\" align=\"center\">NAMA</th>
  <th style=\"width:120px\" align=\"center\">JABATAN</th>
  <th style=\"width:120px\" align=\"center\">UNIT KERJA</th>
  <th style=\"width:100px\" align=\"center\">WAKTU PRESENSI</th>
  <th style=\"width:50px\" align=\"center\">JENIS PRESENSI</th>
</tr>
";
$no = 1;
//$tampil=mysqli_query($conn,"SELECT r_ptt_sk.*, m_tugas.ket_tugas, m_ukerja.ket_ukerja FROM (r_ptt_sk LEFT JOIN m_tugas ON r_ptt_sk.kode_tugas = m_tugas.kode_tugas) LEFT JOIN m_ukerja ON r_ptt_sk.kode_ukerja = m_ukerja.kode_ukerja WHERE niptt = '$niptt' ORDER BY status, tmt_sk DESC ");
foreach ($attlog as $r) {
  $tabel_attlog .= "<tr align=center>
  		<td style=\"width:50px\">$no</td>
  		<td style=\"width:80px\" align=left>$r[cloud_id]</td>
  		<td style=\"width:100px\" align=left>$r[pin]</td>
  		<td style=\"width:100px\" align=left>$r[nama]</td>
  		<td style=\"width:120px\" align=left>$r[ket_jab]</td>
  		<td style=\"width:120px\" align=left>$r[ket_ukerja]</td>
  		<td style=\"width:100px\" align=left>$r[scan_date]</td>
  		<td style=\"width:50px\" align=left>$r[ket_verify]</td>
		</tr>";
  $no++;
}
$tabel_attlog .= "</table>";

/**
 * Prints a cell (rectangular area) with optional borders, background color and html text string.
 * The upper-left corner of the cell corresponds to the current position. After the call, the current position moves to the right or to the next line.<br />
 * If automatic page breaking is enabled and the cell goes beyond the limit, a page break is done before outputting.
 * IMPORTANT: The HTML must be well formatted - try to clean-up it using an application like HTML-Tidy before submitting.
 * Supported tags are: a, b, blockquote, br, dd, del, div, dl, dt, em, font, h1, h2, h3, h4, h5, h6, hr, i, img, li, ol, p, pre, small, span, strong, sub, sup, table, tcpdf, td, th, thead, tr, tt, u, ul
 * NOTE: all the HTML attributes must be enclosed in double-quote.
 * @param $w (float) Cell width. If 0, the cell extends up to the right margin.
 * @param $h (float) Cell minimum height. The cell extends automatically if needed.
 * @param $x (float) upper-left corner X coordinate
 * @param $y (float) upper-left corner Y coordinate
 * @param $html (string) html text to print. Default value: empty string.
 * @param $border (mixed) Indicates if borders must be drawn around the cell. The value can be a number:<ul><li>0: no border (default)</li><li>1: frame</li></ul> or a string containing some or all of the following characters (in any order):<ul><li>L: left</li><li>T: top</li><li>R: right</li><li>B: bottom</li></ul> or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
 * @param $ln (int) Indicates where the current position should go after the call. Possible values are:<ul><li>0: to the right (or left for RTL language)</li><li>1: to the beginning of the next line</li><li>2: below</li></ul> Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0.
 * @param $fill (boolean) Indicates if the cell background must be painted (true) or transparent (false).
 * @param $reseth (boolean) if true reset the last cell height (default true).
 * @param $align (string) Allows to center or align the text. Possible values are:<ul><li>L : left align</li><li>C : center</li><li>R : right align</li><li>'' : empty string : left for LTR or right for RTL</li></ul>
 * @param $autopadding (boolean) if true, uses internal padding and automatically adjust it to account for line width.
 * @see Multicell(), writeHTML()
 * @public
 */
$this->tcpdf_lib->writeHTMLCell(0, 0, '', 45, $tabel_attlog, 0, 1, 0, true, '', true);
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$this->tcpdf_lib->Output('EXPORT ATTLOG ' . $ket_ukerja . ".pdf", 'I');
