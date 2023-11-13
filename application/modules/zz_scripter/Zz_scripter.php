<?php defined('BASEPATH') or exit('No direct script access allowed');

class Zz_scripter extends MY_Controller
{
  //Class construction method
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    show_404();
  }

  public function insert_random_data_to_kak()
  {
    try {
      $unor_lib = array();
      $kegiatan_lib = array();
      $var_iku_lib = array('Langsung', 'Tidak Langsung', 'Pendukung');

      /// |----------------------------------------
      /// | AMBIL KODE UNOR UNTUK LIB
      /// |----------------------------------------
      $q_unor = $this->db->select('kode_unor')->from('m_unor')->get();
      if ($q_unor->num_rows() < 1) {
        echo '<h3>Sorry, an error occured.</h3><br>' .
          "unor data doesn't exist.";
        return;
      }

      $data_unor = $q_unor->result_array();
      $unor_counter = 0;
      foreach ($data_unor as $value) {
        array_push($unor_lib, $value['kode_unor']);
        $unor_counter++;
      }

      /// |----------------------------------------
      /// | AMBIL KODE KEGIATAN UNTUK LIB
      /// |----------------------------------------
      $q_kegiatan = $this->db->select('kode_kegiatan')->from('m_kegiatan')->get();
      if (
        $q_kegiatan->num_rows() < 1
      ) {
        echo '<h3>Sorry, an error occured.</h3><br>' .
          "kegiatan data doesn't exist.";
        return;
      }

      $data_kegiatan = $q_kegiatan->result_array();
      $kegiatan_counter = 0;
      foreach ($data_kegiatan as $value) {
        array_push(
          $kegiatan_lib,
          $value['kode_kegiatan']
        );
        $kegiatan_counter++;
      }

      $insert_counter = 0;
      for ($i = 0; $i < 500; $i++) {
        $hash = strtoupper(md5(em_date('YmdHis') . str_pad($i, 3, '0', STR_PAD_LEFT)));
        $random_kode_unor = $unor_lib[rand(0, ($unor_counter - 1))];
        $random_kode_kegiatan = $kegiatan_lib[rand(0, ($kegiatan_counter - 1))];
        $random_id_iku = rand(1, 7);
        $random_volume = rand(
          10,
          55
        );
        $random_tgl = str_pad(rand(1, 20), 2, '0', STR_PAD_LEFT);
        $random_bulan = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
        $random_date = '2023-' . $random_bulan . '-' . $random_tgl;
        $random_var_iku = $var_iku_lib[rand(0, 2)];

        $data_to_save = array(
          'kode_unor' => $random_kode_unor,
          'kode_kegiatan' => $random_kode_kegiatan,
          'tahun' => 2023,
          'tgl_susun' => $random_date,
          'deskripsi' => substr($hash, 0, 6),
          'keluaran' => substr($hash, 5, 6),
          'indikator' => substr($hash, 11, 6),
          'target' => substr($hash, 17, 6),
          'volume' => $random_volume,
          'satuan' => substr($hash, 0, 2),
          'lokasi' => substr($hash, 23, 6),
          'metode' => substr($hash, 2, 6),
          'id_iku' => $random_id_iku,
          'var_iku' => $random_var_iku,
          'slock' => rand(0, 1),
          'slog' => substr(
            $hash,
            4,
            6
          ),
          'proses' => rand(0, 1),
          'real_bln1' => rand(0, 1),
          'real_bln2' => rand(0, 1),
          'real_bln3' => rand(0, 1),
          'real_bln4' => rand(0, 1),
          'real_bln5' => rand(0, 1),
          'real_bln6' => rand(0, 1),
          'real_bln7' => rand(0, 1),
          'real_bln8' => rand(0, 1),
          'real_bln9' => rand(0, 1),
          'real_bln10' => rand(
            0,
            1
          ),
          'real_bln11' => rand(
            0,
            1
          ),
          'real_bln12' => rand(
            0,
            1
          ),
        );

        $this->db->insert(
          'r_kak',
          $data_to_save
        );
        $insert_counter++;
      }
    } catch (\Throwable $th) {
      echo '<h3>Sorry, an error occured.</h3><br>' . $th->getMessage();
      return;
    }

    echo '<h3>Successful</h3><br>' . $insert_counter . ' data inserted.';
  }

  public function insert_random_data_to_kak_belanja()
  {
    try {
      $kak_lib = array();
      $belanja_lib = array();

      /// |----------------------------------------
      /// | AMBIL ID KAK UNTUK LIB
      /// |----------------------------------------
      $q_kak = $this->db->select('id_kak')->from('r_kak')->get();
      if ($q_kak->num_rows() < 1) {
        echo '<h3>Sorry, an error occured.</h3><br>' .
          "kak data doesn't exist.";
        return;
      }

      $data_kak = $q_kak->result_array();
      $kak_counter = 0;
      foreach ($data_kak as $value) {
        array_push($kak_lib, $value['id_kak']);
        $kak_counter++;
      }

      /// |----------------------------------------
      /// | AMBIL KODE BELANJA UNTUK LIB
      /// |----------------------------------------
      $q_belanja = $this->db->select('kode_belanja')->from('m_belanja')->get();
      if (
        $q_belanja->num_rows() < 1
      ) {
        echo '<h3>Sorry, an error occured.</h3><br>' .
          "belanja data doesn't exist.";
        return;
      }

      $data_belanja = $q_belanja->result_array();
      $belanja_counter = 0;
      foreach ($data_belanja as $value) {
        array_push($belanja_lib, $value['kode_belanja']);
        $belanja_counter++;
      }

      $insert_counter = 0;
      for ($i = 0; $i < 500; $i++) {
        $hash = strtoupper(md5(em_date('YmdHis') . str_pad($i, 3, '0', STR_PAD_LEFT)));

        $random_id_kak = $kak_lib[rand(0, ($kak_counter - 1))];
        $random_kode_belanja = $belanja_lib[rand(0, ($belanja_counter - 1))];

        $random_tgl = str_pad(rand(1, 20), 2, '0', STR_PAD_LEFT);
        $random_bulan = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
        $random_date = '2023-' . $random_bulan . '-' . $random_tgl;

        $random_decimal_suffix = ['.00', '.25', '.50', '.75'];

        $random_koef = rand(
          10,
          69
        ) . $random_decimal_suffix[rand(0, 3)];
        $random_harga = rand(150000, 1250000) . $random_decimal_suffix[rand(0, 3)];
        $random_koef_p1 = rand(
          10,
          72
        ) . $random_decimal_suffix[rand(0, 3)];
        $random_koef_p2 = rand(
          10,
          55
        ) . $random_decimal_suffix[rand(0, 3)];
        $random_koef_p3 = rand(
          10,
          35
        ) . $random_decimal_suffix[rand(0, 3)];

        $data_to_save = array(
          'id_kak' => $random_id_kak,
          'kode_belanja' => $random_kode_belanja,
          'uraian' => substr($hash, 8, 6),
          'spesifikasi' => substr($hash, 4, 6),
          'koef' => $random_koef,
          'satuan' => substr($hash, 2, 2),
          'harga' => $random_harga,
          'koef_p1' => $random_koef_p1,
          'koef_p2' => $random_koef_p2,
          'koef_p3' => $random_koef_p3,
        );

        $this->db->insert('r_kak_belanja', $data_to_save);
        $insert_counter++;
      }
    } catch (\Throwable $th) {
      echo '<h3>Sorry, an error occured.</h3><br>' . $th->getMessage();
      return;
    }

    echo '<h3>Successful</h3><br>' . $insert_counter . ' data kak belanja inserted.';
  }
}
