<?php defined('BASEPATH') or exit('No direct script access allowed');

class Tpp_per_bulan extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    // lakukan proses verifikasi user disini
  }

  public function index()
  {
    // lakukan proses init halaman
    $sent_data = array();
    $data = array(
      'page_title' => "List TPP Per Bulan",
      'module' => "Tpp_per_bulan",
      'view' => "vw_list_tpp_per_bulan",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }
}