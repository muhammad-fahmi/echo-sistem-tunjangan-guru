<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">List TPP Per Bulan</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Home</a>
      </li>
      <li class="breadcrumb-item active">List TPP Per Bulan</li>
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
          <h4 class="card-title">List TPP Per Bulan</h4>

          <form id="form_jurnal_bulanan" action="<?= site_url('tpp_per_bulan'); ?>" method="POST" enctype="multipart/form-data">
            <div class="row mb-4">
              <div class="col-12 mb-2">
                <!-- Unit Kerja -->
                <label for="select_ukerja">Unit Kerja :</label>
                <select type="text" name="select_ukerja" class="form-select form-select-sm" style="width:100%" id="select_ukerja" >
                <option value="<?= $this->session->userdata("kode_unor"); ?>"><?= $this->session->userdata("ket_unor"); ?></option>
                </select>
              </div>

              <div class="col-3">
                <!-- Triwulan -->
                <label for="bln_filter">Masa TPP Bulan:</label>
                <select type="text" name="bln_filter" class="form-select form-select-sm" style="width:100%" id="triwulan" >
                  <option value="1" <?php echo ($bln_filter == 1) ? "selected" : ""; ?>>Januari</option>
                  <option value="2" <?php echo ($bln_filter == 2) ? "selected" : ""; ?>>Februari</option>
                  <option value="3" <?php echo ($bln_filter == 3) ? "selected" : ""; ?>>Maret</option>
                  <option value="4" <?php echo ($bln_filter == 4) ? "selected" : ""; ?>>April</option>
                  <option value="5" <?php echo ($bln_filter == 5) ? "selected" : ""; ?>>Mei</option>
                  <option value="6" <?php echo ($bln_filter == 6) ? "selected" : ""; ?>>Juni</option>
                  <option value="7" <?php echo ($bln_filter == 7) ? "selected" : ""; ?>>Juli</option>
                  <option value="8" <?php echo ($bln_filter == 8) ? "selected" : ""; ?>>Agustus</option>
                  <option value="9" <?php echo ($bln_filter == 9) ? "selected" : ""; ?>>September</option>
                  <option value="10" <?php echo ($bln_filter == 10) ? "selected" : ""; ?>>Oktober</option>
                  <option value="11" <?php echo ($bln_filter == 11) ? "selected" : ""; ?>>November</option>
                  <option value="12" <?php echo ($bln_filter == 12) ? "selected" : ""; ?>>Desember</option>
                </select>
              </div>
              <div class="col-3">
                <!-- Tahun -->
                <label for="tahun">Tahun :</label>
                <select type="text" name="tahun" class="form-select form-select-sm" style="width:100%" id="tahun" >
                  <?php for($y = 2023; $y <= date("Y"); $y++){ ?>
                    <option value="<?= $y ?>" <?php echo ($y == $thn_filter ) ? "selected" : ""; ?>><?= $y ?></option>
                  <?php } ?>                  
                </select>
              </div>
            </div>
            <div class="row">
                <div class="col-3">
                  <button class="btn btn-primary" onclick="reload_table()"><i class="fa fa-refresh"></i> Refresh </button>
                  <br>
                  <br>
                </div>
            </div>
            <div class="row">
              <div class="col-12">
                <!-- Button export file -->
                <a href="<?= site_url('laporan/generate_pdf_tpp_triwulan'); ?>" id="btn_export_file" class="btn btn-sm btn-primary me-2" type="button">
                  <i class="fas fa-upload me-2"></i>Cetak DRAFT Daftar TPP
                </a>
                <a href="<?= site_url('laporan/generate_pdf_tpp_triwulan'); ?>" id="btn_export_file" class="btn btn-sm btn-success me-2" type="button">
                  <i class="fas fa-upload me-2"></i>Finalkan Daftar TPP
                </a>
              </div>
            </div>
            
            <!-- <button id="btn_export_file" class="btn btn-sm btn-success me-2" type="submit" form="form_jurnal_bulanan">
              <i class="fas fa-upload me-2"></i>Export File Jurnal
            </button> -->
          </form>
          <br>
          <div class="alert alert-primary">
            <b>PERHATIAN!!</b> Nilai Total TPP pada tabel adalah TPP sebelum dipotong pajak dan infaq bagi yang muslim
          </div>

          <div class="table-responsive mt-4">

            <div class="_loading loading_tabel_tpp_3_bulan">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_tpp_3_bulan" class="table table-bordered table-hover fs-3" style="width:100%;">

              <tr style="text-align: center;font-size: 10px;">
                <th rowspan="2" style="vertical-align: middle;">No</th>
                <th rowspan="2" style="vertical-align: middle;">Nama Jabatan</th>
                <th rowspan="2" style="vertical-align: middle;">Nama/NIP</th>
                <th rowspan="2" style="vertical-align: middle;">Besaran TPP</th>
                <th colspan="3">TPP Disiplin Kerja</th>
                <th colspan="3">TPP Produktifitas Kerja</th>
                <th rowspan="2" style="vertical-align: middle;">Total TPP</th>
              </tr>
              <tr style="text-align: center;font-size: 10px;">
                <th style="vertical-align: middle;">Besaran</th>
                <th style="vertical-align: middle;">Potongan</th>
                <th style="vertical-align: middle;">Penghasilan</th>
                <th style="vertical-align: middle;">Besaran</th>
                <th style="vertical-align: middle;">Capaian</th>
                <th style="vertical-align: middle;">Penghasilan</th>
              </tr>
              <!-- <tr>
                <td>February</td>
                <td>$80</td>
              </tr> -->

              <!-- <thead class="bg-info text-white">
                <tr class="text-center">
                  <th>Nama Jabatan</th>
                  <th>Nama PNS</th>
                  <th>NIP</th>
                  <th>Besaran TPP</th>
                  <th>Jabatan</th>
                  <th>Unit Kerja</th>
                  <th>Insentif</th>
                  <th>Bulan</th>
                  <th>Jumlah Kotor</th>
                  <th>Jumlah PPh 5%</th>
                  <th>Jumlah PPh 15%</th>
                  <th>Jumlah INFAQ 2,5%</th>
                  <th>Jumlah Bersih</th>
                  <th>No Rekening</th>
                  <th>NIK</th>
                  <th>NPWP</th>
                </tr>
              </thead> -->

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
          aktif : "Y"
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
    generate_table();
    console.log(e);

  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
    selected_kewenangan = '';
  });

  function generate_table(){

  }
</script>