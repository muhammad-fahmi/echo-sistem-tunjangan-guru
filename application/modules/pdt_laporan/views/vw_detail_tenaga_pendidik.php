<div class="row page-titles">
    <div class="col-md-4 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Detail Tenaga Pendidik</h3>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="<?= site_url('pangkalan_data'); ?>">Pangkalan Data</a>
            </li>
            <li class="breadcrumb-item active">Laporan</li>
            <li class="breadcrumb-item active">Detail Tenaga Pendidik</li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="text-end p-3">
        <a class="btn btn-info" href="<?= site_url('pdt_laporan/menu_lap_rekap_tenaga_pendidik'); ?>"><i class="fas fa-undo"></i> Kembali </a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="<?= site_url('..\theme\assets\images\background\user1.jpg'); ?>" alt="...">
                </div>
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <td>NIK</td>
                            <td>:</td>
                            <td><?= $data['detail']['nik'] ?></td>
                        </tr>
                        <tr>
                            <td>NIP</td>
                            <td>:</td>
                            <td><?= $data['detail']['nip'] ?></td>
                        </tr>
                        <tr>
                            <td>NUPTK</td>
                            <td>:</td>
                            <td><?= $data['detail']['nuptk'] ?></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><?= $data['detail']['nama'] ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?= ($data['detail']['jenis_kelamin'] == 'P') ? "Perempuan" : "Laki-laki" ?></td>
                        </tr>
                        <tr>
                            <td>Tempat/Tanggal Lahir</td>
                            <td>:</td>
                            <td><?= $data['detail']['tempat_lahir'] . "," . $data['detail']['tanggal_lahir'] ?></td>
                        </tr>
                        <tr>
                            <td>Sekolah</td>
                            <td>:</td>
                            <td><?= $data['detail']['tempat_tugas'] ?></td>
                        </tr>
                        <tr>
                            <td>No.HP</td>
                            <td>:</td>
                            <td><?= $data['detail']['no_hp'] ?></td>
                        </tr>
                        <?php if (str_contains($data['detail']['status_kepegawaian'], 'PNS')): ?>
                            <tr>
                                <td>SK CPNS</td>
                                <td>:</td>
                                <td><?= $data['detail']['sk_cpns'] ?></td>
                            </tr>
                            <tr>
                                <td>TMT CPNS</td>
                                <td>:</td>
                                <td><?= ($data['detail']['tmt_cpns'] != '1900-01-01') ? $data['detail']['tmt_cpns'] : "-" ?></td>
                            </tr>
                        <?php endif; ?>

                        <?php if (str_contains($data['detail']['status_kepegawaian'], 'PNS') || str_contains($data['detail']['status_kepegawaian'], 'PPPK')): ?>
                            <tr>
                                <td>Pangkat</td>
                                <td>:</td>
                                <td><?= ($data['detail']['pangkat'] != "") ? $data['detail']['pangkat'] : "-" ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td>SK Pengangkatan</td>
                            <td>:</td>
                            <td><?= ($data['detail']['sk_pengangkatan'] != "") ? $data['detail']['sk_pengangkatan'] : "-" ?></td>
                        </tr>
                        <tr>
                            <td>TMT Pengangkatan</td>
                            <td>:</td>
                            <td><?= ($data['detail']['tmt_pengangkatan'] != "") ? $data['detail']['tmt_pengangkatan'] : "-" ?></td>
                        </tr>
                        <tr>
                            <td>Jenis PTK</td>
                            <td>:</td>
                            <td><?= ($data['detail']['jenis_ptk'] != "") ? $data['detail']['jenis_ptk'] : "-" ?></td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td><?= ($data['detail']['jabatan_ptk'] != "") ? $data['detail']['jabatan_ptk'] : "-" ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>