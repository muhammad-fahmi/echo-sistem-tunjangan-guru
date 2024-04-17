<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Daftar Setup Jurnal Mengajar Guru</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Home</a>
      </li>
      <li class="breadcrumb-item active">Daftar Jurnal Mengajar Guru</li>
    </ol>
  </div>

  <!-- <div class="col-md-8 col-12 align-self-center d-none d-md-block">
    <div class="d-flex mt-2 justify-content-end">
      <div class="d-flex me-3 ms-2">
        <div class="chart-text me-2">
          <h6 class="mb-0"><small>Pagu Anggaran</small></h6>
          <h4 class="mt-0 text-info"><?= to_rp($data['anggaran']) ?></h4>
        </div>
        <div class="spark-chart">
          <div id="monthchart"></div>
        </div>
      </div>
      <div class="d-flex ms-2">
        <div class="chart-text me-2">
          <h6 class="mb-0"><small>Realisasi</small></h6>
          <h4 class="mt-0 text-primary"><?= to_rp($data['real_keu']) ?></h4>
        </div>
        <div class="spark-chart">
          <div id="lastmonthchart"></div>
        </div>
      </div>
      <div class="d-flex ms-2">
        <div class="chart-text me-2">
          <h6 class="mb-0"><small>Fisik</small></h6>
          <h4 class="mt-0 text-success"><?= to_rp($data['real_fisik'], false) ?>%</h4>
        </div>
        <div class="spark-chart">
          <div id="nextmonthchart"></div>
        </div>
      </div>
    </div>
  </div> -->

</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
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
          <h4 class="card-title">Daftar Jurnal Mengajar Guru Pengampu</h4>
          <div class="row mb-4">
              <div class="col-12 mb-2">
                <!-- Unit Kerja -->
                <label for="select_ukerja">Unit Kerja :</label>
                <select type="text" name="select_ukerja" class="form-select form-select-sm" style="width:100%" id="select_ukerja">
                <option value="<?= $this->session->userdata("kode_unor"); ?>"><?= $this->session->userdata("ket_unor"); ?></option>
                </select>
              </div>

              <div class="col-3">
                <!-- Bulan -->
                <label for="bulan">Bulan :</label>
                <select type="text" name="filter_bln" class="form-select form-select-sm" style="width:100%" id="filter_bln" >
                  <?php 
                  $bln_now = date("n");
                  for($i = 1;$i <= 12;$i++){
                    $selected = ($i == $bln_now) ? "selected" : "";
                  ?>
                    <option value="<?= $i ?>" <?= $selected ?>><?= getBulan($i) ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-3">
                <!-- Tahun -->
                <label for="tahun">Tahun :</label>
                <select type="text" name="filter_thn" class="form-select form-select-sm" style="width:100%" id="filter_thn">
                  <?php for($i = 2023;$i <= date("Y");$i++){ 
                    $selected = ($i == date('Y')) ? "selected" : "";
                    ?>
                    <option value="<?= $i; ?>" <?= $selected; ?>><?= $i; ?></option>    
                    <?php } ?>
                  </select>
              </div>
              
            </div>
          <div class="row">
          <div class="col-3">
                <button class="btn btn-primary" onclick="reload_table()"><i class="fa fa-refresh"></i> Refresh </button>
              </div>
          </div>
          <div class="table-responsive mt-4">

            <div class="_loading loading_tabel_jurnal_mengajar">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_jurnal_mengajar" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th>NIP / Nama</th>
                  <th>Jabatan</th>
                  <th>Unit Kerja</th>
                  <th>Bulan</th>
                  <th>Tahun</th>
                  <th>Jam Mengajar</th>
                  <th>Aksi</th>
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
  var urlDatatable = "<?= site_url('jurnal_mengajar/datalist') ?>";
  var init_btn_add = false;
  var tabel_jurnal_mengajar = $("#table_jurnal_mengajar").DataTable({
    responsive: true,
    processing: true,
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
      searchPlaceholder: "Keyword"
    },
    ajax: {
      url: urlDatatable,
      /* parameter yang dikirimkan ke controller */
      data: {
        filter_bln: function() {
          return $('#filter_bln').val();
        },
        filter_thn: function() {
          return $('#filter_thn').val();
        },
        select_ukerja: function() {
          return $('#select_ukerja').val();
        },
      },
      type: 'POST',
      beforeSend: function() {
        // lakukan sesuatu sebelum mulai ajax process
        $('.loading_tabel_jurnal_mengajar').addClass('show');
      },
    },
    /* Sesuaikan jumlah kolom dengan id table yang digunakan */
    columns: [{
        data: 'nip',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div><br><b>'+rowData.nama_lengkap+'</b>');
        },
      },
      
      {
        data: 'ket_jab',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-start">' + cellData + '</div>');
        },
      },
      {
        data: 'ket_ukerja',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        },
      },
      {
        data: 'bulan',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-end">' + cellData + '</div>');
        },
      },
      {
        data: 'tahun',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-end">' + cellData + '</div>');
        },
      },
      {
        data: 'jam_mengajar',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-end">' + cellData + '</div>');
        },
      },
      {
        data: 'id',
        orderable: false,
        className: 'vam',
        createdCell: function(td, cellData, rowData, row, col) {
          let id_entry = cellData;
          let html_aksi = '<div class="btn-group">' + '<button type="button" class="btn btn-sm btn-light-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">' +
            'Pilih' +
            '</button>' +
            '<ul class="dropdown-menu">' +
            '<li><a class="dropdown-item" onclick="modal(`' + id_entry + '`, `edit_jurnal_mengajar`)" href="#"><i class="fas fa-edit me-1"></i>Edit</a></li>' +
            '<li><a class="dropdown-item text-danger" onclick="modal(`' + id_entry + '`, `delete_jurnal_mengajar`)" href="#"><i class="fas fa-trash me-1"></i>Delete</a></li>' +
            '</ul>' +
            '</div>';
          $(td).html('<div class="text-center">' + html_aksi + '</div>');
        },
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
      $('.loading_tabel_jurnal_mengajar').removeClass('show');

      let btn_add = '<button class="btn btn-sm btn-success me-2" onclick="modal(`0`,`tambah_jurnal_mengajar`)">' +
        '<i class="fas fa-plus me-1"></i>Tambah Jurnal Mengajar' +
        '</button>';

      if (!init_btn_add) {
        $('.init_btn_container').append(btn_add);
        init_btn_add = true;
      }
    }
  });

  /* fungsi untuk reload datatable ajax */
  function reload_table() {
    tabel_jurnal_mengajar.ajax.reload();
  }

  function modal(id, type) {
    var url = "<?= site_url('jurnal_mengajar/modal') ?>";
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
</script>