<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_jurnal_mengajar extends CI_Model
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
  public function get_datatable($table, $data, $primary_key = 'id')
  {
    // lakukan filtering data
    // deklarasi where condition
    $where_search = (isset_nn_nes($data['search']))
      ? " AND (ket_jab LIKE '%$data[search]%' 
      OR jam_mengajar LIKE '%$data[search]%'
      OR nip LIKE '$data[search]%') "
      : "";
    $where_unit_kerja = "";
    $kode_unit_kerja = $this->session->userdata("kode_unor");
    $where_periode = "WHERE v_progurinda_jurnal_mengajar.bulan = ".$data['filter_bln']." AND v_progurinda_jurnal_mengajar.tahun = ".$data['filter_thn']." ";
    $where_unit_kerja = " AND v_progurinda_jurnal_mengajar.kode_instansi LIKE '".$kode_unit_kerja."%' ";
    /* kalau ada tambahan where condition bisa add lagi di atas */
    // deklarasi query yang digunakan
    $query_result = $this->db->query("SELECT * FROM v_progurinda_jurnal_mengajar
      $where_periode $where_unit_kerja $where_search 
      ORDER BY $data[order_column] $data[order_sort]
      LIMIT $data[start], $data[length]");
    $query_total = $this->db->query("SELECT * FROM v_progurinda_jurnal_mengajar 
       $where_periode $where_unit_kerja $where_search");
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
      $data_result[$index]['nip'] = isset_nn_nes($row['nip'], '-');
      $data_result[$index]['nama_lengkap'] = isset_nn_nes($row['nama_lengkap'], '-');
      $data_result[$index]['ket_jab'] = isset_nn_nes($row['ket_jab'], '-');
      $data_result[$index]['ket_ukerja'] = isset_nn_nes($row['ket_ukerja'], '-');
      $data_result[$index]['bulan'] = isset_nn_nes($row['bulan'], '-');
      $data_result[$index]['tahun'] = isset_nn_nes($row['tahun'], '-');
      $data_result[$index]['jam_mengajar'] = isset_nn_nes($row['jam_mengajar'], '-');
      $data_result[$index]['id'] = isset_nn_nes($row['id']);
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

  public function delete($data)
  {
    try {
      $this->db->trans_begin();
      $this->db->where(["id" => $data["id"]])->delete("progurinda_r_jurnal_mengajar");
      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        $res = [
          'status' => false,
          'message' => "Data Mapel Guru gagal dihapus!"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        $res = [
          'status' => true,
          'message' => "Data Mapel Guru berhasil dihapus!"
        ];
      }
    } catch (\Throwable $th) {
      $res = [
        'status' => false,
        'message' => "Proses hapus kamar kost error! Error message : " . $th->getMessage()
      ];
    }
    return $res;
  }
}