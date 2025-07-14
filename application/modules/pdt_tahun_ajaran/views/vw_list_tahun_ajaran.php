<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Data Tahun Ajaran</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Home</a>
      </li>
      <li class="breadcrumb-item active">Data Tahun Ajaran</li>
    </ol>
  </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- -------------------------------------------------------------- -->
<!-- Container fluid  -->
<!-- -------------------------------------------------------------- -->
<div class="container-fluid">
  <!-- -------------------------------------------------------------- -->
  <!-- Start Page Content -->
  <!-- -------------------------------------------------------------- -->
  <!-- basic table -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Daftar Data Tahun Ajaran</h4>
          <!-- Unit Kerja -->
          <div class="row mb-2">
            <div class="col-4 col-lg-3">
              <label for="select2_sekolah">Sekolah</label>
            </div>
            <div class="col-8 col-lg-9">
              <select type="text" name="select2_sekolah" class="form-select form-select-sm" style="width:100%" id="select2_sekolah">
                <option value="<?= $this->session->userdata("kode_instansi"); ?>"><?= $this->session->userdata("ket_ukerja"); ?></option>
                <option value="sekolah"></option>
              </select>
            </div>
          </div>

          <!-- Semester -->
          <div class="row mb-2">
            <div class="col-4 col-lg-3">
              <label for="semester">Semester</label>
            </div>
            <div class="col-8 col-lg-9">
              <select type="text" name="semester" class="form-select form-select-sm" style="width:100%" id="semester">
                <option value="1">I</option>
                <option value="2">II</option>
                <option value="3">III</option>
              </select>
            </div>
          </div>

          <!-- Tahun Ajar -->
          <div class="row mb-4">
            <div class="col-4 col-lg-3">
              <label for="tahun_ajar">Tahun Ajaran</label>
            </div>
            <div class="col-8 col-lg-9">
              <select type="text" name="tahun_ajar" class="form-select form-select-sm" style="width:100%" id="tahun_ajar">
                <?php for ($i = 2023; $i <= date("Y"); $i++) {
                  $selected = ($i == date('Y')) ? "selected" : "";
                ?>
                  <option value="<?= $i; ?>" <?= $selected; ?>><?= $i; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="col-3">
              <button class="btn btn-primary" onclick="reload_table()"><i class="fa fa-refresh"></i> Refresh </button>
            </div>
          </div>
          <div class="table-responsive mt-4">

            <div class="_loading loading_tabel_tahun_ajaran">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_tahun_ajaran" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th>Tahun Ajar</th>
                  <th>Nama Sekolah</th>
                  <th>Tingkat</th>
                  <th>Jumlah Rombel</th>
                  <th>Aksi</th>
                </tr>
              </thead>

              <tbody style="font-size: 11px;"></tbody>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="toast_container"></div>

<!-- -------------------------------------------------------------- -->
<!-- End Container fluid  -->
<!-- -------------------------------------------------------------- -->

<script>
  var urlDatatable = "<?= site_url('pdt_tahun_ajaran/get_data') ?>";
  var init_btn_add = false;
  var tabel_tahun_ajaran = $("#table_tahun_ajaran").DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    orderCellsTop: true,
    dom: '<"row g-1"' +
      '<"col-12 col-sm-6 init_btn_container"><"col-12 col-sm-6 vam"f>' +
      '<"col-12"tr>' +
      '<"col-12 col-sm-6"li><"col-12 col-sm-6"p>' +
      '>',
    /* set kolom yang di sortir secara default */
    order: [
      [0, "asc"],
    ],
    /* set placeholder dari input search */
    language: {
      searchPlaceholder: "Keyword"
    },
    ajax: {
      url: urlDatatable,
      /* parameter yang dikirimkan ke controller */
      data: {
        semester: function() {
          return $('#semester').val();
        },
        tahun_ajar: function() {
          return $('#tahun_ajar').val();
        },
        select_ukerja: function() {
          return $('#select_ukerja').val();
        },
      },
      type: 'POST',
      beforeSend: function() {
        // lakukan sesuatu sebelum mulai ajax process
        $('.loading_tabel_tahun_ajaran').addClass('show');
      },
    },
    /* Sesuaikan jumlah kolom dengan id table yang digunakan */
    columns: [{
        data: 'tahun_ajaran',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div><br><b>' + rowData.nama_lengkap + '</b>');
        },
      },
      {
        data: 'nama_sekolah',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        },
      },
      {
        data: 'tingkat',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'jumlah_rombel',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-end">' + cellData + '</div>');
        },
      },
      {
        data: 'id_tahun_ajaran',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          let html_aksi = '<div class="btn-group">' + '<button type="button" class="btn btn-sm btn-light-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">' +
            'Pilih' +
            '</button>' +
            '<ul class="dropdown-menu">' +
            '<li><a class="dropdown-item" onclick="modal(\'' + cellData + '\', \'edit_jurnal_mengajar\')" href="#"><i class="fas fa-edit me-1"></i>Edit</a></li>' +
            '<li><a class="dropdown-item text-danger" onclick="modal(\'' + cellData + '\', \'delete_jurnal_mengajar\')" href="#"><i class="fas fa-trash me-1"></i>Delete</a></li>' +
            '</ul>' +
            '</div>';
          $(td).html('<div class="text-center">' + html_aksi + '</div>');
        },
      },
    ],
    /* Lakukan fungsi callback pada bracket ini */
    drawCallback: function(settings) {
      /* gunakan code ini utk mengambil data response ke dalam drawCallback */
      let api = this.api();
      let json = api.ajax.json();
      if (json.status == false) {
        /* jalankan apabila return false */
      }
      /* parameter callback untuk kostumisasi fungsi */
      $('.loading_tabel_tahun_ajaran').removeClass('show');

      let btn_add = '<button class="btn btn-sm btn-success me-2" onclick="modal(`0`,`tambah_data_tahun_ajar`)">' +
        '<i class="fas fa-plus me-1"></i>Tambah Data Tahun Ajar' +
        '</button>';

      if (!init_btn_add) {
        $('.init_btn_container').append(btn_add);
        init_btn_add = true;
      }
    }
  });

  /* fungsi untuk reload datatable ajax */
  function reload_table() {
    tabel_tahun_ajaran.ajax.reload();
  }

  // Select2 Instansi Sekolah
  $('#select2_sekolah').select2({
    allowClear: true,
    placeholder: '--- Pilih Sekolah ---',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_sekolah') ?>',
      delay: 800,
      /* delay before sending ajax request */
      data: function(params) {
        return {
          search: params.term,
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
  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    $('select2_sekolah').empty();
    // what to do when clearing (only if allowClear: true)
  });

  function modal(id, type) {
    var url = "<?= site_url('pdt_tahun_ajaran/modal') ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {
        id: id,
        type: type
      },
      success: function(res) {
        if (res.status) {
          $("#modal_content_id").html(res.html).show();
          $("#whole_modal_id").modal("show");
        } else {
          toaster('info', 'Unknown error on modal calls.\n- ' + res.message);
        }
      }
    });
  }
</script>