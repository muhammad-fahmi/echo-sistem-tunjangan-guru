<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Detail Data Tahun Ajaran</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Data Tahun Ajaran</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?= site_url('pdt_tahun_ajaran'); ?>">Tahun Ajaran</a>
      </li>
      <li class="breadcrumb-item active">Detail</li>
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
            <div><i class="fas fa-file me-2"></i>Data Dokumen</div>
            <div></div>
          </h4>
          <div>

            <div class="row g-1">

              <table style="width: 100%;" class="table table-hover mb-1">
                <tr>
                  <td style="min-width: 150px;">Periode</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'periode_bln', '-') . '/' . check_var($data, 'periode_thn', '-')  ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Dibuat Pada</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= em_date('j F Y, H:i:s', 'set', check_var($data, 'create_on', '')) ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Status Dokumen</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <?php
                    $ket_status = check_var($data, 'ket_status_dokumen', '-');
                    $col_status = check_var($data, 'col_status_dokumen', 'secondary');
                    echo '<span class="badge bg-' . $col_status . '">' . $ket_status . '</span>';
                    ?>
                  </td>
                </tr>

              </table>

            </div>

          </div>
        </div>
      </div>
    </div>

  </div>

</div>

<script>
</script>