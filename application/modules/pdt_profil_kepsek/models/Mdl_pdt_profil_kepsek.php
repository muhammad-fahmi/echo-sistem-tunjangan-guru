<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_pdt_profil_kepsek extends CI_Model
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

  /// |----------------------------------------------------------------------
  /// | >> DATATABLE M PROFIL KEPSEK
  /// |----------------------------------------------------------------------
  private function query_m_profil_kepsek($data)
  {
    $cur_kewenangan = $this->session->userdata('kewenangan');
    $cur_unor = $this->session->userdata('kode_unor');

    // declare table
    $this->db->from('m_profil_kepsek');

    // where condition
    if (check_var($data, 'search')) {
      $this->db->group_start()
        ->like('nip', $data['search'])
        ->or_like('nama', $data['search'])
        ->or_like('alamat_saat_ini', $data['search'])
        ->group_end();
    }

    if ($cur_kewenangan == '10') {
      // tambah kondisi kode_ukerja karena yang login adalah admin sekolah
      $this->db->where(['kode_ukerja' => $cur_unor]);
    }
  }

  public function get_datatable_master($data)
  {
    // START DB BUILDER
    $this->query_m_profil_kepsek($data);

    // ORDER
    $order_col = $data['order_column'];
    $order_sort = strtolower($data['order_sort']) === 'desc' ? 'DESC' : 'ASC';
    $this->db->order_by($order_col, $order_sort);

    // LIMIT
    $this->db->limit((int)$data['length'], (int)$data['start']);

    // RESULT DATA
    $query_result = $this->db->get()->result_array();

    // RE-BUILD FOR TOTAL
    $this->query_m_profil_kepsek($data);
    $total_count = $this->db->get()->num_rows();

    // RE-ARRANGE RESULT DATA
    $no = $data['start'] + 1;
    $data_result = [];
    foreach ($query_result as $row) {
      $row['no'] = $no++;
      $row['something'] = 'something'; // Add your custom column
      $data_result[] = $row;
    }

    return array(
      'total' => $total_count,         // total after search
      'filtered' => $total_count,      // assuming no global filter for now
      'data' => $data_result,
      'draw' => (int)$data['draw']
    );
  }

  /// |----------------------------------------------------------------------
  /// | >> DATATABLE R PROFIL KEPSEK
  /// |----------------------------------------------------------------------
  private function query_r_profil_kepsek($data)
  {
    $cur_kewenangan = $this->session->userdata('kewenangan');
    $cur_unor = $this->session->userdata('kode_unor');

    // declare table
    $this->db->from('r_profil_kepsek');

    // where condition
    if (check_var($data, 'search')) {
      $this->db->group_start()
        ->like('nip', $data['search'])
        ->or_like('nama', $data['search'])
        ->or_like('alamat_saat_ini', $data['search'])
        ->group_end();
    }

    if ($cur_kewenangan == '10') {
      // tambah kondisi kode_ukerja karena yang login adalah admin sekolah
      $this->db->where(['kode_ukerja' => $cur_unor]);
    }
  }

  public function get_datatable_usulan($data)
  {
    // START DB BUILDER
    $this->query_r_profil_kepsek($data);

    // ORDER
    $order_col = $data['order_column'];
    $order_sort = strtolower($data['order_sort']) === 'desc' ? 'DESC' : 'ASC';
    $this->db->order_by($order_col, $order_sort);

    // LIMIT
    $this->db->limit((int)$data['length'], (int)$data['start']);

    // RESULT DATA
    $query_result = $this->db->get()->result_array();

    // RE-BUILD FOR TOTAL
    $this->query_r_profil_kepsek($data);
    $total_count = $this->db->get()->num_rows();

    // RE-ARRANGE RESULT DATA
    $no = $data['start'] + 1;
    $data_result = [];
    foreach ($query_result as $row) {
      $row['no'] = $no++;
      $row['something'] = 'something'; // Add your custom column
      $data_result[] = $row;
    }

    return array(
      'total' => $total_count,         // total after search
      'filtered' => $total_count,      // assuming no global filter for now
      'data' => $data_result,
      'draw' => (int)$data['draw']
    );
  }
}
