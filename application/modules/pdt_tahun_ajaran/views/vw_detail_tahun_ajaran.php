<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Detail Data Tahun Ajaran</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Data Tahun Ajaran</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?= site_url('pdt_tahun_ajaran'); ?>">Tahun Ajaran</a>
      </li>
      <li class="breadcrumb-item active">Detail</li>
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
            <h4 class="card-title">DATA (DEBUG)</h4>
            <small>
              <?php highlight_string("<?php\nSESSION = " . var_export($this->session->userdata(), true) . ";\n\n?>"); ?>
              <?php highlight_string("<?php\nDATA = " . var_export($data, true) . ";\n\n?>"); ?>
            </small>
          </div>
        </div>
      </div>
    <?php
    }
    ?>

    <div class="col-12">
      <div class="card">
        <div class="card-title space-between">
          <h4><i class="fas fa-building me-2"></i>Profil Sekolah</h4>
          <div></div>
        </div>
        <div class="card-body">
          <div class="row g-1">

            <table style="width: 100%;" class="table table-hover mb-1">
              <tr>
                <td style="min-width: 150px;">Tahun Ajar (Periode)</td>
                <td style="min-width: 15px; text-align: center;">:</td>
                <td style="width: 100%;"><?= check_var($data, 'tahun_ajar', '-'); ?></td>
              </tr>

              <tr>
                <td style="min-width: 150px;">Sekolah</td>
                <td style="min-width: 15px; text-align: center;">:</td>
                <td style="width: 100%;"><?= check_var($data, 'nama_sekolah', '-') ?></td>
              </tr>

              <tr>
                <td style="min-width: 150px;">Jenjang</td>
                <td style="min-width: 15px; text-align: center;">:</td>
                <td style="width: 100%;"><?= check_var($data, 'jenjang', '-'); ?></td>
              </tr>
            </table>

          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-title space-between">
          <h4><i class="fa fa-file me-1"></i> Detail Dokumen</h4>
          <div></div>
        </div>
        <div class="card-body">
          <div class="row g-1">
            <table style="width: 100%;" class="table table-hover mb-1">
              <tr>
                <td style="min-width: 150px;">Jumlah Rombel</td>
                <td style="min-width: 15px; text-align: center;">:</td>
                <td style="width: 100%;"><?= check_var($data, 'jumlah_rombel', '-'); ?></td>
              </tr>
            </table>

            <div class="table-responsive">

              <div class="_loading loading_table_rombel">
                <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
              </div>

              <table id="table_rombel" class="table table-bordered table-hover fs-3" style="width:100%;">

                <thead class="bg-info text-white">
                  <tr class="text-center">
                    <th class="vat" style="min-width: 150px;">Kelas</th>
                    <th class="vat" style="min-width: 150px;">Rombel</th>
                    <th class="vat" style="min-width: 10px;">Aksi</th>
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

</div>

<div class="toast_container"></div>

<script>
  var init_btn_add = false;
  let urlDatatable = "<?= site_url('pdt_tahun_ajaran/get_data_rombel') ?>";
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
    }
  });

  /* fungsi untuk reload datatable ajax */
  function reload_table() {
    table_rombel.ajax.reload();
  }
</script>