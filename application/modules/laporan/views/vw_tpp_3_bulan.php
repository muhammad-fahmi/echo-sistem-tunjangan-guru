<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Laporan TPP Per 3 Bulan</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Home</a>
      </li>
      <li class="breadcrumb-item active">Laporan TPP Per 3 Bulan</li>
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
          <h4 class="card-title">Laporan TPP Per 3 Bulan</h4>

          <div class="row mb-4">

            <div class="col-12 mb-2">
              <!-- Unit Kerja -->
              <label for="select_ukerja">Unit Kerja :</label>
              <select type="text" name="select_ukerja" class="form-select form-select-sm" style="width:100%" id="select_ukerja" value="">
                <option value="<?= $this->session->userdata("kode_unor") ?>"><?= $this->session->userdata("ket_unor"); ?></option>
              </select>
            </div>

            <div class="col-6">
              <!-- Triwulan -->
              <label for="triwulan">Triwulan ke :</label>
              <select type="text" name="triwulan" class="form-select form-select-sm" style="width:100%" id="triwulan">
                <option value="" default selected>- Pilih Triwulan -</option>
                <option value="1">I - (JANUARI-MARET)</option>
                <option value="2">II - (APRIL-JUNI)</option>
                <option value="3">III - (JULI-SEPTEMBER)</option>
                <option value="4">IV - (OKTOBER-DESEMBER)</option>
              </select>
            </div>

            <div class="col-6">
              <!-- Tahun -->
              <label for="tahun">Tahun :</label>
              <select type="text" name="tahun" class="form-select form-select-sm" style="width:100%" id="tahun">
                <option value="" default selected>- Pilih Tahun -</option>
                <?php
                $year = (int)em_date('Y');
                for ($i = $year; $i >= 2023; $i--) {
                  echo '<option value="' . $i . '">' . $i . '</option>';
                }
                ?>
              </select>
            </div>

          </div>
          <!-- <button class="btn btn-primary" onclick="generate_tabel_tpp_triwulan()" id="gen_table"><i class="fa-solid fa-rotate-right"></i> Tampilkan </button> -->
          <!-- Button export file -->
          <a href="<?= site_url('laporan/cetak_ttp_3_bln'); ?>" target="_blank" id="btn_export_file" class="btn btn-sm btn-success me-2 disabled" type="button">
            <i class="fas fa-upload me-2"></i>Export Laporan TPP Per Triwulan
          </a>

          <!-- Button export file rekapitulasi (TESTING) -->
          <a href="<?= site_url('laporan/cetak_rekapitulasi_mengajar'); ?>" target="_blank" id="btn_export_rekapitulasi_file" class="btn btn-sm btn-primary me-2 disabled d-none" type="button">
            <i class="fas fa-upload me-2"></i>Export Laporan Rekapitulasi Jurnal Mengajar
          </a>
          <!-- <button id="btn_export_file" class="btn btn-sm btn-success me-2" type="submit" form="form_jurnal_bulanan">
              <i class="fas fa-upload me-2"></i>Export File Jurnal
            </button> -->

          <div class="table-responsive mt-4">

            <div class="_loading loading_tabel_tpp_3_bulan">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_tpp_3_bulan" class="table table-bordered table-hover fs-3" style="width:100%;">

              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th>NIP/Nama</th>
                  <th>Gol</th>
                  <th>Jabatan</th>
                  <th>TPP/Bulan</th>
                  <th>Jumlah Bulan</th>
                  <th>Jumlah Kotor</th>
                  <th>Jumlah PPh 5%</th>
                  <th>Jumlah PPh 15%</th>
                  <th>Jumlah INFAQ 2,5%</th>
                  <th>Jumlah Bersih</th>

                  <!-- <th>Aksi</th> -->
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
  $('#select_ukerja').select2({
    allowClear: true,
    placeholder: 'Pilih Unit Kerja.',
    //dropdownParent: $('#whole_modal_id .modal-content'),
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_instansi') ?>',
      delay: 800,
      /* delay before sending ajax request */
      data: function(params) {
        return {
          search: params.term,
          aktif: "Y"
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
    btn_cetak_handler();
    console.log(e);

  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
    selected_kewenangan = '';
    btn_cetak_handler();
  });

  
  var init_btn_export = false;
  
  function generate_tabel_tpp_triwulan(){
    var urlDatatable = "<?= site_url('laporan/tpp_3_bln_datalist') ?>";
    var triwulan = $("[name=triwulan]").val();
    var thn_filter = $("[name=tahun]").val();
    var select_ukerja = $("[name=select_ukerja]").val();
    $("#gen_table").prop("disabled",true);
    $("#gen_table").html(" . . . Proses tabel");
    $.ajax({
      type: "POST",
      url: url,
      data: {
        triwulan: triwulan,
        tahun: tahun,
        kode_ukerja: kode_ukerja
      },
      success: function(res) {
        $("#gen_table").prop("disabled",false);
        $("#gen_table").html("Tampilkan");
        $("#tabel-body").html(res);
      }
    });
  }

  /* fungsi untuk reload datatable ajax */
  function reload_table() {
    tabel_tpp_3_bulan.ajax.reload();
  }

  function btn_cetak_handler() {
    let val_ukerja = '';
    let val_tahun = '';
    let val_triwulan = '';
    let link_export = $('#btn_export_file');
    let url = '#';

    val_ukerja = $('[name="select_ukerja"]').val();
    val_triwulan = $('[name="triwulan"]').val();
    val_tahun = $('[name="tahun"]').val();

    if (val_ukerja != '' && val_triwulan != '' && val_tahun != '') {
      link_export.removeClass('disabled');
      url = '<?= site_url('laporan/cetak_ttp_3_bln') ?>/' + val_ukerja + '/' + val_triwulan + '/' + val_tahun;
      console.log('url retrieved: ' + url);
    } else {
      link_export.addClass('disabled');
      $url = '#';
    }

    link_export.attr('href', url);
    console.log('btn_cetak_handler running');
  }

  function btn_cetak_rekapitulasi_handler() {
    let val_ukerja = '';
    let val_tahun = '';
    let val_triwulan = '';
    let link_export = $('#btn_export_rekapitulasi_file');
    let url = '#';

    val_ukerja = $('[name="select_ukerja"]').val();
    val_triwulan = $('[name="triwulan"]').val();
    val_tahun = $('[name="tahun"]').val();

    if (val_ukerja != '' && val_triwulan != '' && val_tahun != '') {
      link_export.removeClass('disabled');
      url = '<?= site_url('laporan/cetak_rekapitulasi_mengajar') ?>/' + val_ukerja + '/' + val_triwulan + '/' + val_tahun;
      console.log('url retrieved: ' + url);
    } else {
      link_export.addClass('disabled');
      $url = '#';
    }

    link_export.attr('href', url);
    console.log('btn_cetak_rekapitulasi_handler running');
  }

  $('[name="triwulan"]').on('change', function() {
    btn_cetak_handler();
    btn_cetak_rekapitulasi_handler();
  });

  $('[name="tahun"]').on('change', function() {
    btn_cetak_handler();
    btn_cetak_rekapitulasi_handler();
  });

  setTimeout(() => {
    btn_cetak_handler();
    btn_cetak_rekapitulasi_handler();
  }, 50);
</script>