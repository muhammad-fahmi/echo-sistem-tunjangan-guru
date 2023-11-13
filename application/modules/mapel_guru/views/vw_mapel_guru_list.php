<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Daftar Usul SSH</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Home</a>
      </li>
      <li class="breadcrumb-item active">Daftar Usul SSH</li>
    </ol>
  </div>

  <div class="col-md-8 col-12 align-self-center d-none d-md-block">
    <div class="d-flex mt-2 justify-content-end">
      <div class="d-flex me-3 ms-2">
        <div class="chart-text me-2">
          <h6 class="mb-0"><small>Pagu Anggaran</small></h6>
          <h4 class="mt-0 text-info"><?= to_rp($data['anggaran']) ?></h4>
        </div>
        <div class="spark-chart">
          <div id="monthchart"></div>
        </div>
      </div>
      <div class="d-flex ms-2">
        <div class="chart-text me-2">
          <h6 class="mb-0"><small>Realisasi</small></h6>
          <h4 class="mt-0 text-primary"><?= to_rp($data['real_keu']) ?></h4>
        </div>
        <div class="spark-chart">
          <div id="lastmonthchart"></div>
        </div>
      </div>
      <div class="d-flex ms-2">
        <div class="chart-text me-2">
          <h6 class="mb-0"><small>Fisik</small></h6>
          <h4 class="mt-0 text-success"><?= to_rp($data['real_fisik'], false) ?>%</h4>
        </div>
        <div class="spark-chart">
          <div id="nextmonthchart"></div>
        </div>
      </div>
    </div>
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
          <h4 class="card-title">Usul SSH</h4>

          <div class="table-responsive mt-4">

            <div class="_loading loading_tabel_usul_ssh">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_usul_ssh" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th rowspan="2">No.</th>
                  <th rowspan="1" colspan="7">Standar</th>
                </tr>
                <tr class="text-center">
                  <th>Kode</th>
                  <th>Uraian</th>
                  <th>Spesifikasi</th>
                  <th>Volume</th>
                  <th>Harga</th>
                  <th>PDN</th>
                  <th>Jenis</th>
                </tr>
              </thead>
              <!-- <thead>
                <tr class="text-center">
                  <td>No.</td>
                  <td>Tahun</td>
                  <td>Kode Standar</td>
                  <td>Uraian Standar</td>
                  <td>Spesifikasi Standar</td>
                  <td>Volume Standar</td>
                  <td>Harga Standar</td>
                  <td>PDN Standar</td>
                  <td>Jenis Standar</td>
                  <td>Aksi</td>
                </tr>
              </thead> -->

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
  var urlDatatable = "<?= site_url('usul_ssh/datalist') ?>";
  var init_btn_add = false;
  var tabel_usul_ssh = $("#table_usul_ssh").DataTable({
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
      [1, "asc"],
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
        $('.loading_tabel_usul_ssh').addClass('show');
      },
    },
    /* Sesuaikan jumlah kolom dengan id table yang digunakan */
    columns: [{
        data: 'no',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'kode_standar',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        },
      },
      {
        data: 'uraian_standar',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        },
      },
      {
        data: 'spesifikasi_standar',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        },
      },
      {
        data: 'volume_standar',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'harga_standar',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-end">' + cellData + '</div>');
        },
      },
      {
        data: 'pdn_standar',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-end">' + cellData + '</div>');
        },
      },
      {
        data: 'jenis_standar',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      // {
      //   data: 'tahun',
      //   orderable: false,
      //   className: 'vam',
      //   createdCell: function(td, cellData, rowData, row, col) {
      //     let id_entry = rowData.tahun + '_' + rowData.kode_standar;
      //     let html_aksi = '<div class="btn-group">' + '<button type="button" class="btn btn-sm btn-light-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">' +
      //       'Pilih' +
      //       '</button>' +
      //       '<ul class="dropdown-menu">' +
      //       '<li><a class="dropdown-item" onclick="modal(`' + id_entry + '`, `edit_usul_ssh`)" href="#"><i class="fas fa-edit me-1"></i>Edit</a></li>' +
      //       '<li><a class="dropdown-item text-danger" onclick="modal(`' + id_entry + '`, `delete_usul_ssh`)" href="#"><i class="fas fa-trash me-1"></i>Delete</a></li>' +
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
      $('.loading_tabel_usul_ssh').removeClass('show');

      let btn_add = '<button class="btn btn-sm btn-success me-2" onclick="modal(``,`tambah_usul_ssh`)">' +
        '<i class="fas fa-plus me-1"></i>Tambah Usul SSH' +
        '</button>';

      let btn_sync = '<button class="btn btn-sm btn-info" onclick="modal(``,`sync_usul_ssh`)">' +
        '<i class="fas fa-sync-alt me-1"></i>Sinkronisasi' +
        '</button>';

      if (!init_btn_add) {
        $('.init_btn_container').append(btn_add + btn_sync);
        init_btn_add = true;
      }
    }
  });

  /* fungsi untuk reload datatable ajax */
  function reload_table() {
    tabel_usul_ssh.ajax.reload();
  }

  function modal(id, type) {
    var url = "<?= site_url('usul_ssh/modal') ?>";
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