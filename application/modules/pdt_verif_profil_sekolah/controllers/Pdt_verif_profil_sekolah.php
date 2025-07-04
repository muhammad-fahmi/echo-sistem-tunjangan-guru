<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pdt_verif_profil_sekolah extends MY_Controller
{
  /// |----------------------------------------------------------------------
  /// | >> CONSTRUCT
  /// |----------------------------------------------------------------------
  public function __construct()
  {
    parent::__construct();

    $is_ajax = $this->input->is_ajax_request();
    if (!$is_ajax) {
      $this->session->set_userdata('menu', 'PDT_VerifProfilSekolah');
      if (!check_perm('read')) {
        redirect(site_url('pangkalan_data'));
      }
    }

    $this->load->model('mdl_pdt_verif_profil_sekolah', 'mdl_vrfprofsekolah');
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
      'page_title' => "Verifikasi Profil Sekolah | PROGURINDA",
      'module' => "pdt_verif_profil_sekolah",
      'view' => 'vw_list_verif_ps',
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  public function verif($encryptedID = '')
  {
    $decryptedID = decrypt_id(sanitize_string($encryptedID));

    // CEK VALIDASI DATA
    $dataset = fetch_row_data('vr_profil_sekolah', ['id_dokumen' => $decryptedID], false);
    if ($dataset == false) {
      $this->session->set_userdata('flash_data', "Maaf, data dokumen usulan Profil Sekolah yang akan di-verifikasi tidak valid.");
      redirect(site_url('pdt_verif_profil_sekolah'));
      return;
    }

    // TARIK DATA VERIFIED (M_PROFIL)
    $data_ori = fetch_row_data('vm_profil_sekolah', ['kode_ukerja' => $dataset['kode_ukerja']], []);

    $dataset['id_dokumen'] = encrypt_id($dataset['id_dokumen']);
    $dataset['id_kepsek'] = encrypt_id($dataset['id_kepsek']);

    // CEK STATUS DOKUMEN
    if ($dataset['status_dokumen'] != 'VRFDD') {
      $this->session->set_userdata('flash_data', "Maaf, data dokumen usulan Profil Sekolah hanya bisa di-verifikasi apabila statusnya adalah Verifikasi Disdik.");
      redirect(site_url('pdt_verif_profil_sekolah'));
      return;
    }

    $data = array(
      'page_title' => "Verifikasi Usulan Profil Sekolah | PROGURINDA",
      'module' => "pdt_verif_profil_sekolah",
      'view' => 'vw_verifikasi_verif_ps',
      'data' => $data_ori,
      'dokumen' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  public function detail($encryptedID = '')
  {
    $decryptedID = decrypt_id(sanitize_string($encryptedID));
    $cur_unor = $this->session->userdata('kode_unor');

    // CEK VALIDASI DATA
    $dataset = fetch_row_data('vr_profil_sekolah', ['id_dokumen' => $decryptedID], false);
    if ($dataset == false) {
      $this->session->set_userdata('flash_data', "Maaf, data dokumen usulan Profil Sekolah yang akan dilihat detailnya tidak valid.");
      redirect(site_url('pdt_verif_profil_sekolah'));
      return;
    }

    // CEK PERM
    $same_ukerja = ($dataset['kode_ukerja'] == $cur_unor);
    if (!is_admin() && !$same_ukerja) {
      $this->session->set_userdata('flash_data', "Maaf, Anda tidak memiliki ijin untuk melihat data Profil Sekolah tersebut.");
      redirect(site_url('pdt_verif_profil_sekolah'));
      return;
    }

    $dataset['id_dokumen'] = encrypt_id($dataset['id_dokumen']);
    $dataset['id_kepsek'] = encrypt_id($dataset['id_kepsek']);

    $data = array(
      'page_title' => "Detail Usulan Profil Sekolah | PROGURINDA",
      'module' => "pdt_verif_profil_sekolah",
      'view' => 'vw_detail_verif_ps',
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  /// |----------------------------------------------------------------------
  /// | >> AJAX REQUEST FUNCTIONS
  /// |----------------------------------------------------------------------
  public function get_data()
  {
    /// |----------------------------------------
    /// | CEK PERMISSION
    /// |----------------------------------------
    if (!check_perm('read', 'PDT_VerifProfilSekolah')) return output_json([
      'status' => false,
      'message' => 'Maaf, tidak memiliki permission utk membaca daftar Verifikasi Profil Sekolah'
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
      'is_history' => post_safe('is_history')
    );
    // move the db operation to the designated models
    $result = $this->mdl_vrfprofsekolah->get_datatable($param);
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

  public function do_verif()
  {
    if (!check_perm('verif', 'PDT_ProfilSekolah')) return output_json([
      'status' => false,
      'message' => 'invalid permissions'
    ], 403);

    $post = post_safe();

    $response = $this->mdl_vrfprofsekolah->verif_profil_sekolah($post);

    return output_json($response);
  }
}
