<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


function strtourl($str)
{
  $arrayStr = explode(" ", $str);
  $jml = count($arrayStr);
  $stext = $arrayStr[0];
  for ($i = 1; $i < $jml; $i++) {
    $stext = $stext . "%20" . $arrayStr[$i];
  }
  return $stext;
}

function dlookup($field, $tabel, $strwhere)
{
  $ci = &get_instance();
  $tampil = $ci->db->query("SELECT * FROM " . $tabel . " WHERE " . $strwhere . "");
  if ($tampil->num_rows() > 0) {
    $r = $tampil->row_array();
    return $r[$field];
  } else {
    return "";
  }
}

function get_nama_jabgol($kode_gol, $jns_jab, $ket_jab)
{
  $ci = &get_instance();
  $q_jab = $ci->db->where("kode_gol = '" . $kode_gol . "' AND jns_jab = '" . $jns_jab . "'")->get('m_jafung');
  $nama_jab = false;
  if ($q_jab->num_rows() > 0) {
    $row = $q_jab->row_array();
    $nama_jab = $row["ket_fung"];
  }
  if ($nama_jab != false) {
    return $nama_jab;
  } else {
    return $ket_jab;
  }
}

function select_gen($table, $nameid, $value, $label, $default, $default_label, $selected = "")
{
  $ci = &get_instance();
  $q_tab = $ci->db->get($table);
  if ($q_tab->num_rows() > 0) {
    $options = $q_tab->result_array();
    echo '<select data-toggle="select" class="form-control select select-primary" name="' . $nameid . '" id="' . $nameid . '">';
    echo '<option value="' . $default . '">' . $default_label . '</option>';
    foreach ($options as $opt) {
      echo '<option value="' . $opt[$value] . '" ';
      if ($opt[$value] == $selected) echo 'Selected = "selected"';
      echo '>' . $opt[$label] . '</option>';
    }
    echo '</select>';
  }
}

function str2file($str)
{
  $jml = strlen($str);
  $stext = '';
  for ($i = 0; $i < $jml; $i++) {
    $strcut = substr($str, $i, 1);
    if (
      $strcut <> " " and $strcut <> "." and $strcut <> "/" and $strcut <> ":" and $strcut <> "?" and
      $strcut <> '"' and $strcut <> "<" and $strcut <> ">" and $strcut <> "|"
    ) {
      $stext = $stext . $strcut;
    }
  }
  return $stext;
}

function validasi($str)
{
  $patern = " 1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $stext = "";
  $jml = strlen($str);
  for ($i = 0; $i < $jml; $i++) {
    $strcut = substr($str, $i, 1);
    if (strchr($patern, $strcut)) {
      $stext = $stext . $strcut;
    }
  }
  return $stext;
}

function get_kode_pemda()
{
  $CI = &get_instance();
  $kode_upem = $CI->db->get('m_upem')->row()->kode_upem;
  return $kode_upem;
}

function str2jsfunc_e($str)
{
  $stext = str_replace(" ", "%", str_replace("'", "`", $str));
  return $stext;
}

function str2txtbox($str)
{
  $stext = str_replace("'", "`", $str);
  return $stext;
}

function kekata($x)
{
  $x = abs($x);
  $angka = array(
    "", "satu", "dua", "tiga", "empat", "lima",
    "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"
  );
  $temp = "";
  if ($x < 12) {
    $temp = " " . $angka[$x];
  } else if ($x < 20) {
    $temp = kekata($x - 10) . " belas";
  } else if ($x < 100) {
    $temp = kekata($x / 10) . " puluh" . kekata($x % 10);
  } else if ($x < 200) {
    $temp = " seratus" . kekata($x - 100);
  } else if ($x < 1000) {
    $temp = kekata($x / 100) . " ratus" . kekata($x % 100);
  } else if ($x < 2000) {
    $temp = " seribu" . kekata($x - 1000);
  } else if ($x < 1000000) {
    $temp = kekata($x / 1000) . " ribu" . kekata($x % 1000);
  } else if ($x < 1000000000) {
    $temp = kekata($x / 1000000) . " juta" . kekata($x % 1000000);
  } else if ($x < 1000000000000) {
    $temp = kekata($x / 1000000000) . " milyar" . kekata(fmod($x, 1000000000));
  } else if ($x < 1000000000000000) {
    $temp = kekata($x / 1000000000000) . " trilyun" . kekata(fmod($x, 1000000000000));
  }
  return $temp;
}

