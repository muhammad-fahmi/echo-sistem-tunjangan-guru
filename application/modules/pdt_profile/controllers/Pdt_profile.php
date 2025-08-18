<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pdt_profile extends MY_Controller
{
  /// |----------------------------------------------------------------------
  /// | >> CONSTRUCT
  /// |----------------------------------------------------------------------
  public function __construct()
  {
    parent::__construct();

    $is_ajax = $this->input->is_ajax_request();
    if (!$is_ajax) {
      $this->session->set_userdata('menu', 'PDT_AkunProfile');
      if (!is_logged_in()) {
        redirect(site_url('login'));
      }
    }

    $this->load->model('mdl_pdt_profile', 'mdl_pro');
  }

  /// |----------------------------------------------------------------------
  /// | >> PRIVATE FUNCTION
  /// |----------------------------------------------------------------------

  /// |----------------------------------------------------------------------
  /// | >> PAGE LOAD FUNCTION
  /// |----------------------------------------------------------------------
  public function index()
  {
    $profil = fetch_row_data('v_progurinda_user', ['id_user' => $this->session->userdata('id_user')], []);

    $data = array(
      'page_title' => "Profile | PROGURINDA",
      'module' => "pdt_profile",
      'view' => 'vw_profile',
      'data' => $profil
    );
    echo Modules::run('layout/backend', $data);
  }

  /// |----------------------------------------------------------------------
  /// | >> AJAX REQUEST FUNCTIONS
  /// |----------------------------------------------------------------------
  public function modal()
  {
    if (!is_logged_in()) return output_json([
      'status' => false,
      'message' => 'Maaf, Anda tidak memiliki permission utk memanggil modal pada modul ini.'
    ], 403);

    $id = $this->session->userdata('id_user');
    $action = post_safe('action');

    $res = [
      'status' => false,
      'message' => "Modal command tidak valid."
    ];

    switch ($action) {
      case 'ganti_password': {
          $data_user = fetch_row_data('v_progurinda_user', ['id_user' => $id], false);
          if (!$data_user) return $res;

          $modal_data = [
            'modal_title' => 'Ganti Password',
            'type' => 'ganti_password',
            'data' => $data_user
          ];

          $res = [
            'status' => true,
            'message' => "Modal utk ganti password user",
            'html' => $this->load->view('vwm_crud_profile', $modal_data, TRUE)
          ];
          break;
        }

      case 'update_profile': {
          $data_user = fetch_row_data('v_progurinda_user', ['id_user' => $id], false);
          if (!$data_user) return $res;

          $modal_data = [
            'modal_title' => 'Update Profile',
            'type' => 'update_profile',
            'data' => $data_user
          ];

          $res = [
            'status' => true,
            'message' => "Modal utk update profile user",
            'html' => $this->load->view('vwm_crud_profile', $modal_data, TRUE)
          ];
          break;
        }

      case 'upload_gambar': {
          $data_user = fetch_row_data('v_progurinda_user', ['id_user' => $id], false);
          if (!$data_user) return $res;

          $modal_data = [
            'modal_title' => 'Ganti Profile Image',
            'type' => 'upload_gambar',
            'data' => $data_user
          ];

          $res = [
            'status' => true,
            'message' => "Modal utk update gambar profile",
            'html' => $this->load->view('vwm_crud_profile', $modal_data, TRUE)
          ];
          break;
        }

      default:
        break;
    }

    return output_json($res);
  }

  public function save()
  {
    if (!is_logged_in()) return output_json([
      'status' => false,
      'message' => "Maaf, session tidak valid untuk melakukan update profile"
    ]);

    $post = post_safe();

    $response = $this->mdl_pro->update_profile($post);

    output_json($response);
  }

  public function get_data_profile()
  {
    if (!is_logged_in()) return output_json([
      'status' => false,
      'message' => "Maaf, session tidak valid lagi, mohon untuk login ulang."
    ]);

    $id_user = $this->session->userdata('id_user');

    // targik data user
    $dataset = fetch_row_data('v_progurinda_user', [
      'id_user' => $id_user
    ], false);
    $data_needed = ['username', 'no_hp', 'email_user'];
    foreach ($dataset as $key => $value) {
      if (!in_array($key, $data_needed)) unset($dataset[$key]);
    }

    if (!$dataset) return output_json([
      'status' => false,
      'message' => "Maaf, data profile user tidak valid"
    ]);

    return output_json([
      'status' => true,
      'message' => "Data profile berhasil diterima",
      'data' => $dataset
    ]);
  }

  public function upload_image()
  {
    if (!is_logged_in()) {
      return output_json([
        'status' => false,
        'message' => "Session tidak valid, tidak bisa melakukan upload gambar."
      ]);
    }

    $upload_path = $this->config->item('upload_path') . 'profile_image/';
    if (!is_dir($upload_path)) mkdir($upload_path, 0755, true);

    $timestamp = date('YmdHis');
    $random = generate_random_characters();
    $new_filename = $timestamp . '_' . $random;

    $config['upload_path'] = $upload_path;
    $config['allowed_types'] = 'jpg|jpeg|png|gif|webp';
    $config['file_name'] = $new_filename;
    $config['overwrite'] = false;

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('file')) {
      return output_json([
        'status' => false,
        'message' => "Maaf terjadi error saat proses upload gambar.\n" . $this->upload->display_errors('', '')
      ]);
    }

    $upload_data = $this->upload->data();
    $full_path = $upload_data['full_path']; // full server path
    $full_filename = $upload_data['file_name']; // with extension

    // Check if file size > 250KB, try compressing
    if (filesize($full_path) > 250 * 1024) {
      $type = strtolower($upload_data['image_type']);
      $type = str_replace('image/', '', $type);
      compress_image($full_path, $type);
    }

    $response = $this->mdl_pro->update_profile_img_to_DB($full_filename);

    return output_json($response);
  }

  public function image($filename = null)
  {
    $id_user = $this->session->userdata('id_user');
    if ($filename === null) {
      $userdata = fetch_row_data('v_progurinda_user', ['id_user' => $id_user], false);

      if (!$userdata || !is_logged_in()) return show_404();
      $filename = $userdata['profile_img'];
    } else {
      sanitize_string($filename);
    }

    // get the image
    $upload_file_path = $this->config->item('upload_path');
    $folder = $upload_file_path . 'profile_image/';
    $filepath = $folder . $filename;
    if (!file_exists($filepath)) return http_response_code(204);

    $mime = mime_content_type($filepath);
    if (strpos($mime, 'image/') !== 0) {
      return show_404();
    }

    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($filepath));
    header('Cache-Control: public, max-age=86400'); // Optional: for caching

    ob_clean();
    flush();
    readfile($filepath);
    exit;
  }
}
