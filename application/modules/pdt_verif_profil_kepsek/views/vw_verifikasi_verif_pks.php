<?php
$cur_kewenangan = $this->session->userdata('kewenangan');
?>
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Verifikasi Dokumen</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?= site_url('pdt_verif_profil_kepsek') ?>">Verifikasi Profil Kepala Sekolah</a>
      </li>
      <li class="breadcrumb-item active">Verifikasi Dokumen Usulan Profil Kepala Sekolah</li>
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
              <?php highlight_string("<?php\nOLD_DATA = " . var_export($data, true) . ";\n\n?>"); ?>
              <?php highlight_string("<?php\nNEW_DATA = " . var_export($dokumen, true) . ";\n\n?>"); ?>
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
          <div class="alert alert-danger mb-0">
            <table>
              <tr>
                <td style="min-width: 50px; font-size: 1.5rem;" class="text-center">
                  <i class="fas fa-exclamation-triangle"></i>
                </td>
                <td style="width: 100%;" class="ps-2">
                  Silahkan lakukan pengecekan data awal dan data baru yang diusulkan untuk verifikasi, jika semua data dikonfirmasi benar silahkan pilih <b>Setuju</b> pada kolom tindak lanjut. Namun jika ada data yang tidak benar, silahkan pilih <b>Tolak</b> pada kolom tindak lanjut.<br>
                  Klik tombol <b>Verifikasi</b> di akhir halaman untuk menyelesaikan proses sesuai dengan tindak lanjut yang dipilih.
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>

    <?php
    /// |----------------------------------------------------------------------
    /// | >> DATA AWAL 
    /// |----------------------------------------------------------------------
    ?>
    <div class="col-12 col-lg-6">

      <div id="old_card" class="card">
        <div class="card-body">
          <h4 class="card-title space-between mb-3">
            <div><i class="fas fa-building me-2"></i>Profil Kepala Sekolah (Saat Ini)</div>
            <div></div>
          </h4>

          <div class="row g-2">

            <?php
            if (check_var($data)) {
              // kalau memang ada data awal, tampilkan
            ?>
              <div class="col-12">
                <div class="desc_block old_data old_ket_ukerja" attr-data="ket_ukerja">
                  <label>Sekolah / Unit Kerja</label>
                  <div><?= check_var($data, 'ket_ukerja', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_nip" attr-data="nip">
                  <label>NIP</label>
                  <div><?= check_var($data, 'nip', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_ket_status" attr-data="ket_status">
                  <label>Status</label>
                  <div><?= check_var($data, 'ket_status', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_gelar_dpn" attr-data="gelar_dpn">
                  <label>Gelar Depan</label>
                  <div><?= check_var($data, 'gelar_dpn', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_nama" attr-data="nama">
                  <label>Nama</label>
                  <div><?= check_var($data, 'nama', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_gelar_blk" attr-data="gelar_blk">
                  <label>Gelar Belakang</label>
                  <div><?= check_var($data, 'gelar_blk', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_nik" attr-data="nik">
                  <label>NIK</label>
                  <div><?= check_var($data, 'nik', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_tgl_lahir" attr-data="tgl_lahir">
                  <label>Tgl. Lahir</label>
                  <div><?= em_date('j F Y', 'set', check_var($data, 'tgl_lahir', '')) ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_jenis_kelamin" attr-data="jenis_kelamin">
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
                <div class="desc_block old_data old_ket_agama" attr-data="ket_agama">
                  <label>Agama</label>
                  <div><?= check_var($data, 'ket_agama', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_status_pernikahan" attr-data="status_pernikahan">
                  <label>Status Pernikahan</label>
                  <div><?= check_var($data, 'ket_status_pernikahan', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_pangkat" attr-data="pangkat">
                  <label>Pangkat / Gol. Ruang</label>
                  <div><?= check_var($data, 'pangkat', '-') . ' / ' . check_var($data, 'gol_ruang', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_jenjang_jabatan" attr-data="jenjang_jabatan">
                  <label>Jabatan</label>
                  <div><?= check_var($data, 'jenjang_jabatan', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_kode_didik" attr-data="kode_didik">
                  <label>Pendidikan</label>
                  <div><?= check_var($data, 'kode_didik', '-') . ' / ' . check_var($data, 'pendidikan', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_alamat_saat_ini" attr-data="alamat_saat_ini">
                  <label>Alamat Saat Ini</label>
                  <div><?= check_var($data, 'alamat_saat_ini', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_nuptr" attr-data="nuptr">
                  <label>NUPTR</label>
                  <div><?= check_var($data, 'nuptr', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_nurs" attr-data="nurs">
                  <label>NURS</label>
                  <div><?= check_var($data, 'nurs', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_nrg" attr-data="nrg">
                  <label>NRG</label>
                  <div><?= check_var($data, 'nrg', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_no_sertifikat_pendidik" attr-data="no_sertifikat_pendidik">
                  <label>No. Sertifikat Pendidik</label>
                  <div><?= check_var($data, 'no_sertifikat_pendidik', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_no_sertifikat_crs" attr-data="no_sertifikat_crs">
                  <label>No. Sertifikat GP</label>
                  <div><?= check_var($data, 'no_sertifikat_gp', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_no_sertifikat_crs" attr-data="no_sertifikat_crs">
                  <label>No. Sertifikat CRS</label>
                  <div><?= check_var($data, 'no_sertifikat_crs', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_no_rek_bank" attr-data="no_rek_bank">
                  <label>No. Rekening Bank</label>
                  <div><?= check_var($data, 'no_rek_bank', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_nama_rek_bank" attr-data="nama_rek_bank">
                  <label>Nama Rekening Bank</label>
                  <div><?= check_var($data, 'nama_rek_bank', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_nama_bank" attr-data="nama_bank">
                  <label>Nama Bank</label>
                  <div><?= check_var($data, 'nama_bank', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_npwp" attr-data="npwp">
                  <label>NPWP</label>
                  <div><?= check_var($data, 'npwp', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <?php
                $mttpi = (check_var($data, 'menerima_ttp_insentif', '-'));
                if ($mttpi == 'Y') {
                  $mttpi = 'Menerima';
                } elseif ($mttpi == 'N') {
                  $mttpi = 'Tidak Menerima';
                }
                ?>
                <div class="desc_block old_data old_menerima_ttp_insentif" attr-data="menerima_ttp_insentif">
                  <label>Menerima TTP Insentif</label>
                  <div><?= $mttpi ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_email" attr-data="email">
                  <label>E-mail</label>
                  <div><?= check_var($data, 'email', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_no_hp" attr-data="no_hp">
                  <label>No. HP</label>
                  <div><?= check_var($data, 'no_hp', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_periode_ke" attr-data="periode_ke">
                  <label>Periode Ke</label>
                  <div><?= check_var($data, 'periode_ke', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_no_sk_kepsek" attr-data="no_sk_kepsek">
                  <label>No. SK Kepala Sekolah</label>
                  <div><?= check_var($data, 'no_sk_kepsek', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_tgl_sk_kepsek" attr-data="tgl_sk_kepsek">
                  <label>Tgl. SK Kepala Sekolah</label>
                  <?php
                  $tgl_sk_kepsek = em_date('j F Y', 'set', check_var($data, 'tgl_sk_kepsek', ''));
                  ?>
                  <div><?= check_var($tgl_sk_kepsek, null, '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_nama_ttd_sk_kepsek" attr-data="nama_ttd_sk_kepsek">
                  <label>Penandatangan SK Kepala Sekolah</label>
                  <div><?= check_var($data, 'nama_ttd_sk_kepsek', '-') ?></div>
                </div>
              </div>

              <div class="col-12">
                <div class="desc_block old_data old_masa_penugasan_mulai" attr-data="masa_penugasan_mulai">
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
                <div class="desc_block old_data old_masa_penugasan_selesai" attr-data="masa_penugasan_selesai">
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

              <div class="col-12">
                <div class="desc_block old_data old_s_aktif" attr-data="s_aktif">
                  <label>Status Riwayat</label>
                  <div>
                    <?php
                    $s_aktif = check_var($data, 's_aktif', '-');
                    if ($s_aktif == '1') $s_aktif = 'Riwayat Terbaru (Aktif)';
                    if ($s_aktif == '0') $s_aktif = 'Bukan Riwayat Terbaru (Non-Aktif)';
                    echo $s_aktif;
                    ?>
                  </div>
                </div>
              </div>
            <?php
            } else {
              // kalau tidak ada tampilkan pesan
            ?>
              <div class="col-12">
                <div class="desc_block text-center">Belum ada data profil yang terverifikasi.</div>
              </div>
            <?php
            }
            ?>

          </div>

        </div>
      </div>


    </div>

    <?php
    /// |----------------------------------------------------------------------
    /// | >> DATA BARU
    /// |----------------------------------------------------------------------
    ?>
    <div class="col-12 col-lg-6">

      <div id="new_card" class="card">
        <div class="card-body">
          <h4 class="card-title space-between mb-3">
            <div><i class="fas fa-building me-2"></i>Profil Kepala Sekolah (Baru)</div>
            <div></div>
          </h4>

          <div class="row g-2">

            <div class="col-12">
              <div class="desc_block new_data new_ket_ukerja" attr-data="ket_ukerja">
                <label>Sekolah / Unit Kerja</label>
                <div><?= check_var($dokumen, 'ket_ukerja', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_nip" attr-data="nip">
                <label>NIP</label>
                <div><?= check_var($dokumen, 'nip', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_ket_status" attr-data="ket_status">
                <label>Status</label>
                <div><?= check_var($dokumen, 'ket_status', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_gelar_dpn" attr-data="gelar_dpn">
                <label>Gelar Depan</label>
                <div><?= check_var($dokumen, 'gelar_dpn', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_nama" attr-data="nama">
                <label>Nama</label>
                <div><?= check_var($dokumen, 'nama', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_gelar_blk" attr-data="gelar_blk">
                <label>Gelar Belakang</label>
                <div><?= check_var($dokumen, 'gelar_blk', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_nik" attr-data="nik">
                <label>NIK</label>
                <div><?= check_var($dokumen, 'nik', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_tgl_lahir" attr-data="tgl_lahir">
                <label>Tgl. Lahir</label>
                <div><?= em_date('j F Y', 'set', check_var($dokumen, 'tgl_lahir', '')) ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_jenis_kelamin" attr-data="jenis_kelamin">
                <label>Jenis Kelamin</label>
                <div>
                  <?php
                  $jkelamin = check_var($dokumen, 'jenis_kelamin', '');
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
              <div class="desc_block new_data new_ket_agama" attr-data="ket_agama">
                <label>Agama</label>
                <div><?= check_var($dokumen, 'ket_agama', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_status_pernikahan" attr-data="status_pernikahan">
                <label>Status Pernikahan</label>
                <div><?= check_var($dokumen, 'ket_status_pernikahan', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_pangkat" attr-data="pangkat">
                <label>Pangkat / Gol. Ruang</label>
                <div><?= check_var($dokumen, 'pangkat', '-') . ' / ' . check_var($dokumen, 'gol_ruang', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_jenjang_jabatan" attr-data="jenjang_jabatan">
                <label>Jabatan</label>
                <div><?= check_var($dokumen, 'jenjang_jabatan', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_kode_didik" attr-data="kode_didik">
                <label>Pendidikan</label>
                <div><?= check_var($dokumen, 'kode_didik', '-') . ' / ' . check_var($dokumen, 'pendidikan', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_alamat_saat_ini" attr-data="alamat_saat_ini">
                <label>Alamat Saat Ini</label>
                <div><?= check_var($dokumen, 'alamat_saat_ini', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_nuptr" attr-data="nuptr">
                <label>NUPTR</label>
                <div><?= check_var($dokumen, 'nuptr', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_nurs" attr-data="nurs">
                <label>NURS</label>
                <div><?= check_var($dokumen, 'nurs', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_nrg" attr-data="nrg">
                <label>NRG</label>
                <div><?= check_var($dokumen, 'nrg', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_no_sertifikat_pendidik" attr-data="no_sertifikat_pendidik">
                <label>No. Sertifikat Pendidik</label>
                <div><?= check_var($dokumen, 'no_sertifikat_pendidik', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_no_sertifikat_crs" attr-data="no_sertifikat_crs">
                <label>No. Sertifikat GP</label>
                <div><?= check_var($dokumen, 'no_sertifikat_gp', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_no_sertifikat_crs" attr-data="no_sertifikat_crs">
                <label>No. Sertifikat CRS</label>
                <div><?= check_var($dokumen, 'no_sertifikat_crs', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_no_rek_bank" attr-data="no_rek_bank">
                <label>No. Rekening Bank</label>
                <div><?= check_var($dokumen, 'no_rek_bank', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_nama_rek_bank" attr-data="nama_rek_bank">
                <label>Nama Rekening Bank</label>
                <div><?= check_var($dokumen, 'nama_rek_bank', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_nama_bank" attr-data="nama_bank">
                <label>Nama Bank</label>
                <div><?= check_var($dokumen, 'nama_bank', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_npwp" attr-data="npwp">
                <label>NPWP</label>
                <div><?= check_var($dokumen, 'npwp', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <?php
              $mttpi = (check_var($dokumen, 'menerima_ttp_insentif', '-'));
              if ($mttpi == 'Y') {
                $mttpi = 'Menerima';
              } elseif ($mttpi == 'N') {
                $mttpi = 'Tidak Menerima';
              }
              ?>
              <div class="desc_block new_data new_menerima_ttp_insentif" attr-data="menerima_ttp_insentif">
                <label>Menerima TTP Insentif</label>
                <div><?= $mttpi ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_email" attr-data="email">
                <label>E-mail</label>
                <div><?= check_var($dokumen, 'email', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_no_hp" attr-data="no_hp">
                <label>No. HP</label>
                <div><?= check_var($dokumen, 'no_hp', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_periode_ke" attr-data="periode_ke">
                <label>Periode Ke</label>
                <div><?= check_var($dokumen, 'periode_ke', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_no_sk_kepsek" attr-data="no_sk_kepsek">
                <label>No. SK Kepala Sekolah</label>
                <div><?= check_var($dokumen, 'no_sk_kepsek', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_tgl_sk_kepsek" attr-data="tgl_sk_kepsek">
                <label>Tgl. SK Kepala Sekolah</label>
                <?php
                $tgl_sk_kepsek = em_date('j F Y', 'set', check_var($dokumen, 'tgl_sk_kepsek', ''));
                ?>
                <div><?= check_var($tgl_sk_kepsek, null, '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data nama_ttd_sk_kepsek" attr-data="nama_ttd_sk_kepsek">
                <label>Penandatangan SK Kepala Sekolah</label>
                <div><?= check_var($dokumen, 'nama_ttd_sk_kepsek', '-') ?></div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_masa_penugasan_mulai" attr-data="masa_penugasan_mulai">
                <label>Masa / Tgl. Penugasan (Mulai)</label>
                <div>
                  <?php
                  $mp_mulai = check_var($dokumen, 'masa_penugasan_mulai', '');
                  $mp_text = check_var(em_date('j F Y', 'set', $mp_mulai), null, '-');
                  echo $mp_text;
                  ?>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_masa_penugasan_selesai" attr-data="masa_penugasan_selesai">
                <label>Masa / Tgl. Penugasan (Selesai)</label>
                <div>
                  <?php
                  $mp_selesai = check_var($dokumen, 'masa_penugasan_selesai', '');
                  $mp_text = check_var(em_date('j F Y', 'set', $mp_selesai), null, '-');
                  echo $mp_text;
                  ?>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="desc_block new_data new_s_aktif" attr-data="s_aktif">
                <label>Status Riwayat</label>
                <div>
                  <?php
                  $s_aktif = check_var($dokumen, 's_aktif', '-');
                  if ($s_aktif == '1') $s_aktif = 'Riwayat Terbaru (Aktif)';
                  if ($s_aktif == '0') $s_aktif = 'Bukan Riwayat Terbaru (Non-Aktif)';
                  echo $s_aktif;
                  ?>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>


    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="card-title space-between">
            <div>Form Verifikasi</div>
          </div>

          <form id="form_verifikasi" action="<?= site_url('pdt_verif_profil_kepsek/do_verif') ?>" method="POST">
            <input type="hidden" name="id_dokumen" id="id_dokumen" value="<?= check_var($dokumen, 'id_dokumen', '') ?>">

            <div class="row g-2">

              <div class="col-12">
                <div class="input_block">
                  <label for="tindak_lanjut">Tindak Lanjut</label>
                  <select name="tindak_lanjut" id="tindak_lanjut" class="form-select">
                    <option value="" default hidden>- Pilih Tindak Lanjut -</option>
                    <option value="setuju">Setuju</option>
                    <option value="tolak">Tolak</option>
                  </select>
                  <div class="invalid-feedback" id="error_tindak_lanjut"></div>
                </div>
              </div>

              <div id="container_alasan" class="col-12 d-none">
                <div class="input_block">
                  <label for="alasan">Alasan / Pesan</label>
                  <textarea name="alasan" id="alasan" class="form-control" rows="4" placeholder="Silahkan isi pesan / alasan terkait tindak lanjut yang dipilih"></textarea>
                  <div class="invalid-feedback" id="error_alasan"></div>
                </div>
              </div>

              <div class="col-12 text-end">
                <button type="submit" class="btn btn-success form_action_button ms-2"><i class="fas fa-check-square me-1"></i>Verifikasi</button>
              </div>

            </div>
          </form>

        </div>
      </div>
    </div>

  </div>

</div>

<script>
  function match_old_new_height() {
    $('.old_data').each(function() {
      const $old = $(this);
      const attr = $old.attr('attr-data');
      const $new = $('.new_data[attr-data="' + attr + '"]');

      if ($new.length) {
        // Reset heights first
        $old.css('min-height', '');
        $new.css('min-height', '');

        const oldHeight = $old.outerHeight();
        const newHeight = $new.outerHeight();
        const maxHeight = Math.max(oldHeight, newHeight);

        $old.css('min-height', maxHeight);
        $new.css('min-height', maxHeight);
      }
    });
  }

  /// |----------------------------------------
  /// | DOCUMENT READY
  /// |----------------------------------------
  $(document).ready(function() {
    /// |----------------------------------------
    /// | FORM SUBMISSION
    /// |----------------------------------------
    $('#form_verifikasi').validate($.extend({
      submitHandler: function(form, event) {
        // declare element that will be affected
        // by every state of the form submission
        // right here
        let submit = $('.form_action_button');

        // declare button submit disabling right here if needed
        submit.attr('disabled', true);

        $(form).ajaxSubmit({
          success: function(e) {
            if (e.status) {
              // what to do when the response status = true
              show_notify('success', e.message);
              setTimeout(() => {
                window.location.href = '<?= site_url('pdt_verif_profil_kepsek') ?>/detail/<?= $dokumen['id_dokumen'] ?>';
              }, 2000);
            } else {
              // what to do when the response status = false
              show_notify('error', e.message);
              submit.attr('disabled', false);

              // reset error
              $('#form_verifikasi .is-invalid').removeClass('is-invalid');
              $('#form_verifikasi .invalid-feedback').html('');

              if (e.error_value) {
                $.each(e.error_value, function(field, error) {
                  const el_input = $('#' + field);
                  const wrapper = el_input.closest('.input_block');
                  const el_flatpickrInput = wrapper.find('.flatpickr');
                  const el_select2Input = wrapper.find('.select2-selection');
                  const el_select2Container = wrapper.find('.select2.select2-container');

                  el_input.addClass('is-invalid');
                  if (el_select2Input.length) {
                    el_select2Container.addClass('is-invalid');
                    el_select2Input.addClass('is-invalid');
                  } else if (el_flatpickrInput.length) {
                    el_flatpickrInput.addClass('is-invalid');
                  }

                  $('#error_' + field).html(error); // Display message
                });
              }
            }
          },
          error: function(xhr, status, error) {
            show_notify('error', xhr.status + ' : ' + error);
            console.error(error);
            submit.attr('disabled', false);
          },
          dataType: 'json'
        });
      },
      rules: {
        // nuptr: {
        //   required: true
        // },
      },
      errorClass: 'is-invalid',
      validClass: 'mv-valid',
      /* if there's select2 element, please use this errorPlacement */
      errorPlacement: function(error, element) {
        const feedback = element.closest('.form-floating').find('.invalid-feedback');
        if (feedback.length) {
          feedback.text(error.text());
        }
      },
      highlight: function(element) {
        $(element).addClass('is-invalid');
      },

      unhighlight: function(element) {
        const $el = $(element);
        const closest = $el.closest('.input_block');
        closest.find('.is-invalid').removeClass('is-invalid');
        $('#error_' + $el.attr('id')).html('');
      },
      messages: {
        // NUPTR: {
        //   required: "Username tidak boleh kosong!",
        // },
        // password: {
        //   required: "Password tidak boleh kosong!",
        //   minlength: "Password minimal 6 karakter!"
        // }
      },
    }));

    /// |----------------------------------------
    /// | TINDAK LANJUT LISTENER
    /// |----------------------------------------
    $('#tindak_lanjut').on('change', function(e) {
      if ($(this).val() == 'tolak') {
        $('#container_alasan').removeClass('d-none');
      } else {
        $('#container_alasan').addClass('d-none');
      }
    });

    // match height between parameter
    match_old_new_height();

    /// |----------------------------------------
    /// | CHECK DATA OR CHANGED DATA
    /// |----------------------------------------
    <?php
    if (check_var($data)) {
      // KALAU DATA AWAL ADA, LAKUKAN PERBANDINGAN
      $new_change = get_changed_data($data, $dokumen);
      if (check_var($new_change, 'after')) {
        // kalau ada data yang beda, lakukan penambahan class ke desc_block nya
        foreach ($new_change['after'] as $key => $value) {
          echo "$('.new_{$key}').addClass('new_change');";
        }
      }
    } else {
      // KALAU DATA AWAL TIDAK ADA, MARK SEMUA NEW SEBAGAI CHANGED
    ?>
      $('.new_data').addClass('new_change');
      var old_card = $('#old_card');
      var new_card = $('#new_card');
      old_card.css('min-height', '');
      new_card.css('min-height', '');

      const oldCardHeight = old_card.outerHeight();
      const newCardHeight = new_card.outerHeight();
      const maxCardHeight = Math.max(oldCardHeight, newCardHeight);

      old_card.css('min-height', maxCardHeight);
      new_card.css('min-height', maxCardHeight);
    <?php
    }
    ?>
  });
</script>