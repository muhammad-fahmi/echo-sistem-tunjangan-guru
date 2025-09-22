<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Laporan</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="<?= site_url('pangkalan_data'); ?>">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item active">Laporan</li>
    </ol>
  </div>
</div>
<div class="container-fluid">

  <div class="row">

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Menu Laporan</h4>
          List dari Menu laporan terdapat :
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
      <a href="<?= site_url('pdt_laporan/menu_lap_peserta_didik_tk'); ?>">
        <div class="card">
          <div class="card-body">
            <h2 class="text-center py-2"><i class="fas fa-file"></i></h2>
            <h4 class="text-center">Lap. Keadaan PD</h4>
          </div>
        </div>
      </a>
    </div>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
      <!-- <a href="<.?= site_url('pdt_laporan/menu_lap_peserta_didik_sd'); ?>"> -->
      <a href="#" onclick="on_dev()">
        <div class="card">
          <div class="card-body">
            <h2 class="text-center py-2"><i class="fas fa-file"></i></h2>
            <h4 class="text-center">Lap. Berdasarkan Agama</h4>
          </div>
        </div>
      </a>
    </div>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
      <!-- <a href="<.?= site_url('pdt_laporan/menu_lap_peserta_didik_smp'); ?>"> -->
      <a href="#" onclick="on_dev()">
        <div class="card">
          <div class="card-body">
            <h2 class="text-center py-2"><i class="fas fa-file"></i></h2>
            <h4 class="text-center">Lap. Berdasarkan Ragam Disabilitas</h4>
          </div>
        </div>
      </a>
    </div>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
      <a href="<?= site_url('pdt_laporan/menu_lap_rekap_tenaga_pendidik'); ?>">
        <div class="card">
          <div class="card-body">
            <h2 class="text-center py-2"><i class="fas fa-file"></i></h2>
            <h4 class="text-center">Lap. Rekap Tenaga Pendidik</h4>
          </div>
        </div>
      </a>
    </div>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
      <a href="<?= site_url('pdt_laporan/menu_lap_rekap_tenaga_kependidikan'); ?>">
        <div class="card">
          <div class="card-body">
            <h2 class="text-center py-2"><i class="fas fa-file"></i></h2>
            <h4 class="text-center">Lap. Rekap Tenaga Kependidikan</h4>
          </div>
        </div>
      </a>
    </div>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
      <a href="<?= site_url('pdt_laporan/menu_lap_rekap_ptk'); ?>">
        <div class="card">
          <div class="card-body">
            <h2 class="text-center py-2"><i class="fas fa-file"></i></h2>
            <h4 class="text-center">Lap. Rekap PTK</h4>
          </div>
        </div>
      </a>
    </div>

  </div>

</div>

<div class="toast_container"></div>

<script>
</script>