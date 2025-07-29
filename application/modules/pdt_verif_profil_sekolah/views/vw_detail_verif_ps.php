<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Detail Dokumen Profil Sekolah</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?= site_url('pdt_verif_profil_sekolah') ?>">Verifikasi Profil Sekolah</a>
      </li>
      <li class="breadcrumb-item active">Detail Dokumen</li>
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

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title space-between mb-3">
            <div><i class="fas fa-history me-2"></i>Riwayat Dokumen</div>
            <div></div>
          </h4>
          <div>

            <div id="row_riwayat_dokumen" class="row g-2 row_riwayat_dokumen">

              <div class="col-12">
                <div class="_loading loading_riwayat_dokumen behind-navbar">
                  <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>LOADING...</div>
                </div>
              </div>

            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <form id="form_edit_profil_sekolah" action="<?= site_url('pdt_profil_sekolah/edit') ?>" method="POST">
        <input type="hidden" name="id_dokumen" value="<?= check_var($data, 'id_dokumen', '') ?>">

        <div class="card">
          <div class="card-title space-between">
            <div><i class="fas fa-building me-2"></i>Profil Sekolah</div>
            <div></div>
          </div>
          <div class="card-body">

            <div class="row g-2">

              <!-- <div class="col-12 col-lg-3 col-xl-1"></div> -->

              <!-- <div class="col-12 col-lg-9 col-xl-11"> -->
              <div class="col-12">
                <div class="row g-2">

                  <div class="col-12">
                    <div class="desc_block">
                      <label>Sekolah / Unit Kerja</label>
                      <div><?= check_var($data, 'ket_ukerja', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="jenjang">Jenjang</label>
                      <div class="text_value"><?= check_var($data, 'jenjang', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="status">Status Sekolah</label>
                      <div class="text_value"><?= check_var($data, 'ket_status_sekolah', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="npsn">NPSN</label>
                      <div class="text_value"><?= check_var($data, 'npsn', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="nss">NSS</label>
                      <div class="text_value"><?= check_var($data, 'nss', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="no_statistik_bangunan">No. Statistik Bangunan</label>
                      <div class="text_value"><?= check_var($data, 'no_statistik_bangunan', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="akreditasi">Akreditasi</label>
                      <div class="text_value"><?= check_var($data, 'akreditasi', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="inklusif">Inklusif</label>
                      <div class="text_value">
                        <?php
                        if (check_var($data, 'inklusif', '__') == '1') {
                          echo 'Ya, Sekolah ini Inklusif';
                        } elseif (check_var($data, 'inklusif', '__') == '0') {
                          echo 'Tidak, Sekolah ini tidak Inklusif';
                        } else {
                          echo '-';
                        }
                        ?>
                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="alamat">Alamat</label>
                      <div class="text_value"><?= nl2br(check_var($data, 'alamat', '-')) ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="id_kecamatan">Kecamatan</label>
                      <div class="text_value"><?= check_var($data, 'id_kecamatan', '...') . ' - ' . check_var($data, 'nama_kecamatan', '...') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="id_kelurahan">Kelurahan</label>
                      <div class="text_value"><?= check_var($data, 'id_kelurahan', '...') . ' - ' . check_var($data, 'nama_kelurahan', '...') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="kode_pos">Kode POS</label>
                      <div class="text_value"><?= check_var($data, 'kode_pos', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="map_location">Lokasi pada MAP</label>
                      <div style="display: block; position: relative; width: calc(100% - 40px);">
                        <div id="map_location" style="height: 500px; z-index: 1;"></div>
                      </div>
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="desc_block">
                      <label for="lat">Latitude</label>
                      <div class="text_value"><?= check_var($data, 'lat', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="desc_block">
                      <label for="long">Longitude</label>
                      <div class="text_value"><?= check_var($data, 'long', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="telepon">No. Telepon</label>
                      <div class="text_value"><?= check_var($data, 'telepon', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="website">Website</label>
                      <div class="text_value"><?= check_var($data, 'website', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="email">E-mail</label>
                      <div class="text_value"><?= check_var($data, 'email', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="no_rek_bank">No. Rekening Bank</label>
                      <div class="text_value"><?= check_var($data, 'no_rek_bank', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="nama_bank">Nama Bank</label>
                      <div class="text_value"><?= check_var($data, 'nama_bank', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="cabang_kcp_unit">Cabang KCP Unit</label>
                      <div class="text_value"><?= check_var($data, 'cabang_kcp_unit', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="nama_wajib_pajak">Nama Wajib Pajak</label>
                      <div class="text_value"><?= check_var($data, 'nama_wajib_pajak', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="npwp">NPWP</label>
                      <div class="text_value"><?= check_var($data, 'npwp', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="no_sk_pendirian">No. SK Pendirian</label>
                      <div class="text_value"><?= check_var($data, 'no_sk_pendirian', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="tgl_sk_pendirian">Tgl. SK Pendirian</label>
                      <div class="text_value">
                        <?php
                        $date_skp = check_var($data, 'tgl_sk_pendirian', '');
                        echo check_var(em_date('j F Y', 'set', $date_skp), null, '-');
                        ?>
                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="no_sk_izin_operasional">No. SK Izin Operasional</label>
                      <div class="text_value"><?= check_var($data, 'no_sk_izin_operasional', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="tgl_sk_izin_operasional">Tgl. SK Izin Operasional</label>
                      <div class="text_value">
                        <?php
                        $date_skio = check_var($data, 'tgl_sk_izin_operasional', '');
                        echo check_var(em_date('j F Y', 'set', $date_skio), null, '-');
                        ?>
                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="luas_tanah">Luas Tanah (m<sup>2</sup>)</label>
                      <div class="text_value"><?= number_format(check_var($data, 'luas_tanah', 0), 2, ',', ',') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label for="kepemilikan_tanah">Kepemilikan Tanah</label>
                      <?php
                      $arr_kepemilikan = [
                        'MILIK' => 'Hak Milik',
                        'SEWA' => 'Sewa',
                        'PINJAM' => 'Pinjam',
                        'invalid' => '-'
                      ];
                      ?>
                      <div class="text_value"><?= $arr_kepemilikan[check_var($data, 'kepemilikan_tanah', 'invalid')] ?></div>
                    </div>
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
  function request_riwayat() {
    // you may add more than one param to send
    let loading_riwayat = $('.loading_riwayat_dokumen');
    let container_riwayat = $('#row_riwayat_dokumen');
    $.ajax({
      type: "POST",
      url: "<?= site_url('pangkalan_data/get_riwayat_dokumen') ?>",
      data: {
        id_dokumen: '<?= $data['id_dokumen'] ?>',
        jenis_dokumen: 'PROFIL_SEKOLAH'
      },
      dataType: 'json',
      beforeSend: function(e) {
        loading_riwayat.addClass('show');
      },
      success: function(e) {
        if (e.status) {
          // what to do when the response status = true
          container_riwayat.html(e.html);
          loading_riwayat.removeClass('show');
        } else {
          // what to do when the response status = false
          show_notify('error', e.message);
        }
      },
      error: function(xhr, status, error) {
        show_notify('error', error);
        console.error(error);
      },
    });
  }

  /// |----------------------------------------
  /// | DOCUMENT READY
  /// |----------------------------------------
  $(document).ready(function() {
    /// |----------------------------------------
    /// | MAP FUNCTIONALITY
    /// |----------------------------------------
    // Default coordinates if no value is set
    const defaultLat = <?= check_var($data, 'lat', ' -0.492215') ?>;
    const defaultLng = <?= check_var($data, 'long', '117.1432875') ?>;

    // Get initial coordinates
    let lat = $('#lat').val() || defaultLat;
    let lng = $('#long').val() || defaultLng;

    // Init map
    const map = L.map('map_location').setView([lat, lng], 17);

    // STADIAMAPS
    // L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png', {
    //   maxZoom: 20,
    //   attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, © OpenMapTiles, © OpenStreetMap contributors'
    // }).addTo(map);

    // CARTO VOYAGER
    // L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
    //   attribution: '&copy; <a href="https://carto.com/">CARTO</a> © OpenStreetMap contributors',
    //   subdomains: 'abcd',
    //   maxZoom: 20
    // }).addTo(map);

    // OPEN STREET MAP
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors',
      maxZoom: 19
    }).addTo(map);

    // Marker
    let marker = L.marker([lat, lng], {
      draggable: false
    }).addTo(map);

    // REQUEST RIWAYAT
    request_riwayat();
  });
</script>