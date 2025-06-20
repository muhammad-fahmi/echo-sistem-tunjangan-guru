<?php
$cur_kewenangan = $this->session->userdata('kewenangan');
?>
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Profil Kepala Sekolah</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item active">Update Profil Kepala Sekolah</li>
    </ol>
  </div>
</div>

<div class="container-fluid">

  <div class="row">

    <?php
    $show_debug = false;
    if ($show_debug) {
    ?>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">SESSION DATA (DEBUG)</h4>
            <small>
              <?php highlight_string("<?php\nSESSION = " . var_export($this->session->userdata(), true) . ";\n?>"); ?>
            </small>
          </div>
        </div>
      </div>
    <?php
    }
    ?>

    <?php
    /// |----------------------------------------------------------------------
    /// | >> DAFTAR PROFIL YG SUDAH DI VERIFIKASI
    /// |----------------------------------------------------------------------
    ?>
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-2">Daftar Profil Kepala Sekolah</h4>

          <div class="table-responsive mt-4">
            <div class="_loading loading_tabel_m_profil_kepsek">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="tabel_m_profil_kepsek" class="table table-bordered table-hover fs-3" style="width:100%;">
              <thead>
                <tr class="text-center">
                  <th class="vam" rowspan="2" style="min-width: 40px;">#</th>
                  <!-- nama / nip dll -->
                  <th class="vam" rowspan="2" style="width: 50%;">Kepala Sekolah</th>
                  <!-- nama sekolah / alamat / jenjang -->
                  <th class="vam" rowspan="2" style="width: 50%;">Sekolah</th>
                  <th class="vam" colspan="2" rowspan="1" style="min-width: 180px;">Masa Penugasan</th>
                  <th class="vam" rowspan="2" style="min-width: 60px;">Aksi</th>
                </tr>
                <tr class="text-center vam">
                  <th class="vam">Mulai</th>
                  <th class="vam">Selesai</th>
                </tr>
              </thead>
            </table>
          </div>

        </div>
      </div>
    </div>

    <?php
    /// |----------------------------------------------------------------------
    /// | >> DAFTAR PROFIL YG DIAJUKAN (BARU / UPDATE EXISTING)
    /// |----------------------------------------------------------------------
    ?>
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-2">Usulan Profil Kepala Sekolah</h4>

          <div class="table-responsive mt-4">
            <div class="_loading loading_tabel_r_profil_kepsek">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <div>
              <div class="btn btn-sm btn-success me-1" onclick="on_dev()">
                <i class="fas fa-plus-square me-2"></i>Tambah Profil Baru
              </div>
            </div>

            <table id="tabel_r_profil_kepsek" class="table table-bordered table-hover fs-3" style="width:100%;">
              <thead>
                <tr class="text-center">
                  <th class="vam" style="min-width: 40px;">#</th>
                  <!-- nama / nip dll -->
                  <th class="vam" style="width: 50%;">Kepala Sekolah</th>
                  <!-- nama sekolah / alamat / jenjang -->
                  <th class="vam" style="width: 50%;">Sekolah</th>
                  <th class="vam" style="min-width: 80px;">Periode</th>
                  <th class="vam" style="min-width: 100px;">Dibuat Pada</th>
                  <th class="vam" style="min-width: 80px;">Status</th>
                  <th class="vam" style="min-width: 60px;">Aksi</th>
                </tr>
              </thead>
            </table>
          </div>

        </div>
      </div>
    </div>

  </div>

</div>

