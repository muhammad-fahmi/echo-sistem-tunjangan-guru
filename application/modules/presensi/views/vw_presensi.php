<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Daftar Setup Presensi Guru</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Home</a>
      </li>
      <li class="breadcrumb-item active">Daftar Presensi Guru</li>
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
          <h4 class="card-title">Daftar Presensi Guru</h4>

          <!-- Form untuk get data presensi pegawai -->
          <!--<form id="formPresensi" action="<?= site_url('presensi/get_presensi'); ?>" method="POST" enctype="multipart/form-data"> -->
            <div class="row mb-4">
              <div class="col-12 mb-2">
                <!-- Unit Kerja -->
                <label for="select_ukerja">Unit Kerja :</label>
                <select type="text" name="select_ukerja" class="form-select form-select-sm" style="width:100%" id="select_ukerja">
                <option value="<?= $this->session->userdata("kode_unor"); ?>"><?= $this->session->userdata("ket_unor"); ?></option>
                </select>
              </div>

              <div class="col-6">
                <!-- Bulan -->
                <label for="bulan">Bulan :</label>
                <select type="text" name="filter_bln" class="form-select form-select-sm" style="width:100%" id="filter_bln" >
                  <?php 
                  $bln_now = date("n");
                  for($i = 1;$i <= 12;$i++){
                    $selected = ($i == $bln_now) ? "selected" : "";
                  ?>
                    <option value="<?= $i ?>" <?= $selected ?>><?= getBulan($i) ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-6">
                <!-- Tahun -->
                <label for="tahun">Tahun :</label>
                <select type="text" name="filter_thn" class="form-select form-select-sm" style="width:100%" id="filter_thn">
                  <?php for($i = 2023;$i <= date("Y");$i++){ 
                    $selected = ($i == date('Y')) ? "selected" : "";
                    ?>
                    <option value="<?= $i; ?>" <?= $selected; ?>><?= $i; ?></option>    
                    <?php } ?>
                  </select>
              </div>
            </div>
            <!-- Button integrasi presensi -->
            <button id="cekPresensi" class="btn btn-sm btn-success me-2" onclick="modal_integrasi()">
              <i class="fas fa-sync me-2"></i>Integrasi Presensi
            </button>
          <!-- </form> -->

          <div class="table-responsive mt-4">

            <div class="_loading loading_tabel_presensi">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_presensi" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Jabatan</th>
                  <th>Unit Kerja</th>
                  <th>Tidak Apel Pagi</th>
                  <th>% Potongan Kehadiran</th>
                  <!-- <th>Aksi</th> -->
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
  $('#select_ukerja').select2({
    allowClear: true,
    placeholder: 'Pilih Unit Kerja.',
    //dropdownParent: $('#whole_modal_id .modal-content'),
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_instansi') ?>',
      delay: 800,
      /* delay before sending ajax request */
      data: function(params) {
        return {
          search: params.term
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
    reload_table();
    console.log(e);

  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
    selected_kewenangan = '';
  });

  $('[name=filter_bln]').change(function() {
    //var data = e.params.data;
    //console.log(data);
    reload_table();
  });
  $('[name=filter_thn]').change(function() {
    //var data = e.params.data;
    //console.log(data);
    reload_table();
  });


  var urlDatatable = "<?= site_url('presensi/datalist') ?>";
  // var init_btn_add = false;
  var tabel_presensi = $("#table_presensi").DataTable({
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
    // order: [
    //   ["nip", "asc"],
    // ],
    /* set placeholder dari input search */
    language: {
      searchPlaceholder: "Keyword"
    },
    ajax: {
      url: urlDatatable,
      /* parameter yang dikirimkan ke controller */
      data: {
        kode_ukerja: function() {
          return $('#select_ukerja').val();
        },
        filter_bln: function() {
          return $('#filter_bln').val();
        },
        filter_thn: function() {
          return $('#filter_thn').val();
        },
      },
      type: 'POST',
      beforeSend: function() {
        // lakukan sesuatu sebelum mulai ajax process
        $('.loading_tabel_presensi').addClass('show');
      },
    },
    /* Sesuaikan jumlah kolom dengan id table yang digunakan */
    columns: [{
        data: 'nip',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        },
      },
      {
        data: 'nama',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        },
      },
      {
        data: 'ket_jab',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        },
      },
      {
        data: 'ket_ukerja',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'tidak_apel',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'potongan_persen',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      // {
      //   data: 'mapel',
      //   orderable: false,
      //   className: 'vam',
      //   createdCell: function(td, cellData, rowData, row, col) {
      //     $(td).html('<div class="text-end">' + cellData + '</div>');
      //   },
      // },
      // {
      //   data: 'id',
      //   orderable: false,
      //   className: 'vam',
      //   createdCell: function(td, cellData, rowData, row, col) {
      //     let id_entry = cellData;
      //     let html_aksi = '<div class="btn-group">' + '<button type="button" class="btn btn-sm btn-light-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">' +
      //       'Pilih' +
      //       '</button>' +
      //       '<ul class="dropdown-menu">' +
      //       '<li><a class="dropdown-item" onclick="modal(`' + id_entry + '`, `edit_presensi`)" href="#"><i class="fas fa-edit me-1"></i>Edit</a></li>' +
      //       '<li><a class="dropdown-item text-danger" onclick="modal(`' + id_entry + '`, `delete_presensi`)" href="#"><i class="fas fa-trash me-1"></i>Delete</a></li>' +
      //       '</ul>' +
      //       '</div>';
      //     $(td).html('<div class="text-center">' + html_aksi + '</div>');
      //   },
      // },
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
      $('.loading_tabel_presensi').removeClass('show');

      // let btn_add = '<button class="btn btn-sm btn-success me-2" onclick="modal(`0`,`tambah_mapel_guru`)">' +
      //   '<i class="fas fa-plus me-1"></i>Tambah Mapel Guru' +
      //   '</button>';

      // if (!init_btn_add) {
      //   $('.init_btn_container').append(btn_add);
      //   init_btn_add = true;
      // }
    }
  });

  /* fungsi untuk reload datatable ajax */
  function reload_table() {
    tabel_presensi.ajax.reload();
  }

  function modal(id, type) {
    var url = "<?= site_url('presensi/modal') ?>";
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

  function modal_integrasi() {
    var url = "<?= site_url('presensi/modal_integrasi') ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {
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