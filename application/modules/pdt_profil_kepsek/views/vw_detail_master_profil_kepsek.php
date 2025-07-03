<?php
$cur_kewenangan = $this->session->userdata('kewenangan');
?>
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Profil Kepala Sekolah</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?= site_url('pdt_profil_kepsek') ?>">Update Profil Kepala Sekolah</a>
      </li>
      <li class="breadcrumb-item active">Detail Profil Kepala Sekolah</li>
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
          <h4 class="card-title space-between mb-3">
            <div><i class="fas fa-user me-2"></i>Profil Kepala Sekolah</div>
            <div></div>
          </h4>

          <div class="row g-2">
            <div class="col-12 col-lg-3 col-xl-1">
              <div class="img_profil_md">
                <img src="http://36.66.236.83/simpeg/foto/<?= check_var($data, 'nip', '0000') ?>.jpg" onerror="this.onerror=null; this.src='<?= base_url('theme/assets/images/default-profile.jpg') ?>';" alt="ALT_Description">
              </div>
            </div>

            <div class="col-12 col-lg-9 col-xl-11">
              <div class="row g-2">

                <div class="col-12">
                  <div class="desc_block">
                    <label>Sekolah / Unit Kerja</label>
                    <div><?= check_var($data, 'ket_ukerja', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>NIP</label>
                    <div><?= check_var($data, 'nip', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Status</label>
                    <div><?= check_var($data, 'ket_status', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Nama</label>
                    <div><?= check_var($data, 'nama', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>NIK</label>
                    <div><?= check_var($data, 'nik', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Tgl. Lahir</label>
                    <div><?= em_date('j F Y', 'set', check_var($data, 'tgl_lahir', '')) ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Jenis Kelamin</label>
                    <div>
                      <?php
                      $jkelamin = check_var($data, 'jenis_kelamin', '');
                      if ($jkelamin == 'P') {
                        echo 'Perempuan';
                      } elseif ($jkelamin == 'L') {
                        echo 'Laki-Laki';
                      } else {
                        echo '-';
                      }
                      ?>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Agama</label>
                    <div><?= check_var($data, 'ket_agama', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Status Pernikahan</label>
                    <div><?= check_var($data, 'status_pernikahan', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Pendidikan</label>
                    <div><?= check_var($data, 'kode_didik', '-') . ' / ' . check_var($data, 'pendidikan', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Alamat Saat Ini</label>
                    <div><?= check_var($data, 'alamat_saat_ini', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>NUPTR</label>
                    <div><?= check_var($data, 'nuptr', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>NURS</label>
                    <div><?= check_var($data, 'nurs', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>NRG</label>
                    <div><?= check_var($data, 'nrg', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>No. Sertifikat Pendidik</label>
                    <div><?= check_var($data, 'no_sertifikat_pendidik', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>No. Sertifikat GP</label>
                    <div><?= check_var($data, 'no_sertifikat_gp', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>No. Sertifikat CRS</label>
                    <div><?= check_var($data, 'no_sertifikat_crs', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>No. Rekening Bank</label>
                    <div><?= check_var($data, 'no_rek_bank', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>NPWP</label>
                    <div><?= check_var($data, 'npwp', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <?php
                  $mttpi = (check_var($data, 'menerima_ttp_insentif', '-'));
                  if ($mttpi == 'Y') {
                    $mttpi = 'Ya';
                  } elseif ($mttpi == 'N') {
                    $mttpi = 'Tidak';
                  }
                  ?>
                  <div class="desc_block">
                    <label>Menerima TTP Insentif</label>
                    <div><?= $mttpi ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>E-mail</label>
                    <div><?= check_var($data, 'email', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>NPWP</label>
                    <div><?= check_var($data, 'npwp', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>No. HP</label>
                    <div><?= check_var($data, 'no_hp', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Periode Ke</label>
                    <div><?= check_var($data, 'periode_ke', '-') ?></div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Masa / Tgl. Penugasan (Mulai)</label>
                    <div>
                      <?php
                      $mp_mulai = check_var($data, 'masa_penugasan_mulai', '');
                      $mp_text = check_var(em_date('j F Y', 'set', $mp_mulai), null, '-');
                      echo $mp_text;
                      ?>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="desc_block">
                    <label>Masa / Tgl. Penugasan (Selesai)</label>
                    <div>
                      <?php
                      $mp_selesai = check_var($data, 'masa_penugasan_selesai', '');
                      $mp_text = check_var(em_date('j F Y', 'set', $mp_selesai), null, '-');
                      echo $mp_text;
                      ?>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>

        </div>
      </div>

    </div>

  </div>

</div>

<script></script>