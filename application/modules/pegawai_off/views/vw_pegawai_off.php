<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Daftar Pegawai Non-Aktif</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Home</a>
      </li>
      <li class="breadcrumb-item active">Non-Aktifkan Pegawai</li>
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
          <h4 class="card-title">Daftar Pegawai Non-Aktif</h4>

          <div class="table-responsive mt-4">

            <div class="_loading loading_tabel_pegawai_off">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_pegawai_off" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Jabatan</th>
                  <th>Unit Kerja</th>
                  <th>TMT Non Aktif / TMT Aktif Kembali</th>
                  <th>Keterangan</th>
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
  var urlDatatable = "<?= site_url('pegawai_off/datalist') ?>";
  var init_btn_add = false;
  var tabel_pegawai_off = $("#table_pegawai_off").DataTable({
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
        param1: function() {
          return $('#id_atau_class_element').val();
        },
      },
      type: 'POST',
      beforeSend: function() {
        // lakukan sesuatu sebelum mulai ajax process
        $('.loading_tabel_pegawai_off').addClass('show');
      },
    },
    /* Sesuaikan jumlah kolom dengan id table yang digunakan */
    columns: [
      {
        data: 'nip',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        },
      },
      {
        data: 'nama_lengkap',
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
        data: 'tmt_out',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          var display = "";
          if (rowData.tmt_aktif_kembali != "" && rowData.tmt_aktif_kembali != null){
            display = "<br> s/d <br>"+rowData.tmt_aktif_kembali;
          }
          $(td).html('<div class="text-end">' + cellData + display + '</div>');
        },
      },
      {
        data: 'keterangan_out',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-end">' + cellData + '</div>');
        },
      },
      {
        data: 'id',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          let id_entry = cellData;
          let html_aksi = '<div class="btn-group">' + '<button type="button" class="btn btn-sm btn-light-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">' +
            'Pilih' +
            '</button>' +
            '<ul class="dropdown-menu">' +
            '<li><a class="dropdown-item" onclick="modal(`' + id_entry + '`, `edit_pegawai_out`)" href="#"><i class="fas fa-edit me-1"></i>Edit</a></li>' +
            '<li><a class="dropdown-item text-danger" onclick="modal(`' + id_entry + '`, `delete_pegawai_out`)" href="#"><i class="fas fa-trash me-1"></i>Delete</a></li>' +
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
      $('.loading_tabel_pegawai_off').removeClass('show');

      let btn_add = '<button class="btn btn-sm btn-success me-2" onclick="modal(`0`,`tambah_pegawai_out`)">' +
        '<i class="fas fa-plus me-1"></i>Tambah Pegawai Non-Aktif' +
        '</button>';

      if (!init_btn_add) {
        $('.init_btn_container').append(btn_add);
        init_btn_add = true;
      }
    }
  });

  /* fungsi untuk reload datatable ajax */
  function reload_table() {
    tabel_pegawai_off.ajax.reload();
  }

  function modal(id, type) {
    var url = "<?= site_url('pegawai_off/modal') ?>";
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