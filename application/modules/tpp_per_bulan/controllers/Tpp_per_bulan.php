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
    $bulan_now = date('n');
    $tahun_now = date('Y');
    if ($bulan_filter == 1){
      $sent_data = array(
        "bln_filter" => 12,
        "thn_filter" => (int)$tahun_now - 1  
      );
    }else{
      $sent_data = array(
        "bln_filter" => (int)$bulan_now - 1,
        "thn_filter" => (int)$tahun_now  
      );
    }
    
    $data = array(
      'page_title' => "List TPP Per Bulan",
      'module' => "Tpp_per_bulan",
      'view' => "vw_list_tpp_per_bulan",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }
}