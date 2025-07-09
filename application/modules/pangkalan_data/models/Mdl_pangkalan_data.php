<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_pangkalan_data extends CI_Model
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

  /** fungsi untuk tarik data riwayat dokumen yang final (DITRM) */
  public function get_riwayat_kepala_sekolah($nip = '0000')
  {
    $dataset = $this->db->from('vr_profil_kepseks')
      ->where(['nip' => $nip, 'status_dokumen' => 'DITRM'])
      ->order_by('masa_penugasan_selesai', 'DESC')
      ->get()->result_array();

    return $dataset;
  }
}
