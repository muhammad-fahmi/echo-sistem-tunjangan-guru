<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_ganti_password extends CI_Model
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

  public function get_datatable($table, $data, $primary_key = 'username')
  {
    // lakukan filtering data
    // deklarasi where condition
    $where_search = (isset_nn_nes($data['search']))
      ? "AND (id_user LIKE '%$data[search]%' 
      OR username LIKE '%$data[search]%'
      OR kewenangan LIKE '%$data[search]%'
      OR no_hp LIKE '%$data[search]%'
      )"
      : "";
    /* kalau ada tambahan where condition bisa add lagi di atas */
    // deklarasi query yang digunakan
    $query_result = $this->db->query("SELECT * FROM $table 
      WHERE $primary_key IS NOT NULL $where_search 
      ORDER BY $data[order_column] $data[order_sort]
      LIMIT $data[start], $data[length]");
    $query_total = $this->db->query("SELECT * FROM $table 
      WHERE $primary_key IS NOT NULL $where_search");
    // cari total hasil
    $total_count = 0;
    while ($row = $query_total->unbuffered_row()) {
      $total_count += 1;
    }
    // cari data result + penomoran
    $no = $data['start'] + 1;
    $index = 0;
    $data_result = array();
    while ($row = $query_result->unbuffered_row()) {
      /// |----------------------------------------------------------------------
      /// | PENATAAN DATA SEBELUM DIMASUKKAN KE DALAM RESULT_ARRAY
      /// |----------------------------------------------------------------------
      $data_result[$index]['no'] = $no;
      $data_result[$index]['id_user'] = $row->username;
      $data_result[$index]['username'] = $row->nama_lengkap;
      $data_result[$index]['kewenangan'] = $row->ket_kewenangan;
      $data_result[$index]['kode_unor'] = $row->ket_ukerja; //tambah keterangan unit kerja
      $data_result[$index]['no_hp'] = $row->no_hp;
      $data_result[$index]['tgl_daftar'] = $row->tgl_daftar;
      $data_result[$index]['aktif'] = $row->aktif;

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

  /** fungsi untuk tambah data user */
  public function add_userdata()
  {
    $response = array();

    // Check apakah username sudah ada ..
    $cek = $this->db->get_where('proguinda_m_user', array(
      'id_user' => $this->input->post('username')
    ))->num_rows();
    if ($cek > 0 || $this->input->post('username') == 'system') {
      // Kalau sudah, kembalikan error message
      $response['status'] = false;
      $response['message'] = "Username sudah terdaftar dalam database!";
    } else {
      // Kalau belum, insert data
      $data = [
        'id_user' => htmlspecialchars($this->input->post('username', TRUE)),
        'password' => encrypt_pwd($this->input->post('password')),
        'username' => $this->input->post('nama_lengkap'),
        'kewenangan' => $this->input->post('kewenangan'),
        'kode_unor' => $this->input->post('kode_ukerja'),
        'salt' => micin(),
        'no_hp' => $this->input->post('no_hp'),
        'tgl_daftar' => datetime_now(),
        'aktif' => $this->input->post('aktif') ? 'Y' : 'N'
      ];

      $this->db->trans_start();
      // do your db process here
      $this->db->insert('progruinda_m_user', $data);
      log_generator(
        $this->session->userdata('username'),
        '|progurinda_m_user|',
        '|' . $data['id_user'] . '|',
        'Melakukan penambahan data pada user admin dengan nama ' . $data['id_user'] . '.'
      );
      $this->db->trans_complete();
      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $response['status'] = false;
        $response['message'] = "Proses Penyimpanan ke Database gagal!";
      } else {
        $response['status'] = true;
        $response['message'] = "Data User berhasil ditambah";
      }
    }
    return $response;
  }

  /** fungsi untuk edit data user */
  public function edit_userdata()
  {
    $password1 = $this->input->post('password1');
    $username_lama = $this->input->post('username_lama');
    $response = array();

    //Cek jika ada username sebelum edit
    $cek_user = $this->db->get_where('progurinda_m_user', array(
      'id_user' => $this->input->post('username'),
      'id_user <>' => $username_lama
    ))->num_rows();

    if ($cek_user > 0) {
      //Jika sudah ada, tampilkan error message
      $response['status'] = false;
      $response['message'] = "Username sudah terpakai. Gunakan username lain!";

      return $response;
    }

    /* $data_user = $this->get('m_user', array('username' => $username_lama));

    if ($data_user) {
      $password_lama = $data_user['password'];
      if (!verify_pwd($password1, $password_lama)) {
        $response['status'] = false;
        $response['message'] = "Password lama tidak sesuai!";

        return $response;
      }
    } */
    $new_pass = $this->input->post('password2');
    $data = [
      'id_user' => htmlspecialchars($this->input->post('username', TRUE)),
      'username' => $this->input->post('nama_lengkap'),
      'kewenangan' => $this->input->post('kewenangan'),
      'kode_unor' => $this->input->post('kode_ukerja'),
      'no_hp' => $this->input->post('no_hp'),
      'aktif' => $this->input->post('aktif') ? 'Y' : 'N'
    ];
    if ($new_pass != "") {
      $data['password'] = encrypt_pwd($new_pass);
    }

    $this->db->trans_start();
    // Proses query update ke database
    $this->db->update('progurinda_m_user', $data, array('id_user' => $username_lama));
    log_generator(
      $this->session->userdata('id_user'),
      '|progurinda_m_user|',
      '|' . $data['id_user'] . '|',
      'Mengupdate data pada user admin dengan nama ' . $data['username'] . '.'
    );
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      // Jika proses query gagal
      $response['status'] = false;
      $response['message'] = "Proses Update ke Database Gagal!";
    } else {
      // Jika proses query berhasil
      $response['status'] = true;
      $response['message'] = "Data User berhasil terupdate!";
    }
    return $response;
  }

  /** fungsi untuk delete data user */
  public function delete_userdata($username)
  {
    $response = array();

    $this->db->trans_start();
    $data = $this->db->get_where('progurinda_m_user', "id_user = '$username'")->row_array();
    // do your db process here
    $this->db->delete('progurinda_m_user', array(
      'id_user' => $username
    ));
    log_generator(
      $this->session->userdata('id_user'),
      '|progurinda_m_user|',
      '|' . $username . '|',
      'Melakukan penghapusan data pada user admin dengan nama ' . $data['username'] . '.'
    );
    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      // do your error handler here
      $response['status'] = false;
      $response['message'] = "User ini gagal dihapus!";
    } else {
      $response['status'] = true;
      $response['message'] = "Data User berhasil terhapus!";
    }
    return $response;
  }

  public function get_menu($id, $type)
  {
    $res = array();
    if ($type == 'user') {
      // user
      $table = 'v_progurinda_user';
      $where = array('username' => $id);
    } else {
      // kewenangan
      $table = 'v_kewenangan_menu';
      $where = array('kewenangan' => $id);
    }
    $data_menu = $this->db->from($table)->where($where)
      ->order_by('order', 'asc')->get()->result_array();
    $count = count($data_menu);
    if ($count < 1) {
      // data tidak ditemukan
      $res['status'] = false;
      $res['message'] = "Maaf, data template menu tidak ditemukan. (ERRxGMD003)";
      return $res;
    }
    // kalaua ada datanya lanjutkan..
    // tata datanya
    $key_value = array();
    foreach ($data_menu as $k => $v) {
      array_push($key_value, $v['id_menu']);
    }
    $res['status'] = true;
    $res['message'] = "Data menu berhasil diperoleh dan akan diterapkan ke kolom Preview.";
    $res['raw'] = $data_menu;
    $res['key'] = $key_value;
    return $res;
  }

  public function save_akses_menu($username, $array_menu)
  {
    $res = array();
    $err = 2;
    $subject = $this->session->userdata('id_user');
    $userdata = $this->get('progurinda_m_user', "id_user = '$username'");
    $nama_user = $userdata['username'];
    $this->db->trans_begin();
    // cek apakah sudah ada terdaftar di progurinda_m_user?
    // kalau sudah hapus yang lama
    $cek = $this->check('v_progurinda_user', "id_user = '$username'");
    if ($cek > 0) {
      $this->db->delete('progurinda_m_user', "id_user = '$username'");
    }
    // lakukan loop untuk insert konfigurasi menu baru
    $len = count($array_menu);
    $obj = '|';
    for ($i = 0; $i < $len; $i++) {
      $data_insert = array(
        'order' => ($i + 1),
        'id_menu' => $array_menu[$i],
        'id_user' => $username,
        'id_parent' => 0,
        's_aktif' => -1
      );
      $err++;
      $this->db->insert('m_kewenangan_menu', $data_insert);
      $newid = $this->db->insert_id();
      $obj .= "$newid|";
    }
    $err++;
    log_generator(
      $subject,
      "|m_kewenangan_menu|",
      $obj,
      "Melakukan update Hak Akses Menu pada user dengan nama $nama_user."
    );
    if ($this->db->trans_status() === FALSE) {
      // do your error handler here
      $res['status'] = false;
      $res['message'] = "Maaf, proses penyimpanan hak akses menu baru gagal. (ERRxSAM00$err)";
      $this->db->trans_rollback();
    } else {
      $res['status'] = true;
      $res['message'] = "Proses penyimpanan hak akses menu berhasil!";
      $this->db->trans_commit();
    }
    return $res;
  }
}
