<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Laporan TPP Per 3 Bulan</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Home</a>
      </li>
      <li class="breadcrumb-item active">Laporan TPP Per 3 Bulan</li>
    </ol>
  </div>

  <!-- <div class="col-md-8 col-12 align-self-center d-none d-md-block">
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
  </div> -->

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
          <h4 class="card-title">Laporan TPP Per 3 Bulan</h4>

          <form id="form_jurnal_bulanan" action="<?= site_url('laporan/get_jurnal_bulanan'); ?>" method="POST" enctype="multipart/form-data">
            <div class="row mb-4">
              <div class="col-12 mb-2">
                <!-- Unit Kerja -->
                <label for="select_ukerja">Unit Kerja :</label>
                <select type="text" name="select_ukerja" class="form-select form-select-sm" style="width:100%" id="select_ukerja" value="">
                </select>
              </div>

              <div class="col-6">
                <!-- Triwulan -->
                <label for="triwulan">Triwulan ke :</label>
                <select type="text" name="triwulan" class="form-select form-select-sm" style="width:100%" id="triwulan" value="">
                  <option selected>- - - Pilih Triwulan - - -</option>
                  <option value="1">I - (JANUARI-MARET)</option>
                  <option value="2">II - (APRIL-JUNI)</option>
                  <option value="3">III - (JULI-SEPTEMBER)</option>
                  <option value="4">IV - (OKTOBER-DESEMBER)</option>
                </select>
              </div>
              <div class="col-6">
                <!-- Tahun -->
                <label for="tahun">Tahun :</label>
                <select type="text" name="tahun" class="form-select form-select-sm" style="width:100%" id="tahun" value="">
                  <option selected>- - - Pilih Tahun - - - </option>
                  <option value="2021">2021</option>
                  <option value="2022">2022</option>
                  <option value="2023">2023</option>
                </select>
              </div>
            </div>
            <!-- Button export file -->
            <a href="<?= site_url('laporan/generate_pdf_jurnal_bulanan'); ?>" id="btn_export_file" class="btn btn-sm btn-success me-2" type="button">
              <i class="fas fa-upload me-2"></i>Export Laporan TPP
            </a>
            <!-- <button id="btn_export_file" class="btn btn-sm btn-success me-2" type="submit" form="form_jurnal_bulanan">
              <i class="fas fa-upload me-2"></i>Export File Jurnal
            </button> -->
          </form>

          <div class="table-responsive mt-4">

            <div class="_loading loading_tabel_tpp_3_bulan">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_tpp_3_bulan" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th>Nama</th>
                  <th>NIP</th>
                  <th>Gol</th>
                  <th>Jabatan</th>
                  <th>Unit Kerja</th>
                  <th>Insentif</th>
                  <th>Bulan</th>
                  <th>Jumlah Kotor</th>
                  <th>Jumlah PPh 5%</th>
                  <th>Jumlah PPh 15%</th>
                  <th>Jumlah INFAQ 2,5%</th>
                  <th>Jumlah Bersih</th>
                  <th>No Rekening</th>
                  <th>NIK</th>
                  <th>NPWP</th>
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
  var urlDatatable = "<?= site_url('laporan/datalist') ?>";
  var init_btn_export = false;
  var tabel_tpp_3_bulan = $("#table_tpp_3_bulan").DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    orderCellsTop: true,
    // scrollX: true,
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
        $('.loading_tabel_tpp_3_bulan').addClass('show');
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
      // {
      //   data: 'nama_lengkap',
      //   orderable: false,
      //   className: 'vam',
      //   createdCell: function(td, cellData, rowData, row, col) {
      //     $(td).html('<div class="text-start">' + cellData + '</div>');
      //   },
      // },
      {
        data: 'kode_jab',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        },
      },
      {
        data: 'kode_ukerja',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'bulan',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'tahun',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'jam_mengajar',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'kode_instansi',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'jns_jab',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'ket_jab',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'ket_uorg',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
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
      //       '<li><a class="dropdown-item" onclick="modal(`' + id_entry + '`, `edit_tpp_3_bulan`)" href="#"><i class="fas fa-edit me-1"></i>Edit</a></li>' +
      //       '<li><a class="dropdown-item text-danger" onclick="modal(`' + id_entry + '`, `delete_tpp_3_bulan`)" href="#"><i class="fas fa-trash me-1"></i>Delete</a></li>' +
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
      $('.loading_tabel_tpp_3_bulan').removeClass('show');

      // let btn_export = '<a class="btn btn-sm btn-success me-2" href="'+ <?= base_url('laporan/generate_pdf_jurnal_bulanan') ?> +'">' +
      //   '<i class="fas fa-plus me-1"></i>Tambah TPP' +
      //   '</a>';

      // if (!init_btn_export) {
      //   $('.init_btn_container').append(btn_export);
      //   init_btn_export = true;
      // }
    }
  });

  /* fungsi untuk reload datatable ajax */
  function reload_table() {
    tabel_tpp_3_bulan.ajax.reload();
  }
</script>