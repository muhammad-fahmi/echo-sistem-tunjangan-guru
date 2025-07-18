<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pdt_profil_sekolah extends MY_Controller
{
  /// |----------------------------------------------------------------------
  /// | >> CONSTRUCT
  /// |----------------------------------------------------------------------
  public function __construct()
  {
    parent::__construct();

    $is_ajax = $this->input->is_ajax_request();
    if (!$is_ajax) {
      $this->session->set_userdata('menu', 'PDT_ProfilSekolah');
      if (!check_perm('read') || !is_logged_in()) {
        redirect(site_url('pangkalan_data'));
      }
    }

    $this->load->model('mdl_pdt_profil_sekolah', 'mdl_profsekolah');
  }

  /// |----------------------------------------------------------------------
  /// | >> PRIVATE FUNCTION
  /// |----------------------------------------------------------------------

  /// |----------------------------------------------------------------------
  /// | >> PAGE LOAD FUNCTION
  /// |----------------------------------------------------------------------
  public function index()
  {
    $sent_data = [];

    $data = array(
      'page_title' => "Profil Sekolah | PROGURINDA",
      'module' => "pdt_profil_sekolah",
      'view' => 'vw_list_profil_sekolah',
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  public function edit($encryptedID = '')
  {
    $decryptedID = decrypt_id(sanitize_string($encryptedID));

    // CEK VALIDASI DATA
    $dataset = fetch_row_data('vr_profil_sekolah', ['id_dokumen' => $decryptedID], false);
    if ($dataset == false) {
      $this->session->set_userdata('flash_data', "Maaf, data dokumen usulan Profil Sekolah yang akan di-edit tidak valid.");
      redirect(site_url('pdt_profil_sekolah'));
      return;
    }

    $dataset['id_dokumen'] = encrypt_id($dataset['id_dokumen']);
    $dataset['id_kepsek'] = encrypt_id($dataset['id_kepsek']);

    // CEK STATUS DOKUMEN
    if ($dataset['status_dokumen'] != 'DRAFT') {
      $this->session->set_userdata('flash_data', "Maaf, data dokumen usulan Profil Sekolah hanya bisa di-edit apabila statusnya adalah Draft.");
      redirect(site_url('pdt_profil_sekolah'));
      return;
    }

    $data = array(
      'page_title' => "Edit Usulan Profil | PROGURINDA",
      'module' => "pdt_profil_sekolah",
      'view' => 'vw_edit_profil_sekolah',
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  public function detail($encryptedID = '')
  {
    $decryptedID = decrypt_id(sanitize_string($encryptedID));

    // CEK VALIDASI DATA
    $dataset = fetch_row_data('vr_profil_sekolah', ['id_dokumen' => $decryptedID], false);
    if ($dataset == false) {
      $this->session->set_userdata('flash_data', "Maaf, data dokumen usulan Profil Sekolah yang akan dilihat detailnya tidak valid.");
      redirect(site_url('pdt_profil_sekolah'));
      return;
    }

    $dataset['id_dokumen'] = encrypt_id($dataset['id_dokumen']);
    $dataset['id_kepsek'] = encrypt_id($dataset['id_kepsek']);

    $data = array(
      'page_title' => "Detail Usulan Profil | PROGURINDA",
      'module' => "pdt_profil_sekolah",
      'view' => 'vw_detail_profil_sekolah',
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  public function detail_master($kode_ukerja = '')
  {
    $kode_ukerja = sanitize_string($kode_ukerja);

    // CEK VALIDASI DATA
    $dataset = fetch_row_data('vm_profil_sekolah', ['kode_ukerja' => $kode_ukerja], false);
    if ($dataset == false) {
      $this->session->set_userdata('flash_data', "Maaf, data Profil Sekolah yang akan dilihat detailnya tidak valid.");
      redirect(site_url('pdt_profil_sekolah'));
      return;
    }

    $dataset['id_dokumen'] = encrypt_id($dataset['id_dokumen']);
    $dataset['id_kepsek'] = encrypt_id($dataset['id_kepsek']);

    $data = array(
      'page_title' => "Detail Profil | PROGURINDA",
      'module' => "pdt_profil_sekolah",
      'view' => 'vw_detail_master_profil_sekolah',
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  /// |----------------------------------------------------------------------
  /// | >> AJAX REQUEST FUNCTIONS
  /// |----------------------------------------------------------------------
  public function get_data_master()
  {
    /// |----------------------------------------
    /// | CEK PERMISSION
    /// |----------------------------------------
    if (!check_perm('read', 'PDT_ProfilSekolah')) return output_json([
      'status' => false,
      'message' => 'Maaf, tidak memiliki permission utk membaca daftar Profil Sekolah'
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
      'f_ukerja' => post_safe('f_ukerja')
    );
    // move the db operation to the designated models
    $result = $this->mdl_profsekolah->get_datatable_master($param);
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

  public function get_data_usulan()
  {
    /// |----------------------------------------
    /// | CEK PERMISSION
    /// |----------------------------------------
    if (!check_perm('read', 'PDT_ProfilSekolah')) return output_json([
      'status' => false,
      'message' => 'Maaf, tidak memiliki permission utk membaca daftar Profil Sekolah'
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
      'f_ukerja' => post_safe('f_ukerja'),
      'f_periode_bln' => post_safe('f_periode_bln'),
      'f_periode_thn' => post_safe('f_periode_thn')
    );
    // move the db operation to the designated models
    $result = $this->mdl_profsekolah->get_datatable_usulan($param);
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

  public function modal()
  {
    $action = post_safe('action');
    $id = post_safe('id');

    switch ($action) {
      case 'tambah_usulan_profil': {
          // CHECK PERMISSION
          if (!check_perm('insert', 'PDT_ProfilSekolah')) return output_json([
            'status' => false,
            'message' => 'invalid permissions'
          ], 403);

          // CHECK EXISTING PROFIL
          if (!is_admin()) {
            $cur_unor = $this->session->userdata('kode_unor');
            $existing = fetch_num_rows('m_profil_sekolah', [
              'kode_ukerja' => $cur_unor
            ]);
            if ($existing > 0) return output_json([
              'status' => false,
              'message' => "Maaf, sudah ada profil sekolah yang terverifikasi, silahkan lakukan update pada profil tersebut."
            ]);
          }

          $sent_data = [
            'modal_title' => 'Tambah Profil Sekolah',
            'type' => 'add',
            'data' => [],
          ];

          return output_json([
            'status' => true,
            'message' => 'modal tambah Profil Sekolah retrieved.',
            'html' => $this->load->view('vwm_crud_profil_sekolah', $sent_data, TRUE)
          ]);
          break;
        }

      case 'hapus_usulan_profil': {
          // CHECK PERMISSION
          if (!check_perm('delete', 'PDT_ProfilSekolah')) return output_json([
            'status' => false,
            'message' => 'invalid permissions'
          ], 403);

          $decryptedID = decrypt_id($id);
          $dataset = fetch_row_data('vr_profil_sekolah', ['id_dokumen' => $decryptedID], false);

          // VALIDASI DATA USULAN PROFIL
          if ($dataset === false) return output_json([
            'status' => false,
            'message' => "Maaf, data yang akan di-hapus tidak valid."
          ]);

          // encrypt data yang dikirim ke view
          $dataset['id_dokumen'] = encrypt_id($dataset['id_dokumen']);
          $dataset['id_kepsek'] = encrypt_id($dataset['id_kepsek']);

          // VALIDASI STATUS USULAN PROFIL
          if ($dataset['status_dokumen'] != 'DRAFT') return output_json([
            'status' => false,
            'message' => "Maaf, status usulan profil ini bukan DRAFT, tidak bisa menghapus data tersebut."
          ]);

          // LOAD VIEW
          $sent_data = [
            'modal_title' => 'Hapus Profil Sekolah',
            'type' => 'delete',
            'data' => $dataset,
          ];

          return output_json([
            'status' => true,
            'message' => 'modal hapus Profil Sekolah retrieved.',
            'html' => $this->load->view('vwm_crud_profil_sekolah', $sent_data, TRUE)
          ]);
          break;
        }

      case 'update_existing_profil': {
          // CHECK PERMISSION
          if (!check_perm('update', 'PDT_ProfilSekolah')) return output_json([
            'status' => false,
            'message' => 'invalid permissions'
          ], 403);

          $dataset = fetch_row_data('vm_profil_sekolah', ['kode_ukerja' => $id], false);

          // VALIDASI DATA PROFIL EXISTING
          if ($dataset === false) return output_json([
            'status' => false,
            'message' => "Maaf, data Profil Sekolah yang akan di-update tidak valid lagi."
          ]);

          // LOAD VIEW
          $sent_data = [
            'modal_title' => 'Update Profil Sekolah',
            'type' => 'update',
            'data' => $dataset
          ];

          return output_json([
            'status' => true,
            'message' => "modal update existing Profil Sekolah retrieved.",
            'html' => $this->load->view('vwm_crud_profil_sekolah', $sent_data, TRUE)
          ]);
          break;
        }

      default:
        return output_json([
          'status' => false,
          'message' => 'Invalid modal command.'
        ]);
        break;
    }
  }

  public function save()
  {
    $type = post_safe('type');

    if ($type == 'add') {
      // CHECK PERMISSION
      if (!check_perm('insert', 'PDT_ProfilSekolah')) return output_json([
        'status' => false,
        'message' => 'invalid permissions'
      ], 403);
    } else {
      // CHECK PERMISSION
      if (!check_perm('update', 'PDT_ProfilSekolah')) return output_json([
        'status' => false,
        'message' => 'invalid permissions'
      ], 403);
    }

    $post = post_safe();

    switch ($type) {
      case 'add':
        $response = $this->mdl_profsekolah->tambah_profil_sekolah($post);
        break;

      case 'edit':
        $response = $this->mdl_profsekolah->edit_profil_sekolah($post);
        break;

      case 'update':
        $response = $this->mdl_profsekolah->update_profil_sekolah($post);
        break;

      default:
        return output_json([
          'status' => false,
          'message' => 'invalid save type'
        ], 400);
        break;
    }

    return output_json($response);
  }

  public function delete()
  {
    // CHECK PERMISSION
    if (!check_perm('delete', 'PDT_ProfilSekolah')) return output_json([
      'status' => false,
      'message' => 'invalid permissions'
    ], 403);

    $post = post_safe();

    $response = $this->mdl_profsekolah->delete_profil_sekolah($post);

    return output_json($response);

    // DEBUG
    return output_json([
      'status' => false,
      'message' => 'DEBUG MESSAGE',
      'data' => $post
    ]);
  }

  public function edit_draft()
  {
    // CHECK PERMISSION
    if (!check_perm('update', 'PDT_ProfilSekolah')) return output_json([
      'status' => false,
      'message' => 'invalid permissions'
    ], 403);

    $post = post_safe();

    $response = $this->mdl_profsekolah->edit_profil_sekolah($post);

    return output_json($response);

    // DEBUG
    return output_json([
      'status' => false,
      'message' => 'DEBUG EDIT DRAFT : PDT_ProfilSekolah',
      'data' => $post
    ]);
  }

  public function submit_draft()
  {
    // CHECK PERMISSION
    if (!check_perm('update', 'PDT_ProfilSekolah')) return output_json([
      'status' => false,
      'message' => 'invalid permissions'
    ], 403);

    $post = post_safe();

    $response = $this->mdl_profsekolah->submit_profil_sekolah($post);

    return output_json($response);

    // DEBUG
    return output_json([
      'status' => false,
      'message' => 'DEBUG SUBMIT DRAFT : PDT_ProfilSekolah',
      'data' => $post
    ]);
  }
}
