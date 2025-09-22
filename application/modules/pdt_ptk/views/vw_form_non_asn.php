<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Pendidik dan Tenaga Kependidikan</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Home</a>
      </li>
      <li class="breadcrumb-item active">PTK</li>
    </ol>
  </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- -------------------------------------------------------------- -->
<!-- Container fluid  -->
<!-- -------------------------------------------------------------- -->
<div class="container-fluid">
  <!-- -------------------------------------------------------------- -->
  <!-- Start Page Content -->
  <!-- -------------------------------------------------------------- -->
  <!-- basic table -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Form Pendidik dan Tenaga Kependidikan NON-ASN</h4>
          <form action="<?= site_url("pdt_ptk/save"); ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-12 col-lg-4 col-sm-12" style="margin-bottom:15px">
                <!-- Photo Section -->
                <img style="min-width:80px;width:100%"  src="<?= "http://36.66.236.83/simpeg/foto/" . $nip . ".jpg?" . time(); ?>"  alt="">
              </div>
              <div class="col-12 col-lg-8 col-sm-12">
              <!-- Form Section -->
                  <div class="row">
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">NIP</label>
                      <input type="text" class="form-control" name="nip" id="nip" value="<?= $data_gtk["nip"]; ?>" placeholder="NIP / NI PPPK" readonly="true">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="nik">NIK</label>
                      <input type="text" class="form-control" name="nik" id="nik" value="<?= $data_gtk["nik"]; ?>" placeholder="Isi dengan N.I.K">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="nama_lengkap">Nama Lengkap</label>
                      <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="<?= $data_gtk["nama_lengkap"]; ?>" placeholder="Nama Lengkap" readonly="true">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="ket_jab">Jabatan</label>
                      <input type="text" class="form-control" name="ket_jab" id="ket_jab"  value="<?= $data_gtk["ket_jab"]; ?>" placeholder="Nama Jabatan" readonly="true">
                      <input type="hidden" name="kode_jab" value="<?= $data_gtk["kode_jab"]; ?>">
                      <input type="hidden" name="kode_ukerja" value="<?= $data_gtk["kode_ukerja"]; ?>">
                    </div>
                    <div class="col-12 col-lg-3 col-sm-12" style="margin-top:15px;">
                      <label for="tmp_lahir">Tempat</label>
                      <input type="text" class="form-control" name="tmp_lahir" id="tmp_lahir" value="<?= $data_gtk["tmp_lahir"]; ?>" placeholder="Tempat Lahir" readonly="true">
                    </div>
                    <div class="col-12 col-lg-3 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Tanggal Lahir</label>
                      <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" value="<?= $data_gtk["tgl_lahir"]; ?>" placeholder="Tanggal Lahir format: YYYY-mm-dd contoh 2025-06-05" readonly="true">
                    </div>
                    <div class="col-12 col-lg-3 col-sm-12" style="margin-top:15px;">
                      <label for="j_kelamin">Jenis Kelamin</label>
                      <select name="j_kelamin" id="j_kelamin" class="form-control" >
                        <option value="L" <?= ($data_gtk["j_kelamin"] == "L") ? "selected" : ""; ?>>Laki-laki</option>
                        <option value="P" <?= ($data_gtk["j_kelamin"] == "P") ? "selected" : ""; ?>>Perempuan</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-3 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Status Pernikahan</label>
                      <select name="kode_kawin" id="kode_kawin" class="form-control">
                        <option value="1" <?= ($data_gtk["kode_kawin"] == "1") ? "selected" : ""; ?>>Lajang</option>
                        <option value="2" <?= ($data_gtk["kode_kawin"] == "2") ? "selected" : ""; ?>>Kawin</option>
                        <option value="3" <?= ($data_gtk["kode_kawin"] == "3") ? "selected" : ""; ?>>Janda</option>
                        <option value="4" <?= ($data_gtk["kode_kawin"] == "4") ? "selected" : ""; ?>>Duda</option>
                      </select>
                    </div>
                    <div class="col-6 col-lg-3 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">TMT Jabatan</label>
                      <input type="date" name="tmt_jab" id="tmt_jab" class="form-control"  placeholder="T.M.T" value="<?= $data_gtk["tmt_jab"]; ?>">
                    </div>
                    <div class="col-6 col-lg-3 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Status CPNS/PNS</label>
                      <select name="status_cpns" id="status_cpns" class="form-control">
                        <option value="1" <?= ($data_gtk["status_cpns"] == "1") ? "selected" : ""; ?>>CPNS</option>
                        <option value="2" <?= ($data_gtk["status_cpns"] == "2") ? "selected" : ""; ?>>PNS</option>
                        <option value="3" <?= ($data_gtk["status_cpns"] == "3") ? "selected" : ""; ?>>PPPK</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-3 col-sm-12" style="margin-top:15px;">
                      <label for="kode_gol">Pangkat/Golongan</label>
                      <select name="kode_gol" id="kode_gol" class="form-control">
                        <?php
                        $list_gol = $this->db->get("m_gol")->result_array();
                        foreach ($list_gol as $key => $value) {
                          if($value["kode_gol"] == $data_gtk["kode_gol"]){
                            $selected = "selected"; 
                          }else{
                            $selected = "";
                          }
                          echo '<option value="'.$value["kode_gol"].'" '.$selected.'>'.$value["ket_gol"].' '.$value["nama_gol"].'</option>';
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-12 col-lg-3 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Jenjang JF Guru</label>
                      <select name="jenjang_jf" id="jenjang_jf" class="form-control">
                        <option value="Guru Ahli Pertama" <?= ($data_gtk["jenjang_jf"] == "Guru Ahli Pertama") ? "selected" : ""; ?>>Guru Ahli Pertama</option>
                        <option value="Guru Ahli Muda" <?= ($data_gtk["jenjang_jf"] == "Guru Ahli Muda") ? "selected" : ""; ?>>Guru Ahli Muda</option>
                        <option value="Guru Ahli Madya" <?= ($data_gtk["jenjang_jf"] == "Guru Ahli Madya") ? "selected" : ""; ?>>Guru Ahli Madya</option>
                        <option value="Guru Ahli Utama" <?= ($data_gtk["jenjang_jf"] == "Guru Ahli Utama") ? "selected" : ""; ?>>Guru Ahli Utama</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-3 col-sm-12" style="margin-top:15px;">
                      <label for="status_gtk">Status GTK</label>
                      <select name="status_gtk" id="status_gtk" class="form-control">
                        <option value="Pendidik Guru" <?= ($data_gtk["status_gtk"] == "Pendidik Guru") ? "selected" : ""; ?>>Pendidik Guru</option>
                        <option value="Tendik Staf" <?= ($data_gtk["status_gtk"] == "Tendik Staf") ? "selected" : ""; ?>>Tendik Staf</option>
                        <option value="Non GTK" <?= ($data_gtk["status_gtk"] == "Non GTK") ? "selected" : ""; ?>>Non GTK</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-3 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Jenis PTK</label>
                      <select name="jenis_ptk" id="jenis_ptk" class="form-control">
                        <option value="Guru Kelas" <?= ($data_gtk["jenis_ptk"] == "Guru Kelas") ? "selected" : ""; ?>>Guru Kelas</option>
                        <option value="Guru Mapel" <?= ($data_gtk["jenis_ptk"] == "Guru Mapel") ? "selected" : ""; ?>>Guru Mapel</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-3 col-sm-" style="margin-top:15px;">
                      <label for="NIP">Keterangan (PTK)</label>
                      <input type="text" name="keterangan_ptk" id="keterangan_ptk" class="form-control"  placeholder="Keterangan MAPEL">
                    </div>
                    <div class="col-12 col-lg-3 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Pembimbing PDPD</label>
                      <select name="pembimbing_pdpd" id="pembimbing_pdpd" class="form-control">
                        <option value="YA" <?= ($data_gtk["pembimbing_pdpd"] == "YA") ? "selected" : ""; ?>>YA</option>
                        <option value="TIDAK" <?= ($data_gtk["pembimbing_pdpd"] == "TIDAK") ? "selected" : ""; ?>>TIDAK</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Agama</label>
                      <select name="kode_agama" id="kode_agama" class="form-control">
                        <option <?= ($data_gtk["kode_agama"] == "1") ? "selected" : ""; ?> value="1">Islam</option>
                        <option <?= ($data_gtk["kode_agama"] == "2") ? "selected" : ""; ?> value="2">Kristen</option>
                        <option <?= ($data_gtk["kode_agama"] == "3") ? "selected" : ""; ?> value="3">Katholik</option>
                        <option <?= ($data_gtk["kode_agama"] == "4") ? "selected" : ""; ?> value="4">Hindu</option>
                        <option <?= ($data_gtk["kode_agama"] == "5") ? "selected" : ""; ?> value="5">Buddha</option>
                        <option <?= ($data_gtk["kode_agama"] == "6") ? "selected" : ""; ?> value="6">Kepercayaan</option>
                        <option <?= ($data_gtk["kode_agama"] == "7") ? "selected" : ""; ?> value="7">-</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">NUPTK</label>
                      <input type="text" name="nuptk" id="nuptk" placeholder="Isi dengan NUPTK" class="form-control" value="<?= $data_gtk["nuptk"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">NUKS</label>
                      <input type="text" name="nuks" id="nuks" class="form-control" placeholder="Isi dengan NUKS" value="<?= $data_gtk["nuks"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">NRG</label>
                      <input type="text" name="nrg" id="nrg" placeholder="Isi dengan NRG"class="form-control" value="<?= $data_gtk["nrg"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">No Sertifikat Pendidik</label>
                      <input type="text" name="no_serdik" id="no_serdik" class="form-control" placeholder="Isi dengan No Serdik" value="<?= $data_gtk["no_serdik"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">No Sertifikat Guru Penggerak</label>
                      <input type="text" name="no_sergp" id="no_sergp" class="form-control" placeholder="Isi dengan sertifikat guru penggerak" value="<?= $data_gtk["no_sergp"]; ?>">
                    </div>
                    <div class="col-12 col-lg-12 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">No Sertifikat Guru Calon Kepala Sekolah</label>
                      <input type="text" name="no_crs" id="no_crs" class="form-control" value="<?= $data_gtk["no_crs"]; ?>">
                    </div>
                    <div class="col-12 col-lg-12 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Alamat (Domisili)</label>
                      <textarea name="alamat" id="alamat" class="form-control" style="-webkit-box-sizing: border-box;
                             -moz-box-sizing: border-box;
                              box-sizing: border-box;" rows="5"><?= $data_gtk["alamat"]; ?></textarea>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Pendidikan</label>
                      <input type="text" name="pendidikan" id="pendidikan" value="<?= $data_gtk["pendidikan"]; ?>" class="form-control" placeholder="Isi dengan Pendidikan Terakhir">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Prodi</label>
                      <input type="text" name="prodi" id="prodi" class="form-control" value="<?= $data_gtk["prodi"]; ?>" placeholder="Isi dengan nama Prodi Pendidikan">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Tunjangan Pusat</label>
                      <select name="tunjangan_pusat" id="tunjangan_pusat" class="form-control">

                      </select>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Tunjangan Pemkot</label>
                      <select name="tunjangan_pemkot" id="tunjangan_pemkot" class="form-control">

                      </select>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">No Rek Bank</label>
                      <input type="text" name="no_rek_bank" id="no_rek_bank" class="form-control" value="<?= $data_gtk["no_rek_bank"]; ?>" placeholder="Isi dengan No Rekening BANK">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Nama Rek Bank</label>
                      <input type="text" name="nama_rek_bank" id="nama_rek_bank" class="form-control" value="<?= $data_gtk["nama_rek_bank"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Nama Bank</label>
                      <input type="text" name="nama_bank" id="nama_bank" class="form-control" value="<?= $data_gtk["nama_bank"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;" >
                      <label for="NIP">NPWP</label>
                      <input type="text" name="npwp" id="npwp" class="form-control" value="<?= $data_gtk["npwp"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Dapodik</label>
                      <select name="dapodik" id="dapodik" class="form-control">
                        <option value="Terdata">Terdata</option>
                        <option value="Belum">Belum</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">TMT Dapodik</label>
                      <input type="date" name="tmt_masuk_dapodik" id="tmt_masuk_dapodik" class="form-control" value="<?= $data_gtk["tmt_masuk_dapodik"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">TMT Awal Honorer (Khusus NON ASN)</label>
                     <input type="date" name="tmt_awal_honorer" id="tmt_awal_honorer" value="<?= $data_gtk["tmt_awal_honorer"]; ?>" class="form-control">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Sumber Gaji (Khusus Non ASN)</label>
                      <select class="form-control" name="sumber_gaji" id="sumber_gaji">
                        <option <?= ($data_gtk["kode_agama"] == "1") ? "selected" : ""; ?> value="PTT-B">APBD (PTT-B)</option>
                        <option <?= ($data_gtk["kode_agama"] == "1") ? "selected" : ""; ?> value="PTT-A">APBD (PTT-A)</option>
                        <option <?= ($data_gtk["kode_agama"] == "1") ? "selected" : ""; ?> value="BOSP">BOSP(BOSNAS)</option>
                        <option <?= ($data_gtk["kode_agama"] == "1") ? "selected" : ""; ?> value="BOSDA">BOSDA(BOSDA)</option>
                        <option <?= ($data_gtk["kode_agama"] == "1") ? "selected" : ""; ?> value="YAYASAN">YAYASAN</option>
                        <option <?= ($data_gtk["kode_agama"] == "1") ? "selected" : ""; ?> value="LAIN">SUMBER LAIN</option>
                      </select>
                    </div>
                    <div class="col-5 col-lg-3 col-sm-12" style="margin-top:15px;">
                      <button type="submit" class="form-control btn btn-primary">SIMPAN</button>
                    </div>
                  </div>
                  <div>

                </div>
              </div>
            </div>            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="toast_container"></div>

<!-- -------------------------------------------------------------- -->
<!-- End Container fluid  -->
<!-- -------------------------------------------------------------- -->

<script>
 

 
</script>