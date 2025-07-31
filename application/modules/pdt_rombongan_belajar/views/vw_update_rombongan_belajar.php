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
                  <td style="width: 100%;"><?= check_var($data, 'nama_sekolah', '-') ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Kelas / Rombel</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'tingkat', '-') . '/' . check_var($data, 'nama_rombel', '-')  ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Semester</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'semester', '-') ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Tahun Ajaran</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'tahun_ajaran', '-') ?></td>
                </tr>

              </table>

            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <form id="form_edit_rombongan_belajar" action="<?= site_url('pdt_rombongan_belajar/edit') ?>" method="POST">
        <!-- <input type="hidden" name="id_rombel" value="<?= check_var($data, 'id_rombel', '') ?>"> -->

        <div class="card">
          <div class="card-body">
            <h4 class="card-title space-between mb-3">
              <div><i class="fas fa-user me-2"></i>Daftar Peserta Didik</div>
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

      </form>
    </div>

  </div>

</div>

<script>
  var init_btn_add = false;
  let urlDatatable = "<?= site_url('pdt_peserta_didik/get_data') ?>";
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
      $('.loading_list_peserta_didik').removeClass('show');

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

  /// |----------------------------------------
  /// | DOCUMENT READY
  /// |----------------------------------------
  $(document).ready(function() {
    // REQUEST RIWAYAT
    // request_riwayat();
  });
</script>