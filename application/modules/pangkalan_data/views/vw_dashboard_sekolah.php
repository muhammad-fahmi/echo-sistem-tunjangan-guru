<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Dashboard Sekolah</h3>
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
              <?php highlight_string("<?php\nSESSION = " . var_export($this->session->userdata(), true) . ";\n?>"); ?>
              <?php highlight_string("<?php\nDATA = " . var_export($data, true) . ";\n?>"); ?>
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
          <h4 class="card-title">Dashboard Sekolah</h4>
          Selamat Datang <b><?= $this->session->userdata('username'); ?></b> di aplikasi PROGURINDA - Pangkalan Data, berikut ini profil sekolah Anda :
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title space-between">
            <div>PROFIL</div>
            <div class="btn btn-sm btn-warning pull-right" onclick="on_dev()">UPDATE PROFIL ></div>
          </h4>
          <table class="table table-sm table-hover">
            <tr>
              <td style="min-width: 150px;">NAMA</td>
              <td style="min-width: 20px; text-align: center;">:</td>
              <td style="width: 100%;"><?= check_var($data, 'ket_ukerja', '-') ?></td>
            </tr>
            <tr>
              <td style="min-width: 150px;">JENJANG</td>
              <td style="min-width: 20px; text-align: center;">:</td>
              <td style="width: 100%;"><?= check_var($data, 'jenjang', '-') ?></td>
            </tr>
            <tr>
              <td style="min-width: 150px;">STATUS</td>
              <td style="min-width: 20px; text-align: center;">:</td>
              <td style="width: 100%;">
                <?php
                $status = check_var($data, 'status', null);
                $ket_status = '-';
                if ($status == 'N') $ket_status = 'Negeri';
                if ($status == 'S') $ket_status = 'Swasta';
                echo $ket_status;
                ?>
              </td>
            </tr>
          </table>
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