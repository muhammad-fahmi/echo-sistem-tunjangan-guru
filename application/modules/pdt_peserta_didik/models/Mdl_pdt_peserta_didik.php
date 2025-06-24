<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_pdt_peserta_didik extends CI_Model
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
    // cek kewenangan dan unit kerja
    // $kode_ukerja = $this->session->userdata("kode_unor");
    // $where_ukerja = "(kode_instansi LIKE '" . $kode_ukerja . "%' OR unit_kepeg LIKE '" . $kode_ukerja . "%')";
    // deklarasi where condition
    $where_search = (isset_nn_nes($data['search']))
      ? " AND (nama LIKE '%$data[search]%' 
      OR nisn LIKE '%$data[search]%'
      OR jenis_kelamin LIKE '%$data[search]%'
      OR kode_agama LIKE '$data[search]%')"
      : "";

    /* kalau ada tambahan where condition bisa add lagi di atas */
    // deklarasi query yang digunakan
    $query_result = $this->db->query("SELECT * FROM progurinda_r_siswa
      WHERE id_siswa IS NOT NULL $where_search
      ORDER BY $data[order_column] $data[order_sort]
      LIMIT $data[start], $data[length]");
    $query_total = $this->db->query("SELECT * FROM progurinda_r_siswa 
      WHERE id_siswa IS NOT NULL $where_search");
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
      $data_result[$index]['nama'] = isset_nn_nes($row['nama'], '-');
      $data_result[$index]['nisn'] = isset_nn_nes($row['nisn'], '-');
      $data_result[$index]['nia'] = isset_nn_nes($row['nia'], '-');
      $data_result[$index]['jenis_kelamin'] = isset_nn_nes($row['jenis_kelamin'], '-');
      $data_result[$index]['kode_agama'] = isset_nn_nes($row['kode_agama'], '-');
      $data_result[$index]['alamat'] = isset_nn_nes($row['alamat'], '-');
      $data_result[$index]['id_siswa'] = to_rp(isset_nn_nes($row['id_siswa'], '-'), false);
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

  public function save($data)
  {
    try {
      //start db transaction
      $this->db->trans_begin();
      //cek apakah insert atau update
      if ($data["id_siswa"] == 0) {
        //insert data
        $this->db->insert("progurinda_r_siswa", $data);
      } else {
        //update data
        $this->db->where(["id_siswa" => $data["id_siswa"]])->update("progurinda_r_siswa", $data);
      }
      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        $res = [
          'status' => false,
          'message' => "Data peserta didik (siswa) gagal disimpan!"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        $res = [
          'status' => true,
          'message' => "Data peserta didik (siswa) berhasil disimpan!"
        ];
      }
    } catch (\Throwable $th) {
      $res = [
        'status' => false,
        'message' => "Proses simpan peserta didik (siswa) Error! Error message : " . $th->getMessage()
      ];
    }
    return $res;
  }

  public function delete($data)
  {
    try {
      $this->db->trans_begin();
      $this->db->where(["id_siswa" => $data["id_siswa"]])->delete("progurinda_r_siswa");
      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        $res = [
          'status' => false,
          'message' => "Data Peserta Didik (Siswa) gagal dihapus!"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        $res = [
          'status' => true,
          'message' => "Data Peserta Didik (Siswa) berhasil dihapus!"
        ];
      }
    } catch (\Throwable $th) {
      $res = [
        'status' => false,
        'message' => "Proses hapus peserta didik error! Error message : " . $th->getMessage()
      ];
    }
    return $res;
  }
}
