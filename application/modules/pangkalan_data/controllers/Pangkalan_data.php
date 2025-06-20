<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pangkalan_data extends MY_Controller
{
  /// |----------------------------------------------------------------------
  /// | >> CONSTRUCT
  /// |----------------------------------------------------------------------
  public function __construct()
  {
    parent::__construct();

    $is_ajax = $this->input->is_ajax_request();
    if (!$is_ajax) {
      $this->session->set_userdata('menu', 'PDT_Dashboard');
      if (!check_perm('read')) {
        redirect(site_url('login'));
      }
    }

    $this->load->model('mdl_pangkalan_data', 'mdl_pkldata');
  }

  /// |----------------------------------------------------------------------
  /// | >> PRIVATE FUNCTION
  /// |----------------------------------------------------------------------

  /// |----------------------------------------------------------------------
  /// | >> PAGE LOAD FUNCTION
  /// |----------------------------------------------------------------------
  public function index()
  {
    $cur_kewenangan = $this->session->userdata('kewenangan');
    if (in_array($cur_kewenangan, ['00', '02'])) {
      $view = 'vw_dashboard_admin';
      $sent_data = [];
    } else {
      $view = 'vw_dashboard_sekolah';
      $kode_unor = $this->session->userdata('kode_unor');
      $ukerja_simpeg = fetch_row_data('m_ukerja', ['kode_ukerja' => $kode_unor], false);
      $ukerja_profil = fetch_row_data('m_profil_sekolah', ['kode_ukerja' => $kode_unor], false);
      $sent_data = [];
      if ($ukerja_profil !== false) {
        $sent_data = $ukerja_profil;
      } else if ($ukerja_simpeg !== false) {
        $sent_data = $ukerja_simpeg;
      }
    }

    $data = array(
      'page_title' => "Dashboard Pangkalan Data | PROGURINDA",
      'module' => "pangkalan_data",
      'view' => $view,
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  /// |----------------------------------------------------------------------
  /// | >> AJAX REQUEST FUNCTIONS
  /// |----------------------------------------------------------------------
}
