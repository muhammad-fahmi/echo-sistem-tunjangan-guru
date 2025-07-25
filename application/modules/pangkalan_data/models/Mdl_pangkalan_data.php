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
    $nip = sanitize_string($nip);
    $dataset = $this->db->from('vr_profil_kepsek')
      ->where(['nip' => $nip, 'status_dokumen' => 'DITRM'])
      ->order_by('masa_penugasan_selesai', 'DESC')
      ->get()->result_array();

    return $dataset;
  }

  public function get_riwayat_kepala_sekolah_by_ukerja($kode_ukerja = '0000')
  {
    $kode_ukerja = sanitize_string($kode_ukerja);
    $dataset = $this->db->from('vr_profil_kepsek')
      ->where(['kode_ukerja' => $kode_ukerja, 'status_dokumen' => 'DITRM'])
      ->order_by('masa_penugasan_selesai', 'DESC')
      ->get()->result_array();

    return $dataset;
  }

  public function get_riwayat_sekolah($kode_ukerja = '0000')
  {
    $kode_ukerja = sanitize_string($kode_ukerja);
    $dataset = $this->db->from('vr_profil_sekolah')
      ->where(['kode_ukerja' => $kode_ukerja, 'status_dokumen' => 'DITRM'])
      ->order_by('periode_thn', 'DESC')
      ->order_by('periode_bln', 'DESC')
      ->get()->result_array();

    return $dataset;
  }

  public function get_data_inventaris($id, $is_master = false, $rearrange_data = false)
  {
    $this->db->from('r_inventaris');

    if ($is_master) {
      $this->db->where('id_m_profil_sekolah', $id);
    } else {
      $this->db->where('id_r_profil_sekolah', $id);
    }

    $this->db->order_by('id', 'ASC');
    $dataset = $this->db->get()->result_array();

    if ($rearrange_data && check_var($dataset)) {
      $arranged_data = [];

      foreach ($dataset as $value) {
        $key = $value['inventaris'];

        $arranged_data[$key] = [
          'baik' => (int) $value['baik'],
          'rusak_ringan' => (int) $value['rusak_ringan'],
          'rusak_sedang' => (int) $value['rusak_sedang'],
          'rusak_berat' => (int) $value['rusak_berat'],
          'rusak_total' => (int) $value['rusak_total'],
          'jumlah' => (int) $value['jumlah']
        ];
      }

      $dataset = $arranged_data;
    }

    return $dataset;
  }
}
