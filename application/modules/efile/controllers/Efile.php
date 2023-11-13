<?php defined('BASEPATH') or exit('No direct script access allowed');

class Efile extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    // lakukan proses verifikasi user disini
    $this->load->model('mdl_efile');
  }

  public function index()
  {
    // lakukan proses init halaman
    show_404();
  }

  /**
   * Fungsi untuk membaca file yang sudah diupload
   * @param string $nip
   * @param string nama_efile
   * @param string display_name
   * @return blob
   */
  public function show($nip = '', $nama_efile = '', $display_name = '')
  {

    if (!isset_nn_nes($nip) || !isset_nn_nes($nama_efile)) {
      return $this->output
        ->set_status_header(200)
        ->set_content_type('text')
        ->set_output('UNAUTHORIZED ACCESS');
    } else {
      $filename_explode = explode('.', $nama_efile);
      $file_ext = $filename_explode[1];
      $filepath = $this->config->item('efile_path') . $nip . '/' . $nama_efile;
      if (file_exists($filepath)) {
        $content_type = ($file_ext == 'pdf')
          ? 'application/pdf'
          : $file_ext;
        return $this->output
          ->set_content_type($content_type)
          ->set_output(file_get_contents($filepath));
      } else {
        return $this->output
          ->set_status_header(200)
          ->set_content_type('text')
          ->set_output('FILE NOT FOUND OR FILE IS CORRUPTED');
      }
    }
    /*
    if ($id_dok == '' || $nama_efile == '') {
      show_404();
    } else {
      $data_dok = $this->mdl_efile->get('v_dok_sewa', array('id' => $id_dok));
      $filename_explode = explode('.', $nama_efile);
      $file_ext = $filename_explode[1];
      if ($data_dok) {
        $filepath = $this->config->item("upload_path") .
          "/$data_dok[nik_penyewa_baru]-$data_dok[id]/$nama_efile";
        if (file_exists($filepath)) {
          $content_type = ($file_ext == 'pdf')
            ? 'application/pdf'
            : $file_ext;
          $this->output
            ->set_content_type($content_type)
            ->set_output(file_get_contents($filepath));
        } else {
          show_404();
        }
      } else {
        show_404();
      }
    }
    */
  }
}
