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

  public function get_datatable($table, $data, $primary_key = 'username')
  {
    // lakukan filtering data
    // deklarasi where condition
    $where_search = (isset_nn_nes($data['search']))
      ? "AND (username LIKE '%$data[search]%' 
      OR id_user LIKE '%$data[search]%'
      OR kewenangan LIKE '%$data[search]%'
      OR ket_ukerja LIKE '%$data[search]%'
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
      $ket_kewenangan = array(
        "00" => "Super Admin",
        "01" => "Administrator",
        "10" => "Admin OPD"
      );
      /// |----------------------------------------------------------------------
      /// | PENATAAN DATA SEBELUM DIMASUKKAN KE DALAM RESULT_ARRAY
      /// |----------------------------------------------------------------------
      $data_result[$index]['no'] = $no;
      $data_result[$index]['username'] = $row->username;
      $data_result[$index]['id_user'] = $row->id_user;
      $data_result[$index]['nama_lengkap'] = $row->nama_lengkap;
      $data_result[$index]['kewenangan'] = $ket_kewenangan[$row->kewenangan];
      $data_result[$index]['ket_ukerja'] = $row->ket_ukerja; //tambah keterangan unit kerja
      //$data_result[$index]['tgl_daftar'] = $row->tgl_daftar;
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
    $cek = $this->db->get_where('progurinda_m_user', array(
      'id_user' => $this->input->post('id_user')
    ))->num_rows();
    if ($cek > 0 || $this->input->post('id_user') == 'system') {
      // Kalau sudah, kembalikan error message
      $response['status'] = false;
      $response['message'] = "Username sudah terdaftar dalam database!";
    } else {
      // Kalau belum, insert data
      $data = [
        'id_user' => $this->input->post('id_user'),
        'username' => $this->input->post('username'),
        'pass_str' => null,
        'password' => encrypt_pwd($this->input->post('password')),
        'salt' => micin(),
        'email_user' => $this->input->post('email_user'),
        'kewenangan' => $this->input->post('kewenangan'),
        'kode_unor' => $this->input->post('kode_unor'),
        'aktif' => ($this->input->post('aktif') == 'on') ? 'Y' : 'N'
      ];

      $this->db->trans_start();
      // do your db process here
      $this->db->insert('progurinda_m_user', $data);
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
    $id_user = $this->input->post('id_user');
    $response = array();

    // cek apakah user yg akan di-edit exist
    $cek_user = $this->db->get_where('progurinda_m_user', array(
      'id_user' => $id_user
    ))->num_rows();

    if ($cek_user < 1) {
      // jika tidak ditemukan tampilkan error
      $response['status'] = false;
      $response['message'] = "Data user yang akan di-edit tidak ditemukan.";

      return $response;
    }

    $data = [
      'id_user' => $id_user,
      'username' => $this->input->post('username'),
      'kewenangan' => $this->input->post('kewenangan'),
      'kode_unor' => $this->input->post('kode_unor'),
      'email_user' => $this->input->post('email_user'),
      'aktif' => ($this->input->post('aktif') == 'on') ? 'Y' : 'N'
    ];

    // cek apakah ingin mengganti password?
    $new_pass = $this->input->post('password');
    if (isset_nn_nes($new_pass)) {
      $data['password'] = encrypt_pwd($new_pass);
    }

    $this->db->trans_start();
    // Proses query update ke database
    $this->db->update('progurinda_m_user', $data, array('id_user' => $id_user));

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
  public function delete_userdata($id_user)
  {
    $response = array();

    // cek apakah data yang akan di hapus ada dalam database?
    $queryData = $this->db->get_where('progurinda_m_user', ['id_user' => $id_user]);
    $cek = $queryData->num_rows();
    if ($cek < 1) {
      return [
        'status' => false,
        'message' => "Maaf, data yang akan Anda hapus tidak ditemukan dalam database. Mohon untuk refresh halaman."
      ];
    }

    $data = $queryData->row_array();

    $this->db->trans_start();
    // do your db process here
    $this->db->delete('progurinda_m_user', array(
      'id_user' => $id_user
    ));

    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
      // do your error handler here
      $response['status'] = false;
      $response['message'] = "User ini gagal dihapus!";
    } else {
      $response['status'] = true;
      $response['message'] = "Data User berhasil dihapus!";
    }
    return $response;
  }

  public function get_menu($id, $type)
  {
    $res = array();
    if ($type == 'user') {
      // user
      $table = 'v_user_menu';
      $where = array('username' => $id);
    } else {
      // kewenangan
      $table = 'v_user_menu_kewenangan';
      $where = array('kewenangan' => $id);
    }
    $data_menu = $this->db->from($table)->where($where)
      ->order_by('no_urut', 'asc')->get()->result_array();
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
      array_push($key_value, $v['module_id']);
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
    $subject = $this->session->userdata('username');
    $userdata = $this->get('m_user', "username = '$username'");
    $nama_user = $userdata['nama_lengkap'];
    $this->db->trans_begin();
    // cek apakah sudah ada terdaftar di v_user_menu?
    // kalau sudah hapus yang lama
    $cek = $this->check('v_user_menu', "username = '$username'");
    if ($cek > 0) {
      $this->db->delete('m_user_menu', "username = '$username'");
    }
    // lakukan loop untuk insert konfigurasi menu baru
    $len = count($array_menu);
    $obj = '|';
    for ($i = 0; $i < $len; $i++) {
      $data_insert = array(
        'no_urut' => ($i + 1),
        'module_id' => $array_menu[$i],
        'username' => $username,
        'id_parent' => 0,
        's_aktif' => -1
      );
      $err++;
      $this->db->insert('m_user_menu', $data_insert);
      $newid = $this->db->insert_id();
      $obj .= "$newid|";
    }
    $err++;
    log_generator(
      $subject,
      "|m_user_menu|",
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

  //get data pengguna
  function get_data_pengguna()
  {
    //field yang akan dipilih
    $this->db->select('id, nama, umur');
    //tabel yang akan diakses
    $this->db->from('tabel_pengguna');
    //mengambil data dengan perintah get
    $query = $this->db->get();

    //cek apakah ada record yang didapat,jika ada maka tampilkan data
    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        echo "ID: " . $row->id . ", Nama: " . $row->nama . ", Umur: " . $row->umur . "<br>";
      }
    } else {
      //jika tidak ada record yang didapat
      echo "Tidak ada data yang ditemukan.";
    }
  }

  //insert data pengguna
  function insert_pengguna()
  {
    //data yang akan diinsert disiapkan dalam bentuk array
    $data = array(
      'nama' => 'Bobby',
      'umur' => 30,
      'alamat' => 'Jl. Kusuma Bangsa'
    );
    //query untuk insert data ke tabel pengguna
    $this->db->insert('tabel_pengguna', $data);
  }

  //update data pengguna
  function update_pengguna($id)
  {
    //data update
    $data = array(
      'alamat' => 'Jl. Baru No. 456'
    );
    //WHERE id = 1
    $this->db->where('id', $id);
    $this->db->update('tabel_pengguna', $data);
  }

  //delete pengguna
  function delete_pengguna($id)
  {
    //menghapus data yang idnya = $id
    $this->db->where('id', $id);
    $this->db->delete('tabel_pengguna');
  }
}
