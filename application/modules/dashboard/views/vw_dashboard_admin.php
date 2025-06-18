<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Daftar Arsip TPP</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Home</a>
      </li>
      <li class="breadcrumb-item active">Daftar Arsip TPP`</li>
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
          <h4 class="card-title">Daftar Arsip TPP</h4>

          <form id="form_arsip_tpp" action="<?= site_url('laporan/get_jurnal_bulanan'); ?>" method="POST" enctype="multipart/form-data">
            <div class="row mb-4">
              <div class="col-6">
                <!-- Bulan -->
                <label for="bulan">Masa TPP :</label>
                <select type="text" name="bulan" class="form-select form-select-sm" style="width:100%" id="bulan" value="">
                  <option selected>- - - Pilih Bulan - - -</option>
                  <option value="1">Januari</option>
                  <option value="2">Februari</option>
                  <option value="3">Maret</option>
                  <option value="4">April</option>
                  <option value="5">Mei</option>
                  <option value="6">Juni</option>
                  <option value="7">Juli</option>
                  <option value="8">Agustus</option>
                  <option value="9">September</option>
                  <option value="10">Oktober</option>
                  <option value="11">November</option>
                  <option value="12" selected>Desember</option>
                </select>
              </div>
              <div class="col-6">
                <!-- Tahun -->
                <label for="tahun">Tahun :</label>
                <select type="text" name="tahun" class="form-select form-select-sm" style="width:100%" id="tahun" value="">
                  <option selected>- - - Pilih Tahun - - - </option>
                  <option value="2023" selected>2023</option>
                </select>
              </div>
            </div>
            <!-- Button export file -->
            <!-- <button id="btn_export_file" class="btn btn-sm btn-success me-2" type="submit" form="form_arsip_tpp">
              <i class="fas fa-upload me-2"></i>Buat Arsip
            </button> -->

            <!-- <button id="btn_export_file" class="btn btn-sm btn-success me-2" type="submit" form="form_jurnal_bulanan">
              <i class="fas fa-upload me-2"></i>Export File Jurnal
            </button> -->
          </form>

          <div class="table-responsive mt-4">

            <div class="_loading loading_tabel_arsip_tpp">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_arsip_tpp" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <!-- <th style="width: 10%;">No</th> -->
                  <th>Unit Kerja</th>
                  <th style="width: 20%;">Tgl Arsip</th>
                  <th style="width: 13%;">Status</th>
                  <th style="width: 15%;">Aksi</th>
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
  var urlDatatable = "<?= site_url('dashboard/get_data_list') ?>";
  var init_btn_add = false;
  var tabel_arsip_tpp = $("#table_arsip_tpp").DataTable({
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
        $('.loading_tabel_arsip_tpp').addClass('show');
      },
    },
    /* Sesuaikan jumlah kolom dengan id table yang digunakan */
    columns: [
      {
        data: 'ket_ukerja',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div><b>' + cellData + '</b></div>');
        },
      },
      {
        data: 'tgl_arsip',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div>' + cellData + '</div>');
        },
      },
      {
        data: 'status',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          var keterangan = "<div class='btn btn-success'><b>Sudah</b></div>";
          if (cellData == 0){
            keterangan = "<div class='btn btn-danger'><b>Belum</b></div>";
          }
          $(td).html('<div class="text-center">' + keterangan + '</div>');
        },
      },
      {
        data: 'id',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          let id_entry = cellData;
          let html_aksi = '<button type="button" class="btn btn-sm btn-light-info" onclick="modal(`' + id_entry + '`, `delete_arsip_tpp`)" href="#">' +
            'Batalkan' +
            '</button>';
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
      $('.loading_tabel_arsip_tpp').removeClass('show');

      // let btn_add = '<button class="btn btn-sm btn-success me-2" onclick="modal(`0`,`tambah_jurnal_bulanan`)">' +
      //   '<i class="fas fa-plus me-1"></i>Tambah Jurnal Bulanan' +
      //   '</button>';

      // if (!init_btn_add) {
      //   $('.init_btn_container').append(btn_add);
      //   init_btn_add = true;
      // }
    }
  });

  /* fungsi untuk reload datatable ajax */
  function reload_table() {
    tabel_arsip_tpp.ajax.reload();
  }

  function modal(id, type) {
    var url = "<?= site_url('dashboard/modal') ?>";
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