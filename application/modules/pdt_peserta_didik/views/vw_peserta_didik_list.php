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
  <!-- <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Daftar Peserta Didik</h4>

          <div class="table-responsive mt-4">

            <div class="_loading loading_table_pd">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_pd" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th scope="col">#</th>
                  <th scope="col">Peserta Didik</th>
                  <th scope="col">Jenis Kelamin</th>
                  <th scope="col">Sekolah</th>
                  <th scope="col">Kelas</th>
                  <th scope="col">Rombel</th>
                  <th scope="col">Penyandang Disabilitas</th>
                  <th scope="col">Aktif</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>

              <tbody style="font-size: 11px;"></tbody>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div> -->

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Daftar Siswa</h4>

          <div class="table-responsive mt-4">

            <div class="_loading loading_table_siswa">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_siswa" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th class="vam" style="min-width: 30px;">#</th>
                  <th class="vam" style="min-width: 100px;">Nama Lengkap</th>
                  <th class="vam" style="min-width: 150px;">Orang Tua PD</th>
                  <th class="vam" style="min-width: 80px;">NIK</th>
                  <th class="vam" style="min-width: 80px;">Jenis Kelamin</th>
                  <th class="vam" style="min-width: 60px;">Agama</th>
                  <th class="vam" style="min-width: 40px;">Status</th>
                  <th class="vam" style="min-width: 60px;">Aksi</th>
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
  let urlDatatable = "<?= site_url('pdt_peserta_didik/get_data') ?>";
  var table_siswa = $("#table_siswa").DataTable({
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
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 'nama',
        orderable: true,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' +
            '<div class="badge bg-secondary mb-1" style="opacity: 0.65;">' + rowData['nisn'] + '</div><br>' + cellData +
            '</div>'
          );
        }
      },
      {
        data: 'nama_ibu',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          let nama_ayah = '<div class="mb-2">' + rowData['nama_ayah'] ? rowData['nama_ayah'] : '-' + '</div>';
          let nama_ibu = '<div class="mb-2">' + cellData ? cellData : '-' + '</div>';

          $(td).html('<div class="text-start">' +
            '<div class="badge bg-success mb-1 me-1">Ayah</div>' + nama_ayah + '<br>' +
            '<div class="badge bg-primary mb-1 me-1">Ibu</div>' + nama_ibu +
            '</div>'
          );
        }
      },
      {
        data: 'nik',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        }
      },
      {
        data: 'ket_jns_kelamin',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 'ket_agama',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 's_aktif',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          let status_siswa = (cellData == '1') ?
            '<div class="badge bg-success text-center py-2">Aktif</div>' :
            '<div class="badge bg-secondary text-center py-2">Non-Aktif</div>'
          $(td).html('<div class="text-center">' + status_siswa + '</div>');
        }
      },
      {
        data: 'id_siswa',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          let id = cellData;
          let id_encrypt = '<?= encrypt_id($id); ?>';
          let detail_url = "<?= site_url('pdt_peserta_didik/detail/'); ?>";
          let kewenangan_user = '<?= $this->session->userdata('kewenangan'); ?>';

          let btn_edit = '<div onclick="modal(`' + cellData + '`, `edit_peserta_didik`)" class="badge bg-primary clickable me-1" title="Edit">' +
            '<i class="fas fa-edit"></i> Edit</div>';

          let btn_detail = '<a href="' + detail_url + cellData + '" class="badge bg-secondary clickable text-white me-1"><i class="fas fa-eye"></i> Detail</a>';

          let btn_delete = (kewenangan_user == '00') ?
            '<div onclick="modal(`' + cellData + '`, `delete_peserta_didik`)" class="badge bg-danger clickable me-1" title="Hapus">' +
            '<i class="fas fa-trash"></i> Hapus</div>' :
            '';

          $(td).html('<div class="text-center">' +
            '<div class="d-grid gap-1 px-2"><div class="row">' + btn_edit + '</div>' +
            '<div class="row">' + btn_detail + '</div>' +
            '<div class="row">' + btn_delete + '</div>' +
            '</div></div>');
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
      $('.loading_table_siswa').removeClass('show');

      let btn_add = '<button class="btn btn-sm btn-success me-2" onclick="modal(`0`,`tambah_peserta_didik`)">' +
        '<i class="fas fa-plus me-1"></i>Tambah Siswa Baru' +
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
    table_siswa.ajax.reload();
  }

  function modal(id_siswa, type) {
    var url = "<?= site_url('pdt_peserta_didik/modal') ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {
        id: id_siswa,
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