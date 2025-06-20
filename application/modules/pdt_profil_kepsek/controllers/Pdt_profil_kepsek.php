<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pdt_profil_kepsek extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    // lakukan proses verifikasi user disini
    parent::__construct();
    $priv = $this->session->userdata('kewenangan');
    $log = $this->session->userdata('logged_in');
    if ($log != true) {
      redirect(site_url('login'));
    } else {
      $this->load->model('mdl_pdt_profil_kepsek', 'mpdtks');
    }
  }

  public function index()
  {
    // lakukan proses init halaman
    $sent_data = array();
    $data = array(
      'page_title' => "Update Profil Kepala Sekolah",
      'module' => "pdt_profil_kepsek",
      'view' => "vw_profil_kepsek",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }
}
