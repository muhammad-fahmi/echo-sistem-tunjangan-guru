<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_pdt_ptk extends CI_Model
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
      ? " AND ( nama LIKE '%$data[search]%'
      OR nip LIKE '$data[search]%')"
      : "";

    $where_unit_kerja = " WHERE kode_ukerja LIKE '".$data["kode_ukerja"]."%'";
    //$where_s_aktif = " AND s_aktif = '-1'";
    /* kalau ada tambahan where condition bisa add lagi di atas */
    // deklarasi query yang digunakan
    $query_result = $this->db->query("SELECT * FROM $table
      $where_unit_kerja $where_search
      ORDER BY $data[order_column] $data[order_sort]
      LIMIT $data[start], $data[length]");
    $query_total = $this->db->query("SELECT * FROM $table
      $where_unit_kerja $where_search");
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
      // $data_result[$index]['nip'] = isset_nn_nes($row['nip'], '-');
      $data_result[$index]['nama_lengkap'] = isset_nn_nes($row['nama'], '-');
      $data_result[$index]['ket_jab'] = isset_nn_nes($row['ket_jab'], '-');
      $data_result[$index]['ket_gol'] = isset_nn_nes($row['ket_gol'], '-');
      $data_result[$index]['status_gtk'] = isset_nn_nes($row['status_kepegawaian'],'Belum Diset');
      $data_result[$index]['jenis_ptk'] = isset_nn_nes($row['jenis_ptk'],'Belum Diset');
      $data_result[$index]['encoded_id'] = base64_encode($row["id_gtk"]);

      // $data_result[$index]['nip'] = isset_nn_nes($row['nip'], '-');
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
      $this->db->where(["id" => $data["id"]])->delete("progurinda_pegawai_out");
      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        $res = [
          'status' => false,
          'message' => "Data Tugas tambahan gagal dihapus!"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        $res = [
          'status' => true,
          'message' => "Data Tugas tambahan berhasil dihapus!"
        ];
      }
    } catch (\Throwable $th) {
      $res = [
        'status' => false,
        'message' => "Proses hapus data tugas tambahan error! Error message : " . $th->getMessage()
      ];
    }
    return $res;
  }

  public function update_pns_p3k($data_gtk){
    //update data gtk
    try {
      //query update data
      $proses_update = $this->db->where(["id_gtk" => $data_gtk["id_gtk"]])->update("m_gtk_asn_p3k",$data_gtk);
      if($proses_update !== false){
        $response["status"] = true;
        $response["message"] = "Proses update data GTK SUKSES!";
      }
    } catch (\Throwable $th) {
      //throw $th;
      $response["status"] = false;
      $response["message"] = "Proses update data GTK GAGAL!Error:".$th->getMessage();
    }
    return $response;
  }
}