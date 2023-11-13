<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_usul_ssh extends CI_Model
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
  public function get_datatable($data)
  {
    // lakukan filtering data
    // deklarasi where condition
    $where_search = (isset_nn_nes($data['search']))
      ? "AND (uraian_standar LIKE '%$data[search]%' 
      OR spesifikasi_standar LIKE '%$data[search]%'
      OR kode_standar LIKE '%$data[search]%'
      OR jenis_standar LIKE '%$data[search]%'
      OR volume_standar LIKE '%$data[search]%')"
      : "";

    $thn_value = $this->session->userdata('tahun_anggaran');
    $where_tahun = "AND tahun = '$thn_value'";
    /* kalau ada tambahan where condition bisa add lagi di atas */
    // deklarasi query yang digunakan
    $query_result = $this->db->query("SELECT * FROM r_standarharga 
      WHERE tahun IS NOT NULL $where_search $where_tahun 
      ORDER BY $data[order_column] $data[order_sort]
      LIMIT $data[start], $data[length]");
    $query_total = $this->db->query("SELECT * FROM r_standarharga 
      WHERE tahun IS NOT NULL $where_search $where_tahun");
    // cari total hasil
    $total_count = $query_total->num_rows();
    // cari data result + penomoran
    $no = $data['start'] + 1;
    $index = 0;
    $data_result = array();
    while ($row = $query_result->unbuffered_row('array')) {
      /// |----------------------------------------------------------------------
      /// | PENATAAN DATA SEBELUM DIMASUKKAN KE DALAM RESULT_ARRAY
      /// |----------------------------------------------------------------------
      $data_result[$index] = $row;
      $data_result[$index]['no'] = $no;

      $data_result[$index]['tahun'] = isset_nn_nes($row['tahun'], '-');
      $data_result[$index]['kode_standar'] = isset_nn_nes($row['kode_standar'], '-');
      $data_result[$index]['uraian_standar'] = isset_nn_nes($row['uraian_standar'], '-');
      $data_result[$index]['spesifikasi_standar'] = isset_nn_nes($row['spesifikasi_standar'], '-');
      $data_result[$index]['volume_standar'] = isset_nn_nes($row['volume_standar'], '-');
      $data_result[$index]['harga_standar'] = to_rp(isset_nn_nes($row['harga_standar'], '-'), false);
      $data_result[$index]['pdn_standar'] = to_rp(isset_nn_nes($row['pdn_standar'], '-'), false);
      $data_result[$index]['jenis_standar'] = isset_nn_nes($row['jenis_standar'], '-');

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
