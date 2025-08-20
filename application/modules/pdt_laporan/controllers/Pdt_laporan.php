<?php defined('BASEPATH') or exit('No direct script access allowed');

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
}
