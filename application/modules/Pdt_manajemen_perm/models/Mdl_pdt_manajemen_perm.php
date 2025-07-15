<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mdl_pdt_manajemen_perm extends CI_Model
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

  private function query_m_kewenangan($data)
  {
    // declare table
    $this->db->from('m_kewenangan');

    // where condition
    if (check_var($data, 'search')) {
      $this->db->group_start()
        ->like('id_kewenangan', $data['search'])
        ->or_like('ket_kewenangan', $data['search'])
        ->group_end();
    }
  }

  public function get_datatable($data)
  {
    // START DB BUILDER
    $this->query_m_kewenangan($data);

    // ORDER
    $order_col = $data['order_column'];
    $order_sort = strtolower($data['order_sort']) === 'desc' ? 'DESC' : 'ASC';
    $this->db->order_by($order_col, $order_sort);

    // LIMIT
    $this->db->limit((int)$data['length'], (int)$data['start']);

    // RESULT DATA
    $query_result = $this->db->get()->result_array();

    // RE-BUILD FOR TOTAL
    $this->query_m_kewenangan($data);
    $total_count = $this->db->get()->num_rows();

    // RE-ARRANGE RESULT DATA
    $no = $data['start'] + 1;
    $data_result = [];

    foreach ($query_result as $row) {
      $row['no'] = $no++;

      // tampilan tombol aksi
      $fixed_list = ['00', '01', '02', '10'];
      $tombol_edit =  (!in_array($row['id_kewenangan'], $fixed_list))
        ? '<a onclick="modal(`edit_kewenangan`, `' . $row['id_kewenangan'] . '`)" class="clickable text-white badge bg-primary"><i class="fas fa-edit me-1"></i>Edit</a>'
        : '<span class="text-white badge bg-warning"><i class="fas fa-lock me-1"></i>Locked</span>';
      $tombol_delete = (!in_array($row['id_kewenangan'], $fixed_list))
        ? '<span class="clickable text-white badge bg-danger" onclick="modal(`hapus_kewenangan`, `' . $row['id_kewenangan'] . '`)"><i class="fas fa-trash me-1"></i>Hapus</span>'
        : '';
      $row['aksi_display'] = '<div class="d-grid gap-1">' .
        $tombol_edit . $tombol_delete .
        '</div>';

      $data_result[] = $row;
    }

    return array(
      'total' => $total_count,         // total after search
      'filtered' => $total_count,      // assuming no global filter for now
      'data' => $data_result,
      'draw' => (int)$data['draw']
    );
  }

  private function get_list_kewenangan_menu_as_html($base_kewenangan_menu)
  {
    $html = '<input type="hidden" name="error" value="NO">';

    $perm_list = ['read', 'insert', 'update', 'delete', 'verif'];
    $icon_classes = [
      'YES' => 'fas fa-check-square text-success',
      'NO'  => 'fas fa-window-close text-danger',
      'DEFAULT' => 'fas fa-minus-square text-secondary'
    ];

    foreach ($base_kewenangan_menu as $value) {
      $menu_icon = check_var($value, 'icon', 'mdi mdi-view-dashboard');
      $id_menu = $value['id_menu'];

      $is_child_prefix = ($value['is_child'] === 'YES')
        ? '&#92;<span class="me-2" style="font-family: monospace;">__</span>'
        : '';

      $menu_title = $is_child_prefix . '<i class="' . $menu_icon . ' me-1"></i>' . $value['menu_title'];

      $html .= '<tr>';
      $html .= '<td class="text-start vam">' . $menu_title . '</td>';

      foreach ($perm_list as $perm_key) {
        $val = isset($value[$perm_key]) ? $value[$perm_key] : '';
        $toggle_class = isset($icon_classes[$val]) ? $icon_classes[$val] : $icon_classes['DEFAULT'];

        $html .= '
        <td class="text-center vam">
          <input type="hidden" id="' . $id_menu . '__' . $perm_key . '" name="' . $id_menu . '[' . $perm_key . ']" value="' . $val . '">
          <div onclick="toggle_value(`' . $id_menu . '`, `' . $perm_key . '`)" class="d-block clickable" style="font-size: 2rem;">
            <i id="' . $id_menu . '__' . $perm_key . '__icon" class="' . $toggle_class . '"></i>
          </div>
        </td>';
      }

      $html .= '<td class="text-center vam">
          <input type="hidden" id="' . $id_menu . '__all" value="">
          <div onclick="toggle_all(`' . $id_menu . '`, `all`)" class="d-block clickable" style="font-size: 2rem;">
            <i id="' . $id_menu . '__all__icon" class="' . $icon_classes['DEFAULT'] . '"></i>
          </div>
        </td>';

      $html .= '</tr>';
    }

    return $html;
  }

  public function get_kewenangan_menu($selected_kewenangan)
  {
    $base_menu = $this->db->from('m_menu')
      ->order_by('order', 'asc')
      ->get()->result_array();

    $default_html = '<input type="hidden" name="error" value="YES">' .
      '<tr>
        <td class="text-start vam"><i class="fas fa-edit me-1"></i>Menu belum di-set Admin</td>
        <td class="text-center vam">
          <div class="d-block" style="font-size: 2rem; opacity: 0.6;"><i class="fas fa-minus-square text-secondary"></i></div>
        </td>
        <td class="text-center vam">
          <div class="d-block" style="font-size: 2rem; opacity: 0.6;"><i class="fas fa-minus-square text-secondary"></i></div>
        </td>
        <td class="text-center vam">
          <div class="d-block" style="font-size: 2rem; opacity: 0.6;"><i class="fas fa-minus-square text-secondary"></i></div>
        </td>
        <td class="text-center vam">
          <div class="d-block" style="font-size: 2rem; opacity: 0.6;"><i class="fas fa-minus-square text-secondary"></i></div>
        </td>
        <td class="text-center vam">
          <div class="d-block" style="font-size: 2rem; opacity: 0.6;"><i class="fas fa-minus-square text-secondary"></i></div>
        </td>
      </tr>';

    if (!check_var($base_menu)) return [
      'status' => true,
      'message' => "Maaf, Daftar menu belum di setting Admin. tidak bisa melanjutkan proses",
      'html' => $default_html
    ];

    $base_kewenangan_menu = [];
    foreach ($base_menu as $key => $value) {
      $data_kewenangan_existing = $this->db->from('m_kewenangan_menu')
        ->group_start()
        ->where('id_kewenangan', 'OK')
        ->or_where('id_kewenangan', $selected_kewenangan)
        ->group_end()
        ->where('id_menu', $value['id_menu'])
        ->get()->row_array();

      $base_kewenangan_menu[$key] = $value;

      $base_kewenangan_menu[$key]['read'] = check_var($data_kewenangan_existing, 'read', '');
      $base_kewenangan_menu[$key]['insert'] = check_var($data_kewenangan_existing, 'insert', '');
      $base_kewenangan_menu[$key]['update'] = check_var($data_kewenangan_existing, 'update', '');
      $base_kewenangan_menu[$key]['delete'] = check_var($data_kewenangan_existing, 'delete', '');
      $base_kewenangan_menu[$key]['verif'] = check_var($data_kewenangan_existing, 'verif', '');
    }

    $html_output = $this->get_list_kewenangan_menu_as_html($base_kewenangan_menu);

    return [
      'status' => true,
      'message' => 'List Kewenangan Menu retrieved.',
      'base_menu' => $base_menu,
      'base_kewenangan' => $base_kewenangan_menu,
      'html' => $html_output
    ];
  }

  public function save_hak_akses($data)
  {
    $id_kewenangan = $data['f_id_kewenangan'];

    $existing_menu = $this->db->from('m_kewenangan_menu')
      ->where([
        'id_kewenangan' => $id_kewenangan
      ])->get()->result_array();

    if (check_var($existing_menu)) {
      foreach ($existing_menu as $key => $value) {
        unset($existing_menu[$key]['id']); // unset kolom id (auto-increment)
      }
    }

    $new_menu = [];

    // remove fields that are not menus
    unset($data['f_id_kewenangan'], $data['error']);

    foreach ($data as $menu_id => $permissions) {
      $new_menu[] = [
        'id_kewenangan' => $id_kewenangan,
        'id_menu' => $menu_id,
        'read'    => isset($permissions['read']) ? $permissions['read'] : '',
        'insert'  => isset($permissions['insert']) ? $permissions['insert'] : '',
        'update'  => isset($permissions['update']) ? $permissions['update'] : '',
        'delete'  => isset($permissions['delete']) ? $permissions['delete'] : '',
        'verif'   => isset($permissions['verif']) ? $permissions['verif'] : '',
      ];
    }

    $changed_data = summarize_permission_changes($existing_menu, $new_menu);

    try {
      $this->db->trans_begin();
      // DELETE ALL EXISTING MENU
      $proc = 1;
      $this->db->where('id_kewenangan', $id_kewenangan)->delete('m_kewenangan_menu');

      // SAVE NEW MENU
      $proc = 2;
      $this->db->insert_batch('m_kewenangan_menu', $new_menu);

      // BUAT LOG
      $proc = 3;
      $ket_kewenangan = fetch_single_data('m_kewenangan', 'ket_kewenangan', ['id_kewenangan' => $id_kewenangan], 'INVALID KEWENANGAN');
      log_generator(
        $this->session->userdata('id_user'),
        'm_kewenangan_menu',
        'BATCH',
        "Melakukan perubahan Hak Akses menu untuk Kewenangan {$ket_kewenangan} [{$id_kewenangan}] dengan rincian sebagai berikut:\n\nNew Menu: {$changed_data['new_menu']}\nModified Menu: {$changed_data['changed_permission']}\nDeleted Menu: {$changed_data['deleted_menu']}"
      );

      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        return [
          'status' => false,
          'message' => "Maaf, terjadi kesalahan saat proses penyimpanan hak akses.\nROLLBACK ISSUE #{$proc}"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        return [
          'status' => true,
          'message' => "Proses penyimpanan hak akses berhasil dilakukan."
        ];
      }
    } catch (\Throwable $th) {
      $catch_msg = sanitize_string($th->getMessage());
      return [
        'status' => false,
        'message' => "Maaf, terjadi kesalahan pada proses penyimpanan hak akses.\n{$catch_msg}"
      ];
    }
  }

  public function save_kewenangan($data)
  {
    // Form validation
    $this->load->library('form_validation');

    // Define validation rules
    $this->form_validation->set_rules('id_kewenangan', 'ID Kewenangan', 'required|numeric|max_length[2]');
    $this->form_validation->set_rules('ket_kewenangan', 'Nama Kewenangan', 'required');

    // Validate the input data
    if ($this->form_validation->run() === FALSE) {
      // Get raw error array (field => message)
      $error_value = $this->form_validation->error_array();

      // Optional: Also format for general display
      $error_text = '<ul class="mb-0">';
      foreach ($error_value as $field => $error) {
        $error_text .= "<li>{$error}</li>";
      }
      $error_text .= '</ul>';

      // Return response with error details
      return [
        'status' => false,
        'message' => "Maaf, tidak bisa melakukan submit karena form tidak valid.\n{$error_text}",
        'error_value' => $error_value
      ];
    }

    $process = ($data['type'] == 'add') ? 'tambah' : 'edit';

    /// |----------------------------------------
    /// | CEK EXISTING ID (IF INSERT)
    /// |----------------------------------------
    if ($data['type'] == 'add') {
      $existing_id = fetch_row_data('m_kewenangan', [
        'id_kewenangan' => $data['id_kewenangan']
      ], false);

      if ($existing_id !== false) return [
        'status' => false,
        'message' => "Maaf, sudah ada Kewenangan dengan ID: {$existing_id['id_kewenangan']} terdaftar dalam database."
      ];
    }

    /// |----------------------------------------
    /// | CEK EXISTING NAMA (INSERT / UPDATE)
    /// |----------------------------------------
    $existing_name = fetch_row_data('m_kewenangan', [
      'ket_kewenangan' => $data['ket_kewenangan'],
      'id_kewenangan <>' => $data['id_kewenangan']
    ], false);
    if ($existing_name !== false) return [
      'status' => false,
      'message' => "Maaf, sudah ada Kewenangan dengan Nama: {$existing_name['ket_kewenangan']} terdaftar dalam database."
    ];

    try {
      $this->db->trans_begin();
      /// |----------------------------------------
      /// | PROSES DB
      /// |----------------------------------------
      $target_id = $data['id_kewenangan'];
      if ($data['type'] == 'add') {
        // DO INSERT
        $proc = 1;
        $this->db->insert('m_kewenangan', [
          'id_kewenangan' => $data['id_kewenangan'],
          'ket_kewenangan' => $data['ket_kewenangan']
        ]);
      } else {
        // DO UPDATE
        $proc = 2;
        $this->db->update('m_kewenangan', [
          'ket_kewenangan' => $data['ket_kewenangan']
        ], [
          'id_kewenangan' => $data['id_kewenangan']
        ]);
      }

      /// |----------------------------------------
      /// | BUAT LOG
      /// |----------------------------------------
      $proc = 3;
      log_generator(
        $this->session->userdata('id_user'),
        'm_kewenangan',
        $target_id,
        "Proses {$process} Kewenangan dengan data sebagai berikut:\n\nID: {$data['id_kewenangan']}\nNama: {$data['ket_kewenangan']}"
      );

      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        return [
          'status' => true,
          'message' => "Proses {$process} kewenangan gagal dilakukan.\nROLLBACK ISSUE #{$proc}"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        return [
          'status' => true,
          'message' => "Proses {$process} kewenangan berhasil dilakukan."
        ];
      }
    } catch (\Throwable $th) {
      $catch_msg = sanitize_string($th->getMessage());
      return [
        'status' => false,
        'message' => "Maaf, proses penyimpanan data kewenangan mengalami error.\n{$catch_msg}"
      ];
    }
  }

  public function delete_kewenangan($data)
  {
    /// |----------------------------------------
    /// | PASTIKAN DATA EXIST
    /// |----------------------------------------
    $existing_data = fetch_row_data('m_kewenangan', [
      'id_kewenangan' => $data['id_kewenangan']
    ], false);
    if ($existing_data === false) return [
      'status' => false,
      'message' => "Maaf, data yang akan dihapus tidak valid. coba refresh halaman."
    ];

    try {
      $this->db->trans_begin();
      // do your db process here
      // HAPUS KEWENANGAN
      $proc = 1;
      $this->db->delete('m_kewenangan', [
        'id_kewenangan' => $existing_data['id_kewenangan']
      ]);

      // HAPUS MENU TERKAIT
      $proc = 2;
      $this->db->delete('m_kewenangan_menu', [
        'id_kewenangan' => $existing_data['id_kewenangan']
      ]);

      // BUAT LOG
      $proc = 3;
      log_generator(
        $this->session->userdata('id_user'),
        'm_kewenangan',
        $existing_data['id_kewenangan'],
        "Menghapus data kewenangan dan semua hak akses menu terkait dengan data berikut ini:\n\nID: {$existing_data['id_kewenangan']}\nNama: {$existing_data['ket_kewenangan']}"
      );
      if ($this->db->trans_status() === FALSE) {
        // do your error handler here
        $this->db->trans_rollback();
        return [
          'status' => false,
          'message' => "Maaf, terjadi kesalahan saat proses penghapusan data kewenangan.\nROLLBACK ISSUE #{$proc}"
        ];
      } else {
        // do your success handler here
        $this->db->trans_commit();
        return [
          'status' => true,
          'message' => "Proses hapus data kewenangan berhasil dilakukan."
        ];
      }
    } catch (\Throwable $th) {
      $catch_msg = sanitize_string($th->getMessage());
      return [
        'status' => false,
        'message' => "Maaf, terjadi kesalahan dalam proses hapus data kewenangan.\n{$catch_msg}"
      ];
    }
  }
}
