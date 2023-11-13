<div class="row g-2">
  <div class="col-12">
    <div class="panel">
      <div class="header">Daftar Dispensasi</div>
      <div class="separator"></div>
      <div class="body">
        <div class="row g-2">
          <div class="col-12">
            <div class="btn btn-sm btn-success mb-2" onclick="modal(`save_surat_tugas`,0)"><i class="fas fa-plus-square me-1"></i>Tambah Dispensasi</div>
          </div>
          <div class="col-12 col-sm-4 col-md-6 col-lg-4 mb-2">
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
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-2">
            <label for="filter_tgl">Filter Tanggal: (bulan/tanggal/tahun)</label>
            <input type="date" id="filter_tgl" class="form-control form-control-sm" pattern="\d{4}/\d{2}/\d{2}" value="<?php echo date("Y-m") . "-01"; ?>">
          </div>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-2 text-center text-sm-start">
            <label for="filter_tgl_akhir" class="d-block">&nbsp;</label>
            <input type="date" id="filter_tgl_akhir" class="form-control form-control-sm" value="<?php echo date("Y-m-d"); ?>">
          </div>
        </div>
        <div class="_loading trans">
          <div class="text">Loading...</div>
        </div>
        <!-- <div class="btn btn-sm btn-success mb-2" onclick="modal('','add')">
          <i class="fas fa-plus-square me-1"></i>Tambah Permohonan
        </div> -->
        <table id="transaksi" class="table table-border table-hover">
          <thead>
            <tr>
              <td style="min-width: 40px;">No</td>
              <td style="width: auto;">Pegawai</td>
              <td style="width: auto;">Durasi</td>
              <td style="width: auto;">Keterangan</td>
              <td style="width: auto;">Jenis Dispensasi</td>
              <td style="width: auto;">Dispensasi</td>
              <td style="min-width: 65px;">Aksi</td>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  var urlDatatable = "<?= site_url('surat_tugas/get_datatable') ?>";
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
      [1, "desc"],
    ],
    /* set placeholder dari input search */
    language: {
      searchPlaceholder: "Cari Pegawai.."
    },
    ajax: {
      url: urlDatatable,
      /* parameter yang dikirimkan ke controller */
      data: {
        kode_ukerja: function() {
          return $('#kode_ukerja').val();
        },
        filter_tgl: function() {
          return $('#filter_tgl').val();
        },
        filter_tgl_akhir: function() {
          return $('#filter_tgl_akhir').val();
        },
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
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 'nip',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start"><div class="smalltext b o">' + cellData + '</div>' +
            '<div>' + rowData.nama_lengkap + '</div>' +
            '<div class="smalltext b o">' + rowData.ket_ukerja + '</div>' +
            '<div class="d-block d-sm-none">' +

            '<hr class="mini">' +
            '<div><span class="fas fa-play text-info me-2"></span>' + rowData.tgl_mulai + '</div>' +
            '<div><span class="fas fa-stop text-warning me-2"></span>' + rowData.tgl_selesai + '</div>' +

            '<hr class="mini">' +
            '<a href="" target="_blank" class="badge bg-info text-black">E-FILE DOKUMEN</a><br>' +
            '<i class="fas fa-quote-left me-2"></i>' + rowData.keterangan + '<i class="fas fa-quote-right ms-2"></i>' +

            '</div>' +
            '</div>');
        }
      },
      {
        data: 'tgl_mulai',
        orderable: false,
        className: 'vam d-none d-sm-table-cell',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' +
            '<div><span class="fas fa-play text-info me-2"></span>' + cellData + '</div>' +
            '<div><span class="fas fa-stop text-warning me-2"></span>' + rowData.tgl_selesai + '</div>' +
            '</div>');
        }
      },
      {
        data: 'keterangan',
        orderable: false,
        className: 'vam d-none d-sm-table-cell',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' +
            '<a href="<?= site_url("efile/") ?>' + rowData.nip + '/' + rowData.dokumen + '/' + rowData.display_name + '" target="_blank" class="badge bg-info text-black">E-FILE DOKUMEN</a>' +
            '<hr class="mini">' +
            '<i class="fas fa-quote-left me-2"></i>' + cellData + '<i class="fas fa-quote-right ms-2"></i>' +
            '</div>');
        }
      },
      {
        data: 'jenis_dispensasi',
        orderable: false,
        className: 'vam d-none d-sm-table-cell',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' +
            cellData +
            '</div>');
        }
      },
      {
        data: 'ket_dispensasi',
        orderable: false,
        className: 'vam d-none d-sm-table-cell',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' +
            cellData +
            '</div>');
        }
      },
      {
        data: 'id',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          var btn_del = "";
          <?php if ($this->session->kewenangan == '00') { ?>
            btn_del = '<div class="badge bg-danger clickable d-block" onclick="modal(`delete_surat_tugas`,' + cellData + ')" title="Hapus Surat Tugas">Delete</div>';
          <?php } else { ?>
            if (rowData.jenis_dispensasi != "Dispensasi Walikota") {
              btn_del = '<div class="badge bg-danger clickable d-block" onclick="modal(`delete_surat_tugas`,' + cellData + ')" title="Hapus Surat Tugas">Delete</div>';
            }
          <?php } ?>
          $(td).html('<div class="text-start">' +
            '<div class="badge bg-warning text-black mb-1 clickable d-block" onclick="modal(`save_surat_tugas`,' + cellData + ')" title="Update Surat Tugas">Update</div>' + btn_del +
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
    tabel_transaksi.ajax.reload();
  }

  function modal(param1, param2) {
    var url = "<?= site_url('surat_tugas/modal') ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {
        id: param2,
        type: param1
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

  $('#filter_tgl,#filter_tgl_akhir').on('change', function(e) {
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
          param1: 'additional parameter to send',
          param2: 'additional parameter to send'
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
</script>