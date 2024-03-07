<?php

/** cek apakah data yang diberikan itu string kosong atau null */
function isset_nn_nes($data, $placeholder = null)
{
  $result = false;
  if (is_array($data)) {
    if (count($data) > 0) $result = true;
  } elseif (is_object($data)) {
    if (!is_null($data)) $result = true;
  } else {
    if (trim($data) != '' && trim($data) != '-') $result = true;
  }
  if ($placeholder === null) {
    return $result;
  } else {
    return ($result) ? $data : $placeholder;
  }
}

/** hapus / unset array key yang memiliki nilai berupa string kosong / null */
function trim_array($data_array)
{
  foreach ($data_array as $key => $value) {
    if (!isset_nn_nes($value)) {
      unset($data_array[$key]);
    } else {
      /* ga usah lakuin apa-apa */
    }
  }
  return $data_array;
}

/**
 * @param string $string The input string to be cleaned.
 * @return string The cleaned string.
 * 
 * Cleans a given string by performing the following steps:
 * 1. Replaces spaces with underscores.
 * 2. Removes all characters except alphabetic letters (both uppercase and lowercase),
 *    numbers, and underscores.
 * 3. Ensures that consecutive underscores are reduced to a single underscore.
 */
function clean_string($string = 'String_ placeholder')
{
  if (!is_string($string)) {
    return "ERROR";
  }

  // Replace spaces with underscores
  $replace_space = str_replace(' ', '_', $string);

  // Remove non-alphanumeric characters (including underscores)
  $cleanedString = preg_replace("/[^a-zA-Z0-9_]/", "", $replace_space);

  // Remove consecutive underscores
  $cleanedString = preg_replace("/_+/", "_", $cleanedString);

  return $cleanedString;
}

/** ambil data datetime berdasarkan waktu saat ini (dalam timezone GMT+8 secara default). dengan output berupa string */
function datetime_now($alphanum = false, $timezone = 'Asia/Hong_Kong')
{
  $now = new DateTime();
  $now->setTimezone(new DateTimeZone($timezone));
  $data = $now->format('Y-m-d H:i:s');

  if ($alphanum != false) {
    $data = preg_replace("/[^A-Za-z0-9]/", '', $data);
  }

  return $data;
}

/** fungsi datetime generator + timezone
 * - param1: format date pake string default: Y-m-d
 * - param2: kalau value = "set" param3 harus diisi dengan datetime yg valid, kalau di set dengan string format seperti now, 1 day ago, +5 day, +5 hour akan melakukan modifikasi terhadap date yang dicetak
 * - param3: value datetime, default null, tapi kalau diisi maka akan mengacu pada tanggal tersebut
 * - param4: timezone berdasarkan aturan string php, default adalah Asia/Hong_Kong (GMT+8)
 */
function em_date($format = "Y-m-d", $when = "now", $datetime = null, $timezone = 'Asia/Hong_Kong')
{
  if ($datetime != null) {
    $dt = new DateTime($datetime, new DateTimeZone($timezone));
    if ($when != "set") {
      $dt->modify($when);
    }
    $data = $dt->format($format);
    return $data;
  } else {
    $dt = new DateTime($when, new DateTimeZone($timezone));
    $data = $dt->format($format);
    return $data;
  }
}

/** ambil data tanggal saat ini, dan lakukan split per tahun, bulan, hari, jam, menit */
function datetime_array($timezone = 'Asia/Hong_Kong')
{
  $now = new DateTime();
  $now->setTimezone(new DateTimeZone($timezone));
  $data = $now->format('Y-m-d H:i:s');

  $split_date = explode(' ', $data);
  $date = explode('-', $split_date[0]);
  $time = explode(':', $split_date[1]);

  $result = array(
    'year' => $date[0],
    'month' => $date[1],
    'day' => $date[2],

    'hour' => $time[0],
    'minute' => $time[1],
  );

  return $result;
}

/** fungsi ini digunakan utk melakukan switching pada nomor yang didapat dari datetime_now($alphanum = true) */
function switch_numbers($numbers)
{
  $result = '';
  $splitArray = str_split($numbers);
  foreach ($splitArray as $key => $value) { /* lakukan konversi karakter disini */
    $result .= key_reference($value);
  }
  return $result;
}

