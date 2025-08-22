<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Laporan Peserta Didik TK</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="<?= site_url('pangkalan_data'); ?>">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item active">Laporan</li>
      <li class="breadcrumb-item active">Laporan Peserta Didik TK</li>
    </ol>
  </div>
</div>
<div class="container-fluid">
  <!-- basic table -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-title">
          <h4 class="space-between">Laporan Peserta Didik</h4>
        </div>
        <div class="card-body">
          <!-- Unit Kerja -->
          <div class="row mb-2">
            <div class="col-4 col-lg-3">
              <label for="id_sekolah">Sekolah</label>
            </div>
            <div class="col-8 col-lg-9">
              <select type="text" name="id_sekolah" class="form-select form-select" style="width:100%" id="id_sekolah">
                <?php $selected = ($data["id_sekolah"] != "") ? "selected" : ""; ?>
                <option value="<?php echo $data["id_sekolah"]; ?>" <?php echo $selected ?>><?php echo $data["ket_sekolah"]; ?></option>
              </select>
            </div>
          </div>

          <!-- Tahun Ajar -->
          <div class="row mb-4">
            <div class="col-4 col-lg-3">
              <label for="id_tahun_ajaran">Tahun Ajaran</label>
            </div>
            <div class="col-8 col-lg-9">
              <select type="text" name="id_tahun_ajaran" class="form-select form-select" style="width:100%" id="id_tahun_ajaran">
                <?php $selected = ($data["id_tahun_ajaran"] != "") ? "selected" : ""; ?>
                <option value="<?php echo $data["id_tahun_ajaran"]; ?>" <?php echo $selected ?>><?php echo $data["ket_tahun_ajaran"]; ?></option>
              </select>
            </div>
          </div>

          <div class="modal-footer text-start gap-2">
            <button class="btn btn-primary" onclick="reload_table()"><i class="fas fa-retweet"></i> Refresh </button>
            <button class="btn btn-info" onclick=""><i class="fas fa-file"></i> Cetak </button>
          </div>
        </div>
      </div>
    </div>

    <!-- REKAP I -->
    <div class="col-12">
      <div class="card">
        <div class="card-title">
          <h4 class="space-between">Keadaan Peserta Didik</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">

            <div class="_loading loading_tabel_rekap_pd_all">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="tabel_rekap_pd_all" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <!-- <th class="vam" rowspan="2" style="min-width: 15px;">#</th> -->
                  <th class="vam" rowspan="2" style="min-width: 150px;">Sekolah</th>
                  <th class="vam" rowspan="2" style="min-width: 60px;">Kelas</th>
                  <th class="vam" rowspan="2" style="min-width: 60px;">Rombel</th>
                  <th class="vam" colspan="3" rowspan="1" style="min-width: 80px;">Peserta Didik/Jenis Kelamin</th>
                </tr>
                <tr class="text-center">
                  <th class="vam">L</th>
                  <th class="vam">P</th>
                  <th class="vam">Jumlah</th>
                </tr>
              </thead>

              <tbody style="font-size: 11px;"></tbody>

            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- REKAP II -->
    <div class="col-12">
      <div class="card">
        <div class="card-title">
          <h4 class="space-between">Rekap Peserta Didik</h4>
        </div>
        <div class="card-body">

          <div class="table-responsive">

            <div class="_loading loading_tabel_rekap_pd">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="tabel_rekap_pd" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th class="vam" rowspan="2" style="min-width: 10px;">#</th>
                  <th class="vam" rowspan="2" style="min-width: 150px;">Nama TK</th>
                  <th class="vam" rowspan="2" style="min-width: 60px;">Kelas</th>
                  <th class="vam" rowspan="2" style="min-width: 60px;">Jml Rombel</th>
                  <th class="vam" colspan="3" rowspan="1" style="min-width: 80px;">Jumlah Siswa</th>
                </tr>
                <tr class="text-center">
                  <th class="vam">L</th>
                  <th class="vam">P</th>
                  <th class="vam">Jumlah</th>
                </tr>
              </thead>

              <tbody style="font-size: 11px;"></tbody>

            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- REKAP III -->
    <div class="col-12">
      <div class="card">
        <div class="card-title">
          <h4 class="space-between">Peserta Didik Penyandang Disabilitas</h4>
        </div>
        <div class="card-body">

          <div class="table-responsive">

            <div class="_loading loading_tabel_rekap_pd_disabilitas">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="tabel_rekap_pd_disabilitas" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th class="vam" rowspan="2" style="min-width: 15px;">#</th>
                  <th class="vam" rowspan="2" style="min-width: 150px;">Nama TK</th>
                  <th class="vam" rowspan="2" style="min-width: 60px;">Kelas</th>
                  <th class="vam" rowspan="2" style="min-width: 60px;">Rombel</th>
                  <th class="vam" colspan="3" rowspan="1" style="min-width: 80px;">Peserta Didik/Jenis Kelamin</th>
                </tr>
                <tr class="text-center">
                  <th class="vam">L</th>
                  <th class="vam">P</th>
                  <th class="vam">Jumlah</th>
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

