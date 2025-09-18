<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class Pdt_laporan extends MY_Controller
{
  public function __construct()
  {
    // lakukan proses verifikasi user disini
    parent::__construct();

    $is_ajax = $this->input->is_ajax_request();
    if (!$is_ajax) {
      $this->session->set_userdata('menu', 'PDT_Laporan');
      if (!check_perm('read') || !is_logged_in()) {
        redirect(site_url('pangkalan_data'));
      }
    }
    $this->load->model('mdl_pdt_laporan', 'mdl_laporan');
  }

  public function index()
  {
    $sent_data = array();
    $data = array(
      'page_title' => "Laporan Pangkalan Data | PROGURINDA",
      'module' => "pdt_laporan",
      'view' => "vw_menu_laporan",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  public function menu_lap_peserta_didik_tk()
  {
    $dataset = array();
    // lakukan proses init halaman
    $data = array(
      'page_title' => "Laporan Peserta Didik Jenjang TK | PROGURINDA",
      'module' => "pdt_laporan",
      'view' => "vw_lap_peserta_didik_tk",
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  public function get_data_rekap_tk()
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
      'id_sekolah' => $this->input->post('id_sekolah'),
      'id_tahun_ajaran' => $this->input->post('id_tahun_ajaran'),
      'bulan' => $this->input->post('bulan')
    );
    // move the db operation to the designated models
    $result = $this->mdl_laporan->get_datatable_tk($param);
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

  public function menu_lap_peserta_didik_sd()
  {
    $dataset = array();
    // lakukan proses init halaman
    $data = array(
      'page_title' => "Laporan Peserta Didik Jenjang SD | PROGURINDA",
      'module' => "pdt_laporan",
      'view' => "vw_lap_peserta_didik_sd",
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  public function menu_lap_peserta_didik_smp()
  {
    $dataset = array();
    // lakukan proses init halaman
    $data = array(
      'page_title' => "Laporan Peserta Didik Jenjang SMP | PROGURINDA",
      'module' => "pdt_laporan",
      'view' => "vw_lap_peserta_didik_smp",
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  /**============================================
   *               REKAP TENAGA PENDIDIK
   *=============================================**/
  public function menu_lap_rekap_tenaga_pendidik()
  {
    $dataset = [
      "data_tenaga_pendidik_pns" => isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_pns(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_pns() : 0,
      "data_tenaga_pendidik_pppk" => isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_pppk(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_pppk() : 0,
      "data_tenaga_pendidik_negeri" => isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_negeri(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_negeri() : 0,
      "data_tenaga_pendidik_swasta" => isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_swasta(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_swasta() : 0,
      "total_data" => $this->mdl_laporan->get_all_data_pendidik()
    ];
    // lakukan proses init halaman
    $data = array(
      'page_title' => "Laporan Tenaga Pendidik | PROGURINDA",
      'module' => "pdt_laporan",
      'view' => "vw_lap_rekap_tenaga_pendidik",
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  public function cetak_rekap_tenaga_pendidik()
  {
    $dataset = [
      "data_tenaga_pendidik_pns" => isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_pns(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_pns() : 0,
      "data_tenaga_pendidik_pppk" => isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_pppk(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_pppk() : 0,
      "data_tenaga_pendidik_negeri" => isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_negeri(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_negeri() : 0,
      "data_tenaga_pendidik_swasta" => isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_swasta(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_swasta() : 0,
      "total_data" => $this->mdl_laporan->get_all_data_pendidik()
    ];

    $data = [
      'data' => $dataset
    ];

    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
    $spreadsheet = $reader->loadFromString($this->load->view('vw_cetak_rekap_tenaga_pendidik', $data, true));
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

    $spreadsheet->getActiveSheet()->getStyle('A1:K3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('A1:K3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    $spreadsheet->getActiveSheet()->getStyle('A4:K29')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('A4:K29')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    $spreadsheet->getActiveSheet()->getStyle('B4:B29')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('B4:B29')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    // Define the start and end row numbers and the desired height
    $startRow = 1;
    $endRow = 14;
    $rowHeight = 20; // Example height in points

    // Loop through the rows and set the height
    for ($row = $startRow; $row <= $endRow; $row++) {
      // Set row height for row 1
      $spreadsheet->getActiveSheet()->getRowDimension($row)->setRowHeight($rowHeight);
    }

    $startColumn = 65;
    $endColumn = 76;
    $columnWidth = 10; // Example height in points

    for ($column = $startColumn; $column <= $endColumn; $column++) {
      // Set column width for column A
      $spreadsheet->getActiveSheet()->getColumnDimension(chr($column))->setWidth($columnWidth);
    }

    $spreadsheet->getActiveSheet()->getStyle('B4')
      ->getFill()
      ->setFillType(Fill::FILL_SOLID)
      ->getStartColor()
      ->setARGB('FFFFFF00');

    $spreadsheet->getActiveSheet()->getStyle('B7')
      ->getFill()
      ->setFillType(Fill::FILL_SOLID)
      ->getStartColor()
      ->setARGB('FFFFFF00');

    $spreadsheet->getActiveSheet()->getStyle('B12')
      ->getFill()
      ->setFillType(Fill::FILL_SOLID)
      ->getStartColor()
      ->setARGB('FFFFFF00');

    $spreadsheet->getActiveSheet()->getStyle('B16')
      ->getFill()
      ->setFillType(Fill::FILL_SOLID)
      ->getStartColor()
      ->setARGB('FFFFFF00');

    $spreadsheet->getActiveSheet()->getStyle('B19')
      ->getFill()
      ->setFillType(Fill::FILL_SOLID)
      ->getStartColor()
      ->setARGB('FFFFFF00');

    $spreadsheet->getActiveSheet()->getStyle('B23')
      ->getFill()
      ->setFillType(Fill::FILL_SOLID)
      ->getStartColor()
      ->setARGB('FFFFFF00');

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('laporan_rekap_tenaga_pendidik.xlsx');

    $file_url = 'laporan_rekap_tenaga_pendidik.xlsx';
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
    readfile($file_url);
    unlink('laporan_rekap_tenaga_pendidik.xlsx');
  }

  public function menu_lap_rekap_tenaga_kependidikan()
  {
    $dataset = [
      "data_tenaga_kependidikan_pns" => isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_pns(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_pns() : 0,
      "data_tenaga_kependidikan_pppk" => isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_pppk(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_pppk() : 0,
      "data_tenaga_kependidikan_negeri" => isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_negeri(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_negeri() : 0,
      "data_tenaga_kependidikan_swasta" => isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_swasta(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_swasta() : 0,
      "total_data" => $this->mdl_laporan->get_all_data_kependidikan()
    ];

    // lakukan proses init halaman
    $data = array(
      'page_title' => "Laporan Tenaga Kependidikan | PROGURINDA",
      'module' => "pdt_laporan",
      'view' => "vw_lap_rekap_tenaga_kependidikan",
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  public function cetak_rekap_tenaga_kependidikan()
  {
    $dataset = [
      "data_tenaga_kependidikan_pns" => isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_pns(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_pns() : 0,
      "data_tenaga_kependidikan_pppk" => isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_pppk(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_pppk() : 0,
      "data_tenaga_kependidikan_negeri" => isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_negeri(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_negeri() : 0,
      "data_tenaga_kependidikan_swasta" => isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_swasta(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_swasta() : 0,
      "total_data" => $this->mdl_laporan->get_all_data_kependidikan()
    ];

    $data = [
      'data' => $dataset
    ];

    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
    $spreadsheet = $reader->loadFromString($this->load->view('vw_cetak_rekap_tenaga_kependidikan', $data, true));
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

    $spreadsheet->getActiveSheet()->getStyle('A1:K3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('A1:K3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    $spreadsheet->getActiveSheet()->getStyle('A4:K29')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('A4:K29')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    $spreadsheet->getActiveSheet()->getStyle('B4:B29')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('B4:B29')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

    // Define the start and end row numbers and the desired height
    $startRow = 1;
    $endRow = 14;
    $rowHeight = 20; // Example height in points

    // Loop through the rows and set the height
    for ($row = $startRow; $row <= $endRow; $row++) {
      // Set row height for row 1
      $spreadsheet->getActiveSheet()->getRowDimension($row)->setRowHeight($rowHeight);
    }

    $startColumn = 65;
    $endColumn = 76;
    $columnWidth = 10; // Example height in points

    for ($column = $startColumn; $column <= $endColumn; $column++) {
      // Set column width for column A
      $spreadsheet->getActiveSheet()->getColumnDimension(chr($column))->setWidth($columnWidth);
    }

    $spreadsheet->getActiveSheet()->getStyle('B4')
      ->getFill()
      ->setFillType(Fill::FILL_SOLID)
      ->getStartColor()
      ->setARGB('FFFFFF00');

    $spreadsheet->getActiveSheet()->getStyle('B7')
      ->getFill()
      ->setFillType(Fill::FILL_SOLID)
      ->getStartColor()
      ->setARGB('FFFFFF00');

    $spreadsheet->getActiveSheet()->getStyle('B12')
      ->getFill()
      ->setFillType(Fill::FILL_SOLID)
      ->getStartColor()
      ->setARGB('FFFFFF00');

    $spreadsheet->getActiveSheet()->getStyle('B16')
      ->getFill()
      ->setFillType(Fill::FILL_SOLID)
      ->getStartColor()
      ->setARGB('FFFFFF00');

    $spreadsheet->getActiveSheet()->getStyle('B19')
      ->getFill()
      ->setFillType(Fill::FILL_SOLID)
      ->getStartColor()
      ->setARGB('FFFFFF00');

    $spreadsheet->getActiveSheet()->getStyle('B23')
      ->getFill()
      ->setFillType(Fill::FILL_SOLID)
      ->getStartColor()
      ->setARGB('FFFFFF00');

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('laporan_rekap_tenaga_kependidikan.xlsx');

    $file_url = 'laporan_rekap_tenaga_kependidikan.xlsx';
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
    readfile($file_url);
    unlink('laporan_rekap_tenaga_kependidikan.xlsx');
  }

  public function menu_lap_rekap_ptk()
  {
    $dataset = array();
    // lakukan proses init halaman
    $data = array(
      'page_title' => "Laporan Rekap PTK | PROGURINDA",
      'module' => "pdt_laporan",
      'view' => "vw_lap_rekap_ptk",
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }
}