/** fungsi ini digunakan dalam fungsi switch_numbers() */
function key_reference($digit)
{
  switch ($digit) {
    case '0': {
        $txt = '3';
        break;
      }
    case '1': {
        $txt = '4';
        break;
      }
    case '2': {
        $txt = '7';
        break;
      }
    case '3': {
        $txt = '2';
        break;
      }
    case '4': {
        $txt = '8';
        break;
      }
    case '5': {
        $txt = '0';
        break;
      }
    case '6': {
        $txt = '1';
        break;
      }
    case '7': {
        $txt = '9';
        break;
      }
    case '8': {
        $txt = '5';
        break;
      }
    case '9': {
        $txt = '6';
        break;
      }
    default: {
        $txt = 'x';
        break;
      }
  }
  return $txt;
}

/** ubah string dalam format datetime mysql menjadi string dalam format waktu indonesia. output yang dihasilkan berbentuk array yang berisi tanggal, waktu, dan tanggal+waktu (output berupa string kosong apabila parameter fungsi tidak diisi) */
function datetime_to_view($datetime_string = '')
{
  if (strlen($datetime_string) >= 19) {
    $split = explode(' ', $datetime_string);
    $date = $split[0];
    $time = $split[1];
    $split_date = explode('-', $date);
    $split_time = explode(':', $time);
    $dateview = $split_date[2] . '/' . $split_date[1] . '/' . $split_date[0];
    $timeview = $split_time[0] . ':' . $split_time[1];
    $result = array(
      'date' => $dateview,
      'time' => $timeview,
      'datetime' => $dateview . ' ' . $timeview
    );
  } else {
    $result = array(
      'date' => '',
      'time' => '',
      'datetime' => ''
    );
  }
  return $result;
}

/** fungsi ini untuk mengubah format SQL date menjadi view format date, return string */
function date_to_view($date_string = "")
{
  if (strlen($date_string) >= 10) {
    $split = explode('-', $date_string);
    return $split[2] . '/' . $split[1] . '/' . $split[0];
  } else {
    return '';
  }
}

/** ubah string datetime dalam format indonesia menjadi string datetime dalam format mysql. output berupa string
 * - **require :** date string & time string (if it's datetime, split them first)
 * - **output :** string sql datetime
 */
function datetime_to_sql($date_string = '', $time_string = '')
{
  $time = ($time_string != '') ? $time_string . ':00' : '00:00:00';
  if ($date_string != '') {
    $split = explode('/', $date_string);
    $result = $split[2] . '-' . $split[1] . '-' . $split[0] . ' ' . $time;
  } else {
    $result = '0000-00-00 00:00:00';
  }
  return $result;
}

/** buat perhitungan elapsed time dengan membandingkan datetime yang ada di parameter dengan datetime sekarang (saat ini) dan output hasilnya berupa string */
function datetime_elapsed_time($datetime = '', $full = false, $lang = 'en', $array = false)
{
  $datetime = ($datetime == '') ? datetime_now() : $datetime;
  date_default_timezone_set('Asia/Hong_Kong');
  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);

  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;

  /* pemilihan bahasa */
  if ($lang == 'en') { /* pakai format english */
    $string = array(
      'y' => 'Year',
      'm' => 'Month',
      'w' => 'Week',
      'd' => 'Day',
      'h' => 'Hour',
      'i' => 'Minute',
      's' => 'Second',
    );
    foreach ($string as $key => &$value) {
      if ($diff->$key) {
        $value = $diff->$key . ' ' . $value . ($diff->$key > 1 ? 's' : '');
      } else {
        unset($string[$key]);
      }
    }
    $text_ag = ' ago';
    $text_jn = ' just now';
  } elseif ($lang == 'id') { /* pakai format indonesia */
    $string = array(
      'y' => 'Tahun',
      'm' => 'Bulan',
      'w' => 'Minggu',
      'd' => 'Hari',
      'h' => 'Jam',
      'i' => 'Menit',
      's' => 'Detik',
    );
    $text_ag = ' yang lalu';
    $text_jn = ' baru saja';
    foreach ($string as $key => &$value) {
      if ($diff->$key) {
        $value = $diff->$key . ' ' . $value . ($diff->$key > 1 ? '' : '');
      } else {
        unset($string[$key]);
      }
    }
  } else {
    // untuk menampilkan number saja
    $string = array(
      'y' => '',
      'm' => '',
      'w' => '',
      'd' => '',
      'h' => '',
      'i' => '',
      's' => '',
    );
    $text_ag = '';
    $text_jn = '';
    foreach ($string as $key => &$value) {
      if ($diff->$key) {
        $value = $diff->$key . $value . ($diff->$key > 1 ? '' : '');
      } else {
        $value = '0';
      }
    }
  }

  // ini untuk menentukan kalau tidak full maka expected nilai integer
  if (!$full) $string = array_slice($string, 0, 1);

  if ($array) {
    return $string;
  } else {
    $string = (is_array($string)) ? implode(', ', $string) . $text_ag : $text_jn;
    return $string;
  }
}

