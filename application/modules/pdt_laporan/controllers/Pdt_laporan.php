<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
    $count_data_tenaga_pendidik_pns = isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_pns(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_pns() : 0;

    $count_data_tenaga_pendidik_pppk = isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_pppk(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_pppk() : 0;

    $count_data_tenaga_pendidik_negeri = isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_negeri(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_negeri() : 0;

    $count_data_tenaga_pendidik_swasta = isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_swasta(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_swasta() : 0;

    $count_total_data = $this->mdl_laporan->get_all_data_pendidik();

    $spreadsheet = IOFactory::load('template_laporan_rekap_tenaga_pendidik.xlsx');

    $worksheet = $spreadsheet->getActiveSheet();

    $worksheet->getCell('C8')->setValue($count_data_tenaga_pendidik_pns);
    $worksheet->getCell('D8')->setValue($count_data_tenaga_pendidik_pppk);
    $worksheet->getCell('E8')->setValue($count_data_tenaga_pendidik_pns + $count_data_tenaga_pendidik_pppk);
    $worksheet->getCell('F8')->setValue($count_data_tenaga_pendidik_negeri);
    $worksheet->getCell('G8')->setValue($count_data_tenaga_pendidik_swasta);
    $worksheet->getCell('H8')->setValue($count_data_tenaga_pendidik_negeri + $count_data_tenaga_pendidik_swasta);
    $worksheet->getCell('I8')->setValue($count_data_tenaga_pendidik_pns + $count_data_tenaga_pendidik_pppk);
    $worksheet->getCell('J8')->setValue($count_data_tenaga_pendidik_negeri + $count_data_tenaga_pendidik_swasta);
    $worksheet->getCell('K8')->setValue($count_data_tenaga_pendidik_pns + $count_data_tenaga_pendidik_pppk + $count_data_tenaga_pendidik_negeri + $count_data_tenaga_pendidik_swasta);


    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
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
    $count_data_tenaga_kependidikan_pns = isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_pns(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_pns() : 0;

    $count_data_tenaga_kependidikan_pppk = isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_pppk(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_pppk() : 0;

    $count_data_tenaga_kependidikan_negeri = isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_negeri(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_negeri() : 0;

    $count_data_tenaga_kependidikan_swasta = isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_swasta(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_swasta() : 0;

    $count_total_data = $this->mdl_laporan->get_all_data_kependidikan();

    $spreadsheet = IOFactory::load('template_laporan_rekap_tenaga_kependidikan.xlsx');

    $worksheet = $spreadsheet->getActiveSheet();

    $worksheet->getCell('C8')->setValue($count_data_tenaga_kependidikan_pns);
    $worksheet->getCell('D8')->setValue($count_data_tenaga_kependidikan_pppk);
    $worksheet->getCell('E8')->setValue($count_data_tenaga_kependidikan_pns + $count_data_tenaga_kependidikan_pppk);
    $worksheet->getCell('F8')->setValue($count_data_tenaga_kependidikan_negeri);
    $worksheet->getCell('G8')->setValue($count_data_tenaga_kependidikan_swasta);
    $worksheet->getCell('H8')->setValue($count_data_tenaga_kependidikan_negeri + $count_data_tenaga_kependidikan_swasta);
    $worksheet->getCell('I8')->setValue($count_data_tenaga_kependidikan_pns + $count_data_tenaga_kependidikan_pppk);
    $worksheet->getCell('J8')->setValue($count_data_tenaga_kependidikan_negeri + $count_data_tenaga_kependidikan_swasta);
    $worksheet->getCell('K8')->setValue($count_data_tenaga_kependidikan_pns + $count_data_tenaga_kependidikan_pppk + $count_data_tenaga_kependidikan_negeri + $count_data_tenaga_kependidikan_swasta);


    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
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
    $dataset = [
      "data_tenaga_pendidik_pns" => isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_pns(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_pns() : 0,
      "data_tenaga_pendidik_pppk" => isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_pppk(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_pppk() : 0,
      "data_tenaga_pendidik_negeri" => isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_negeri(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_negeri() : 0,
      "data_tenaga_pendidik_swasta" => isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_swasta(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_swasta() : 0,
      "total_data_pendidik" => $this->mdl_laporan->get_all_data_pendidik(),
      "data_tenaga_kependidikan_pns" => isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_pns(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_pns() : 0,
      "data_tenaga_kependidikan_pppk" => isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_pppk(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_pppk() : 0,
      "data_tenaga_kependidikan_negeri" => isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_negeri(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_negeri() : 0,
      "data_tenaga_kependidikan_swasta" => isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_swasta(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_swasta() : 0,
      "total_data_kependidikan" => $this->mdl_laporan->get_all_data_kependidikan()
    ];
    // lakukan proses init halaman
    $data = array(
      'page_title' => "Laporan Rekap PTK | PROGURINDA",
      'module' => "pdt_laporan",
      'view' => "vw_lap_rekap_ptk",
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  public function cetak_rekap_ptk()
  {
    $count_data_tenaga_pendidik_pns = isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_pns(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_pns() : 0;

    $count_data_tenaga_pendidik_pppk = isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_pppk(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_pppk() : 0;

    $count_data_tenaga_pendidik_negeri = isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_negeri(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_negeri() : 0;

    $count_data_tenaga_pendidik_swasta = isset_nn_nes($this->mdl_laporan->get_tenaga_pendidik_swasta(), 0) ? $this->mdl_laporan->get_tenaga_pendidik_swasta() : 0;

    $count_total_data = $this->mdl_laporan->get_all_data_pendidik();

    $count_data_tenaga_kependidikan_pns = isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_pns(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_pns() : 0;

    $count_data_tenaga_kependidikan_pppk = isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_pppk(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_pppk() : 0;

    $count_data_tenaga_kependidikan_negeri = isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_negeri(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_negeri() : 0;

    $count_data_tenaga_kependidikan_swasta = isset_nn_nes($this->mdl_laporan->get_tenaga_kependidikan_swasta(), 0) ? $this->mdl_laporan->get_tenaga_kependidikan_swasta() : 0;

    $count_total_data_kependidikan = $this->mdl_laporan->get_all_data_kependidikan();

    $spreadsheet = IOFactory::load('template_laporan_rekap_ptk.xlsx');

    $worksheet = $spreadsheet->getActiveSheet();

    $worksheet->getCell('C9')->setValue($count_data_tenaga_pendidik_pns);
    $worksheet->getCell('D9')->setValue($count_data_tenaga_pendidik_pppk);
    $worksheet->getCell('E9')->setValue($count_data_tenaga_pendidik_pns + $count_data_tenaga_pendidik_pppk);
    $worksheet->getCell('F9')->setValue($count_data_tenaga_pendidik_negeri);
    $worksheet->getCell('G9')->setValue($count_data_tenaga_pendidik_swasta);
    $worksheet->getCell('H9')->setValue($count_data_tenaga_pendidik_negeri + $count_data_tenaga_pendidik_swasta);
    $worksheet->getCell('I9')->setValue($count_data_tenaga_pendidik_pns + $count_data_tenaga_pendidik_pppk);
    $worksheet->getCell('J9')->setValue($count_data_tenaga_pendidik_negeri + $count_data_tenaga_pendidik_swasta);
    $worksheet->getCell('K9')->setValue($count_data_tenaga_pendidik_pns + $count_data_tenaga_pendidik_pppk + $count_data_tenaga_pendidik_negeri + $count_data_tenaga_pendidik_swasta);

    $worksheet->getCell('C10')->setValue($count_data_tenaga_kependidikan_pns);
    $worksheet->getCell('D10')->setValue($count_data_tenaga_kependidikan_pppk);
    $worksheet->getCell('E10')->setValue($count_data_tenaga_kependidikan_pns + $count_data_tenaga_kependidikan_pppk);
    $worksheet->getCell('F10')->setValue($count_data_tenaga_kependidikan_negeri);
    $worksheet->getCell('G10')->setValue($count_data_tenaga_kependidikan_swasta);
    $worksheet->getCell('H10')->setValue($count_data_tenaga_kependidikan_negeri + $count_data_tenaga_kependidikan_swasta);
    $worksheet->getCell('I10')->setValue($count_data_tenaga_kependidikan_pns + $count_data_tenaga_kependidikan_pppk);
    $worksheet->getCell('J10')->setValue($count_data_tenaga_kependidikan_negeri + $count_data_tenaga_kependidikan_swasta);
    $worksheet->getCell('K10')->setValue($count_data_tenaga_kependidikan_pns + $count_data_tenaga_kependidikan_pppk + $count_data_tenaga_kependidikan_negeri + $count_data_tenaga_kependidikan_swasta);


    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('laporan_rekap_ptk.xlsx');

    $file_url = 'laporan_rekap_ptk.xlsx';
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
    readfile($file_url);
    unlink('laporan_rekap_ptk.xlsx');
  }
}
