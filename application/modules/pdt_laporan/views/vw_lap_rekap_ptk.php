<style>
    .highlight {
        background-color: yellow !important;
        font-weight: bold !important;
    }

    .table-container {
        overflow-x: scroll !important;
        width: 100% !important;
    }
</style>


<div class="row page-titles">
    <div class="col-md-4 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Laporan Rekap PTK</h3>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="<?= site_url('pangkalan_data'); ?>">Pangkalan Data</a>
            </li>
            <li class="breadcrumb-item active">Laporan</li>
            <li class="breadcrumb-item active">Laporan Rekap PTK</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h3>Rekap PTK</h3>
                        <small>Rekapitulasi ptk</small>
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
                                <.?php $selected=($data["tempat_tugas"] !="" ) ? "selected" : "" ; ?>
                                    <option value="<.?php echo $data[" tempat_tugas"]; ?>" <.?php echo $selected ?>><.?php echo $data["tempat_tugas"]; ?>
                                    </option>
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
                        <a class="btn btn-info" href="<?= site_url("pdt_laporan/cetak_rekap_ptk"); ?>"><i
                                class="fas fa-file"></i> Cetak </a>
                    </div>

                    <div class="table-responsive mt-4 table-container">
                        <div class="_loading loading_tabel_tahun_ajaran">
                            <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
                        </div>

                        <table id="table_ptk" class="table table-bordered fs-3">
                            <thead class="bg-info text-white">
                                <tr class="text-center">
                                    <th class="vam text-center" style="min-width: 30px;" rowspan="3">No</th>
                                    <th class="vam text-center" style="min-width: 30px;" rowspan="3">Keterangan</th>
                                    <th class="vam text-center" style="min-width: 150px;" colspan="6">Tenaga
                                        Kependidikan</th>
                                    <th class="vam text-center" style="min-width: 20px;" colspan="3" rowspan="2">Jumlah
                                        Tenaga Kependidikan</th>
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
                                    <td rowspan="7">1</td>
                                    <td class="highlight" colspan="10">DAPODIK</td>
                                </tr>
                                <tr>
                                    <td colspan="10" class="fw-bold">Terdata/Masuk</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Pendidik/Guru</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold"><?= (string) $data['data_tenaga_pendidik_pns']; ?>
                                    </td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold"><?= (string) $data['data_tenaga_pendidik_pppk']; ?>
                                    </td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">
                                        <?= (string) ($data['data_tenaga_pendidik_pns'] + $data['data_tenaga_pendidik_pppk']); ?>
                                    </td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold"><?= (string) $data['data_tenaga_pendidik_negeri']; ?></td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold"><?= (string) $data['data_tenaga_pendidik_swasta']; ?></td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">
                                        <?= (string) ($data['data_tenaga_pendidik_negeri'] + $data['data_tenaga_pendidik_swasta']); ?>
                                    </td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">
                                        <?= (string) ($data['data_tenaga_pendidik_pns'] + $data['data_tenaga_pendidik_pppk']); ?>
                                    </td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">
                                        <?= (string) ($data['data_tenaga_pendidik_negeri'] + $data['data_tenaga_pendidik_swasta']); ?>
                                    </td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold"><?= (string) ($data['total_data_pendidik']); ?></td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Kependidikan</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">
                                        <?= (string) $data['data_tenaga_kependidikan_pns']; ?></td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">
                                        <?= (string) $data['data_tenaga_kependidikan_pppk']; ?></td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">
                                        <?= (string) ($data['data_tenaga_kependidikan_pns'] + $data['data_tenaga_kependidikan_pppk']); ?>
                                    </td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold"><?= (string) $data['data_tenaga_kependidikan_negeri']; ?>
                                    </td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold"><?= (string) $data['data_tenaga_kependidikan_swasta']; ?>
                                    </td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">
                                        <?= (string) ($data['data_tenaga_kependidikan_negeri'] + $data['data_tenaga_kependidikan_swasta']); ?>
                                    </td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">
                                        <?= (string) ($data['data_tenaga_kependidikan_pns'] + $data['data_tenaga_kependidikan_pppk']); ?>
                                    </td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">
                                        <?= (string) ($data['data_tenaga_kependidikan_negeri'] + $data['data_tenaga_kependidikan_swasta']); ?>
                                    </td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold"><?= (string) ($data['total_data_kependidikan']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="10" class="fw-bold">Belum Terdata/Masuk</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Pendidik/Guru</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Kependidikan</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td rowspan="10">2</td>
                                    <td class="highlight" colspan="10">TUNJANGAN DAERAH</td>
                                </tr>
                                <tr>
                                    <td colspan="10" class="fw-bold">Terima TPP</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Pendidik/Guru</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Kependidikan</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td colspan="10" class="fw-bold">Terima Insentif</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Pendidik/Guru</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Kependidikan</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td colspan="10" class="fw-bold">Belum Terima</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Pendidik/Guru</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Kependidikan</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td rowspan="19">3</td>
                                    <td class="highlight" colspan="10">SUMBER GAJI NON ASN</td>
                                </tr>
                                <tr>
                                    <td colspan="10" class="fw-bold">APBD (PTT-A)</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Pendidik/Guru</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Kependidikan</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td colspan="10" class="fw-bold">APBD (PTT-B)</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Pendidik/Guru</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Kependidikan</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td colspan="10" class="fw-bold">BOSP (BOSNAS)</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Pendidik/Guru</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Kependidikan</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td colspan="10" class="fw-bold">BOSDA</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Pendidik/Guru</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Kependidikan</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td colspan="10" class="fw-bold">Yayasan</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Pendidik/Guru</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Kependidikan</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td colspan="10" class="fw-bold">Sumber Lain</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Pendidik/Guru</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td><span class="ms-3">Tenaga Kependidikan</span></td>
                                    <!-- CPNS_PNS -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- PPPK -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Negeri -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Swasta -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Jumlah Non-ASN -->
                                    <td class="text-center fw-bold">-</td>
                                    <!-- Total (ASN + Non-ASN) -->
                                    <td class="text-center fw-bold">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>