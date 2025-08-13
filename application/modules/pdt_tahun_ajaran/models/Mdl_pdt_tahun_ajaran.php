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

  public function query_data_tahun_ajaran($data)
  {
    $cur_unor = $this->session->userdata('kode_unor');

    // declare table
    $this->db->from('v_tahun_ajaran');

    // where condition
    if (check_var($data, 'search')) {
      $this->db->group_start()
        ->like('tahun_ajar', $data['search'])
        ->or_like('nama_sekolah', $data['search'])
        ->or_like('jenjang', $data['search'])
        ->group_end();
    }

    // if (check_var($data['id_rombel'])) {
    //   $this->db->where('id_rombel', $data['id_rombel']);
    // }
  }

  /* fungsi untuk menarik data dari DB dan konversi ke dataset untuk jquery datatable */
  public function get_datatable($data, $primary_key = 'id_tahun_ajar')
  {
    // START DB BUILDER
    $this->query_data_tahun_ajaran($data);

    // ORDER
    $order_col = $data['order_column'];
    $order_sort = strtolower($data['order_sort']) === 'desc' ? 'DESC' : 'ASC';
    $this->db->order_by($order_col, $order_sort);

    // LIMIT
    $this->db->limit((int)$data['length'], (int)$data['start']);

    // RESULT DATA
    $query_result = $this->db->get()->result_array();

    // RE-BUILD FOR TOTAL
    $this->query_data_tahun_ajaran($data);
    $total_count = $this->db->get()->num_rows();

    $no = $data['start'] + 1;
    $data_result = [];
    foreach ($query_result as $row) {
      $row['no'] = $no++;

      // store modified data into the result
      $data_result[] = $row;
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
