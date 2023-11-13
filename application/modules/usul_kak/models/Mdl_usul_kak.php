<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_usul_kak extends CI_Model
{
  /** fungsi untuk menarik data dari database */
  public function get($table, $where = null, $result_array = false)
  {
    if ($where != null) {
      if ($result_array) {
        $result = $this->db->get_where($table, $where)->result_array();
      } else {
        $result = $this->db->get_where($table, $where)->row_array();
      }
    } else {
      $result = $this->db->select('*')->from($table)->get()->result_array();
    }
    return $result;
  }

  /** fungsi untuk mengecek num_rows return int */
  public function check($table, $where = null)
  {
    if ($where != null) {
      $result = $this->db->get_where($table, $where)->num_rows();
    } else {
      $result = $this->db->select('*')->from($table)->get()->num_rows();
    }
    return $result;
  }

  /* fungsi untuk menarik data dari DB dan konversi ke dataset untuk jquery datatable */
  public function get_datatable($table, $data, $primary_key = 'id_kak')
  {
    // lakukan filtering data
    // deklarasi where condition
    $where_search = (isset_nn_nes($data['search']))
      ? "AND (uraian_kegiatan LIKE '%$data[search]%' 
    OR deskripsi LIKE '%$data[search]%')"
      : "";
    /* kalau ada tambahan where condition bisa add lagi di atas */
    $where_kode_unor = "";
    $where_tgl = "";
    $where_kode_ukerja = "";
    // deklarasi query yang digunakan
    $query_result = $this->db->query("SELECT * FROM $table 
    WHERE $primary_key IS NOT NULL $where_search $where_tgl $where_kode_ukerja 
    ORDER BY $data[order_column] $data[order_sort]
    LIMIT $data[start], $data[length]");
    $query_total = $this->db->query("SELECT * FROM $table 
    WHERE $primary_key IS NOT NULL $where_search $where_tgl $where_kode_ukerja");
    // cari total hasil
    $total_count = 0;
    while ($row = $query_total->unbuffered_row()) {
      $total_count += 1;
    }
    // cari data result + penomoran
    $no = $data['start'] + 1;
    $index = 0;
    $data_result = array();
    while ($row = $query_result->unbuffered_row('array')) {
      $data_result[$index] = $row;
      /// |----------------------------------------------------------------------
      /// | PENATAAN DATA SEBELUM DIMASUKKAN KE DALAM RESULT_ARRAY
      /// |----------------------------------------------------------------------
      $data_result[$index]['no'] = $no;
      $data_result[$index]['total_belanja'] = 0;
      $no += 1;
      $index += 1;
    }
    // kembalikan data yang didapat ke controller
    return array(
      'total' => $total_count,
      'filtered' => $total_count,
      'data' => $data_result,
      'draw' => $data['draw']
    );
  }

  /* fungsi untuk menarik data dari DB dan konversi ke dataset untuk jquery datatable */
  public function get_datatable_belanja($table, $data, $primary_key = 'id_kak_belanja')
  {
    // lakukan filtering data
    // deklarasi where condition
    $where_search = (isset_nn_nes($data['search']))
      ? "AND (kakbel_uraian LIKE '%$data[search]%' 
    OR deskripsi LIKE '%$data[search]%')"
      : "";
    /* kalau ada tambahan where condition bisa add lagi di atas */
    $where_kode_unor = "";
    $where_tgl = "";
    $where_kode_ukerja = "";
    // deklarasi query yang digunakan
    $query_result = $this->db->query("SELECT * FROM $table 
    WHERE $primary_key IS NOT NULL $where_search $where_tgl $where_kode_ukerja 
    ORDER BY $data[order_column] $data[order_sort]
    LIMIT $data[start], $data[length]");
    $query_total = $this->db->query("SELECT * FROM $table 
    WHERE $primary_key IS NOT NULL $where_search $where_tgl $where_kode_ukerja");
    // cari total hasil
    $total_count = 0;
    while ($row = $query_total->unbuffered_row()) {
      $total_count += 1;
    }
    // cari data result + penomoran
    $no = $data['start'] + 1;
    $index = 0;
    $data_result = array();
    while ($row = $query_result->unbuffered_row('array')) {
      $data_result[$index] = $row;
      /// |----------------------------------------------------------------------
      /// | PENATAAN DATA SEBELUM DIMASUKKAN KE DALAM RESULT_ARRAY
      /// |----------------------------------------------------------------------
      $data_result[$index]['no'] = $no;
      $data_result[$index]['total_belanja'] = 0;
      $no += 1;
      $index += 1;
    }
    // kembalikan data yang didapat ke controller
    return array(
      'total' => $total_count,
      'filtered' => $total_count,
      'data' => $data_result,
      'draw' => $data['draw']
    );
  }
}