function terbilang($x, $style = 4)
{
  if ($x < 0) {
    $hasil = "minus " . trim(kekata($x));
  } else {
    $hasil = trim(kekata($x));
  }
  switch ($style) {
    case 1:
      $hasil = strtoupper($hasil);
      break;
    case 2:
      $hasil = strtolower($hasil);
      break;
    case 3:
      $hasil = ucwords($hasil);
      break;
    default:
      $hasil = ucfirst($hasil);
      break;
  }
  return $hasil;
}

function terbilang_koma($x, $style = 4)
{
  $x = $x - intval($x);
  if ($x < 1 and $x >= 0) {
    $hasil = trim(kekata($x));
  }
  switch ($style) {
    case 1:
      $hasil = strtoupper($hasil);
      break;
    case 2:
      $hasil = strtolower($hasil);
      break;
    case 3:
      $hasil = ucwords($hasil);
      break;
    default:
      $hasil = ucfirst($hasil);
      break;
  }
  return $hasil;
}


function cek_prev($aksi)
{
  $user_reg = explode("|", $_SESSION["user_reg"]);
  $jenisuser = $user_reg[2];
  switch ($aksi) {
    default:
      return false;
      break;
    case "C":
      if ($jenisuser == '00') {
        return true;
      } else {
        return false;
      }
      break;
    case "R":
      return false;
      break;
    case "U":
      if ($jenisuser == '00' or $jenisuser == '01') {
        return true;
      } else {
        return false;
      }
      break;
    case "D":
      if ($jenisuser == '00') {
        return true;
      } else {
        return false;
      }
      break;
  }
}


function combotgl($awal, $akhir, $var, $default)
{
  echo "<select name=$var>";
  echo "<option value=0 selected>$default</option>";
  for ($i = $awal; $i <= $akhir; $i++) {
    echo "<option value=$i>$i</option>";
  }
  echo "</select> ";
}

function combobln($awal, $akhir, $var, $default)
{
  $nama_bln = array(
    1 => "Januari", "Februari", "Maret", "April", "Mei",
    "Juni", "Juli", "Agustus", "September",
    "Oktober", "November", "Desember"
  );

  echo "<select name=$var>";
  echo "<option value=0 selected>$default</option>";
  for ($bln = $awal; $bln <= $akhir; $bln++) {
    echo "<option value=$bln>$nama_bln[$bln]</option>";
    //	echo "<option value=1>$bln</option>";
  }
  echo "</select> ";
}

function combotgl2($awal, $akhir, $var, $terpilih)
{
  echo "<select name=$var>";
  for ($i = $awal; $i <= $akhir; $i++) {
    if ($i == $terpilih)
      echo "<option value=$i selected>$i</option>";
    else
      echo "<option value=$i>$i</option>";
  }
  echo "</select> ";
}

function combobln2($awal, $akhir, $var, $terpilih)
{
  $nama_bln = array(
    1 => "Januari", "Februari", "Maret", "April", "Mei",
    "Juni", "Juli", "Agustus", "September",
    "Oktober", "November", "Desember"
  );

  echo "<select name=$var>";
  for ($bln = $awal; $bln <= $akhir; $bln++) {
    if ($bln == $terpilih)
      echo "<option value=$bln selected>$nama_bln[$bln]</option>";
    else
      echo "<option value=$bln>$nama_bln[$bln]</option>";
  }
  echo "</select> ";
}

//-----------------------------------dari fungsi_js.php ----------------------------//



//-----------------------------------dari fungsi_tanggal.php ----------------------//

/*
 * Formating Tanggal
 * Format available : 
 * D : Nama Hari (Senin,selasa,dll.)
 * M : Nama Bulan (Januari, Februari)
 * yyyy : Tahun (2021,2022,etc)
 * dd-mm-yyyy : tanggal-bulan-tahun
 * d M yyyy   : tanggal NamaBulan Tahun
 * d M yyyy T : tanggal NamaBulan Tahun Waktu
 * D, d M yyyy T : Hari, tanggal Bulan Tahun Waktu
 */
