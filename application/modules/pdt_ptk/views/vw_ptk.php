<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Pendidik dan Tenaga Kependidikan</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Home</a>
      </li>
      <li class="breadcrumb-item active">PTK</li>
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
          <h4 class="card-title">Daftar Pendidik dan Tenaga Kependidikan ASN / PPPK</h4>

          <div class="table-responsive mt-4">

            <div class="_loading loading_tabel_ptk">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_ptk" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th>NIP / Status</th>
                  <th>Nama</th>
                  <th>Jabatan</th>
                  <th>Golongan</th>
                  <th>Status Pendidik</th>
                  <th>Jenis PTK</th>
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
  var urlDatatable = "<?= site_url('pdt_ptk/datalist') ?>";
  var init_btn_add = false;
  var tabel_ptk = $("#table_ptk").DataTable({
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
        // param1: function() {
        //   return $('#id_atau_class_element').val();
        // },
      },
      type: 'POST',
      beforeSend: function() {
        // lakukan sesuatu sebelum mulai ajax process
        $('.loading_tabel_ptk').addClass('show');
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
        data: 'nama',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        },
      },
      {
        data: 'jabatan_ptk',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        },
      },
      {
        data: 'pangkat_golongan',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div>' + cellData +'</div>');
        },
      },
      {
        data: 'status_kepegawaian',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          var display = "";
          if (cellData !== false){
            display = rowData.status_gtk;
          }else{
            display = "Belum Diset";
          }
          $(td).html('<div class="text-end">' + display + '</div>');
        },
      },
      {
        data: 'jenis_ptk',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          var display = "";
          if (cellData !== false){
            display = rowData.jenis_ptk;
          }else{
            display = "Belum Diset";
          }
          $(td).html('<div class="text-end">' + cellData + '</div>');
        },
      },
      
      {
        data: 'encoded_id',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          let id_entry = cellData;
          console.log(cellData);
          let html_aksi = '<div class="btn-group">' + '<button type="button" class="btn btn-sm btn-light-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">' +
            'Pilih' +
            '</button>' +
            '<ul class="dropdown-menu">' +
            '<li><a class="dropdown-item" href="<?php echo site_url("pdt_ptk/edit/"); ?>'+cellData+'"><i class="fas fa-edit me-1"></i>Edit</a></li>' +
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
      $('.loading_tabel_ptk').removeClass('show');

      let btn_add = '<button class="btn btn-sm btn-success me-2" onclick="modal(`0`,`tambah_gtk`)">' +
        '<i class="fas fa-plus me-1"></i>Tambah PTK' +
        '</button>';

      if (!init_btn_add) {
        $('.init_btn_container').append(btn_add);
        init_btn_add = true;
      }
    }
  });

  /* fungsi untuk reload datatable ajax */
  function reload_table() {
    tabel_ptk.ajax.reload();
  }

  function modal(id, type) {
    var url = "<?= site_url('ptk/modal') ?>";
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