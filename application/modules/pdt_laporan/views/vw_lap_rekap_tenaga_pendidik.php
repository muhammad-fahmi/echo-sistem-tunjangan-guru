<style>
  .highlight {
    background-color: yellow !important;
    font-weight: bold !important;
  }
</style>


<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Laporan Rekap Tenaga Pendidik</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="<?= site_url('pangkalan_data'); ?>">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item active">Laporan</li>
      <li class="breadcrumb-item active">Laporan Rekap Tenaga Pendidik</li>
    </ol>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <h3>Rekap Tenaga Pendidik/Guru</h3>
            <small>Rekapitulasi tenaga pendidik/guru</small>
          </div>
        </div>
        <div class="card-body">

          <!-- Unit Kerja -->
          <!-- <div class="row mb-2">
              <div class="col-4 col-lg-3">
                <label for="tempat_tugas">Sekolah</label>
              </div>
              <div class="col-8 col-lg-9">
                <select type="text" name="tempat_tugas" class="form-select form-select" style="width:100%" id="tempat_tugas">
                  <.?php $selected = ($data["tempat_tugas"] != "") ? "selected" : ""; ?>
                  <option value="<.?php echo $data["tempat_tugas"]; ?>" <.?php echo $selected ?>><.?php echo $data["tempat_tugas"]; ?></option>
                </select>
              </div>
            </div> -->

          <!-- Status Instansi -->
          <!-- <div class="row mb-2">
              <div class="col-4 col-lg-3">
                <label for="status_instansi">Status Instansi</label>
              </div>
              <div class="col-8 col-lg-9">
                <select type="text" name="status_instansi" class="form-select form-select" style="width:100%" id="status_instansi">
                  <option value="negeri">Negeri</option>
                  <option value="swasta">Swasta</option>
                </select>
              </div>
            </div> -->

          <div class="modal-footer text-start gap-2">
            <a class="btn btn-info" href="<?= site_url("pdt_laporan/cetak_rekap_tenaga_pendidik"); ?>"><i class="fas fa-file"></i> Cetak </a>
          </div>

          <div class="table-responsive mt-4">
            <div class="_loading loading_tabel_tahun_ajaran">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="table_tenaga_pendidik" class="table table-bordered fs-3" style="width:100%;">
              <thead class="bg-info text-white">
                <tr class="text-center">
                  <th class="vam text-center" style="min-width: 30px;" rowspan="3">No</th>
                  <th class="vam text-center" style="min-width: 30px;" rowspan="3">Keterangan</th>
                  <th class="vam text-center" style="min-width: 150px;" colspan="6">Pendidik/Guru</th>
                  <th class="vam text-center" style="min-width: 20px;" colspan="3" rowspan="2">Jumlah Pendidik/Guru</th>
                </tr>
                <tr>
                  <th class="vam text-center" colspan="3">ASN</th>
                  <th class="vam text-center" colspan="3">NON ASN DI SEKOLAH</th>
                </tr>
                <tr>
                  <th class="vam text-center">CPNS_PNS</th>
                  <th class="vam text-center">PPPK</th>
                  <th class="vam text-center">JUMLAH</th>
                  <th class="vam text-center">Negeri</th>
                  <th class="vam text-center">Swasta</th>
                  <th class="vam text-center">JUMLAH</th>
                  <th class="vam text-center">ASN</th>
                  <th class="vam text-center">NON ASN</th>
                  <th class="vam text-center">JUMLAH</th>
                </tr>
              </thead>

              <tbody style="font-size: 11px;">
                <tr>
                  <td rowspan="3">1</td>
                  <td class="highlight" colspan="10">DAPODIK</td>
                </tr>
                <tr>
                  <td>Terdata/Masuk</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center fw-bold"><?= (string) $data['data_tenaga_pendidik_pns']; ?></td>
                  <!-- PPPK -->
                  <td class="text-center fw-bold"><?= (string) $data['data_tenaga_pendidik_pppk']; ?></td>
                  <!-- Jumlah ASN -->
                  <td class="text-center fw-bold"><?= (string) ($data['data_tenaga_pendidik_pns'] + $data['data_tenaga_pendidik_pppk']); ?></td>
                  <!-- Negeri -->
                  <td class="text-center fw-bold"><?= $data['data_tenaga_pendidik_negeri']; ?></td>
                  <!-- Swasta -->
                  <td class="text-center fw-bold"><?= $data['data_tenaga_pendidik_swasta']; ?></td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center fw-bold"><?= (string) ($data['data_tenaga_pendidik_negeri'] + $data['data_tenaga_pendidik_swasta']); ?></td>
                  <!-- Jumlah ASN -->
                  <td class="text-center fw-bold"><?= (string) ($data['data_tenaga_pendidik_pns'] + $data['data_tenaga_pendidik_pppk']); ?></td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center fw-bold"><?= (string) ($data['data_tenaga_pendidik_negeri'] + $data['data_tenaga_pendidik_swasta']); ?></td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center fw-bold"><?= (string) ($data['total_data']); ?></td>
                </tr>
                <tr>
                  <td>Belum Terdata/Masuk</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td rowspan="5">2</td>
                  <td class="highlight" colspan="10">TUNJANGAN PUSAT</td>
                </tr>
                <tr>
                  <td>Terima TPG</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td>Terima TAMSIL (ASN)</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td>Terima Antun (NON ASN)</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td>Belum Terima</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td rowspan="4">3</td>
                  <td class="highlight" colspan="10">TUNJANGAN DAERAH</td>
                </tr>
                <tr>
                  <td>Terima TPP</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td>Terima Insentif</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td>Belum Terima</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td rowspan="3">4</td>
                  <td class="highlight" colspan="10">PENGANGKATAN JF</td>
                </tr>
                <tr>
                  <td>SUdah Diangkat JF</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td>Belum Diangkat JF</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td rowspan="4">5</td>
                  <td class="highlight" colspan="10">JENJANG JF</td>
                </tr>
                <tr>
                  <td>Jenjang Pertama</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td>Jenjang Muda</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td>Jenjang Madya</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td rowspan="7">6</td>
                  <td class="highlight" colspan="10">PENGGAJIAN NON ASN</td>
                </tr>
                <tr>
                  <td>APBD (PTT-A)</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td>APBD (PTT-B)</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td>BOSP (BOSNAS)</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td>BOSDA</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td>Yayasan</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
                <tr>
                  <td>Sumber Lain</td>
                  <!-- CPNS_PNS -->
                  <td class="text-center">-</td>
                  <!-- PPPK -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Negeri -->
                  <td class="text-center">-</td>
                  <!-- Swasta -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah ASN -->
                  <td class="text-center">-</td>
                  <!-- Jumlah Non-ASN -->
                  <td class="text-center">-</td>
                  <!-- Total (ASN + Non-ASN) -->
                  <td class="text-center">-</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
</script>