<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pdt_manajemen_perm extends MY_Controller
{
  /// |----------------------------------------------------------------------
  /// | >> CONSTRUCT
  /// |----------------------------------------------------------------------
  public function __construct()
  {
    parent::__construct();

    $is_ajax = $this->input->is_ajax_request();
    if (!$is_ajax) {
      $this->session->set_userdata('menu', 'PDT_ManajemenPerm');
      if (!is_super_admin() || !is_logged_in()) {
        redirect(site_url('login'));
      }
    }

    $this->load->model('mdl_pdt_manajemen_perm', 'mdl_mp');
  }

  /// |----------------------------------------------------------------------
  /// | >> PRIVATE FUNCTION
  /// |----------------------------------------------------------------------

  /// |----------------------------------------------------------------------
  /// | >> PAGE LOAD FUNCTION
  /// |----------------------------------------------------------------------
  public function index()
  {
    $data = array(
      'page_title' => "Hak Akses | PROGURINDA",
      'module' => "pdt_manajemen_perm",
      'view' => 'vw_manajemen_perm',
      'data' => []
    );
    echo Modules::run('layout/backend', $data);
  }

  /// |----------------------------------------------------------------------
  /// | >> AJAX REQUEST FUNCTIONS
  /// |----------------------------------------------------------------------
  public function modal()
  {
    if (!is_super_admin()) return output_json([
      'status' => false,
      'message' => 'Maaf, Anda tidak memiliki permission utk memanggil modal pada modul ini.'
    ], 403);

    $id = post_safe('id');
    $action = post_safe('action');

    $res = [
      'status' => false,
      'message' => "Modal command tidak valid."
    ];

    switch ($action) {
      case 'tambah_kewenangan': {
          $modal_data = [
            'modal_title' => 'Tambah Kewenangan Baru',
            'type' => 'add',
            'data' => []
          ];

          $res = [
            'status' => true,
            'message' => "Modal utk tambah kewenangan baru",
            'html' => $this->load->view('vwm_crud_kewenangan', $modal_data, TRUE)
          ];
          break;
        }

      case 'edit_kewenangan': {
          /// |----------------------------------------
          /// | PASTIKAN DATA KEWENANGAN EXIST
          /// |----------------------------------------
          $is_exist = fetch_row_data('m_kewenangan', ['id_kewenangan' => $id], false);
          if (!$is_exist) return [
            'status' => false,
            'message' => "Data yang akan di-edit tidak valid.\nCoba refresh halaman."
          ];

          $modal_data = [
            'modal_title' => 'Edit Kewenangan',
            'type' => 'edit',
            'data' => $is_exist
          ];

          $res = [
            'status' => true,
            'message' => "Modal utk edit kewenangan",
            'html' => $this->load->view('vwm_crud_kewenangan', $modal_data, TRUE)
          ];
          break;
        }

      case 'hapus_kewenangan': {
          /// |----------------------------------------
          /// | PASTIKAN DATA KEWENANGAN EXIST
          /// |----------------------------------------
          $is_exist = fetch_row_data('m_kewenangan', ['id_kewenangan' => $id], false);
          if (!$is_exist) return [
            'status' => false,
            'message' => "Data yang akan di-hapus tidak valid.\nCoba refresh halaman."
          ];

          $modal_data = [
            'modal_title' => 'Hapus Kewenangan',
            'type' => 'delete',
            'data' => $is_exist
          ];

          $res = [
            'status' => true,
            'message' => "Modal utk hapus kewenangan",
            'html' => $this->load->view('vwm_crud_kewenangan', $modal_data, TRUE)
          ];

          break;
        }

      default:
        break;
    }

    output_json($res);
  }

  public function get_data()
  {
    /// |----------------------------------------
    /// | CEK PERMISSION
    /// |----------------------------------------
    if (!is_super_admin()) return output_json([
      'status' => false,
      'message' => 'Maaf, tidak memiliki permission utk membaca daftar kewenangan.'
    ], 403);

    /// |----------------------------------------
    /// | DATATABLE PARAMS
    /// |----------------------------------------
    $index = post_safe("order[0][column]");
    // insert datatable param to transfer
    $param = array(
      'start' => post_safe("start"),
      'length' => post_safe("length"),
      'order_column' => post_safe("columns[$index][data]"),
      'order_sort' => post_safe("order[0][dir]"),
      'search' => post_safe("search[value]"),
      'draw' => post_safe("draw"),
      /* additional data can be declared here */
    );
    // move the db operation to the designated models
    $result = $this->mdl_mp->get_datatable($param);
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

  public function get_kewenangan_menu()
  {
    /// |----------------------------------------
    /// | CEK PERMISSION
    /// |----------------------------------------
    if (!is_super_admin()) return output_json([
      'status' => false,
      'message' => 'Maaf, tidak memiliki permission utk membaca daftar kewenangan.'
    ], 403);

    $selected_kewenangan = post_safe('id_kewenangan');

    $response = $this->mdl_mp->get_kewenangan_menu($selected_kewenangan);

    return output_json($response);
  }

  public function save_kewenangan()
  {
    if (!is_super_admin()) return output_json([
      'status' => false,
      'message' => 'Maaf, Anda tidak memiliki permission utk melakukan modifikasi pada data kewenangan.'
    ], 403);

    $post = post_safe();

    $response = $this->mdl_mp->save_kewenangan($post);

    return output_json($response);
  }

  public function delete_kewenangan()
  {
    if (!is_super_admin()) return output_json([
      'status' => false,
      'message' => 'Maaf, Anda tidak memiliki permission utk menghapus data kewenangan.'
    ], 403);

    $post = post_safe();

    $response = $this->mdl_mp->delete_kewenangan($post);

    return output_json($response);
  }

  public function save_hak_akses()
  {
    if (!is_super_admin()) return output_json([
      'status' => false,
      'message' => 'Maaf, Anda tidak memiliki permission utk melakukan modifikasi pada hak akses kewenangan.'
    ], 403);

    $post = post_safe();

    if ($post['error'] == 'YES') return output_json([
      'status' => false,
      'message' => "Maaf, tidak bisa melanjutkan proses karena daftar menu tidak valid."
    ]);

    $cleaned_post = clean_empty_or_all_no_permissions($post);

    $response = $this->mdl_mp->save_hak_akses($cleaned_post);

    return output_json($response);
  }
}