/** convert angka parameter menjadi format yang lebih singkat (contoh : 1,43m) */
function short_num($num, $decimals = 2, $lang = 'en',  $caps = false)
{
  /* cek locale */
  if ($lang == 'en') {
    $suffix = array('k', 'm', 'b');
    $thousand_separator = ',';
    $decimal_separator = '.';
  } else {
    $suffix = array('rb', 'jt', 'm');
    $thousand_separator = '.';
    $decimal_separator = ',';
  }

  /* cek huruf besar/kecil pada suffix */
  foreach ($suffix as $key => $value) {
    if ($caps) {
      $suffix[$key] = ' ' . strtoupper($value);
    } else {
      $suffix[$key] = ' ' . $value;
    }
  }

  /* mulai perhitungan */
  if ($num < 1000) {
    $result = $num;
  } else if ($num < 1000000) {
    // apapun yang kurang dari 1 juta
    $result = number_format(
      $num / 1000,
      $decimals,
      $decimal_separator,
      $thousand_separator
    ) . $suffix[0];
  } else if ($num < 1000000000) {
    // apapun yang kurang dari 1 milyar
    $result = number_format(
      $num / 1000000,
      $decimals,
      $decimal_separator,
      $thousand_separator
    ) . $suffix[1];
  } else {
    // apapun yang kurang dari 1 triliun
    $result = number_format(
      $num / 1000000000,
      $decimals,
      $decimal_separator,
      $thousand_separator
    ) . $suffix[2];
  }

  return $result;
}

/** lakukan enkripsi bcrypt pada string password yang diisi sebagai parameter. output berupa hashed password */
function encrypt_pwd($pwd)
{
  // hash passwordnya
  $simp = md5(md5($pwd));
  $hashed = password_hash($simp, PASSWORD_BCRYPT);
  return $hashed;
}

/** lakukan autentikasi pada hashed password yang diisi sebagai parameter. output berupa boolean TRUE jika password sesuai, FALSE jika password tidak sesuai */
function verify_pwd($pwd, $hashedPwd)
{
  // verify passwordnya
  $simp = md5(md5($pwd));
  $result = password_verify($simp, $hashedPwd);
  return $result;
}

/** ubah php array menjadi string yang dipisah tiap value-nya menggunakan <br> HTML tag */
function print_array_as_html($array)
{
  $string = '';
  foreach ($array as $key => $value) {
    // cek apakah ini merupakan key value terakhir
    end($array);
    if ($key === key($array)) {
      // jika iya tampilkan tanpa menambahkan <br> tag
      $string .= '<b>[ ' . $key . ' ]</b><br>' . $value;
    } else {
      // jika tidak tampilkan menambahkan <br> tag
      $string .= '<b>[ ' . $key . ' ]</b><br>' . $value . '<br><br>';
    }
  }
  return $string;
}

