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

/**
 * Checks if a variable has a valid value (not empty).
 * 
 * @param mixed $data The variable to check
 * @param string|int|null $key_to_check If $data is an array/object, check this specific key/property
 * @param mixed $placeholder_if_not_valid Value to return if check fails
 * @return mixed Returns boolean result of check or placeholder/original value based on parameters
 */
function check_var($data, $key_to_check = null, $placeholder_if_not_valid = null)
{
  // Special handling for $placeholder_if_not_valid parameter
  $use_placeholder = func_num_args() > 2;

  // First, get the target data to check
  if ($key_to_check !== null) {
    if (is_array($data) && array_key_exists($key_to_check, $data)) {
      $data = $data[$key_to_check];
      $exists = true;
    } elseif (is_object($data) && property_exists($data, $key_to_check)) {
      $data = $data->$key_to_check;
      $exists = true;
    } else {
      $exists = false;
    }
  } else {
    $exists = true;
  }

  // If the key doesn't exist, return false or the placeholder
  if (!$exists) {
    return $use_placeholder ? $placeholder_if_not_valid : false;
  }

  // Check if the value is valid (not empty)
  $is_valid = false;

  if (is_array($data)) {
    $is_valid = count($data) > 0;
  } elseif (is_object($data)) {
    $is_valid = true; // Objects are always considered valid, unless null
  } elseif (is_numeric($data) || $data === '0' || $data === 0) {
    $is_valid = true; // Fix: Numeric values (including 0) are considered valid
  } else {
    $is_valid = trim((string)$data) !== '';
  }

  // Return appropriate value based on validity and placeholder setting
  if ($use_placeholder) {
    return $is_valid ? $data : $placeholder_if_not_valid;
  }

  return $is_valid;
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

function em_date($format = "Y-m-d", $when = "now", $datetime = null, $lang = 'id', $timezone = 'Asia/Hong_Kong')
{
  if (!check_var($datetime) && $when != "now") return '';

  if (check_var($datetime) && $datetime != null) {
    $dt = new DateTime($datetime, new DateTimeZone($timezone));
    if ($when != "set") {
      $dt->modify($when);
    }
  } else {
    $dt = new DateTime($when, new DateTimeZone($timezone));
  }

  $id_month_short = indonesian_month($dt->format('n'));
  $id_month_full = indonesian_month($dt->format('n'), true);

  if ($format == 'elapsed') {
    return time_elapsed_string($dt, $lang);
  } elseif ($format == 'j M Y' && $lang == 'id') {
    return $dt->format('j') . ' ' . $id_month_short . ' ' . $dt->format('Y');
  } elseif ($format == 'j F Y' && $lang == 'id') {
    return $dt->format('j') . ' ' . $id_month_full . ' ' . $dt->format('Y');
  } elseif ($format == 'j M Y, H:i:s' && $lang == 'id') {
    return $dt->format('j') . ' ' . $id_month_short . ' ' . $dt->format('Y') . ', ' . $dt->format('H:i:s');
  } elseif ($format == 'j F Y, H:i:s' && $lang == 'id') {
    return $dt->format('j') . ' ' . $id_month_full . ' ' . $dt->format('Y') . ', ' . $dt->format('H:i:s');
  } else {
    return $dt->format($format);
  }
}

function indonesian_month($month_number = 1, $full = false)
{
  $short_months = [
    1 => 'Jan',
    2 => 'Feb',
    3 => 'Mar',
    4 => 'Apr',
    5 => 'Mei',
    6 => 'Jun',
    7 => 'Jul',
    8 => 'Agu',
    9 => 'Sep',
    10 => 'Okt',
    11 => 'Nov',
    12 => 'Des',
  ];

  $full_months = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember',
  ];

  return $full ? $full_months[$month_number] : $short_months[$month_number];
}

