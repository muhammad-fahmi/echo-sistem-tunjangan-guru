<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pdt_profil_kepsek extends MY_Controller
{
  /// |----------------------------------------------------------------------
  /// | >> CONSTRUCT
  /// |----------------------------------------------------------------------
  public function __construct()
  {
    parent::__construct();

    $is_ajax = $this->input->is_ajax_request();
    if (!$is_ajax) {
      $this->session->set_userdata('menu', 'PDT_ProfilKepsek');
      if (!check_perm('read')) {
        redirect(site_url('pangkalan_data'));
      }
    }

    $this->load->model('mdl_pdt_profil_kepsek', 'mdl_profkepsek');
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
      'page_title' => "Profil Kepala Sekolah | PROGURINDA",
      'module' => "pdt_profil_kepsek",
      'view' => 'vw_list_profil_kepsek',
      'data' => $sent_data
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
    if (!check_perm('read', 'PDT_ProfilKepsek')) return output_json([
      'status' => false,
      'message' => 'Maaf, tidak memiliki permission utk membaca daftar profil kepala sekolah'
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
    $result = $this->mdl_profkepsek->get_datatable_master($param);
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
    if (!check_perm('read', 'PDT_ProfilKepsek')) return output_json([
      'status' => false,
      'message' => 'Maaf, tidak memiliki permission utk membaca daftar profil kepala sekolah'
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
    $result = $this->mdl_profkepsek->get_datatable_usulan($param);
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
          if (!check_perm('insert', 'PDT_ProfilKepsek')) return output_json([
            'status' => false,
            'message' => 'invalid permissions'
          ], 403);

          $sent_data = [
            'modal_title' => 'Tambah Profil Kepala Sekolah',
            'type' => 'add',
            'data' => [],
          ];

          return output_json([
            'status' => true,
            'message' => 'modal tambah profil kepala sekolah retrieved.',
            'html' => $this->load->view('vwm_crud_profil_kepsek', $sent_data, TRUE)
          ]);
          break;
        }

      case 'edit_usulan_profil': {
          // CHECK PERMISSION
          if (!check_perm('update', 'PDT_ProfilKepsek')) return output_json([
            'status' => false,
            'message' => 'invalid permissions'
          ], 403);

          $dataset = fetch_row_data('vr_profil_kepsek', ['id_dokumen' => $id], false);

          // VALIDASI DATA USULAN PROFIL
          if ($dataset === false) return output_json([
            'status' => false,
            'message' => "Maaf, data yang akan di-edit tidak valid."
          ]);

          // VALIDASI STATUS USULAN PROFIL
          if ($dataset['status_dokumen'] != 'DRAFT') return output_json([
            'status' => false,
            'message' => "Maaf, status usulan profil ini bukan DRAFT, tidak bisa mengedit data tersebut."
          ]);

          // LOAD VIEW
          $sent_data = [
            'modal_title' => 'Edit Profil Kepala Sekolah',
            'type' => 'edit',
            'data' => $dataset,
          ];

          return output_json([
            'status' => true,
            'message' => 'modal edit profil kepala sekolah retrieved.',
            'html' => $this->load->view('vwm_crud_profil_kepsek', $sent_data, TRUE)
          ]);
          break;
        }

      case 'hapus_usulan_profil': {
          // CHECK PERMISSION
          if (!check_perm('delete', 'PDT_ProfilKepsek')) return output_json([
            'status' => false,
            'message' => 'invalid permissions'
          ], 403);

          $dataset = fetch_row_data('vr_profil_kepsek', ['id_dokumen' => $id], false);

          // VALIDASI DATA USULAN PROFIL
          if ($dataset === false) return output_json([
            'status' => false,
            'message' => "Maaf, data yang akan di-hapus tidak valid."
          ]);

          // VALIDASI STATUS USULAN PROFIL
          if ($dataset['status_dokumen'] != 'DRAFT') return output_json([
            'status' => false,
            'message' => "Maaf, status usulan profil ini bukan DRAFT, tidak bisa menghapus data tersebut."
          ]);

          // LOAD VIEW
          $sent_data = [
            'modal_title' => 'Hapus Profil Kepala Sekolah',
            'type' => 'delete',
            'data' => $dataset,
          ];

          return output_json([
            'status' => true,
            'message' => 'modal hapus profil kepala sekolah retrieved.',
            'html' => $this->load->view('vwm_crud_profil_kepsek', $sent_data, TRUE)
          ]);
          break;
        }

      case 'update_existing_profil': {
          // CHECK PERMISSION
          if (!check_perm('update', 'PDT_ProfilKepsek')) return output_json([
            'status' => false,
            'message' => 'invalid permissions'
          ], 403);

          $dataset = fetch_row_data('vm_profil_kepsek', ['id_kepsek' => $id], false);

          // VALIDASI DATA PROFIL EXISTING
          if ($dataset === false) return output_json([
            'status' => false,
            'message' => "Maaf, data profil kepala sekolah yang akan di-update tidak valid lagi."
          ]);

          // VALIDASI DATA USULAN UPDATE YANG MASIH ONGOING
          $data_ongoing = fetch_row_data(
            'vr_profil_kepsek',
            "`id_kepsek` = '$id' AND (" .
              "`status_dokumen` <> 'DITRM' AND " .
              "`status_dokumen` <> 'DITLK'" .
              ")",
            false
          );

          if ($data_ongoing !== false) return output_json([
            'status' => false,
            'message' => "Maaf, tidak bisa mengajukan usulan update lagi karena masih ada dokumen usulan update yang belum selesai prosesnya.<ul class=\"mb-0\">" .
              "<li>Nama: " . check_var($data_ongoing, 'nama', '-') . "</li>" .
              "<li>NIP: " . check_var($data_ongoing, 'nip', '-') . "</li>" .
              "<li>Periode: " . check_var($data_ongoing, 'periode_bln', '00') . "/" . check_var($data_ongoing, 'periode_thn', '0000') . "</li>" .
              "<li>Status: " . check_var($data_ongoing, 'ket_status_dokumen', '-') . "</li>" .
              "</ul>"
          ]);

          // LOAD VIEW
          $sent_data = [
            'modal_title' => '',
            'type' => 'update',
            'data' => $dataset
          ];

          return output_json([
            'status' => true,
            'message' => "modal update existing profil kepala sekolah retrieved.",
            'html' => $this->load->view('vwm_crud_profil_kepsek', $sent_data, TRUE)
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
      if (!check_perm('insert', 'PDT_ProfilKepsek')) return output_json([
        'status' => false,
        'message' => 'invalid permissions'
      ], 403);
    } else {
      // CHECK PERMISSION
      if (!check_perm('update', 'PDT_ProfilKepsek')) return output_json([
        'status' => false,
        'message' => 'invalid permissions'
      ], 403);
    }

    $post = post_safe();

    switch ($type) {
      case 'add':
        $response = $this->mdl_profkepsek->tambah_profil_kepsek($post);
        break;

      case 'edit':
        $response = $this->mdl_profkepsek->edit_profil_kepsek($post);
        break;

      case 'update':
        $response = $this->mdl_profkepsek->update_profil_kepsek($post);
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
    if (!check_perm('delete', 'PDT_ProfilKepsek')) return output_json([
      'status' => false,
      'message' => 'invalid permissions'
    ], 403);

    $post = post_safe();

    // DEBUG
    return output_json([
      'status' => false,
      'message' => 'DEBUG MESSAGE',
      'data' => $post
    ]);
  }
}