/** fungsi ini digunakan untuk mengambil src pertama dari tag img yang ada di dalam, string text html, opsi kedua jika true akan return semua result (array), jika false return 1 match saja (string) */
function get_img_tag($html_text, $all = false)
{
  $image = '';
  if ($all != true) {
    preg_match_all('/< *img[^>]*src *= *["\']?([^"\']*)/i', $html_text, $image);
    if ($image != null && $image != '') {
      return $image[1];
    } else {
      return '';
    }
  } else {
    preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $html_text, $image);
    if ($image != null && $image != '') {
      return $image;
    } else {
      return '';
    }
  }
}

/** fungsi untuk generate salt random pada m_user, karena sekarang menggunakan bcrypt */
function micin()
{
  $salt = md5(md5(microtime()));
  $micin = substr($salt, -7);
  return strtoupper($micin);
}

/** fungsi untuk merubah angka menjadi Rp. */
function to_rp($number = 0, $prefix = true)
{
  $num = number_format(round($number, 2, PHP_ROUND_HALF_UP), 2, ',', '.');
  if ($prefix) {
    return 'Rp. ' . $num;
  } else {
    return $num;
  }
}

/** fungsi ini digunakan untuk mensimulasikan left join pada MySQL, namun diterapkan pada 2 array php yang di tarik dari model, $left_array merupakan tabel masternya, $right_array merupakan tabel yang akan dijoin, $left_id merupakan id dari tabel master yang akan di hubungkan dengan foreign key ($right_id) dari tabel ( NOTE : nama key dari tabel foreign akan ditambahkan prefix '_' utk menghindari bentrok ) */
function left_join_array($master_table, $foreign_table, $master_id, $foreign_id = NULL)
{
  $final = array();

  if (empty($foreign_id))
    // kalau foregin id kosong, maka akan diasumsikan bahwa namanya sama dengan master id
    $foreign_id = $master_id;

  foreach ($master_table as $mk => $mval) {
    // masukkan data master ke dalam array baru
    $final[$mk] = $mval;

    // lakukan pengecekan loop dari tabel foreign
    foreach ($foreign_table as $fk => $fval) {

      if ($mval[$master_id] == $fval[$foreign_id]) {
        // jika valuenya master id dan foreign id valuenya sama, tambahkan data dari tabel foreign ke dalam array baru
        foreach ($fval as $index => $data)
          $final[$mk]['_' . $index] = $data;
        break; // lakukan break disini agar value yang sudah ditambahkan tadi tidak ditumpuk
      } else {
        // jika valuenya master id dan foreign id valuenya berbeda, isi saja datanya dengan null
        foreach ($fval as $index => $data)
          $final[$mk]['_' . $index] = NULL;
      }
    }
  }
  return $final;
}

/** fungsi ini untuk mengubah empty string / null menjadi strip 
 * fungsi ini juga menerima suffix, kalau tidak kosong akan ditambahkan spasi + suffix
 */
function null_to_dash($string, $suffix = '')
{
  if (isset($string)) {
    if ($string != null) {
      $text = trim($string);
      $suffix = ($suffix != '') ? ' ' . $suffix : '';
      return ($text == '' || $text == '-') ? '-' : $text . $suffix;
    } else {
      return '-';
    }
  } else {
    return '-';
  }
}

/** fungsi untuk sanitize string menggunakan strip tags dan trim */
function sanitize_string($string)
{
  $string = strip_tags(trim($string));
  return $string;
}

/** fungsi untuk mencetak menu sidebar pada sistem cuti */
function menu_loader($privilege = '200', $menu = 'dashboard')
{
  /// |----------------------------------------------------------------------
  /// | NOTE BEFORE USING
  /// |----------------------------------------------------------------------
  // sebelum menggunakan fungsi ini sesuaikan style menu di bawah
  // dan pastikan ada permission tag (privilege dipisah dengan koma)
  // dan pastikan ada order, untuk mengurutkan menunya
  $CI = &get_instance();
  $table = 'm_menu';
  // query untuk tarik data menu
  $data = $CI->db->select('*')->from($table)
    ->where('id <> 0')
    ->group_start()
    ->like('permission', 'all')
    ->or_like('permission', $privilege)
    ->group_end()
    ->order_by('order', 'asc')->get()->result_array();
  if (isset_nn_nes($data)) {
    foreach ($data as $v) {
      if ($v['module'] == '-') {
        // output hr separator
        echo '<hr>';
      } else {
        // output menu
        $active = ($menu == $v['module']) ? 'active' : '';
        echo '' .
          '<a href="' . site_url($v['link']) . '" class="item ' . $active . '">
            <div class="bg"></div>
            <i class="fa ' . $v['icon'] . ' fa-fw"></i> ' . $v['name'] . '
          </a>';
      }
    }
  }
}

