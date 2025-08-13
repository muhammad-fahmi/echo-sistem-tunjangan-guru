<?php defined('BASEPATH') or exit('No direct script access allowed');

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

/**
 * @property Mdl_pdt_peserta_didik $mdl_peserta_didik
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Loader|MY_Loader $load
 */
class Pdt_peserta_didik extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();

    $is_ajax = $this->input->is_ajax_request();
    if (!$is_ajax) {
      $this->session->set_userdata('menu', 'PDT_PesertaDidik');
      if (!check_perm('read') || !is_logged_in()) {
        redirect(site_url('pangkalan_data'));
      }
    }

    $this->load->model('mdl_pdt_peserta_didik', 'mdl_peserta_didik');
  }

  public function index()
  {
    // lakukan proses init halaman
    $sent_data = array();
    $data = array(
      'page_title' => "Peserta Didik | PROGURINDA",
      'module' => "pdt_peserta_didik",
      'view' => "vw_peserta_didik_list",
      'data' => $sent_data
    );
    echo Modules::run('layout/backend', $data);
  }

  public function detail($encryptedID = '')
  {
    $decryptedID = decrypt_id(sanitize_string($encryptedID));

    // CEK VALIDASI DATA
    $dataset = fetch_row_data('v_progurinda_siswa', ['id_siswa' => $decryptedID], false);
    if ($dataset == false) {
      $this->session->set_userdata('flash_data', "Maaf, data Peserta Didik yang akan dilihat detailnya tidak valid.");
      redirect(site_url('pdt_peserta_didik'));
      return;
    }
    $getdata_from_rombel = fetch_row_data('v_peserta_didik_rombel', ['id_siswa' => $decryptedID], false);
    if ($dataset == false) {
      $this->session->set_userdata('flash_data', "Maaf, data Peserta Didik yang akan dilihat detailnya tidak valid.");
      redirect(site_url('pdt_peserta_didik'));
      return;
    }

    $dataset['id_siswa'] = encrypt_id($dataset['id_siswa']);
    $dataset['ket_jenjang'] = $getdata_from_rombel['ket_jenjang'];
    $dataset['ket_kelas'] = $getdata_from_rombel['ket_kelas'];
    $dataset['ket_sekolah'] = $getdata_from_rombel['ket_sekolah'];
    $dataset['nama_rombel'] = $getdata_from_rombel['nama_rombel'];

    $data = array(
      'page_title' => "Detail Data Peserta Didik | PROGURINDA",
      'module' => "pdt_peserta_didik",
      'view' => 'vw_peserta_didik_detail',
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  public function get_data()
  {
    // get index value
    $index = $this->input->post("order[0][column]");
    // insert datatable param to transfer
    $param = array(
      'start' => $this->input->post("start"),
      'length' => $this->input->post("length"),
      'order_column' => $this->input->post("columns[$index][data]"),
      'order_sort' => $this->input->post("order[0][dir]"),
      'search' => $this->input->post("search[value]"),
      'draw' => $this->input->post("draw"),
      /* additional data can be declared here */
    );
    // move the db operation to the designated models
    $result = $this->mdl_peserta_didik->get_datatable($param);
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
    $type = $this->input->post('type');
    $id = $this->input->post('id');
    $decryptedID = decrypt_id(sanitize_string($id));
    /// |----------------------------------------
    /// | DEFAULT VALUE
    /// |----------------------------------------
    $res = [
      'status' => false,
      'message' => "Sorry this feature is under development."
    ];

    /// |----------------------------------------
    /// | COMMANDS
    /// |----------------------------------------
    switch ($type) {
      case 'tambah_peserta_didik': {
          /// |----------------------------------------
          /// | INSERT DATA
          /// |----------------------------------------
          $dataset = [
            // 'id_siswa' => $this->mdl_peserta_didik->generate_id_siswa(),
            'id_siswa' => '',
            'nama' => '',
            'nisn' => '',
            'nik' => '',
            'jenis_kelamin' => '',
            'kode_agama' => '',
            'nama_ayah' => '',
            'nama_ibu' => '',
            'no_kk' => '',
            'alamat' => '',
            's_aktif' => '',
            'pdpd' => '',
            'type' => ''
          ];
          $data = [
            'modal_title' => "Tambah Data Siswa",
            'data' => $dataset,
          ];
          $res = [
            'status' => true,
            'message' => "Modal Tambah Data Siswa",
            'html' => $this->load->view('vw_peserta_didik_modal_save', $data, true)
          ];
          break;
        }
      case 'edit_peserta_didik': {
          /// |----------------------------------------
          /// | EDIT DATA
          /// |----------------------------------------
          $dataset = $this->mdl_peserta_didik->get('v_progurinda_siswa', "id_siswa = '$decryptedID'");
          $data = [
            'modal_title' => "Edit Data Siswa",
            'type' => $type,
            'data' => $dataset,
          ];
          $res = [
            'status' => true,
            'message' => "Modal Edit Data Siswa",
            'html' => $this->load->view('vw_peserta_didik_modal_save', $data, true)
          ];
          break;
        }
      case 'delete_peserta_didik': {
          /// |----------------------------------------
          /// | DELETE DATA
          /// |----------------------------------------
          $dataset = $this->mdl_peserta_didik->get('v_progurinda_siswa', "id_siswa = '$decryptedID'");
          if (isset_nn_nes($dataset)) {
            $data = [
              'modal_title' => "Hapus Data Siswa",
              'data' => $dataset,
            ];
            $res = [
              'status' => true,
              'message' => "Modal Hapus Data Siswa",
              'html' => $this->load->view('vw_peserta_didik_modal_delete', $data, true)
            ];
          }
          break;
        }
      case 'import_data_siswa': {
          $data = [
            'modal_title' => "Import Data Siswa",
          ];
          $res = [
            'status' => true,
            'message' => "Modal import data siswa.",
            'html' => $this->load->view('vw_peserta_didik_modal_import', $data, true)
          ];
          break;
        }
      default: {
          break;
        }
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }

  public function get_data()
  {
    // get index value
    $index = $this->input->post("order[0][column]");
    // insert datatable param to transfer
    $param = array(
      'start' => $this->input->post("start"),
      'length' => $this->input->post("length"),
      'order_column' => $this->input->post("columns[$index][data]"),
      'order_sort' => $this->input->post("order[0][dir]"),
      'search' => $this->input->post("search[value]"),
      'draw' => $this->input->post("draw"),
      /* additional data can be declared here */
    );
    // move the db operation to the designated models
    $result = $this->mdl_peserta_didik->get_datatable($param);
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

  public function save()
  {
    /// |----------------------------------------
    /// | AMBIL DATA POST
    /// |----------------------------------------
    $post = $this->input->post();

    // set data array utk proses insert
    $data_to_save = array(
      'id_siswa' => $post['id_siswa'],
      'nama' => $post['nama'],
      'nisn' => $post['nisn'],
      'nik' => $post['nik'],
      'jenis_kelamin' => $post['jenis_kelamin'],
      'kode_agama' => $post['kode_agama'],
      'nama_ayah' => $post['nama_ayah'],
      'nama_ibu' => $post['nama_ibu'],
      'no_kk' => $post['no_kk'],
      'alamat' => $post['alamat'],
      // 's_aktif' => $post['s_aktif'],
      's_aktif' => 1,
      'tgl_masuk' => em_date('Y-m-d'),
      'pdpd' => $post['pdpd_options'],
    );

    // Jika peserta didik di non-aktifkan, lanjutkan proses insert data
    // if ($data_to_save['s_aktif'] == 0) {
    //   $data_to_save['alasan_keluar'] = $post['alasan_keluar'];
    //   $data_to_save['tgl_keluar'] = em_date('Y-m-d');
    // }

    $res = $this->mdl_peserta_didik->save_peserta_didik($data_to_save);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }

  public function detail($encryptedID = '')
  {
    $decryptedID = decrypt_id(sanitize_string($encryptedID));

    // CEK VALIDASI DATA
    $dataset = fetch_row_data('v_progurinda_siswa', ['id_siswa' => $decryptedID], false);
    if ($dataset == false) {
      $this->session->set_userdata('flash_data', "Maaf, data Peserta Didik yang akan dilihat detailnya tidak valid.");
      redirect(site_url('pdt_peserta_didik'));
      return;
    }

    $dataset['id_siswa'] = encrypt_id($dataset['id_siswa']);

    $data = array(
      'page_title' => "Detail Data Peserta Didik | PROGURINDA",
      'module' => "pdt_peserta_didik",
      'view' => 'vw_peserta_didik_detail',
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  public function delete()
  {
    $res = [
      'status' => false,
      'message' => "Maaf, proses penghapusan data peserta didik gagal dilakukan!"
    ];

    $data["id_siswa"] = $this->input->post('id_siswa');
    $res = $this->mdl_peserta_didik->delete_peserta_didik($data);

    return $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($res));
  }

  public function preview_data()
  {
    if (empty($_FILES)) {
      var_dump("Tidak ada file yang diupload.");
    } else {
      $date_now = date('YmdHis');
      $file_name = 'import_siswa_' . $date_now . '.xlsx';
      $files = glob('uploads/' . '*');
      foreach ($files as $file) {
        if (is_file($file)) {
          unlink($file); // Delete file
        }
      }
      move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $file_name);

      $reader = new Xlsx();
      $spreadsheet = $reader->load('uploads/' . $file_name); // Load file yang tadi diupload ke folder tmp
      $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
      $data = [];
      array_shift($sheet); // Hapus header dari array

      $index = 0;
      $kosong = 0;
      foreach ($sheet as $row) { // Lakukan perulangan dari data yang ada di excel
        // Ambil data pada excel sesuai Kolom
        $nisn = $row['A']; // Ambil data NISN
        $nama = $row['B']; // Ambil data nama
        $nik = $row['C']; // Ambil data NIK
        $jenis_kelamin = $row['D']; // Ambil data jenis kelamin
        $agama = $row['E']; // Ambil data agama
        $nama_ayah = $row['F']; // Ambil data ayah
        $nama_ibu = $row['G']; // Ambil data ibu
        $no_kk = $row['H']; // Ambil data KK
        $alamat = $row['I']; // Ambil data alamat
        $disabilitas = $row['J']; // Ambil data disabilitas
        if ($nisn == '' || $nama == '' || $nik == '' || $jenis_kelamin == '' || $agama == '' || $nama_ayah == '' || $nama_ibu == '' || $no_kk == '' || $alamat == '' || $disabilitas == '') {
          $kosong++;
          $data[$index] = [
            'nisn' => $nisn,
            'nama' => $nama,
            'nik' => $nik,
            'jenis_kelamin' => $jenis_kelamin,
            'agama' => $agama,
            'nama_ayah' => $nama_ayah,
            'nama_ibu' => $nama_ibu,
            'no_kk' => $no_kk,
            'alamat' => $alamat,
            'disabilitas' => $disabilitas
          ];
        } else {
          $data[$index] = [
            'nisn' => $nisn,
            'nama' => $nama,
            'nik' => $nik,
            'jenis_kelamin' => $jenis_kelamin,
            'agama' => $agama,
            'nama_ayah' => $nama_ayah,
            'nama_ibu' => $nama_ibu,
            'no_kk' => $no_kk,
            'alamat' => $alamat,
            'disabilitas' => $disabilitas
          ];
        }

        $index++;
      }

      // Hapus file yang sudah diupload
      unlink('uploads/' . $file_name); // Hapus file yang sudah diupload

      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => true,
          'message' => "Preview data berhasil.",
          'data' => $data,
          'kosong' => $kosong,
        ]));
    }
  }

  public function import_data()
  {
    if (empty($_FILES)) {
      var_dump("Tidak ada file yang diupload.");
    } else {
      $date_now = date('YmdHis');
      $file_name = 'import_siswa_' . $date_now . '.xlsx';
      $files = glob('uploads/' . '*');
      foreach ($files as $file) {
        if (is_file($file)) {
          unlink($file); // Delete file
        }
      }
      move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $file_name);

      $reader = new Xlsx();
      $spreadsheet = $reader->load('uploads/' . $file_name); // Load file yang tadi diupload ke folder tmp
      $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
      $data = [];
      array_shift($sheet); // Hapus header dari array

      $index = 0;
      foreach ($sheet as $row) { // Lakukan perulangan dari data yang ada di excel
        // Ambil data pada excel sesuai Kolom
        $nisn = $row['A']; // Ambil data NISN
        $nama = $row['B']; // Ambil data nama
        $nik = $row['C']; // Ambil data NIK
        $jenis_kelamin = $row['D']; // Ambil data jenis kelamin
        $agama = $row['E']; // Ambil data agama
        $nama_ayah = $row['F']; // Ambil data ayah
        $nama_ibu = $row['G']; // Ambil data ibu
        $no_kk = $row['H']; // Ambil data KK
        $alamat = $row['I']; // Ambil data alamat
        $disabilitas = $row['J']; // Ambil data disabilitas

        if ($jenis_kelamin == 'Laki-laki') {
          $jenis_kelamin = 'L';
        } else if ($jenis_kelamin == 'Perempuan') {
          $jenis_kelamin = 'P';
        }

        if ($agama == 'Islam') {
          $agama = 1;
        } else if ($agama == 'Kristen') {
          $agama = 2;
        } else if ($agama == 'Katolik') {
          $agama = 3;
        } else if ($agama == 'Hindu') {
          $agama = 4;
        } else if ($agama == 'Buddha') {
          $agama = 5;
        } else if ($agama == 'Kepercayaan') {
          $agama = 6;
        } else {
          $agama = 7; // Default value for unknown agama
        }

        if ($disabilitas == "PD Intelektual/Grahita") {
          $disabilitas = 1;
        } else if ($disabilitas == "PD Netra") {
          $disabilitas = 2;
        } else if ($disabilitas == "PD Wicara") {
          $disabilitas = 3;
        } else if ($disabilitas == "PD Rungu") {
          $disabilitas = 4;
        } else if ($disabilitas == "PD Fisik/Daksa") {
          $disabilitas = 5;
        } else if ($disabilitas == "PD Mental") {
          $disabilitas = 6;
        } else {
          $disabilitas = 7;
        }

        $data[$index] = [
          'nisn' => $nisn,
          'nama' => $nama,
          'nik' => $nik,
          'jenis_kelamin' => $jenis_kelamin,
          'kode_agama' => $agama,
          'nama_ayah' => $nama_ayah,
          'nama_ibu' => $nama_ibu,
          'no_kk' => $no_kk,
          'alamat' => $alamat,
          'pdpd' => $disabilitas,
          's_aktif' => 1, // Set active status
          'tgl_masuk' => em_date('Y-m-d'),
        ];

        $this->mdl_peserta_didik->import_data($data[$index]);

        $index++;
      }

      return $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode([
          'status' => true,
          'message' => "Import data berhasil.",
          'data' => $data
        ]));
    }
  }
}
