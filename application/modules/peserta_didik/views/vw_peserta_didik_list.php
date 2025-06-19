<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Daftar Peserta Didik</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Home</a>
      </li>
      <li class="breadcrumb-item active">Daftar Peserta Didik</li>
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
        <div class="card-body">
          <h4 class="card-title">Daftar Peserta Didik</h4>

          <div class="table-responsive mt-4">

            <div class="_loading loading_tabel_user">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_pd" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th scope="col">No.</th>
                  <th scope="col">Nama Lengkap / NISN</th>
                  <th scope="col">Sekolah</th>
                  <th scope="col">Kelas</th>
                  <th scope="col">Konsentrasi</th>
                  <th scope="col">Agama</th>
                  <th scope="col">Aksi</th>
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
  var init_btn_add = false;
  let urlDatatable = "<?= site_url('user/get_data') ?>";
  var tabel_pd = $("#table_pd").DataTable({
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
      searchPlaceholder: "Cari data peserta didik..."
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
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 'id_user',
        orderable: true,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        }
      },
      {
        data: 'username',
        orderable: false,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        }
      },
      {
        data: 'kewenangan',
        orderable: false,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 'ket_ukerja',
        orderable: false,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 'aktif',
        orderable: false,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 'id_user',
        orderable: false,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          let kewenangan_user = '<?= $this->session->userdata('kewenangan'); ?>';
          let btn_user_management = '<a href="<?= site_url('user/menu_management/'); ?>' + cellData + '" class="badge bg-secondary clickable me-1" title="Menu Management">' +
            '<i class="fas fa-list"></i></a>';

          let btn_edit = '<div onclick="modal(`' + cellData + '`, `edit`)" class="badge bg-primary clickable me-1" title="Edit">' +
            '<i class="fas fa-edit"></i></div>';

          let btn_delete = (kewenangan_user == '00') ?
            '<div onclick="modal(`' + cellData + '`, `hapus`)" class="badge bg-danger clickable" title="Hapus">' +
            '<i class="fas fa-trash"></i></div>' :
            '';

          $(td).html('<div class="text-center">' + btn_edit + btn_delete + '</div>');
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
      $('.loading_tabel_pd').removeClass('show');

      let btn_add = '<button class="btn btn-sm btn-success me-2" onclick="modal(`0`,`tambah_pd`)">' +
        '<i class="fas fa-plus me-1"></i>Tambah Peserta Didik' +
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
    tabel_pd.ajax.reload();
  }

  function modal(id, type) {
    var url = "<?= site_url('peserta_didik/modal') ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {
        username: id,
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