/** fungsi untuk pengecekan akses menu sistem cuti, return true kalau boleh mengakses */
function menu_auth($privilege = '200', $menu = '-')
{
  /// |----------------------------------------------------------------------
  /// | NOTE BEFORE USING
  /// |----------------------------------------------------------------------
  // pastikan ada permission tag (privilege dipisah dengan koma)
  // dan pastikan ada order, untuk mengurutkan menunya
  $CI = &get_instance();
  $table = 'm_menu';
  // query untuk tarik data menu
  $data = $CI->db->select('*')->from($table)
    ->where('id <> 0')
    ->where('module', $menu)
    ->group_start()
    ->like('permission', 'all')
    ->or_like('permission', $privilege)
    ->group_end()
    ->get()->num_rows();
  if ($data > 0) {
    return true;
  } else {
    return false;
  }
}

/** fungsi ambild ata user_menu untuk ditata nanti di sidebar listing */
function menu_loader_sipedal($username, $kewenangan)
{
  $CI = &get_instance();
  if ($kewenangan == 11) {
    $username = "atasan_langsung";
  }
  $data = $CI->db->select('*')->from('v_user_menu')->where(array(
    'username' => $username
  ))->order_by('no_urut', 'asc')->get()->result_array();
  if ($data) {
    $menu = $CI->session->userdata('menu');
    $html = '';
    foreach ($data as $r) {
      if ($r['module_id'] == '0000hr') {
        $html .= '<hr>';
      } else {
        $active = ($menu == $r['module']) ? 'active' : '';
        $html .= '' .
          '<a href="' . site_url($r['url_module']) . '" class="item ' . $active . '">
            <div class="bg"></div>
            <i class="' . $r['icon_module'] . ' me-1"></i> ' . $r['nama_module'] .
          '</a>';
      }
    }
    return $html;
  } else {
    return '- NO ACCESS -';
  }
}

/** fungsi untuk autentikasi akses menu */
function menu_auth_sipedal($username, $module, $kewenangan)
{
  $CI = &get_instance();
  if ($kewenangan == '11') {
    // gunakan username atasan_langsung
    $username = 'atasan_langsung';
  }
  $cek = $CI->db->get_where('v_user_menu', array(
    'username' => $username,
    'module' => $module
  ))->num_rows();
  if ($cek > 0) {
    return true;
  } else {
    return false;
  }
}

/** fungsi untuk membuat log */
function log_generator($username = '-', $table = '-', $object = '-', $message = '-')
{
  $curdate = datetime_now();
  $CI = &get_instance();
  $data = array(
    'subject' => $username,
    'table' => $table,
    'object' => $object,
    'message' => $message,
    'datetime' => $curdate
  );
  $CI->db->insert('r_log', $data);
}

/** fungsi untuk generate no dokumen */
function generate_no_dok()
{
  $CI = &get_instance();
  $curyear = date('Y');
  $no = $CI->db->select('id')->from('r_dok_sewa')
    ->like('tgl_dok', $curyear)->get()->num_rows();
  $numbering = str_pad(($no + 1), 5, '0', STR_PAD_LEFT);
  return "MNJD-$curyear-$numbering";
}

/** fungsi untuk merubah int menit menjadi int jam dan int menit
 * - return array [hour, minute] if format = int
 * - return time format (string) if format = time
 * - return false if format isn't specified
 */
