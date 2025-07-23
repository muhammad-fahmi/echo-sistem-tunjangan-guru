<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Shared\Drawing as DrawingHelper;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

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
      if (!check_perm('read') || !is_logged_in()) {
        redirect(site_url('pangkalan_data'));
      }
    }

    $this->load->model('mdl_pdt_profil_kepsek', 'mdl_profkepsek');
  }

  /// |----------------------------------------------------------------------
  /// | >> PRIVATE FUNCTION
  /// |----------------------------------------------------------------------
  private function insert_image_to_spreadsheet($sheet, $imageUrl, $startCell, $endCell)
  {
    // Step 1: Check if URL is a valid image
    $headers = @get_headers($imageUrl, 1);
    if (!$headers || strpos($headers[0], '200') === false) return;

    $contentType = $headers['Content-Type'] ?? '';
    if (is_array($contentType)) $contentType = $contentType[0];
    if (strpos($contentType, 'image/') !== 0) return;

    // Step 2: Download image to a temp file
    $imgData = @file_get_contents($imageUrl);
    if (!$imgData) return;

    $ext = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
    if (!in_array(strtolower($ext), ['png', 'jpg', 'jpeg', 'gif'])) return;

    $tempFolderPath = $this->config->item('template_path') . 'temp/';
    if (!is_dir($tempFolderPath)) mkdir($tempFolderPath, 0755, true);
    $tmpFile = $tempFolderPath . 'temp_img.' . $ext;
    file_put_contents($tmpFile, $imgData);

    // Step 3: Get merged cell size
    [$startColLetter, $startRow] = Coordinate::coordinateFromString($startCell);
    [$endColLetter, $endRow] = Coordinate::coordinateFromString($endCell);
    $startCol = Coordinate::columnIndexFromString($startColLetter);
    $endCol = Coordinate::columnIndexFromString($endColLetter);
    $defaultFont = $sheet->getParent()->getDefaultStyle()->getFont();

    $totalWidth = 0;
    for ($col = $startCol; $col <= $endCol; $col++) {
      $colLetter = Coordinate::stringFromColumnIndex($col);
      $totalWidth += $sheet->getColumnDimension($colLetter)->getWidth();
    }
    $totalWidthPx = DrawingHelper::cellDimensionToPixels($totalWidth, $defaultFont);

    $totalHeight = 0;
    for ($row = $startRow; $row <= $endRow; $row++) {
      $totalHeight += $sheet->getRowDimension($row)->getRowHeight() ?: 15; // default row height
    }
    $totalHeightPx = DrawingHelper::cellDimensionToPixels($totalHeight, $defaultFont);

    // Step 4: Get original image size & scale proportionally
    [$imgWidth, $imgHeight] = getimagesize($tmpFile);
    $scale = min($totalWidthPx / $imgWidth, $totalHeightPx / $imgHeight);

    $resizedWidth = (int) round($imgWidth * $scale);

    $offsetX = ($totalWidthPx - $resizedWidth) / 2;

    // Step 5: Insert image
    $drawing = new MemoryDrawing();
    $drawing->setRenderingFunction(MemoryDrawing::RENDERING_PNG);
    $drawing->setMimeType(MemoryDrawing::MIMETYPE_PNG);
    $imageResource = imagecreatefromstring($imgData);
    $drawing->setImageResource($imageResource);
    $drawing->setMimeType("image/{$ext}");

    $drawing->setCoordinates($startCell);
    $drawing->setResizeProportional(true);
    $drawing->setWidth($resizedWidth);
    $drawing->setOffsetX($offsetX);
    $drawing->setWorksheet($sheet);

    unlink($tmpFile);
  }

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

  public function edit($encryptedID = '')
  {
    $decryptedID = decrypt_id(sanitize_string($encryptedID));

    // CEK VALIDASI DATA
    $dataset = fetch_row_data('vr_profil_kepsek', ['id_dokumen' => $decryptedID], false);
    if ($dataset == false) {
      $this->session->set_userdata('flash_data', "Maaf, data dokumen usulan profil kepala sekolah yang akan di-edit tidak valid.");
      redirect(site_url('pdt_profil_kepsek'));
      return;
    }

    $dataset['id_dokumen'] = encrypt_id($dataset['id_dokumen']);
    $dataset['id_kepsek'] = encrypt_id($dataset['id_kepsek']);

    // CEK STATUS DOKUMEN
    if ($dataset['status_dokumen'] != 'DRAFT') {
      $this->session->set_userdata('flash_data', "Maaf, data dokumen usulan profil kepala sekolah hanya bisa di-edit apabila statusnya adalah Draft.");
      redirect(site_url('pdt_profil_kepsek'));
      return;
    }

    $data = array(
      'page_title' => "Edit Usulan Profil | PROGURINDA",
      'module' => "pdt_profil_kepsek",
      'view' => 'vw_edit_profil_kepsek',
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  public function detail($encryptedID = '')
  {
    $decryptedID = decrypt_id(sanitize_string($encryptedID));

    // CEK VALIDASI DATA
    $dataset = fetch_row_data('vr_profil_kepsek', ['id_dokumen' => $decryptedID], false);
    if ($dataset == false) {
      $this->session->set_userdata('flash_data', "Maaf, data dokumen usulan profil kepala sekolah yang akan dilihat detailnya tidak valid.");
      redirect(site_url('pdt_profil_kepsek'));
      return;
    }

    $dataset['id_dokumen'] = encrypt_id($dataset['id_dokumen']);
    $dataset['id_kepsek'] = encrypt_id($dataset['id_kepsek']);

    $data = array(
      'page_title' => "Detail Usulan Profil | PROGURINDA",
      'module' => "pdt_profil_kepsek",
      'view' => 'vw_detail_profil_kepsek',
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  public function detail_master($encryptedID = '')
  {
    $decryptedID = decrypt_id(sanitize_string($encryptedID));

    // CEK VALIDASI DATA
    $dataset = fetch_row_data('vm_profil_kepsek', ['id_kepsek' => $decryptedID], false);
    if ($dataset == false) {
      $this->session->set_userdata('flash_data', "Maaf, data profil kepala sekolah yang akan dilihat detailnya tidak valid.");
      redirect(site_url('pdt_profil_kepsek'));
      return;
    }

    $dataset['id_dokumen'] = encrypt_id($dataset['id_dokumen']);
    $dataset['id_kepsek'] = encrypt_id($dataset['id_kepsek']);

    $data = array(
      'page_title' => "Profil Kepala Sekolah | PROGURINDA",
      'module' => "pdt_profil_kepsek",
      'view' => 'vw_detail_master_profil_kepsek',
      'data' => $dataset
    );
    echo Modules::run('layout/backend', $data);
  }

  public function cetak($nip)
  {
    $nip = sanitize_string($nip);

    $data_kepsek = fetch_row_data('vm_profil_kepsek', [
      'nip' => $nip
    ], false);
    if (!$data_kepsek) return output_error('Maaf, data Kepala Seolah tidak valid.');

    $data_riwayat = $this->mdl_profkepsek->get_riwayat_kepala_sekolah($nip);

    try {
      $template_file = $this->config->item('template_path') . 'laporan_kepsek.xlsx';
      if (!file_exists($template_file)) return output_error('Maaf, file template untuk cetak laporan Kepala Sekolah tidak ditemukan.');

      $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template_file);
      $sheet = $spreadsheet->getActiveSheet();

      $imgUrl = "http://36.66.236.83/simpeg/foto/" . check_var($data_kepsek, 'nip', '0000') . ".jpg";
      $this->insert_image_to_spreadsheet($sheet, $imgUrl, 'A3', 'A14');

      $use_new_logic = true;

      if (!$use_new_logic) {
        // DEFAULT SET CELL VALUE
        $sheet->setCellValue("D3", check_var($data_kepsek, 'nama', ''));
        $sheet->setCellValue("F3", check_var($data_kepsek, 'gelar_dpn', ''));
        $sheet->setCellValue("H3", check_var($data_kepsek, 'gelar_blk', ''));

        $sheet->setCellValue("D4", check_var($data_kepsek, 'nip', ''));
        $sheet->setCellValue("D5", check_var($data_kepsek, 'nuptr', ''));
        $sheet->setCellValue("D6", check_var($data_kepsek, 'nurs', ''));
        $sheet->setCellValue("D7", check_var($data_kepsek, 'nrg', ''));
        $sheet->setCellValue("D8", check_var($data_kepsek, 'nik', ''));
        $sheet->setCellValue("D9", em_date('j F Y', 'set', check_var($data_kepsek, 'tgl_lahir', '')));
        $sheet->setCellValue("D10", check_var($data_kepsek, 'ket_jenis_kelamin', ''));
        $sheet->setCellValue("D11", check_var($data_kepsek, 'alamat_saat_ini', ''));
        $sheet->setCellValue("D12", check_var($data_kepsek, 'ket_status_pernikahan', ''));
        $sheet->setCellValue("D13", check_var($data_kepsek, 'pendidikan', ''));
        $sheet->setCellValue("D14", check_var($data_kepsek, 'no_sertifikat_pendidik', ''));
        $sheet->setCellValue("D15", check_var($data_kepsek, 'no_sertifikat_gp', ''));
        $sheet->setCellValue("D16", check_var($data_kepsek, 'no_sertifikat_crs', ''));
        $sheet->setCellValue("D17", check_var($data_kepsek, 'no_rek_bank', ''));
        $sheet->setCellValue("D18", check_var($data_kepsek, 'nama_rek_bank', ''));
        $sheet->setCellValue("D19", check_var($data_kepsek, 'nama_bank', ''));
        $sheet->setCellValue("D20", check_var($data_kepsek, 'npwp', ''));
        $sheet->setCellValue("D21", check_var($data_kepsek, 'menerima_ttp_insentif', ''));
        $sheet->setCellValue("D22", check_var($data_kepsek, 'pangkat_gol_ruang', ''));
        $sheet->setCellValue("D23", check_var($data_kepsek, 'jenjang_jabatan', ''));
        $sheet->setCellValue("D24", check_var($data_kepsek, 'ket_status', ''));
        $sheet->setCellValue("D25", check_var($data_kepsek, 'email', ''));
        $sheet->setCellValue("D26", check_var($data_kepsek, 'no_hp', ''));
        $sheet->setCellValue("D27", check_var($data_kepsek, 'ket_agama', ''));
        $sheet->setCellValue("D28", check_var($data_kepsek, 'periode_ke', ''));

        $mpm = em_date('j F Y', 'set', check_var($data_kepsek, 'masa_penugasan_mulai', ''));
        $mps = em_date('j F Y', 'set', check_var($data_kepsek, 'masa_penugasan_selesai', ''));
        $dates = $mpm . ' s/d ' . $mps;
        $sheet->setCellValue("D29", $dates);

        $startRow = 6;
        $styledRow = 6;
        $num = 1;
        foreach ($data_riwayat as $riwayat) {
          if ($startRow > $styledRow) {
            foreach (range('J', 'P') as $col) {
              $style = $sheet->getStyle("{$col}{$styledRow}");
              $sheet->duplicateStyle($style, "{$col}{$startRow}");
            }
          }

          $sheet->setCellValue("J{$startRow}", $num);
          $sheet->setCellValue("K{$startRow}", $riwayat['ket_ukerja']);
          $sheet->setCellValue("L{$startRow}", em_date('j F Y', 'set', $riwayat['masa_penugasan_mulai']));
          $sheet->setCellValue("M{$startRow}", em_date('j F Y', 'set', $riwayat['masa_penugasan_selesai']));
          $startRow++;
          $num++;
        }
      } else {
        // CUSTOM SET CELL VALUE (OVEERIDE STRING TYPE)
        setStrCellValue($sheet, 'D3', check_var($data_kepsek, 'nama', ''));
        setStrCellValue($sheet, 'F3', check_var($data_kepsek, 'gelar_dpn', ''));
        setStrCellValue($sheet, 'H3', check_var($data_kepsek, 'gelar_blk', ''));

        setStrCellValue($sheet, 'D4', check_var($data_kepsek, 'nip', ''));
        setStrCellValue($sheet, 'D5', check_var($data_kepsek, 'nuptr', ''));
        setStrCellValue($sheet, 'D6', check_var($data_kepsek, 'nurs', ''));
        setStrCellValue($sheet, 'D7', check_var($data_kepsek, 'nrg', ''));
        setStrCellValue($sheet, 'D8', check_var($data_kepsek, 'nik', ''));
        setStrCellValue($sheet, 'D9', em_date('j F Y', 'set', check_var($data_kepsek, 'tgl_lahir', '')));
        setStrCellValue($sheet, 'D10', check_var($data_kepsek, 'ket_jenis_kelamin', ''));
        setStrCellValue($sheet, 'D11', check_var($data_kepsek, 'alamat_saat_ini', ''));
        setStrCellValue($sheet, 'D12', check_var($data_kepsek, 'ket_status_pernikahan', ''));
        setStrCellValue($sheet, 'D13', check_var($data_kepsek, 'pendidikan', ''));
        setStrCellValue($sheet, 'D14', check_var($data_kepsek, 'no_sertifikat_pendidik', ''));
        setStrCellValue($sheet, 'D15', check_var($data_kepsek, 'no_sertifikat_gp', ''));
        setStrCellValue($sheet, 'D16', check_var($data_kepsek, 'no_sertifikat_crs', ''));
        setStrCellValue($sheet, 'D17', check_var($data_kepsek, 'no_rek_bank', ''));
        setStrCellValue($sheet, 'D18', check_var($data_kepsek, 'nama_rek_bank', ''));
        setStrCellValue($sheet, 'D19', check_var($data_kepsek, 'nama_bank', ''));
        setStrCellValue($sheet, 'D20', check_var($data_kepsek, 'npwp', ''));
        setStrCellValue($sheet, 'D21', check_var($data_kepsek, 'menerima_ttp_insentif', ''));
        setStrCellValue($sheet, 'D22', check_var($data_kepsek, 'pangkat_gol_ruang', ''));
        setStrCellValue($sheet, 'D23', check_var($data_kepsek, 'jenjang_jabatan', ''));
        setStrCellValue($sheet, 'D24', check_var($data_kepsek, 'ket_status', ''));
        setStrCellValue($sheet, 'D25', check_var($data_kepsek, 'email', ''));
        setStrCellValue($sheet, 'D26', check_var($data_kepsek, 'no_hp', ''));
        setStrCellValue($sheet, 'D27', check_var($data_kepsek, 'ket_agama', ''));
        setStrCellValue($sheet, 'D28', check_var($data_kepsek, 'periode_ke', ''));

        $mpm = em_date('j F Y', 'set', check_var($data_kepsek, 'masa_penugasan_mulai', ''));
        $mps = em_date('j F Y', 'set', check_var($data_kepsek, 'masa_penugasan_selesai', ''));
        $dates = $mpm . ' s/d ' . $mps;
        setStrCellValue($sheet, 'D29', $dates);

        $startRow = 6;
        $styledRow = 6;
        $num = 1;
        foreach ($data_riwayat as $riwayat) {

          if ($startRow > $styledRow) {
            foreach (range('J', 'P') as $col) {
              $style = $sheet->getStyle("{$col}{$styledRow}");
              $sheet->duplicateStyle($style, "{$col}{$startRow}");
            }
          }

          setStrCellValue($sheet, "J{$startRow}", $num);
          setStrCellValue($sheet, "K{$startRow}", check_var($riwayat, 'ket_ukerja', ''));
          $mpm = em_date('j F Y', 'set', check_var($riwayat, 'masa_penugasan_mulai', ''));
          setStrCellValue($sheet, "L{$startRow}", $mpm);
          $mps = em_date('j F Y', 'set', check_var($riwayat, 'masa_penugasan_selesai', ''));
          setStrCellValue($sheet, "M{$startRow}", $mps);
          setStrCellValue($sheet, "N{$startRow}", check_var($riwayat, 'no_sk_kepsek', ''));
          setStrCellValue($sheet, "O{$startRow}", check_var($riwayat, 'tgl_sk_kepsek', ''));
          setStrCellValue($sheet, "P{$startRow}", check_var($riwayat, 'ttd_sk_kepsek', ''));

          $startRow++;
          $num++;
        }
      }

      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="Cetak Laporan Kepala Sekolah.xlsx"');
      header('Cache-Control: max-age=0');

      $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
      $writer->save('php://output');
      exit;
    } catch (\Throwable $th) {
      $cm = sanitize_string($th->getMessage());
      return output_error("Maaf, terjadi kesalahan saat akan mencetak laporan.\n\n$cm");
    }
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
      'f_ukerja' => post_safe('f_ukerja')
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
      'f_ukerja' => post_safe('f_ukerja'),
      'f_periode_bln' => post_safe('f_periode_bln'),
      'f_periode_thn' => post_safe('f_periode_thn')
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

      case 'hapus_usulan_profil': {
          // CHECK PERMISSION
          if (!check_perm('delete', 'PDT_ProfilKepsek')) return output_json([
            'status' => false,
            'message' => 'invalid permissions'
          ], 403);

          $decryptedID = decrypt_id($id);
          $dataset = fetch_row_data('vr_profil_kepsek', ['id_dokumen' => $decryptedID], false);

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

          $id_kepsek = decrypt_id($id);
          $dataset = fetch_row_data('vm_profil_kepsek', ['id_kepsek' => $id_kepsek], false);

          // VALIDASI DATA PROFIL EXISTING
          if ($dataset === false) return output_json([
            'status' => false,
            'message' => "Maaf, data profil kepala sekolah yang akan di-update tidak valid lagi."
          ]);

          $dataset['id_kepsek'] = encrypt_id($dataset['id_kepsek']);

          // LOAD VIEW
          $sent_data = [
            'modal_title' => 'Update Profil Kepala Sekolah',
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

    $response = $this->mdl_profkepsek->delete_profil_kepsek($post);

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
    if (!check_perm('update', 'PDT_ProfilKepsek')) return output_json([
      'status' => false,
      'message' => 'invalid permissions'
    ], 403);

    $post = post_safe();

    $response = $this->mdl_profkepsek->edit_profil_kepsek($post);

    return output_json($response);
  }

  public function submit_draft()
  {
    // CHECK PERMISSION
    if (!check_perm('update', 'PDT_ProfilKepsek')) return output_json([
      'status' => false,
      'message' => 'invalid permissions'
    ], 403);

    $post = post_safe();

    $response = $this->mdl_profkepsek->submit_profil_kepsek($post);

    return output_json($response);

    // DEBUG
    return output_json([
      'status' => false,
      'message' => 'DEBUG SUBMIT DRAFT : PDT_ProfilKepsek',
      'data' => $post
    ]);
  }
}