function tglFormat($tgl, $format)
{
  $tgl2time = strtotime($tgl);
  $hari = getHari(date("N", $tgl2time));
  $isDate = date("d", $tgl2time);
  $isMonth = date("m", $tgl2time);
  $isYear = date("Y", $tgl2time);

  switch ($format) {
    default:
      $tanggal = $tgl;
      break;
    case "D":
      $tanggal = getHari(date("N", $tgl2time));
      break;
    case "M":
      $tanggal = getBulan(date("m", $tgl2time));
      break;
    case "yyyy":
      $tanggal = getHari(date("Y", $tgl2time));
      break;
    case "dd-mm-yyyy":
      $tanggal = date("d-m-Y", $tgl2time);
      break;
    case "d M yyyy":
      $tanggal = date("d", $tgl2time) . " " . getBulan(date("m", $tgl2time)) . " " . date("Y", $tgl2time);
      break;
    case "d M yyyy T":
      $tanggal = intval(date("d", $tgl2time)) . " " . getBulan(date("m", $tgl2time)) . " " . date("Y", $tgl2time) . " " . date("H:i:s", $tgl2time);
      break;
    case "D, d M yyyy T":
      $tanggal = getHari(date("N", $tgl2time)) . ", " . intval(date("d", $tgl2time)) . " " . getBulan(date("m", $tgl2time)) . " " . date("Y", $tgl2time) . " " . date("H:i:s", $tgl2time);
      break;
  }
  return $tanggal;
}


//-----------------------------------dari fungsi_tgl.php-----------------------//

/**
 * Fungsi untuk menghasilkan tanggal dengan format dd M yyyy
 * @param string $tgl string tanggal dengan format yyyy-mm-dd
 * @return string
 */
function tgl_indo($tgl)
{
  //mengambil bagian tanggal
  $tanggal = substr($tgl, 8, 2);
  //mengambil nama bulan
  $bulan = getBulan(substr($tgl, 5, 2));
  //mengambil tahun
  $tahun = substr($tgl, 0, 4);
  //kembalikan tanggal
  return $tanggal . ' ' . $bulan . ' ' . $tahun;
}

/**
 * Fungsi untuk mendapat nama hari dalam bahasa indonesia
 * @param int $hari
 * @return string
 */
function getHari($hari)
{
  $arrHari = array(1 => "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu");
  return $arrHari[$hari];
}

/**
 * Fungsi untuk mendapat nama bulan dalam bahasa indonesia
 * @param int $bln bulan dalam angka
 * @return string
 */
function getBulan($bln)
{
  if ($bln < 10 && strlen($bln) < 2) {
    $bln = "0" . $bln;
  }
  $arrBulan = array("00" => "Undefined", "01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli", "08" => "Agustus", "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember");
  return $arrBulan[$bln];
}

function tgl_formal($tgl)
{
  if (!empty($tgl)) {
    $tanggal = substr($tgl, 8, 2);
    $bulan = substr($tgl, 5, 2);
    $tahun = substr($tgl, 0, 4);
    return $tanggal . '-' . $bulan . '-' . $tahun;
  } else
    return '00-00-0000';
}

function tgl_mysql($tgl)
{
  if (!empty($tgl)) {
    $tanggal = substr($tgl, 0, 2);
    $bulan = substr($tgl, 3, 2);
    $tahun = substr($tgl, 6, 4);
    return $tahun . '-' . $bulan . '-' . $tanggal;
  } else
    return '0000-00-00';
}
function Umur($tgl, $tglSkrg)
{
  if (!empty($tgl) and !empty($tglSkrg)) {
    $bln = (substr($tglSkrg, 0, 4) - substr($tgl, 0, 4)) * 12;
    $bln = $bln + (intval(substr($tglSkrg, 5, 2)) - intval(substr($tgl, 5, 2)));
    if (substr($tgl, 7, 2) < substr($tglSkrg, 7, 2)) {
      $bln = $bln - 1;
    }
    return $bln;
  } else {
    return '';
  }
}

function tgl_add($jns, $jml, $tgl)
{
  if (!empty($tgl)) {
    $tanggal = substr($tgl, 8, 2);
    $bulan = substr($tgl, 5, 2);
    $tahun = substr($tgl, 0, 4);
    if ($jns == 'd') {
      $tanggal = $tanggal + ($jml);
    } elseif ($jns == 'm') {
      $bulan = $bulan + ($jml);
    } else {
      $tahun = $tahun + ($jml);
    }
    return $tanggal . '-' . $bulan . '-' . $tahun;
  } else
    return '';
}

