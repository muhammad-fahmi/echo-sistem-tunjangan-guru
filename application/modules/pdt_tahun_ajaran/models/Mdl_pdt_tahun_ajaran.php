<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_pdt_tahun_ajaran extends CI_Model
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
  public function get_datatable($data, $primary_key = 'id')
  {
    // lakukan filtering data
    // deklarasi where condition
    $where_search = (isset_nn_nes($data['search']))
      ? "AND (nisn LIKE '%$data[search]%' 
      OR nama LIKE '%$data[search]%'
      OR ket_u_kerja LIKE '%$data[search]%'
      OR ket_kelas LIKE '%$data[search]%'
      OR nama_rombel LIKE '%$data[search]%')"
      : "";
    /* kalau ada tambahan where condition bisa add lagi di atas */
    // deklarasi query yang digunakan
    $query_result = $this->db->query("SELECT * FROM `v_progurinda_siswa` 
      WHERE $primary_key IS NOT NULL $where_search 
      ORDER BY $data[order_column] $data[order_sort]
      LIMIT $data[start], $data[length]");
    $query_total = $this->db->query("SELECT * FROM `v_progurinda_siswa` 
      WHERE $primary_key IS NOT NULL $where_search");
    // cari total hasil
    $total_count = 0;
    while ($row = $query_total->unbuffered_row()) {
      $total_count += 1;
    }
    // cari data result + penomoran
    $no = $data['start'] + 1;
    $index = 0;
    $data_result = array();
    while ($row = $query_result->unbuffered_row()) {
      /// |----------------------------------------------------------------------
      /// | PENATAAN DATA SEBELUM DIMASUKKAN KE DALAM RESULT_ARRAY
      /// |----------------------------------------------------------------------
      $data_result[$index]['no'] = $no;
      // $data_result[$index]['kolom_1'] = $row->kolom_1;
      // $data_result[$index]['kolom_2'] = $row->kolom_2;
      // $data_result[$index]['kolom_3'] = $row->kolom_3;

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
