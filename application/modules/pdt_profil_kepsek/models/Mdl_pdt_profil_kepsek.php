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

  /// |----------------------------------------------------------------------
  /// | >> FUNGSI CRUD
  /// |----------------------------------------------------------------------
  public function tambah_profil_kepsek($post)
  {
    // FORM VALIDATION
    $this->load->library('form_validation');

    // Define validation rules
    $this->form_validation->set_rules('nip', 'NIP', 'required|numeric');
    $this->form_validation->set_rules('kode_ukerja', 'Kode Unit Kerja', 'required|numeric');
    $this->form_validation->set_rules('periode_bln', 'Periode (Bulan)', 'required|numeric');
    $this->form_validation->set_rules('periode_thn', 'Periode (Tahun)', 'required|numeric');

    // Validate the input data
    if ($this->form_validation->run() === FALSE) {
      // Collect errors
      $errors = validation_errors('<li>', '</li>'); // This will return a string with errors formatted as HTML

      // Build error list
      $error_list = '<ul class="mb-0">';
      $error_list .= $errors;
      $error_list .= '</ul>';

      // Return response with error details
      return [
        'status' => false,
        'message' => 'Proses tidak bisa dilanjutkan karena form tidak valid.<br>' . $error_list
      ];
    }

    // TARIK DATA PEGAWAI YG DIPILIH
    $data_pegawai = fetch_row_data('v_pns', ['nip' => $post['nip']], false);
    if ($data_pegawai === false) return [
      'status' => false,
      'message' => 'Maaf, NIP yang dipilih tidak valid lagi.'
    ];

    // NORMALISASI DATA DARI V_PNS KE FORMAT M_PROFIL
    $cur_user = $this->session->userdata('id_user');
    $data_to_save = [
      'periode_bln' => $post['periode_bln'],
      'periode_thn' => $post['periode_thn'],
      'create_on' => em_date('Y-m-d H:i:s'),
      'create_by' => $cur_user,
      'status_dokumen' => 'DRAFT',
      'kode_ukerja' => $post['kode_ukerja'],
      'nip' => $post['nip'],
      'nama' => trim($data_pegawai['nama_lengkap']),
      'nuptr' => null, /* sumber di v_pns (?) */
      'nurs' => null, /* sumber di v_pns (?) */
      'nrg' => null, /* sumber di v_pns (?) */
      'nik' => check_var($data_pegawai, 'nik', null),
      'tgl_lahir' => check_var($data_pegawai, 'tgl_lahir', null),
      'jenis_kelamin' => check_var($data_pegawai, 'j_kelamin', null),
      'alamat_saat_ini' => check_var($data_pegawai, 'tt_alamat', null),
      'status_pernikahan' => check_var($data_pegawai, 'ket_kawin', null),

      /* belum di re-check */
      'kode_didik' => check_var($data_pegawai, 'kode_didik', null),
      'pendidikan' => check_var($data_pegawai, 'pendidikan', null),
      'no_sertifikat_pendidik' => check_var($data_pegawai, 'no_sertifikat_pendidik', null),
      'no_sertifikat_gp' => check_var($data_pegawai, 'no_sertifikat_gp', null),
      'no_sertifikat_crs' => check_var($data_pegawai, 'no_sertifikat_crs', null),
      'no_rek_bank' => check_var($data_pegawai, 'no_rek_bank', null),
      'npwp' => check_var($data_pegawai, 'no_npwp', null),
      'menerima_ttp_insentif' => null, /* sumber di v_pns (?) */
    ];

    // DEBUG
    return [
      'status' => false,
      'message' => 'DEBUG MDL : tambah_profil_kepsek',
      'data' => $post
    ];
  }

  public function edit_profil_kepsek($data)
  {
    // DEBUG
    return [
      'status' => false,
      'message' => 'DEBUG MDL : edit_profil_kepsek',
      'data' => $data
    ];
  }

  public function update_profil_kepsek($data)
  {
    // DEBUG
    return [
      'status' => false,
      'message' => 'DEBUG MDL : update_profil_kepsek',
      'data' => $data
    ];
  }

  public function delete_profil_kepsek($data)
  {
    // DEBUG
    return [
      'status' => false,
      'message' => 'DEBUG MDL : delete_profil_kepsek',
      'data' => $data
    ];
  }
}
