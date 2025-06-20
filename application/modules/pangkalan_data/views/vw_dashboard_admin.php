<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Dashboard Admin</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </div>
</div>

<div class="container-fluid">

  <div class="row">

    <?php
    $show_debug = true;
    if ($show_debug) {
    ?>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">SESSION DATA (DEBUG)</h4>
            <small>
              <?php highlight_string("<?php\nOUTPUT = " . var_export($this->session->userdata(), true) . ";\n?>"); ?>
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
          <h4 class="card-title">Dashboard Admin</h4>
          Selamat Datang <b><?= $this->session->userdata('username'); ?></b> di aplikasi PROGURINDA - Pangkalan Data, berikut ini rangkuman proses yang perlu Anda diketahui :
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">TK / PAUD</h4>
          <h1 class="text-center">33</h1>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">SD</h4>
          <h1 class="text-center">53</h1>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">SMP</h4>
          <h1 class="text-center">23</h1>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">PROFIL KEPSEK PERLU VERIFIKASI</h4>
          <h1 class="text-center">12</h1>
        </div>
      </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">PROFIL SEKOLAH PERLU VERIFIKASI</h4>
          <h1 class="text-center">0</h1>
        </div>
      </div>
    </div>

  </div>

</div>

<script>
  $(document).ready(function() {
    // do something on document ready
  });
</script>