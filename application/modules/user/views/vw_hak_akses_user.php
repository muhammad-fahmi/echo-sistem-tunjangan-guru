<div class="row g-2">
  <div class="col-12">
    <div class="panel">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= site_url('dashboard'); ?>">
            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
          </a>
        </li>
        <li class="breadcrumb-item">
          <a href="<?= site_url('user'); ?>">Manajemen User</a>
        </li>
        <li class="breadcrumb-item active">
          <a href="#">Hak Akses Menu</a>
        </li>
      </ol>
    </div>
  </div>
  <div class="col-12">
    <div class="panel h">
      <div class="body">User yang saat ini di-edit hak akses menu-nya adalah : <b class="cbold"><?= $data['data_user']['nama_lengkap'] ?></b></div>
    </div>
  </div>
  <?php
  /// |----------------------------------------------------------------------
  /// | KOLOM BUTTON TAMBAH / DESKRIPSI MENU
  /// |----------------------------------------------------------------------
  ?>
  <div class="col-12 col-md-8 col-lg-9">
    <div class="panel h">
      <div class="header">Daftar Menu</div>
      <div class="separator"></div>
      <div class="body d-inline-block">
        <div class="panel light-1 mb-3">
          Berikut ini daftar menu yang ada dalam aplikasi SISMAP, harap untuk ditentukan menu apa saja yang boleh diakses oleh <?= $data['data_user']['nama_lengkap'] ?> (<?= $data['data_user']['ket_kewenangan'] ?>). Untuk mengetahui fungsi menu masing-masing bisa mengklik tombol <i class="text-info fas fa-question-circle"></i>. Untuk menambahkannya ke dalam daftar menu yang bisa di akses (kolom Preview) bisa mengklik tombol <i class="text-warning fas fa-plus-circle"></i>. <b>Jangan lupa untuk menyimpan perubahan data dengan mengklik tombol <span class="badge bg-success"><i class="fas fa-save me-1"></i>Simpan</span></b>.
        </div>
        <?php
        // loop result dan tampilkan sebagai button listing
        foreach ($data['data_menu'] as $k => $v) {
          if ($v['module_id'] == '0000hr') {
            $btn_color = 'warning';
          } else {
            $btn_color = 'info';
          }
        ?>
          <div class="btn-group me-1 mb-2">
            <!-- button deskripsi -->
            <button onclick="info_menu($(this))" type="button" attr-id="<?= $v['module_id'] ?>" attr-name="<?= $v['nama_module'] ?>" attr-desc="<?= $v['deskripsi_module'] ?>" class="btn btn-sm btn-outline-<?= $btn_color ?>"><?= $v['nama_module'] ?>
              <i class="fas fa-question-circle ms-1"></i>
            </button>
            <!-- button tambah ke preview -->
            <button onclick="tambah_menu($(this))" type="button" attr-id="<?= $v['module_id'] ?>" attr-name="<?= $v['nama_module'] ?>" attr-icon="<?= $v['icon_module'] ?>" class="btn btn-sm btn-outline-warning btn_load"><i class="fas fa-plus-circle"></i></button>
          </div>
        <?php
        }
        ?>
        <div class="row g-2 mt-1">
          <div class="col-12 col-lg-6">
            <div class="panel light-1 h">
              <div class="body">
                <div class="smalltext b o">LOAD TEMPLATE MENU BERDASARKAN KEWENANGAN</div>
                <div class="row g-2">
                  <div class="col-10 col-lg-10">
                    <select id="select2_kewenangan"></select>
                  </div>
                  <div class="col-2 col-lg-2 d-grid">
                    <button onclick="load_menu('kewenangan')" class="btn btn-sm btn-outline-warning btn_load"><i class="fas fa-sign-out-alt"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="panel light-1 h">
              <div class="body">
                <div class="smalltext b o">LOAD TEMPLATE MENU BERDASARKAN USER LAINNYA</div>
                <div class="row g-2">
                  <div class="col-10 col-lg-10">
                    <select id="select2_user"></select>
                  </div>
                  <div class="col-2 col-lg-2 d-grid">
                    <button onclick="load_menu('user')" class="btn btn-sm btn-outline-warning btn_load"><i class="fas fa-sign-out-alt"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
  /// |----------------------------------------------------------------------
  /// | KOLOM PREVIEW MENU
  /// |----------------------------------------------------------------------
  ?>
  <div class="col-12 col-md-4 col-lg-3">
    <div class="panel h">
      <div class="p-relative o-hidden">
        <div class="_loading trans">
          <div class="text">Loading...</div>
        </div>
        <div class="header">Preview</div>
        <div class="separator"></div>
        <div class="body mb-2">
          <div class="echo_sidebar preview">
            <div id="preview_menu" class="list">
              <?php
              $array_menu = array();
              $count = count($data['data_preview']);
              if ($count > 0) {
              ?>
                <?php
                foreach ($data['data_preview'] as $k => $v) {
                  array_push($array_menu, $v['module_id']);
                ?>
                  <?php
                  if ($v['module_id'] == '0000hr') {
                    // tampilkan separator saja
                  ?>
                    <hr>
                  <?php
                  } else {
                    // tampilkan icon dan nama menu
                  ?>
                    <a class="item">
                      <div class="text"><i class="<?= $v['icon_module'] ?> me-1"></i><?= $v['nama_module'] ?></div>
                      <div class="bg"></div>
                    </a>
                  <?php
                  }
                  ?>
                <?php
                }
                ?>
              <?php
              } else {
                echo '<div class="alert alert-warning mb-0">Belum ada hak akses menu yang ditambahkan.</div>';
              }
              ?>
            </div>
          </div>
        </div>
        <div class="separator"></div>
        <div class="body text-end">
          <input id="username" type="hidden" name="username" value="<?= $data['data_user']['username'] ?>">
          <button onclick="delete_menu_preview()" class="btn btn-sm btn-danger btn_load"><i class="fas fa-undo-alt me-1"></i>Tata Ulang</button>
          <button onclick="save_menu()" class="btn btn-sm btn-success ms-1 btn_load"><i class="fas fa-save me-1"></i>Simpan</button>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  var array_menu = <?= json_encode($array_menu) ?>;
  var username = '<?= $data['data_user']['username'] ?>';
  /** fungsi untuk melihat deskripsi dari menu */
  function info_menu(e) {
    var name = e.attr('attr-name');
    var desc = e.attr('attr-desc');
    $.notify('<b><i class="fas fa-info-circle me-1"></i>' + name + '</b><br>' + desc, 'info');
  }

  /** fungsi untuk menambahkan menu ke kolom preview */
  function tambah_menu(e) {
    $('.btn_load').addClass('nope');
    var id = e.attr('attr-id');
    var name = e.attr('attr-name');
    var icon = e.attr('attr-icon');

    // cek apakah menu ini sudah ditambahkan atau belum
    if (array_menu.includes(id) && id != '0000hr') {
      $.notify('<b><i class="fas fa-exclamation-triangle me-1"></i>Gagal!</b><br>' +
        "Akses menu sudah ada, harap cek kolom Preview.", 'error');
      $('.btn_load').removeClass('nope');
      return;
    }

    // cek apakah ini menu yang pertama kali ditambahkan?
    if (array_menu.length == 0) {
      $('#preview_menu').html('');
    }

    // masukkan data yang baru jika beluma ada
    array_menu.push(id);
    if (id != '0000hr') {
      $('#preview_menu').append('<a class="item">' +
        '<div class="text"><i class="' + icon + ' me-1"></i>' + name + '</div>' +
        '<div class="bg"></div>' +
        '</a>');
    } else {
      $('#preview_menu').append('<hr>');
    }
    $('.btn_load').removeClass('nope');
  }

  var selected_kewenangan = '';
  var selected_user = '';
  /** fungsi untuk select2 handler data kewenangan */
  $('#select2_kewenangan').select2({
    allowClear: true,
    placeholder: 'Pilih Kewenangan yang ingin dtiru menunya.',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_kewenangan') ?>',
      delay: 800,
      /* delay before sending ajax request */
      data: function(params) {
        return {
          search: params.term,
          param1: 'additional parameter to send',
          param2: 'additional parameter to send'
        }
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
    }
  }).on('select2:select', function(e) {
    // what to do when option selected
    selected_kewenangan = $('#select2_kewenangan').val();
  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
    selected_kewenangan = '';
  });

  /** fungsi untuk select2 handler data user */
  $('#select2_user').select2({
    allowClear: true,
    placeholder: 'Pilih User yang ingin ditiru menunya.',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_user') ?>',
      delay: 800,
      /* delay before sending ajax request */
      data: function(params) {
        return {
          search: params.term,
          param1: 'additional parameter to send',
          param2: 'additional parameter to send'
        }
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
    }
  }).on('select2:select', function(e) {
    // what to do when option selected
    selected_user = $('#select2_user').val();
  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
    selected_user = '';
  });

  /** fungsi untuk request menu data based on type */
  function load_menu(type) {
    // you may add more than one param to send
    $('.btn_load').addClass('nope');
    var selected_id;
    if (type == 'user') {
      selected_id = selected_user;
    } else {
      selected_id = selected_kewenangan;
    }
    $.ajax({
      type: "POST",
      url: "<?= site_url('user/get_menu_data') ?>",
      data: {
        id: selected_id,
        type: type
      },
      dataType: 'json',
      beforeSend: function(e) {
        // what to do before sending the AJAX
        // for example showing loading element
        $('._loading').addClass('show');
      },
      success: function(e) {
        if (e.status) {
          // what to do when the response status = true
          $.notify('<b><i class="fas fa-check-square me-1"></i>Sukses!</b><br>' + e.message, 'success');
          // load module id ke array menu
          array_menu = e.key;
          // load menu ke dalam kolom preview
          var html = '';
          var rawdata = e.raw;
          rawdata.forEach(e => {
            if (e.module_id == '0000hr') {
              html += '<hr>';
            } else {
              html += '<a class="item">' +
                '<div class="text"><i class="' + e.icon_module + ' me-1"></i>' + e.nama_module + '</div>' +
                '<div class="bg"></div>' +
                '</a>';
            }
          });
          $('#preview_menu').html(html);
        } else {
          // what to do when the response status = false
          $.notify('<b><i class="fas fa-exclamation-triangle me-1"></i>Gagal!</b><br>' + e.message, 'error');
        }
        $('._loading').removeClass('show');
        $('.btn_load').removeClass('nope');
      }
    });
  }

  /** fungsi untuk menghapus semua menu di kolom preview */
  function delete_menu_preview() {
    $('.btn_load').addClass('nope');
    $('#preview_menu').html('<div class="alert alert-warning mb-0">Belum ada hak akses menu yang ditambahkan.</div>');
    array_menu = [];
    $('.btn_load').removeClass('nope');
  }

  function save_menu() {
    // you may add more than one param to send
    $('.btn_load').addClass('nope');
    // cek apakah array_menu masih kosong atau tidak
    if (!Array.isArray(array_menu) && !array_menu.length) {
      // array exists and is not empty
      $.notify('<b><i class="fas fa-exclamation-triangle me-1"></i>Gagal!</b><br>' +
        'Maaf, daftar menu masih kosong, harap untuk diisi terlebih dahulu.', 'error');
      return false;
    }
    $.ajax({
      type: "POST",
      url: "<?= site_url('user/save_akses_menu') ?>",
      data: {
        username: username,
        module_id: array_menu,
      },
      dataType: 'json',
      beforeSend: function(e) {
        // what to do before sending the AJAX
        // for example showing loading element
        $('._loading').addClass('show');
      },
      success: function(e) {
        if (e.status) {
          // what to do when the response status = true
          $.notify('<b><i class="fas fa-check-square me-1"></i>Sukses!</b><br>' + e.message, 'success');
        } else {
          // what to do when the response status = false
          $.notify('<b><i class="fas fa-exclamation-triangle me-1"></i>Gagal!</b><br>' + e.message, 'error');
        }
        $('._loading').removeClass('show');
      }
    });
    $('.btn_load').removeClass('nope');
  }
</script>