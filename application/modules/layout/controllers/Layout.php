<?php defined('BASEPATH') or exit('No direct script access allowed');

class Layout extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    // do something in index
    show_404();
  }

  private function data_check($data)
  {
    if ($data != null) {
      $newdata = $data;
      $module = $data['module'] ?? 'layout';
      $view = $data['view'] ?? 'vw_error_404';
      $page_title = $data['page_title'] ?? '______';
      $view_page = "$module/$view";
      $newdata['page_title'] = $page_title;
      $newdata['view'] = $view_page;
      return $newdata;
    } else {
      return false;
    }
  }

  public function portal($data = null)
  {
    $new_data = $this->data_check($data);
    if ($new_data) {
      $this->load->view('vw_portal', $new_data);
    } else {
      show_404();
    }
  }

  public function portal_menu($data = null)
  {
    $new_data = $this->data_check($data);
    if ($new_data) {
      $this->load->view('vw_portal_menu', $new_data);
    } else {
      show_404();
    }
  }

  public function frontend($data = null)
  {
    $new_data = $this->data_check($data);
    if ($new_data) {
      $this->load->view('vw_frontend', $new_data);
    } else {
      show_404();
    }
  }

  public function backend($data = null)
  {
    $new_data = $this->data_check($data);
    if ($new_data) {
      $this->load->view('vw_backend', $new_data);
    } else {
      show_404();
    }
  }

  public function underconstruction()
  {
    $this->load->view('vw_underconstruction');
  }
}