function int2date($num)
{
  if ($num < 10 && strlen($num) < 2) {
    $num = "0" . $num;
  }
  return $num;
}

/*
*Fungsi untuk mengecek apakah sebaut tanggal ada diantara rentang tanggal yang ditentukan
*@params
*date_in string (format y-m-d)
*date_start string (format y-m-d)
*date_end string (format y-m-d)
*return boolean (true or false)
*/
function dateInBetween($date_in, $date_start, $date_end)
{
  if ($date_start == $date_end) {
    if ($date_in == $date_start) {
      return true;
    } else {
      return false;
    }
  } else {
    if (strtotime($date_start) <= strtotime($date_in) && strtotime($date_end) >= strtotime($date_in))
      return true;
    else
      return false;
  }
}

/*
*Fungsi untuk mengecek apakah selisih tanggal diantara rentang tanggal yang ditentukan dalam menit
*@params
*date_start string (format y-m-d H:i:S)
*date_end string (format y-m-d H:i:S)
*return int (in minutes)
*/
function dateDiffInMinutes($date_start, $date_end)
{
  $to_time = strtotime(date("Y-m-d H:i", strtotime($date_end)));
  $from_time = strtotime(date("Y-m-d H:i", strtotime($date_start)));
  return round(($to_time - $from_time) / 60, 0, PHP_ROUND_HALF_DOWN);
}

function tmt_pensiun($tgl_pensiun)
{
  if (!empty($tgl_pensiun)) {
    $tmt_pensiun = strtotime($tgl_pensiun);
    $tgl = date("d", $tmt_pensiun);
    //update tmt untuk tgl 1 menjadi bulan berikutnya
    if ($tgl >= '01') {
      $tmt_pensiun = strtotime(date('Y-m-', strtotime("+ 1 month", $tmt_pensiun)) . '01');
    }
    return date("Y-m-d", $tmt_pensiun);
  } else
    return '';
}