function time_elapsed_string($datetime, $lang = 'id', $full = false)
{
  $now = new DateTime();
  $ago = $datetime;
  $diff = $now->diff($ago);

  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;

  if ($lang == 'id') {
    // Translations for Bahasa Indonesia
    $string = array(
      'y' => 'tahun',
      'm' => 'bulan',
      'w' => 'minggu',
      'd' => 'hari',
      'h' => 'jam',
      'i' => 'menit',
      's' => 'detik',
    );
    $suffix = ' yang lalu';
    $now_string = 'baru saja';
  } else {
    // Default to English
    $string = array(
      'y' => 'year',
      'm' => 'month',
      'w' => 'week',
      'd' => 'day',
      'h' => 'hour',
      'i' => 'minute',
      's' => 'second',
    );
    $suffix = ' ago';
    $now_string = 'just now';
  }

  foreach ($string as $k => &$v) {
    $multi_suffix = ($lang == 'en') ? 's' : '';
    if ($diff->$k) {
      $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? $multi_suffix : '');
    } else {
      unset($string[$k]);
    }
  }

  if (!$full) $string = array_slice($string, 0, 1);
  return $string ? implode(', ', $string) . $suffix : $now_string;
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

/** fungsi untuk ngambil data yang ada di field tertentu pada tabel sesuai dengan kondisi `where` */
function fetch_single_data($table_name, $field_name, $where = null, $placeholder = '')
{
  $CI = &get_instance();
  if ($where == null) return $placeholder;
  $q = $CI->db->get_where($table_name, $where);
  $count = $q->num_rows();
  if ($count < 1) return $placeholder;
  $data = $q->row_array();
  if (!isset($data[$field_name])) return $placeholder;

  return $data[$field_name];
}

/** fungsi untuk ngambil 1 row dari tabel dengan kondisi yang ditentukan */
function fetch_row_data($table_name, $where = null, $placeholder = '')
{
  $CI = &get_instance();
  if ($where == null) return $placeholder;
  $q = $CI->db->get_where($table_name, $where);
  $count = $q->num_rows();
  if ($count < 1) return $placeholder;
  $data = $q->row_array();

  return $data;
}

/** fungsi untuk ngambil nilai apakah ada atau tidak di DB */
function fetch_num_rows($table_name, $where = null)
{
  $CI = &get_instance();
  if ($where == null) return 0;
  $q = $CI->db->get_where($table_name, $where);
  $count = $q->num_rows();

  return $count;
}

/**
 * Securely get POST input with optional XSS filtering.
 */
function post_safe($key = null, $default = null)
{
  $CI = &get_instance();
  $value = $CI->input->post($key, TRUE); // TRUE enables XSS filtering

  return $value !== null ? $value : $default;
}

/**
 * Securely get GET input with optional XSS filtering.
 */
function get_safe($key = null, $default = null)
{
  $CI = &get_instance();
  $value = $CI->input->get($key, TRUE);

  return $value !== null ? $value : $default;
}

/** fungsi untuk ngecek kewenangan di sesi dan menentukan apakah yg login saat ini termasuk admin (output : true / false) */
function is_admin()
{
  $CI = &get_instance();
  $cur_kewenangan = $CI->session->userdata('kewenangan');

  return ($cur_kewenangan == '00' || $cur_kewenangan == '02')
    ? true : false;
}

// Define a mapping from digits to character strings
function get_digit_to_string_mapping()
{
  return [
    '0' => 'SD',
    '1' => 'KJ',
    '2' => 'MM',
    '3' => 'BY',
    '4' => 'RH',
    '5' => 'JL',
    '6' => 'WW',
    '7' => 'TN',
    '8' => 'NB',
    '9' => 'XT'
  ];
}

// Define a reverse mapping from character strings to digits
function get_string_to_digit_mapping()
{
  $mapping = get_digit_to_string_mapping();
  return array_flip($mapping);
}

/** Encrypt a numeric ID into a string */
function encrypt_id($numericID)
{
  $mapping = get_digit_to_string_mapping();
  $encrypted = '';
  // Iterate through each digit in the numeric ID
  foreach (str_split($numericID) as $digit) {
    // Append the corresponding string from the mapping
    if (check_var($mapping, $digit)) {
      $encrypted .= $mapping[$digit];
    } else {
      $encrypted .= '';
    }
  }
  return $encrypted;
}

