<?php defined('BASEPATH') or exit('No direct script access allowed');

class Portal extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();
    $log = $this->session->userdata('logged_in');
    $user = $this->session->userdata('username');
    $kewenangan = $this->session->userdata('kewenangan');
    if ($log != true) {
      redirect(site_url('login'));
    } else {
      $this->load->model('mdl_portal', 'user');
    }
  }

  public function index()
  {
    $this->session->set_userdata('menu', 'user');
    $sent_data = array(
      'm_user' => $this->user->get('m_user'),
    );
    $data = array(
      'page_title' => "Portal PROGURINDA",
      'module' => "portal",
      'view' => "vw_portal_",
      'data' => $sent_data
    );
    echo Modules::run('layout/portal', $data);
  }
}