function antiinjection($data)
{
  $CI = &get_instance();

  $filter_sql = $CI->db->escape(stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
  return $filter_sql;
}

function halaman($url, $row, $per_page)
{
  $CI = &get_instance();
  $config['base_url'] = $url;
  $config['uri_segment'] = '3';
  $config['total_rows'] = $row;
  $config['per_page'] = $per_page;
  /* This Application Must Be Used With BootStrap 3 *  */
  $config['full_tag_open'] = "<ul class='pagination pagination-default' style='margin:0px;'>";
  $config['full_tag_close'] = "</ul>";
  $config['num_tag_open'] = '<li>';
  $config['num_tag_close'] = '</li>';
  $config['cur_tag_open'] = "<li class='disabled'><li class='active'><span class='sr-only'>";
  $config['cur_tag_close'] = "</span></li></li>";
  $config['next_tag_open'] = '<li>';
  $config['next_tagl_close'] = "</li>";
  $config['prev_tag_open'] = '<li>';
  $config['prev_tagl_close'] = "</li>";
  $config['first_tag_open'] = "<li>";
  $config['first_tagl_close'] = "</li>";
  $config['last_tag_open'] = "<li>";
  $config['last_tagl_close'] = "</li>";
  // End of bs3 config
  $config['first_page'] = 'First';
  $config['last_page'] = 'Last';
  $config['next_page'] = '&laquo;';
  $config['previous_page'] = '&laquo;';

  $CI->pagination->initialize($config);
  //buat pagination
  return $CI->pagination->create_links();
}

function halaman2($url, $row, $per_page, $uri_segment)
{
  $CI = &get_instance();
  $config['base_url'] = $url;
  $config['uri_segment'] = $uri_segment;
  $config['total_rows'] = $row;
  $config['per_page'] = $per_page;
  /* This Application Must Be Used With BootStrap 3 *  */
  $config['full_tag_open'] = "<ul class='pagination pagination-default' style='margin:0px;'>";
  $config['full_tag_close'] = "</ul>";
  $config['num_tag_open'] = '<li>';
  $config['num_tag_close'] = '</li>';
  $config['cur_tag_open'] = "<li class='disabled'><li class='active'><span class='sr-only'>";
  $config['cur_tag_close'] = "</span></li></li>";
  $config['next_tag_open'] = '<li>';
  $config['next_tagl_close'] = "</li>";
  $config['prev_tag_open'] = '<li>';
  $config['prev_tagl_close'] = "</li>";
  $config['first_tag_open'] = "<li>";
  $config['first_tagl_close'] = "</li>";
  $config['last_tag_open'] = "<li>";
  $config['last_tagl_close'] = "</li>";
  // End of bs3 config
  $config['first_page'] = 'First';
  $config['last_page'] = 'Last';
  $config['next_page'] = '&laquo;';
  $config['previous_page'] = '&laquo;';

  $CI->pagination->initialize($config);
  //buat pagination
  return $CI->pagination->create_links();
}

function cek_efile_riwayat($nip = NULL, $nama_efile = NULL, $add = NULL)
{
  if ($add != NULL) {
    if (is_dir("../simpeg_efile/efile/" . $nip)) {
      $dir = opendir("../simpeg_efile/efile/" . $nip);
      while ($entri = readdir($dir)) {
        $jnsfile = substr($entri, 0, strlen($nama_efile . $add));
        if ($jnsfile == $nama_efile . $add) {
          //return "<span class='fui-check' aria-hidden='true' style='color:green'></span>";
          return "btn-success";
        }
      }
    }
  }
  //return "<span class='fui-cross' aria-hidden='true' style='color:red'></span>";
  return "btn-danger";
}

/**
 * Converts bytes into human readable file size.
 *
 * @param string $bytes
 * @return string human readable file size (2,87 Мб)
 * @author Mogilev Arseny
 */
function FileSizeConvert($bytes)
{
  $bytes = floatval($bytes);
  $arBytes = array(
    0 => array(
      "UNIT" => "TB",
      "VALUE" => pow(1000, 4)
    ),
    1 => array(
      "UNIT" => "GB",
      "VALUE" => pow(1000, 3)
    ),
    2 => array(
      "UNIT" => "MB",
      "VALUE" => pow(1000, 2)
    ),
    3 => array(
      "UNIT" => "KB",
      "VALUE" => 1000
    ),
    4 => array(
      "UNIT" => "B",
      "VALUE" => 1
    ),
  );

  foreach ($arBytes as $arItem) {
    if ($bytes >= $arItem["VALUE"]) {
      $result = $bytes / $arItem["VALUE"];
      $result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
      break;
    }
  }
  return $result;
}

//-----------------------------dari paging.php------------------------------//

//----------------------------Encrypting password---------------------------//
/**
 * Encrypting password
 * @param password
 * returns salt and encrypted password
 */
function hashSSHA($password)
{

  $salt = sha1(rand());
  $salt = substr($salt, 0, 10);
  $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
  $hash = array("salt" => $salt, "encrypted" => $encrypted);
  return $hash;
}

/**
 * Decrypting password
 * @param salt, password
 * returns hash string
 */
function checkhashSSHA($salt, $password)
{

  $hash = base64_encode(sha1($password . $salt, true) . $salt);

  return $hash;
}

function phpFileUploadError($errorCode, $lang = 'en')
{
  if ($lang == 'id') {
    $array = [
      0 => 'Tidak ada error pada proses upload file',
      1 => 'Ukuran file melebihi limit yang ditentukan pada konfigurasi server',
      2 => 'Ukuran file melebihi limit yang ditentukan pada konfigurasi client',
      3 => 'File yang diupload hanya sebagian yang berhasil, harap cek koneksi.',
      4 => 'Tidak ada file yang diupload.',
      6 => 'Folder temporary tidak ditemukan.',
      7 => 'Tidak memiliki ijin untuk membuat file pada server.',
      8 => 'Ada ekstensi server yang menghalau proses upload file ini.',
    ];
  } else {
    $array = [
      0 => 'There is no error, the file successfully uploaded',
      1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
      2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
      3 => 'The uploaded file was only partially uploaded',
      4 => 'No file was uploaded',
      6 => 'Missing a temporary folder',
      7 => 'Failed to write file to disk',
      8 => 'A PHP extension stopped the file upload',
    ];
  }
  return $array[$errorCode];
}

function konversi_counting($nilai, $decimal = 0, $spare = ".", $spare_dec = ",")
{
  if ($nilai == '')
    $nilai = 0;

  $result = number_format($nilai, $decimal, $spare_dec, $spare);

  return $result;
}
