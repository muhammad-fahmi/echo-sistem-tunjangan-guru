<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Update Rombongan Belajar</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Data Tahun Ajaran</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?= site_url('pdt_rombongan_belajar') ?>">Rombongan Belajar</a>
      </li>
      <li class="breadcrumb-item active">Update</li>
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
        <div class="card-body">
          <h4 class="card-title space-between">
            <div><i class="fas fa-building me-2"></i>Profil Rombongan Belajar</div>
            <div></div>
          </h4>
          <div>

            <div class="row g-1">

              <table style="width: 100%;" class="table table-hover mb-1">
                <tr>
                  <td style="min-width: 150px;">Sekolah</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'ket_sekolah', '-') ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Kelas / Rombel</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'ket_kelas', '-') . '/' . check_var($data, 'nama_rombel', '-')  ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Semester</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'semester', '-') ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Tahun Ajaran</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'ket_tahun_ajaran', '-') ?></td>
                </tr>

              </table>

            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="col-12">

      <div class="card">
        <div class="card-body">
          <h4 class="card-title space-between mb-3">
            <div><i class="fas fa-user me-2"></i>Manajemen Peserta Didik</div>
            <div></div>
          </h4>

          <div class="row g-2">

            <div class="col-12">
              <div class="row g-2">

                <div class="table-responsive mt-4">

                  <div class="_loading loading_list_peserta_didik">
                    <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
                  </div>

                  <table id="list_peserta_didik" class="table table-bordered table-hover fs-3" style="width:100%;">

                    <thead class="bg-info text-white">
                      <tr class="text-center">
                        <th class="vam" style="min-width: 30px;">#</th>
                        <th class="vam" style="min-width: 100px;">Nama Lengkap</th>
                        <th class="vam" style="min-width: 80px;">Jenis Kelamin</th>
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

    </div>

  </div>

</div>

<script>
  var init_btn_add_siswa = false;
  let urlDatatable = "<?= site_url('pdt_rombongan_belajar/get_data_siswa') ?>";
  var list_peserta_didik = $("#list_peserta_didik").DataTable({
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
        data: 'ket_jns_kelamin',
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
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

          let btn_detail = '<a href="' + detail_url + cellData + '" class="badge bg-secondary clickable text-white me-1"><i class="fas fa-eye"></i> Detail</a>';
          let btn_delete = (kewenangan_user == '00') ?
            '<div onclick="modal(`' + cellData + '`, `delete_siswa_rombel`)" class="badge bg-danger clickable me-1" title="Hapus">' +
            '<i class="fas fa-trash"></i> Hapus</div>' :
            '';

          $(td).html('<div class="text-center">' +
            '<div class="d-grid gap-1 px-2"><div class="row">' +
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
      $('.loading_list_peserta_didik').removeClass('show');

      let btn_add_siswa = '<button class="btn btn-sm btn-success me-2" onclick="modal(`0`,`tambah_siswa_rombel`)">' +
        '<i class="fas fa-plus me-1"></i>Tambah Peserta Didik' +
        '</button>';

      if (!init_btn_add_siswa) {
        $('.init_btn_container').append(btn_add_siswa);
        init_btn_add_siswa = true;
      }
      /* parameter callback untuk kostumisasi fungsi */
      //$('._loading').removeClass('show');
    }
  });

  /* fungsi untuk reload datatable ajax */
  function reload_table() {
    list_peserta_didik.ajax.reload();
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

  /// |----------------------------------------
  /// | DOCUMENT READY
  /// |----------------------------------------
  $(document).ready(function() {
    // REQUEST RIWAYAT
    // request_riwayat();
  });
</script>