<script>
  // URL datatable
  var urlDatatable_rekap_all = "<?= site_url('pdt_laporan/get_data_rekap_tk') ?>";
  // var urlDatatable_rekap = "<.?= site_url('pdt_laporan/get_data_rekap_tk') ?>";
  // var urlDatatable_disabilitas = "<.?= site_url('pdt_laporan/get_data_rekap_disabilitas') ?>";

  var tabel_rekap_pd_all = $("#tabel_rekap_pd_all").DataTable({
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
      [0, "asc"],
    ],
    /* set placeholder dari input search */
    language: {
      searchPlaceholder: ""
    },
    ajax: {
      url: urlDatatable_rekap_all,
      /* parameter yang dikirimkan ke controller */
      data: {
        id_tahun_ajaran: function() {
          return $('#id_tahun_ajaran').val();
        },
        id_sekolah: function() {
          return $('#id_sekolah').val();
        },
      },
      type: 'POST',
      beforeSend: function() {
        // lakukan sesuatu sebelum mulai ajax process
        $('.loading_tabel_rekap_pd_all').addClass('show');
      },
    },
    /* Sesuaikan jumlah kolom dengan id table yang digunakan */
    columns: [{
        data: 'ket_sekolah',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        },
      },
      {
        data: 'ket_kelas',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'nama_rombel',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'jumlah_laki_laki',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'jumlah_perempuan',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'jumlah_total',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      // {
      //   data: 'id_tahun_ajaran',
      //   orderable: false,
      //   className: 'vam',
      //   createdCell: function(td, cellData, rowData, row, col) {
      //     $(td).html('<div class="text-center">' + rowData['aksi_display'] + '</div>');
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
      $('.loading_tabel_rekap_pd_all').removeClass('show');
    }
  });

  // var tabel_rekap_pd = $("#tabel_rekap_pd").DataTable({
  //   responsive: true,
  //   processing: false,
  //   serverSide: true,
  //   orderCellsTop: true,
  //   dom: '<"row g-1"' +
  //     '<"col-12 col-sm-6 init_btn_container"><"col-12 col-sm-6 vam"f>' +
  //     '<"col-12"tr>' +
  //     '<"col-12 col-sm-6"li><"col-12 col-sm-6"p>' +
  //     '>',
  //   /* set kolom yang di sortir secara default */
  //   order: [
  //     [0, "asc"],
  //   ],
  //   /* set placeholder dari input search */
  //   language: {
  //     searchPlaceholder: ""
  //   },
  //   ajax: {
  //     url: urlDatatable_rekap,
  //     /* parameter yang dikirimkan ke controller */
  //     data: {
  //       // semester: function() {
  //       //   return $('#semester').val();
  //       // },
  //       id_tahun_ajaran: function() {
  //         return $('#id_tahun_ajaran').val();
  //       },
  //       id_sekolah: function() {
  //         return $('#id_sekolah').val();
  //       },
  //     },
  //     type: 'POST',
  //     beforeSend: function() {
  //       // lakukan sesuatu sebelum mulai ajax process
  //       $('.loading_tabel_rekap_pd').addClass('show');
  //     },
  //   },
  //   /* Sesuaikan jumlah kolom dengan id table yang digunakan */
  //   columns: [{
  //       data: 'tahun_ajar',
  //       orderable: false,
  //       className: 'vat',
  //       createdCell: function(td, cellData, rowData, row, col) {
  //         $(td).html('<div class="text-start">' + cellData + '</div>');
  //       },
  //     },
  //     {
  //       data: 'nama_sekolah',
  //       orderable: false,
  //       className: 'vat',
  //       createdCell: function(td, cellData, rowData, row, col) {
  //         $(td).html('<div class="text-start">' + cellData + '</div>');
  //       },
  //     },
  //     {
  //       data: 'jenjang',
  //       orderable: false,
  //       className: 'vat',
  //       createdCell: function(td, cellData, rowData, row, col) {
  //         $(td).html('<div class="text-center">' + cellData + '</div>');
  //       },
  //     },
  //     {
  //       data: 'jumlah_rombel',
  //       orderable: false,
  //       className: 'vat',
  //       createdCell: function(td, cellData, rowData, row, col) {
  //         $(td).html('<div class="text-center">' + cellData + '</div>');
  //       },
  //     },
  //     {
  //       data: 'id_tahun_ajaran',
  //       orderable: false,
  //       className: 'vam',
  //       createdCell: function(td, cellData, rowData, row, col) {
  //         $(td).html('<div class="text-center">' + rowData['aksi_display'] + '</div>');
  //       },
  //     },
  //   ],
  //   /* Lakukan fungsi callback pada bracket ini */
  //   drawCallback: function(settings) {
  //     /* gunakan code ini utk mengambil data response ke dalam drawCallback */
  //     let api = this.api();
  //     let json = api.ajax.json();
  //     if (json.status == false) {
  //       /* jalankan apabila return false */
  //     }
  //     /* parameter callback untuk kostumisasi fungsi */
  //     $('.loading_tabel_rekap_pd').removeClass('show');
  //   }
  // });

  // /* fungsi untuk reload datatable ajax */
  function reload_table() {
    tabel_rekap_pd_all.ajax.reload();
    // tabel_rekap_pd.ajax.reload();
  }

  // Select2 Instansi Sekolah
  $('#id_sekolah').select2({
    allowClear: true,
    placeholder: '--- Pilih Sekolah ---',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_sekolah') ?>',
      delay: 800,
      /* delay before sending ajax request */
      data: function(params) {
        return {
          search: params.term,
        }
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
    }
  }).on('select2:select', function(e) {
    // what to do when option selected
  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    $('#id_sekolah').empty();
    // what to do when clearing (only if allowClear: true)
  });

  // Select2 tahun ajaran
  $('#id_tahun_ajaran').select2({
    allowClear: true,
    placeholder: '--- Pilih Tahun Ajaran ---',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_tahun_ajaran') ?>',
      delay: 800,
      /* delay before sending ajax request */
      data: function(params) {
        return {
          search: params.term,
        }
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
    }
  }).on('select2:select', function(e) {
    // what to do when option selected
  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    $('id_tahun_ajaran').empty();
    // what to do when clearing (only if allowClear: true)
  });
</script>