/** Decrypt a string back into a numeric ID */
function decrypt_id($stringID)
{
  $mapping = get_string_to_digit_mapping();
  $decrypted = '';
  // Iterate through substrings of the string ID
  for ($i = 0; $i < strlen($stringID); $i += 2) {
    $subStr = substr($stringID, $i, 2);
    // Append the corresponding digit from the reverse mapping
    if (check_var($mapping, $subStr)) {
      $decrypted .= $mapping[$subStr];
    } else {
      $decrypted .= '';
    }
  }
  return $decrypted;
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

/** simple function to get default periode bln array */
function array_periode_bulan()
{
  return [
    '01' => '01 - Januari',
    '02' => '02 - Februari',
    '03' => '03 - Maret',
    '04' => '04 - April',
    '05' => '05 - Mei',
    '06' => '06 - Juni',
    '07' => '07 - Juli',
    '08' => '08 - Agustus',
    '09' => '09 - September',
    '10' => '10 - Oktober',
    '11' => '11 - November',
    '12' => '12 - Desember',
  ];
}

/** fungsi untuk ngecek permission ke database langsung, output true/false
 * @param $menu: id_menu yang diakses, cek tabel m_menu
 * @param $action: aksi yang akan dilakukan (read/ insert/ update/ delete/ verif)
 * @return boolean
 */
function check_perm($action, $menu = null)
{
  $CI = &get_instance();
  $cur_kewenangan = $CI->session->userdata('kewenangan');
  $cur_menu = ($menu === null)
    ? $CI->session->userdata('menu')
    : $menu;

  $valid_action = ['read', 'insert', 'update', 'delete', 'verif'];

  if (!in_array($action, $valid_action)) return false;

  $dataset = $CI->db->select($action)
    ->from('v_kewenangan_menu')
    ->group_start()
    ->where(['id_kewenangan' => $cur_kewenangan])
    ->or_where(['id_kewenangan' => 'OK'])
    ->group_end()
    ->where(['id_menu' => $cur_menu])
    ->get()->row_array();

  return ($dataset[$action] == 'YES') ? true : false;
}

/** fungsi untuk menghapus semua karakter pada string yang bukan alphanumeric atau spasi */
function str_alphanumeric_space($string)
{
  $filtered = preg_replace("/[^a-zA-Z0-9 ]/", "", $string);
  return $filtered;
}

/** fungsi untuk mencetak menu sidebar pada sistem cuti */
function menu_loader($echo = true)
{
  /// |----------------------------------------------------------------------
  /// | NOTE BEFORE USING
  /// |----------------------------------------------------------------------
  // sebelum menggunakan fungsi ini sesuaikan style menu di bawah
  // dan pastikan ada permission tag (privilege dipisah dengan koma)
  // dan pastikan ada order, untuk mengurutkan menunya
  $CI = &get_instance();
  $table = 'v_kewenangan_menu';

  $cur_kewenangan = $CI->session->userdata('kewenangan');
  $cur_menu = $CI->session->userdata('menu');

  // query untuk tarik data menu
  $data = $CI->db->select('*')->from($table)
    ->group_start()
    ->where(['id_kewenangan' => $cur_kewenangan])
    ->or_where(['id_kewenangan' => 'OK'])
    ->group_end()
    ->where(['read' => 'YES'])
    ->order_by('order', 'asc')->get()->result_array();

  $html = '';
  $cur_parent_dropdown = false;
  if (isset_nn_nes($data)) {
    foreach ($data as $v) {
      if ($v['id_menu'] == '-') {
        // output hr separator
        $html .= '<hr>';
      } else {
        // output menu
        $active = ($cur_menu == $v['id_menu']) ? 'selected' : '';
        $icon = check_var($v, 'icon', 'mdi mdi-view-dashboard');
        $subs = (check_var($v, 'menu_sub', false) === false)
          ? ''
          : '<div class="sub">' . $v['menu_sub'] . '</div>';

        if ($cur_parent_dropdown && $v['is_child'] == 'NO') {
          /// |----------------------------------------
          /// | CLOSE THE DROPDOWN
          /// |----------------------------------------
          $html .= '</ul></li>';
          $cur_parent_dropdown = false;
        }

        if (
          !$cur_parent_dropdown &&
          $v['is_parent'] == 'YES'
          && $v['is_child'] == 'NO'
        ) {
          /// |----------------------------------------
          /// | BUATKAN OPENER UNTUK DROPDOWN
          /// |----------------------------------------
          $cur_parent_dropdown = true;
          if (strpos($cur_menu, $v['id_menu']) !== false) {
            $parent_active = 'selected';
            $a_expand = 'true';
            $c_open = 'expand';
          } else {
            $parent_active = '';
            $a_expand = 'false';
            $c_open = 'collapse';
          }
          $html .= '<li class="bz_sidebar_item parent_item ' . $v['id_menu'] . ' ' . $parent_active . '">
            <a class="sidebar_link" href="javascript:void(0)" aria-expanded="' . $a_expand . '">
              <div class="icon"><i class="' . $icon . '"></i></div>
              <div class="menu_title">
                <div class="main">' . check_var($v, 'menu_title', 'UNKNOWN') . '<i class="dropdown-arrow dropdown-arrow-' . $v['id_menu'] . ' fas fa-chevron-down"></i></div>
                ' . $subs . '
              </div>
              <ul aria-expanded="' . $a_expand . '" class="' . $c_open . ' first-level">';

          continue;
        }

        /// |----------------------------------------
        /// | OUTPUT MENU NORMALLY
        /// |----------------------------------------
        if (check_var($v, 'on_dev', 'NO') == 'YES') {
          $href = 'href="#"';
          $onclick = 'onclick="on_dev()"';
        } else {
          $href = 'href="' . site_url(check_var($v, 'url', '#')) . '"';
          $onclick = '';
        }
        $html .= '<li class="bz_sidebar_item ' . $v['id_menu'] . ' ' . $active . '">
            <a ' . $href . ' ' . $onclick . ' class="sidebar_link">
              <div class="icon"><i class="' . $icon . '"></i></div>
              <div class="menu_title">
                <div class="main">' . check_var($v, 'menu_title', 'UNKNOWN') . '</div>
                ' . $subs . '
              </div>
            </a>
          </li>';
      }
    }
  }

  if ($echo) {
    echo $html;
  } else {
    return $html;
  }
}

/** fungsi utk output array sebagai json response, parameter kedua merupakan response code (default: 200) */
function output_json($response_array, $status_code = 200)
{
  $CI = &get_instance();
  $CI->output
    ->set_content_type('application/json')
    ->set_status_header($status_code)
    ->set_output(json_encode($response_array));
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

/** fungsi utk ngecek data apa aja yang diganti / diupdate dengan membandingkan data original dan data yang diupdate, return array ['before' => [], 'after' => []] */
function get_changed_data($original_array, $update_array)
{
  $before = [];
  $after = [];

  foreach ($update_array as $key => $newValue) {
    // Only compare keys that exist in the original record
    if (array_key_exists($key, $original_array)) {
      $oldValue = $original_array[$key];

      // Optional: normalize both values for fair comparison (e.g., trim, cast types)
      if ($oldValue != $newValue) {
        $before[$key] = $oldValue;
        $after[$key] = $newValue;
      }
    }
  }

  return [
    'before' => $before,
    'after' => $after
  ];
}

/** fungsi untuk format result array jadi readable string menggunakan `|` sebagai separator */
function format_log_view($array_data)
{
  $parts = [];
  foreach ($array_data as $k => $v) {
    $parts[] = "`{$k}` : `{$v}`";
  }
  return implode(" | ", $parts);
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
