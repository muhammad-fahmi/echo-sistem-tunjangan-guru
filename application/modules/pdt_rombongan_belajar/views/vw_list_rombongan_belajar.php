<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Daftar Rombongan Belajar</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="<?= site_url('pangkalan_data'); ?>">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item active">Data Tahun Ajaran</li>
      <li class="breadcrumb-item active">Rombongan Belajar</li>
    </ol>
  </div>
  <!-- ============================================================== -->
  <!-- End Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
</div>
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
        <div class="card-title">
          <h4 class="space-between">Daftar Rombongan Belajar</h4>
        </div>
        <div class="card-body">

          <div class="table-responsive">

            <div class="_loading loading_table_rombel">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_rombel" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th class="vat" style="min-width: 30px;">#</th>
                  <th class="vat" style="min-width: 100px;">Jenjang</th>
                  <th class="vat" style="min-width: 150px;">Sekolah</th>
                  <th class="vat" style="min-width: 60px;">Kelas</th>
                  <th class="vat" style="min-width: 80px;">Rombel</th>
                  <th class="vat" style="min-width: 60px;">Aksi</th>
                </tr>
              </thead>

              <tbody style="font-size: 12px;"></tbody>

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
  var init_btn_add = false;
  let urlDatatable = "<?= site_url('pdt_rombongan_belajar/get_data') ?>";
  var table_rombel = $("#table_rombel").DataTable({
    responsive: true,
    processing: false,
    serverSide: true,
    orderCellsTop: true,
    dom: '<"row g-1"' +
      '<"col-12 col-sm-6 init_btn_container"><"col-12 col-sm-6 vam"f>' +
      '<"col-12"tr>' +
      '<"col-12 col-sm-6"li><"col-12 col-sm-6"p>' +
      '>',
    /* set kolom yang di sortir secara default */
    order: [
      [1, "desc"],
    ],
    /* set placeholder dari input search */
    language: {
      searchPlaceholder: "Cari data rombongan belajar..."
    },
    ajax: {
      url: urlDatatable,
      /* parameter yang dikirimkan ke controller */
      data: {
        param1: function() {
          return $('#xor').val();
        },
      },
      type: 'POST',
      beforeSend: function() {
        // lakukan sesuatu sebelum mengirimkan ajax
        $('._loading').addClass('show');
      },
    },
    /* Sesuaikan jumlah kolom dengan id table yang digunakan */
    columns: [{
        data: 'no',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 'ket_jenjang',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        }
      },
      {
        data: 'ket_sekolah',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        }
      },
      {
        data: 'ket_kelas',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 'nama_rombel',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 'id',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + rowData['aksi_display'] + '</div>');
        }
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
      $('.loading_table_rombel').removeClass('show');

      let btn_add = '<button class="btn btn-sm btn-success me-2" onclick="modal(`0`,`tambah_rombongan_belajar`)">' +
        '<i class="fas fa-plus me-1"></i>Tambah Rombel Baru' +
        '</button>';

      if (!init_btn_add) {
        $('.init_btn_container').append(btn_add);
        init_btn_add = true;
      }
      /* parameter callback untuk kostumisasi fungsi */
      //$('._loading').removeClass('show');
    }
  });

  /* fungsi untuk reload datatable ajax */
  function reload_table() {
    table_rombel.ajax.reload();
  }

  function modal(id, type) {
    var url = "<?= site_url('pdt_rombongan_belajar/modal') ?>";
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