<div class="row g-2">
  <div class="col-12">
    <div class="panel">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= site_url('dashboard'); ?>">
            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
          </a>
        </li>
        <li class="breadcrumb-item active">
          <a href="#">Manajemen User</a>
        </li>
      </ol>
    </div>
  </div>
  <div class="col-12">
    <div class="panel">
      <div class="header">Daftar User</div>
      <div class="separator"></div>
      <div class="body">
        <div class="add-button">
          <a onclick="modal('<?= $mu['username'] ?>', 'tambah')" class="btn btn-sm btn-success mb-3">
            <i class="fa fa-plus-square me-1"></i>
            Tambah User
          </a>
        </div>
        <table id="table_user" class="table table-border table-hover text-white">
          <thead class="#" style="text-align: center;">
            <tr>
              <td scope="col">No.</td>
              <td scope="col">Username</td>
              <td scope="col">Nama Lengkap</td>
              <td scope="col">Kewenangan</td>
              <td scope="col">Unit Kerja</td>
              <td scope="col">No. HP</td>
              <td scope="col">Tanggal Daftar</td>
              <td scope="col">Aktif</td>
              <td scope="col">Aksi</td>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  let urlDatatable = "<?= site_url('user/get_data') ?>";
  var tabel_user = $("#table_user").DataTable({
    responsive: true,
    processing: false,
    serverSide: true,
    orderCellsTop: true,
    dom: '<"row g-2"' +
      '<"col-12 col-sm-6"l><"col-12 col-sm-6"f>' +
      '<"col-12"tr>' +
      '<"col-12 col-sm-6"i><"col-12 col-sm-6"p>' +
      '>',
    /* set kolom yang di sortir secara default */
    order: [
      [1, "desc"],
    ],
    /* set placeholder dari input search */
    language: {
      searchPlaceholder: "Cari data user..."
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
        data: 'username',
        orderable: true,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        }
      },
      {
        data: 'nama_lengkap',
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
        data: 'no_hp',
        orderable: false,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 'tgl_daftar',
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
        data: 'username',
        orderable: false,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' +
            '<a href="<?= site_url('user/menu_management/'); ?>' + cellData + '" class="badge bg-secondary clickable me-1" title="Menu Management">' +
            '<i class="fas fa-list"></i></a>' +
            '<a onclick="modal(`' + cellData + '`, `edit`)" class="badge bg-primary clickable me-1" title="Edit">' +
            '<i class="fas fa-edit"></i></a>' +
            '<a onclick="modal(`' + cellData + '`, `hapus`)" class="badge bg-danger clickable" title="Hapus">' +
            '<i class="fas fa-trash"></i></a>' +
            '</div>');
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
      $('._loading').removeClass('show');
    }
  });

  /* fungsi untuk reload datatable ajax */
  function reload_table() {
    tabel_user.ajax.reload();
  }

  function modal(id, type) {
    var url = "<?= site_url('user/modal') ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {
        username: id,
        type: type
      },
      success: function(res) {
        $("#modal").html(res).show();
        $("#my_modal").modal("show");
      }
    });
  }
</script>