<script>
  $(document).ready(function() {
    // do something on document ready
    /// |----------------------------------------------------------------------
    /// | >> MASTER PROFIL KEPSEK
    /// |----------------------------------------------------------------------
    var m_profil_kepsek = $("#tabel_m_profil_kepsek").DataTable({
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
        [4, "desc"],
      ],
      /* set placeholder dari input search */
      language: {
        searchPlaceholder: "Cari data..."
      },
      ajax: {
        url: '<?= site_url('pdt_profil_kepsek/get_data_master') ?>',
        /* parameter yang dikirimkan ke controller */
        data: {
          param1: function() {
            return $('#id_atau_class_element').val();
          },
        },
        type: 'POST',
        beforeSend: function() {
          // lakukan sesuatu sebelum mulai ajax process
          $('.loading_tabel_m_profil_kepsek').addClass('show');
        },
        error: function(xhr, status, error) {
          show_notify('error', xhr.status + ' : ' + error);
        }
      },
      /* Sesuaikan jumlah kolom dengan id table yang digunakan */
      columns: [{
          data: 'no', // index 0
          orderable: false,
          className: 'vat',
          createdCell: function(td, cellData, rowData, row, col) {
            $(td).html('<div class="text-center">' + cellData + '</div>');
          }
        },
        {
          data: 'nip', // index 1
          orderable: false,
          className: 'vat',
          createdCell: function(td, cellData, rowData, row, col) {
            $(td).html('<div class="text-center">' + cellData + '</div>');
          }
        },
        {
          data: 'kode_ukerja', // index 2
          orderable: false,
          className: 'vat',
          createdCell: function(td, cellData, rowData, row, col) {
            $(td).html('<div class="text-center">' + cellData + '</div>');
          }
        },
        {
          data: 'masa_penugasan_mulai', // index 3
          orderable: false,
          className: 'vat',
          createdCell: function(td, cellData, rowData, row, col) {
            $(td).html('<div class="text-center">' + cellData + '</div>');
          }
        },
        {
          data: 'masa_penugasan_selesai', // index 4
          orderable: false,
          className: 'vat',
          createdCell: function(td, cellData, rowData, row, col) {
            $(td).html('<div class="text-center">' + cellData + '</div>');
          }
        },
        {
          data: 'id_kepsek', // index 5
          orderable: false,
          className: 'vat',
          createdCell: function(td, cellData, rowData, row, col) {
            $(td).html('<div class="text-center">' + cellData + '</div>');
          }
        }
      ],
      /* Lakukan fungsi callback pada bracket ini */
      drawCallback: function(settings) {
        /* gunakan code ini utk mengambil data response ke dalam drawCallback */
        let api = this.api();
        let json = api.ajax.json();
        if (json.status == false) {
          /* jalankan apabila return false */
        }

        $('.loading_tabel_m_profil_kepsek').removeClass('show');
        /* parameter callback untuk kostumisasi fungsi */
      }
    });

    /* fungsi untuk reload datatable ajax */
    function reload_table() {
      m_profil_kepsek.ajax.reload();
    }

    /// |----------------------------------------------------------------------
    /// | >> USULAN PROFIL KEPSEK
    /// |----------------------------------------------------------------------
    var r_profil_kepsek = $("#tabel_r_profil_kepsek").DataTable({
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
        [4, "desc"],
      ],
      /* set placeholder dari input search */
      language: {
        searchPlaceholder: "Cari data..."
      },
      ajax: {
        url: '<?= site_url('pdt_profil_kepsek/get_data_usulan') ?>',
        /* parameter yang dikirimkan ke controller */
        data: {
          param1: function() {
            return $('#id_atau_class_element').val();
          },
        },
        type: 'POST',
        beforeSend: function() {
          // lakukan sesuatu sebelum mulai ajax process
          $('.loading_tabel_r_profil_kepsek').addClass('show');
        },
        error: function(xhr, status, error) {
          show_notify('error', xhr.status + ' : ' + error);
        }
      },
      /* Sesuaikan jumlah kolom dengan id table yang digunakan */
      columns: [{
          data: 'no', // index 0
          orderable: false,
          className: 'vat',
          createdCell: function(td, cellData, rowData, row, col) {
            $(td).html('<div class="text-center">' + cellData + '</div>');
          }
        },
        {
          data: 'nip', // index 1
          orderable: false,
          className: 'vat',
          createdCell: function(td, cellData, rowData, row, col) {
            $(td).html('<div class="text-center">' + cellData + '</div>');
          }
        },
        {
          data: 'kode_ukerja', // index 2
          orderable: false,
          className: 'vat',
          createdCell: function(td, cellData, rowData, row, col) {
            $(td).html('<div class="text-center">' + cellData + '</div>');
          }
        },
        {
          data: 'periode_bln', // index 3
          orderable: false,
          className: 'vat',
          createdCell: function(td, cellData, rowData, row, col) {
            $(td).html('<div class="text-center">' + cellData + '</div>');
          }
        },
        {
          data: 'create_on', // index 4
          orderable: false,
          className: 'vat',
          createdCell: function(td, cellData, rowData, row, col) {
            $(td).html('<div class="text-center">' + cellData + '</div>');
          }
        },
        {
          data: 'status_dokumen', // index 5
          orderable: false,
          className: 'vat',
          createdCell: function(td, cellData, rowData, row, col) {
            $(td).html('<div class="text-center">' + cellData + '</div>');
          }
        },
        {
          data: 'id_dokumen', // index 6
          orderable: false,
          className: 'vat',
          createdCell: function(td, cellData, rowData, row, col) {
            $(td).html('<div class="text-center">' + cellData + '</div>');
          }
        }
      ],
      /* Lakukan fungsi callback pada bracket ini */
      drawCallback: function(settings) {
        /* gunakan code ini utk mengambil data response ke dalam drawCallback */
        let api = this.api();
        let json = api.ajax.json();
        if (json.status == false) {
          /* jalankan apabila return false */
        }

        $('.loading_tabel_r_profil_kepsek').removeClass('show');
        /* parameter callback untuk kostumisasi fungsi */
      }
    });

    /* fungsi untuk reload datatable ajax */
    function reload_table() {
      r_profil_kepsek.ajax.reload();
    }
  });
</script>