function min_to_hour_and_min($int_minute, $format = 'int')
{
  $hour = floor($int_minute / 60);
  $minute = $int_minute % 60;
  if ($format == 'int') {
    return [
      'hour' => $hour,
      'minute' => $minute
    ];
  } elseif ($format == 'time') {
    $hour = str_pad($hour, 2, '0', STR_PAD_LEFT);
    $minute = str_pad($minute, 2, '0', STR_PAD_LEFT);
    return "$hour:$minute:00";
  } else {
    return false;
  }
}

/** fungsi untuk konversi time awal dan durasi dalam menit menjadi interval antara 2 time value
 * - return berupa string
 * - jika full_datetime = true, harap untuk menggunakan datetime format pada parameter string_time_start
 */
function min_to_jam_kerja($string_time_start, $durasi_menit, $full_datetime = false)
{
  $start = strtotime($string_time_start);
  $durasi = $durasi_menit * 1;
  if ($full_datetime) {
    $start_time = date("Y-m-d H:i:s", strtotime("+0 minutes", $start));
    $end_time = date("Y-m-d H:i:s", strtotime("+$durasi minutes", $start));
  } else {
    $start_time = date("H:i", strtotime("+0 minutes", $start));
    $end_time = date("H:i", strtotime("+$durasi minutes", $start));
  }
  return "$start_time - $end_time";
}

/** fungsi untuk mendapatkan semua tanggal yang ada sejak mulai sampai akhir (inclusion)
 * - required : kedua format harus Y-m-d
 */
function get_all_date_in_between($start_date, $end_date)
{
  $begin = new DateTime($start_date);
  $end = new DateTime($end_date);

  $interval = DateInterval::createFromDateString('1 day');
  $period = new DatePeriod($begin, $interval, $end);

  $arr = [];
  $i = 0;
  foreach ($period as $dt) {
    $arr[$i] = $dt->format("Y-m-d");
    $i++;
  }

  // include tgl akhir
  $arr[$i] = $end_date;

  return $arr;
}

/** fungsi utk output respon via ajax
 * - require array yang berisi :
 * - - status : true/false
 * - - message : pesannya apa
 * - - additional data if needed
 */
function ajax_response($array_res)
{
  $CI = &get_instance();
  $CI->output
    ->set_content_type('application/json')
    ->set_output(json_encode($array_res));
}

function get_status_id_hari_kerja($int_code = 0, $with_label = false)
{
  $result = ($with_label)
    ? '<div class="badge bg-danger">Belum di-set</div>'
    : "Belum di-set";
  switch ($int_code) {
    case 1: {
        $result = ($with_label)
          ? '<div class="badge bg-info text-black">5 Hari Kerja</div>'
          : '5 Hari Kerja';
        break;
      }
    case 2: {
        $result = ($with_label)
          ? '<div class="badge bg-primary">6 Hari Kerja</div>'
          : '6 Hari Kerja';
        break;
      }
    case 99: {
        $result = ($with_label)
          ? '<div class="badge bg-warning text-black">Shift</div>'
          : 'Shift';
        break;
      }
    default:
      break;
  }
  return $result;
}

function ssh_get_volume_selection()
{
  $CI = &get_instance();
  $query =  $CI->db->select('volume_standar')->from('r_standarharga')
    ->order_by('volume_standar', 'ASC')->group_by('volume_standar')->get();
  return [
    'count' => $query->num_rows(),
    'data' => $query->result_array()
  ];
}

function keg_get_unor_selection()
{
  $CI = &get_instance();
  $query =  $CI->db->select('kode_unor, ket_unor')->from('m_unor')
    ->order_by('kode_unor', 'ASC')->group_by('kode_unor')->get();
  return [
    'count' => $query->num_rows(),
    'data' => $query->result_array()
  ];
}

function keg_get_kegiatan_selection()
{
  $CI = &get_instance();
  $query =  $CI->db->select('kode_kegiatan, uraian_kegiatan')->from('m_kegiatan')->where([
    'jns_kegiatan' => 'D'
  ])->order_by('kode_kegiatan', 'ASC')->group_by('kode_kegiatan')->get();
  return [
    'count' => $query->num_rows(),
    'data' => $query->result_array()
  ];
}
