<div class="row g-2">
  <div class="col-12">
    <div class="panel">
      <div class="header">Daftar Record Presensi</div>
      <div class="separator"></div>
      <div class="body">
        <div class="row g-3">
          <div class="col-4 col-md-4 col-lg-3 mb-2">
            <label for="instansi">Filter Instansi : </label>
            <select type="text" class="form-select form-select-sm instansi select2" name="kode_ukerja" id="kode_ukerja">
              <?php
              $temp = $this->session->userdata("kode_ukerja");
              $ket_temp = $this->session->userdata("ket_ukerja") . ' [ ' . $this->session->userdata("kode_ukerja") . ' ]';
              if ($temp != '') {
                echo '<option value="' . $temp . '" default selected>' . $ket_temp . '</option>';
              }
              ?>
            </select>
          </div>
          <div class="col-4 col-md-4 col-lg-3 mb-2">
            <label for="instansi">Filter Mesin : </label>
            <select type="text" class="form-select form-select-sm instansi select2" name="cloud_id" id="cloud_id">
              <option value="all"> - - - Semua Mesin - - - </option>
            </select>
          </div>
          <div class="col-4 col-md-4 col-lg-3 mb-2">
            <label for="instansi">Filter Jenis Pegawai : </label>
            <select type="text" class="form-select form-select-sm instansi select2" name="filter_jnspeg" id="filter_jnspeg">
              <option value="all"> - - - Semua Pegawai - - - </option>
              <option value="PNS"> PNS </option>
              <option value="PTT"> PTT </option>
            </select>
          </div>
        </div>
        <div class="row g-2">
          <div class="col-6 col-sm-4 col-md-4 col-lg-2 mb-2 text-center text-sm-start">
            <label for="filter_tgl">Filter Tanggal:</label>
            <input type="date" id="filter_tgl" class="form-control form-control-sm" value="<?php echo date("Y-m-d"); ?>">
          </div>
          <div class="col-3 d-block d-sm-none"></div>
          <div class="col-6 col-sm-4 col-md-4 col-lg-2 mb-2 text-center text-sm-start">
            <label for="filter_tgl_akhir" class="d-none d-sm-block">&nbsp;</label>
            <input type="date" id="filter_tgl_akhir" class="form-control form-control-sm" value="<?php echo date("Y-m-d"); ?>">
          </div>
        </div>
        <div class="row g-2">
          <!-- <div class="col-4 col-sm-6 col-md-4 col-lg-2 mb2 text-center text-sm-start">
            <button id="export_excel" onclick="export_attlog('excel')" class="btn btn-success"> Export Excel</button>
          </div> -->
          <div class="col-4 col-sm-6 col-md-4 col-lg-2 mb2 text-center text-sm-start">
            <button id="export_pdf" onclick="export_attlog('pdf')" class="btn btn-danger"> Export PDF</button>
          </div>
        </div>
        <div class="_loading trans">
          <div class="text">Loading...</div>
        </div>
        <!-- <div class="btn btn-sm btn-success mb-2" onclick="modal('','add')">
          <i class="fas fa-plus-square me-1"></i>Tambah Permohonan
        </div> -->
        <br>
        <table id="transaksi" class="table table-border table-hover">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th width="10%">CLOUD ID</th>
              <th width="10%">NIP</th>
              <th width="15%">Nama</th>
              <th width="15%">Jabatan</th>
              <th width="15%">Unit Kerja</th>
              <th width="10%">Waktu Presensi</th>
              <th width="10%">Jenis Presensi</th>
              <th width="10%">Status</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  var urlDatatable = "<?= site_url('dashboard/get_data_attlog') ?>";
  var tabel_transaksi = $("#transaksi").DataTable({
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
      [6, "desc"],
    ],
    /* set placeholder dari input search */
    language: {
      searchPlaceholder: "Cari Attlog.."
    },
    ajax: {
      url: urlDatatable,
      /* parameter yang dikirimkan ke controller */
      data: {
        kode_ukerja: function() {
          return $('#kode_ukerja').val();
        },
        cloud_id: function() {
          return $('#cloud_id').val();
        },
        filter_tgl: function() {
          return $('#filter_tgl').val();
        },
        filter_tgl_akhir: function() {
          return $('#filter_tgl_akhir').val();
        },
        filter_jnspeg: function() {
          return $('#filter_jnspeg').val();
        }
      },
      type: 'POST',
      beforeSend: function() {
        // lakukan sesuatu sebelum mulai ajax process
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
        data: 'cloud_id',
        orderable: false,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        }
      },
      {
        data: 'pin',
        orderable: false,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        }
      },
      {
        data: 'nama',
        orderable: false,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        }
      },
      {
        data: 'ket_jab',
        orderable: false,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        }
      },
      {
        data: 'ket_ukerja',
        orderable: false,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        }
      },
      {
        data: 'scan_date',
        orderable: true,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        }
      },
      {
        data: 'ket_verify',
        orderable: false,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + rowData.ket_verify + '</div>');
        }
      },
      {
        data: 'ket_status_scan',
        orderable: false,
        className: '',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + rowData.ket_status_scan + '</div>');
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
    tabel_transaksi.ajax.reload();
  }

  function modal(id, type) {
    var url = "<?= site_url('transaksi/modal') ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {
        id: id,
        type: type
      },
      success: function(res) {
        if (res.status) {
          $("#modal").html(res.html).show();
          $("#my_modal").modal("show");
        } else {
          $.notify('<b><i class="fas fa-exclamation-triangle me-1"></i>Error!</b><br>' + res.message, 'error');
        }
      }
    });
  }

  $('#filter_tgl,#filter_tgl_akhir,#filter_jnspeg').on('change', function(e) {
    reload_table();
  });

  /* fungsi select2 filter_ukerja dashboard; */
  $('#kode_ukerja').select2({
    allowClear: false,
    placeholder: 'Pilih Instansi',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_instansi') ?>',
      delay: 800,
      /* delay before sending ajax request */
      data: function(params) {
        return {
          search: params.term,
          aktif: 'N'
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
    //reset cloud id filter
    $("#cloud_id").html(
      "<option value='all'> - - - Semua Mesin - - - </option>"
    );
    reload_table();
  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
  });
  /* fungsi select2 filter_ukerja dashboard; */
  $('#cloud_id').select2({
    allowClear: false,
    placeholder: 'Pilih Mesin',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_mesin') ?>',
      delay: 800,
      /* delay before sending ajax request */
      data: function(params) {
        return {
          search: params.term,
          kode_ukerja: $("#kode_ukerja").val(),
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
    reload_table();
  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
  });

  function export_attlog(jenis) {
    var url = "<?php echo site_url("dashboard/export_attlog_excel"); ?>";
    if (jenis == "pdf") {
      url = "<?php echo site_url("dashboard/export_attlog_pdf"); ?>";
    }
    var kode_ukerja = $('#kode_ukerja').val();
    var cloud_id = $('#cloud_id').val();
    var filter_tgl = $('#filter_tgl').val();
    var filter_tgl_akhir = $('#filter_tgl_akhir').val();
    var filter_jnspeg = $('#filter_jnspeg').val();
    if (kode_ukerja == "6971") {
      alert("Silahkan pilih OPD terlebih dahulu!");
    } else {
      window.open(url + "/" + kode_ukerja + "/" + cloud_id + "/" + filter_jnspeg + "/" + filter_tgl + "/" + filter_tgl_akhir);
    }
  }
</script>