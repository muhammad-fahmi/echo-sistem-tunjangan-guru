<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_pdt_laporan extends CI_Model
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

  /// |---------------------------------------------------------
  /// | >> QUERY MODEL DATATABLE
  /// |---------------------------------------------------------
  public function query_data_rekap_pd_tk($data)
  {
    // declare table
    $this->db->from('vr_peserta_didik_tk');

    // where condition
    if (check_var($data, 'search')) {
      $this->db->group_start()
        ->like('nama', $data['search'])
        ->or_like('ket_jns_kelamin', $data['search'])
        ->or_like('ket_disabilitas', $data['search'])
        ->group_end();
    }

    if (check_var($data['id_sekolah'])) {
      $this->db->where('id_sekolah', $data['id_sekolah']);
    }

    if (check_var($data['id_kelas'])) {
      $this->db->where('id_kelas', $data['id_kelas']);
    }

    if (check_var($data['nama_rombel'])) {
      $this->db->where('nama_rombel', $data['nama_rombel']);
    }
  }

  public function query_data_rekap_pd_sd($data)
  {
    // declare table
    $this->db->from('vr_peserta_didik_sd');

    // where condition
    if (check_var($data, 'search')) {
      $this->db->group_start()
        ->like('nama', $data['search'])
        ->or_like('ket_jns_kelamin', $data['search'])
        ->or_like('ket_disabilitas', $data['search'])
        ->group_end();
    }

    if (check_var($data['id_sekolah'])) {
      $this->db->where('id_sekolah', $data['id_sekolah']);
    }

    if (check_var($data['id_kelas'])) {
      $this->db->where('id_kelas', $data['id_kelas']);
    }

    if (check_var($data['nama_rombel'])) {
      $this->db->where('nama_rombel', $data['nama_rombel']);
    }
  }

  public function query_data_rekap_pd_smp($data)
  {
    // declare table
    $this->db->from('vr_peserta_didik_smp');

    // where condition
    if (check_var($data, 'search')) {
      $this->db->group_start()
        ->like('ket_kelas', $data['search'])
        ->or_like('nama_rombel', $data['search'])
        ->group_end();
    }

    if (check_var($data['id_sekolah'])) {
      $this->db->where('id_sekolah', $data['id_sekolah']);
    }

    if (check_var($data['id_kelas'])) {
      $this->db->where('id_kelas', $data['id_kelas']);
    }

    if (check_var($data['nama_rombel'])) {
      $this->db->where('nama_rombel', $data['nama_rombel']);
    }
  }

  /// |---------------------------------------------------------
  /// | >> PROSES MODEL GET DATA
  /// |---------------------------------------------------------
  public function get_datatable_tk($data)
  {
    // START DB BUILDER
    $this->query_data_rekap_pd_tk($data);

    // ORDER
    $order_col = $data['order_column'];
    $order_sort = strtolower($data['order_sort']) === 'desc' ? 'DESC' : 'ASC';
    $this->db->order_by($order_col, $order_sort);

    // LIMIT
    $this->db->limit((int)$data['length'], (int)$data['start']);

    // RESULT DATA
    $query_result = $this->db->get()->result_array();

    // RE-BUILD FOR TOTAL
    $this->query_data_rekap_pd_tk($data);
    $total_count = $this->db->get()->num_rows();

    $no = $data['start'] + 1;
    $data_result = [];
    foreach ($query_result as $row) {
      $row['no'] = $no++;

      // tampilan aksi
      $encrypt_id = encrypt_id($row['id_tahun_ajaran']);
      $tombol_detail = '<a href="' . site_url('pdt_tahun_ajaran/detail/') . $encrypt_id . '" class="badge bg-info clickable text-white me-1 py-1"><i class="fas fa-eye"></i> Detail</a>';
      // $tombol_delete = ($this->session->userdata('kewenangan') == '10') ?
      //   '<div onclick="modal(`' . $encrypt_id . '`, `delete_siswa_rombel`)" class="badge bg-danger clickable me-1 py-1" title="Hapus"><i class="fas fa-trash"></i> Hapus</div>'
      //   : '';

      $row['aksi_display'] = '<div class="d-grid gap-1">' .
        $tombol_detail
        . '</div>';

      // store modified data into the result
      $data_result[] = $row;
    }
    // kembalikan data yang didapat ke controller
    return array(
      'total' => $total_count,
      'filtered' => $total_count,
      'data' => $data_result,
      'draw' => (int)$data['draw']
    );
  }

  public function get_datatable_rombel($data)
  {
    // START DB BUILDER
    $this->query_data_rekap_pd_sd($data);

    // ORDER
    $order_col = $data['order_column'];
    $order_sort = strtolower($data['order_sort']) === 'desc' ? 'DESC' : 'ASC';
    $this->db->order_by($order_col, $order_sort);

    // LIMIT
    $this->db->limit((int)$data['length'], (int)$data['start']);

    // RESULT DATA
    $query_result = $this->db->get()->result_array();

    // RE-BUILD FOR TOTAL
    $this->query_data_rekap_pd_sd($data);
    $total_count = $this->db->get()->num_rows();

    $no = $data['start'] + 1;
    $data_result = [];
    foreach ($query_result as $row) {
      $row['no'] = $no++;

      // tampilan aksi
      $encrypt_id = encrypt_id($row['id']);
      $tombol_detail = '<a href="' . site_url('pdt_rombongan_belajar/detail/') . $encrypt_id . '" class="badge bg-info clickable text-white me-1 py-1"><i class="fas fa-eye"></i> Detail</a>';

      $row['aksi_display'] = '<div class="d-grid gap-1">' .
        $tombol_detail
        . '</div>';

      // store modified data into the result
      $data_result[] = $row;
    }
    // kembalikan data yang didapat ke controller
    return array(
      'total' => $total_count,
      'filtered' => $total_count,
      'data' => $data_result,
      'draw' => (int)$data['draw']
    );
  }

  /// |---------------------------------------------------------
  /// | >> PROSES MODEL CRUD
  /// |---------------------------------------------------------
}
