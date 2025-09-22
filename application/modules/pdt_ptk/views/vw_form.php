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
          <h4 class="card-title">Form Pendidik dan Tenaga Kependidikan ASN/PPPK</h4>
          <form id="ptk_form" action="<?= site_url("pdt_ptk/save_update_pns_p3k"); ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
              <div class="col-12 col-lg-4 col-sm-12" style="margin-bottom:15px">
                <!-- Photo Section -->
                <img style="min-width:80px;width:100%"  src="<?php 
                $decoded = urldecode("http://36.66.236.83/simpeg/foto/".$data_gtk['nip'].".jpg");
                $clean = preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $decoded);
                echo $clean; ?>"  alt="">
              </div>
              <div class="col-12 col-lg-8 col-sm-12">
              <!-- Form Section -->
                  <div class="row">
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">NIP</label>
                      <input type="text" class="form-control" name="nip" id="nip" value="<?= $data_gtk["nip"]; ?>" placeholder="NIP / NIPPPK" readonly="true">
                      <input type="hidden" id="id_gtk" name="id_gtk" value="<?= $data_gtk["id_gtk"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="nik">NIK</label>
                      <input type="text" class="form-control" name="nik" id="nik" value="<?= $data_gtk["nik"]; ?>" placeholder="Isi dengan N.I.K">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="nama_lengkap">Nama Lengkap</label>
                      <input type="text" class="form-control" name="nama" id="nama" value="<?= $data_gtk["nama"]; ?>" placeholder="Nama Lengkap" readonly="true">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="ket_jab">Jabatan</label>
                      <input type="text" class="form-control" name="jabatan_ptk" id="jabatan_ptk"  value="<?= $data_gtk["jabatan_ptk"]; ?>" placeholder="Nama Jabatan" readonly="true">
                    </div>
                    <div class="col-12 col-lg-12 col-sm-12" style="margin-top:15px;">
                      <label for="ket_jab">Tempat Tugas</label>
                      <input type="text" class="form-control" name="tempat_tugas" id="tempat_tugas"  value="<?= $data_gtk["tempat_tugas"]; ?>" placeholder="Tempat Tugas" readonly="true">
                      <input type="hidden" name="kode_ukerja" value="<?= $data_gtk["kode_ukerja"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="tmp_lahir">Tempat Lahir</label>
                      <input type="text" class="form-control" name="tmp_lahir" id="tmp_lahir" value="<?= $data_gtk["tmp_lahir"]; ?>" placeholder="Tempat Lahir" readonly="true">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Tanggal Lahir</label>
                      <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" value="<?= $data_gtk["tgl_lahir"]; ?>" placeholder="Tanggal Lahir format: YYYY-mm-dd contoh 2025-06-05" readonly="true">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="jns_kelamin">Jenis Kelamin</label>
                      <select name="jns_kelamin" id="jns_kelamin" class="form-control" >
                        <option value="L" <?= ($data_gtk["jns_kelamin"] == "L") ? "selected" : ""; ?>>Laki-laki</option>
                        <option value="P" <?= ($data_gtk["jns_kelamin"] == "P") ? "selected" : ""; ?>>Perempuan</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Status Pernikahan</label>
                      <select name="kode_kawin" id="kode_kawin" class="form-control">
                        <option value="1" <?= ($data_gtk["kode_kawin"] == "1") ? "selected" : ""; ?>>Lajang</option>
                        <option value="2" <?= ($data_gtk["kode_kawin"] == "2") ? "selected" : ""; ?>>Kawin</option>
                        <option value="3" <?= ($data_gtk["kode_kawin"] == "3") ? "selected" : ""; ?>>Janda</option>
                        <option value="4" <?= ($data_gtk["kode_kawin"] == "4") ? "selected" : ""; ?>>Duda</option>
                      </select>
                    </div>
                    <div class="col-6 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="tmt_jab">TMT Jabatan</label>
                      <input type="date" name="tmt_jab" id="tmt_jab" class="form-control"  placeholder="T.M.T Jabatan" value="<?= $tmt_jab; ?>">
                    </div>
                    <div class="col-6 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Status Kepegawaian</label>
                      <input type="text" value="<?= $data_gtk["status_kepegawaian"]; ?>" class="form form-control" readonly="true">
                      <!-- <select name="status_kepegawaian" id="status_kepegawaian" class="form-control">
                        <option value="CPNS" <?= ($data_gtk["status_kepegawaian"] == "CPNS") ? "selected" : ""; ?>>CPNS</option>
                        <option value="PNS" <?= ($data_gtk["status_kepegawaian"] == "PNS") ? "selected" : ""; ?>>PNS</option>
                        <option value="PPPK" <?= ($data_gtk["status_kepegawaian"] == "PPPK") ? "selected" : ""; ?>>PPPK</option>
                         Kab/Kota</option>
                        <option value="PNS Depag" <?= ($data_gtk["status_kepegawaian"] == "PNS Depag") ? "selected" : ""; ?>>PNS Depag</option>
                        <option value="PNS Diperbantukan" <?= ($data_gtk["status_kepegawaian"] == "PNS Diperbantukan") ? "selected" : ""; ?>>PNS Diperbantukan</option>
                      </select> -->
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="pangkat_golongan">Pangkat/Golongan</label>
                      <select name="pangkat_golongan" id="pangkat_golongan" class="form-control">
                        <?php
                        // if($data_gtk["status_kepegawaian"] == "PPPK"){
                        //   $ket_gol = $data_gtk["ket_gol_pppk"];
                        // }else{
                        //   $ket_gol = $data_gtk["ket_gol"];                          
                        // }
                        $list_gol = $this->db->get("m_gol")->result_array();
                        foreach ($list_gol as $key => $value) {
                          //jika statusnya pppk
                          if($data_gtk["status_kepegawaian"] == "PPPK"){
                            //status selected jika ket gol = ket_gol_pppk
                            $selected_gol = ($data_gtk["pangkat_golongan"] == $value['ket_gol_pppk']) ? "selected" : "";
                            $nama_gol = $value["nama_gol"];
                            $ket_gol = $value['ket_gol_pppk'];
                          }else{
                            //status selected jika ket gol = ket_gol
                            $selected_gol = ($data_gtk["pangkat_golongan"] == $value['ket_gol']) ? "selected" : "";
                            $nama_gol = $value["nama_gol"];
                            $ket_gol  = $value['ket_gol'];
                          }
                          echo '<option value="'.$ket_gol.'" '.$selected_gol.'>'.$ket_gol.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Jenjang JF Guru</label>
                      <select name="jenjang_jf_guru" id="jenjang_jf_guru" class="form-control">
                        <option value="Guru Ahli Pertama" <?= ($data_gtk["jenjang_jf"] == "Guru Ahli Pertama") ? "selected" : ""; ?>>Guru Ahli Pertama</option>
                        <option value="Guru Ahli Muda" <?= ($data_gtk["jenjang_jf"] == "Guru Ahli Muda") ? "selected" : ""; ?>>Guru Ahli Muda</option>
                        <option value="Guru Ahli Madya" <?= ($data_gtk["jenjang_jf"] == "Guru Ahli Madya") ? "selected" : ""; ?>>Guru Ahli Madya</option>
                        <option value="Guru Ahli Utama" <?= ($data_gtk["jenjang_jf"] == "Guru Ahli Utama") ? "selected" : ""; ?>>Guru Ahli Utama</option>
                        <option value="Belum Diangkat JF" <?= ($data_gtk["jenjang_jf"] == "Belum Diangkat JF") ? "selected" : ""; ?>>Belum Diangkat JF</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="status_gtk">Status GTK</label>
                      <select name="status_gtk" id="status_gtk" class="form-control">
                        <option value="Pendidik Guru" <?= ($data_gtk["status_gtk"] == "Pendidik Guru") ? "selected" : ""; ?>>Pendidik Guru</option>
                        <option value="Tendik Staf" <?= ($data_gtk["status_gtk"] == "Tendik Staf") ? "selected" : ""; ?>>Tenaga Kependidikan</option>
                        <option value="Non GTK" <?= ($data_gtk["status_gtk"] == "Non GTK") ? "selected" : ""; ?>>Non GTK</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Jabatan PTK</label>
                      <select name="jabatan_ptk" id="jabatan_ptk" class="form-control">
                        <option value="Guru Kelas" <?= ($data_gtk["jabatan_gtk"] == "Guru Kelas") ? "selected" : ""; ?>>Guru Kelas</option>
                        <option value="Guru Agama Islam" <?= ($data_gtk["jabatan_gtk"] == "Guru Agama Islam") ? "selected" : ""; ?>>Guru Agama Islam</option>
                        <option value="Guru Agama Katolik" <?= ($data_gtk["jabatan_gtk"] == "Guru Agama Katolik") ? "selected" : ""; ?>>Guru Agama Katolik</option>
                        <option value="Guru Agama Kristen" <?= ($data_gtk["jabatan_gtk"] == "Guru Agama Kristen") ? "selected" : ""; ?>>Guru Agama Kristen</option>
                        <option value="Guru Agama Buddha"  <?= ($data_gtk["jabatan_gtk"] == "Guru Agama Buddha") ? "selected" : ""; ?>>Guru Agama Buddha</option>
                        <option value="Guru Agama Hindu"   <?= ($data_gtk["jabatan_gtk"] == "Guru Agama Hindu") ? "selected" : ""; ?>>Guru Agama Hindu</option>
                        <option value="Guru Bahasa Indonesia" <?= ($data_gtk["jabatan_gtk"] == "Bahasa Indonesia") ? "selected" : ""; ?>>Guru Bahasa Indonesia</option>
                        <option value="Guru Bahasa Inggris" <?= ($data_gtk["jabatan_gtk"] == "Bahasa Inggris") ? "selected" : ""; ?>>Guru Bahasa Inggris</option>
                        <option value="Guru Bimbingan Konseling" <?= ($data_gtk["jabatan_gtk"] == "Guru Bimbingan Konseling") ? "selected" : ""; ?>>Guru Bimbingan Konseling</option>
                        <option value="Guru IPA" <?= ($data_gtk["jabatan_gtk"] == "Guru IPA") ? "selected" : ""; ?>>Guru IPA</option>
                        <option value="Guru IPS" <?= ($data_gtk["jabatan_gtk"] == "Guru IPS") ? "selected" : ""; ?>>Guru IPS</option>
                        <option value="Guru Matematika" <?= ($data_gtk["jabatan_gtk"] == "Guru Matematika") ? "selected" : ""; ?>>Guru Matematika</option>
                        <option value="Guru Muatan Lokal Lainnya" <?= ($data_gtk["jabatan_gtk"] == "Guru Muatan Lokal Lainnya") ? "selected" : ""; ?>>Guru Muatan Lokal Lainnya</option>
                        <option value="Guru Pendidikan Khusus" <?= ($data_gtk["jabatan_gtk"] == "Guru Pendidikan Khusus") ? "selected" : ""; ?>>Guru Pendidikan Khusus</option>
                        <option value="Guru Penjasorkes" <?= ($data_gtk["jabatan_gtk"] == "Guru Penjasorkesl") ? "selected" : ""; ?>>Guru Penjasorkes</option>
                        <option value="Guru PPKn" <?= ($data_gtk["jabatan_gtk"] == "Guru PPKn") ? "selected" : ""; ?>>Guru PPKn</option>
                        <option value="Guru Prakarya dan Kewirausahaan" <?= ($data_gtk["jabatan_gtk"] == "Guru Prakarya dan Kewirausahaan") ? "selected" : ""; ?>>Guru Prakarya dan Kewirausahaan</option>
                        <option value="Guru Seni Budaya" <?= ($data_gtk["jabatan_gtk"] == "Guru Seni Budaya") ? "selected" : ""; ?>>Guru Seni Budaya</option>
                        <option value="Guru Seni Rupa" <?= ($data_gtk["jabatan_gtk"] == "Guru Seni Rupa") ? "selected" : ""; ?>>Guru Seni Rupa</option>
                        <option value="Guru Sosiologi" <?= ($data_gtk["jabatan_gtk"] == "Guru Sosiologi") ? "selected" : ""; ?>>Guru Sosiologi</option>
                        <option value="Guru TIK" <?= ($data_gtk["jabatan_gtk"] == "Guru TIK") ? "selected" : ""; ?>>Guru TIK</option>
                        <option value="Kepala Sekolah" <?= ($data_gtk["jabatan_gtk"] == "Kepala Sekolah") ? "selected" : ""; ?>>Kepala Sekolah</option>
                        <option value="Laboran" <?= ($data_gtk["jabatan_gtk"] == "Laboran") ? "selected" : ""; ?>>Laboran</option>
                        <option value="Penjaga Sekolah" <?= ($data_gtk["jabatan_gtk"] == "Penjaga Sekolah") ? "selected" : ""; ?>>Penjaga Sekolah</option>
                        <option value="Office Boy" <?= ($data_gtk["jabatan_gtk"] == "Office Boy") ? "selected" : ""; ?>>Office Boy</option>
                        <option value="Petugas Keamanan" <?= ($data_gtk["jabatan_gtk"] == "Petugas Keamanan") ? "selected" : ""; ?>>Petugas Keamanan</option>
                        <option value="Pustakawan" <?= ($data_gtk["jabatan_gtk"] == "Pustakawan") ? "selected" : ""; ?>>Pustakawan</option>
                        <option value="Tenaga Administrasi Sekolah" <?= ($data_gtk["jabatan_gtk"] == "Tenaga Administrasi Sekolah") ? "selected" : ""; ?>>Tenaga Administrasi Sekolah</option>
                        <option value="Tukang Kebun" <?= ($data_gtk["jabatan_gtk"] == "Tukang Kebun") ? "selected" : ""; ?>>Tukang Kebun</option>
                        <option value="Tutor" <?= ($data_gtk["jabatan_gtk"] == "Tutor") ? "selected" : ""; ?>>Tutor</option>
                      </select>
                    </div>
                    <!-- <div class="col-12 col-lg-3 col-sm-" style="margin-top:15px;">
                      <label for="NIP">Keterangan (PTK)</label>
                      <input type="text" name="keterangan_ptk" id="keterangan_ptk" class="form-control"  placeholder="Keterangan MAPEL">
                    </div> -->
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Pembimbing PDPD</label>
                      <select name="pembimbing_pdpd" id="pembimbing_pdpd" class="form-control">
                        <option value="YA" <?= ($data_gtk["pembimbing_pdpd"] == "YA") ? "selected" : ""; ?> >YA</option>
                        <option value="TIDAK" <?= ($data_gtk["pembimbing_pdpd"] == "TIDAK") ? "selected" : ""; ?> >TIDAK</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="agama">Agama</label>
                      <select name="agama" id="agama" class="form-control">
                        <option value="Islam" <?= ($data_gtk["agama"] == "Islam") ? "selected" : ""; ?>>Islam</option>
                        <option value="Kristen" <?= ($data_gtk["agama"] == "Kristen") ? "selected" : ""; ?>>Kristen</option>
                        <option value="Katholik" <?= ($data_gtk["agama"] == "Katholik") ? "selected" : ""; ?>>Katholik</option>
                        <option value="Hindu" <?= ($data_gtk["agama"] == "Hindu") ? "selected" : ""; ?>>Hindu</option>
                        <option value="Buddha" <?= ($data_gtk["agama"] == "Buddha") ? "selected" : ""; ?>>Buddha</option>
                        <option value="Kepercayaan" <?= ($data_gtk["agama"] == "Kepercayaan") ? "selected" : ""; ?>>Kepercayaan</option>
                        <option value="-">-</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NUPTK">NUPTK</label>
                      <input type="text" name="nuptk" id="nuptk" placeholder="Isi dengan NUPTK" class="form-control" value="<?= $data_gtk["nuptk"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NUKS">NUKS</label>
                      <input type="text" name="nuks" id="nuks" class="form-control" placeholder="Isi dengan NUKS" value="<?= $data_gtk["nuks"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NRG">NRG</label>
                      <input type="text" name="nrg" id="nrg" placeholder="Isi dengan NRG"class="form-control" value="<?= $data_gtk["nrg"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="no_serdik">No Sertifikat Pendidik</label>
                      <input type="text" name="no_serdik" id="no_serdik" class="form-control" placeholder="Isi dengan No Serdik" value="<?= $data_gtk["no_serdik"]; ?>">
                    </div>
                    <div class="col-12 col-lg-12 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">No Sertifikat Guru Penggerak</label>
                      <input type="text" name="no_sergp" id="no_sergp" class="form-control" placeholder="Isi dengan sertifikat guru penggerak" value="<?= $data_gtk["no_sergp"]; ?>">
                    </div>
                    <div class="col-12 col-lg-12 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">No Sertifikat Guru Calon Kepala Sekolah <i style="color:red">*</i> Hanya untuk calon kepala sekolah / kepala sekolah</label>
                      <input type="text" name="no_crs" id="no_crs" class="form-control" value="<?= $data_gtk["no_crs"]; ?>">
                    </div>
                    <div class="col-12 col-lg-12 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Alamat (Domisili)</label>
                      <textarea name="alamat" id="alamat" class="form-control" style="-webkit-box-sizing: border-box;
                             -moz-box-sizing: border-box;
                              box-sizing: border-box;" rows="5">
                            <?= $data_gtk["alamat"]; ?>  
                            </textarea>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="pendidikan">Pendidikan</label>
                      <input type="text" name="pendidikan" id="pendidikan" class="form-control" placeholder="Isi dengan Pendidikan Terakhir" value="<?= $data_gtk["pendidikan"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="prodi">Prodi</label>
                      <input type="text" name="bidang_studi_pendidikan" id="bidang_studi_pendidikan" class="form-control" placeholder="Isi dengan nama Prodi Pendidikan" value="<?= $data_gtk["bidang_studi_pendidikan"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Tunjangan Pusat</label>
                      <select name="tunjangan_pusat" id="tunjangan_pusat" class="form-control">
                          <option value="Terima TPG" <?= ($data_gtk["tunjangan_pusat"] == "Terima TPG")? "selected" : ""; ?>>Terima TPG</option>
                          <option value="Terima Tamsil" <?= ($data_gtk["tunjangan_pusat"] == "Terima Tamsil")? "selected" : ""; ?>>Terima Tamsil</option>
                          <option value="Terima Antun" <?= ($data_gtk["tunjangan_pusat"] == "Terima Antun")? "selected" : ""; ?>>Terima Antun</option>
                          <option value="Belum Terima" <?= ($data_gtk["tunjangan_pusat"] == "Belum Terima")? "selected" : ""; ?>>Belum Terima</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Tunjangan Pemkot</label>
                      <select name="tunjangan_pemkot" id="tunjangan_pemkot" class="form-control">
                          <option value="Belum Terima" <?= ($data_gtk["tunjangan_pemkot"] == "Belum Terima")? "selected" : ""; ?>>Belum Terima</option>
                          <option value="Terima TPP" <?= ($data_gtk["tunjangan_pemkot"] == "Terima TPG")? "selected" : ""; ?>>Terima TPG</option>
                          <option value="Terima Insentif" <?= ($data_gtk["tunjangan_pemkot"] == "Terima Insentif")? "selected" : ""; ?>>Terima Insentif</option>
                          
                      </select>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">No Rek Bank</label>
                      <input type="text" name="no_rek_bank" id="no_rek_bank" class="form-control" placeholder="Isi dengan No Rekening BANK" value="<?= $data_gtk["no_rek_bank"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Nama Pemilik Rek Bank</label>
                      <input type="text" name="nama_rek_bank" id="nama_rek_bank" class="form-control" value="<?= $data_gtk["nama_rek_bank"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NIP">Nama Bank</label>
                      <input type="text" name="nama_bank" id="nama_bank" class="form-control" value="<?= $data_gtk["nama_bank"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="NPWP">NPWP</label>
                      <input type="text" name="npwp" id="npwp" class="form-control" value="<?= $data_gtk["npwp"]; ?>">
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="Dapodik">Dapodik</label>
                      <select name="dapodik" id="dapodik" class="form-control">
                        <option value="Terdata" <?= ($data_gtk["dapodik"] == "Terdata")? "selected" : ""; ?>>Terdata</option>
                        <option value="Belum" <?= ($data_gtk["dapodik"] == "Belum")? "selected" : ""; ?>>Belum</option>
                      </select>
                    </div>
                    <div class="col-12 col-lg-6 col-sm-12" style="margin-top:15px;">
                      <label for="TMT Dapodik">TMT Dapodik</label>
                      <input type="date" name="tmt_masuk_dapodik" id="tmt_masuk_dapodik" class="form-control" value="<?= $data_gtk["tmt_masuk_dapodik"]; ?>">
                    </div>
                    <div class="col-5 col-lg-3 col-sm-12" style="margin-top:15px;">
                      <button type="submit" id="save_ptk_button" class="form-control btn btn-primary">SIMPAN</button>
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
 /// |----------------------------------------
  /// | FORM AJAX
  /// |----------------------------------------
  $('#ptk_form').validate($.extend({
    submitHandler: function(form, event) {
      var submit = $('#save_ptk_btn');
      submit.attr('disabled', true);
      $(form).ajaxSubmit({
        error: function(e) {
          toaster('danger', 'Unknown error, check console.');
          console.log(e);
          submit.attr('disabled', false);
        },
        success: function(e) {
          if (e.status) {
            // what to do when the response status = true
            //reload_table();
            toaster('success', e.message);
            setTimeout(() => {
              // modal dismiss
              window;
            }, 350);
          } else {
            // what to do when the response status = false
            toaster('info', e.message);
            submit.attr('disabled', false);
          }
        },
        dataType: 'json'
      });
    },
    rules: {
      tmt_jab: {
        required: true
      },
      status_kepegawaian: {
        required: true
      },
      pangkat_golongan: {
        required: true
      },
      status_gtk:{
        required: true
      },
      agama:{
        required: true
      },
      alamat:{
        required: true
      },
      pendidikan:{
        required:true
      },
      bidang_studi_pendidikan:{
        required:true
      },
      tunjangan_pusat:{
        required:true
      },
      tunjangan_pemkot:{
        required:true
      },
      npwp:{
        required:true
      },
      dapodik:
      {
        required:true
      }
    },
    errorClass: 'is-invalid',
    validClass: 'mv-valid',
    /* if there's select2 element, please use this errorPlacement */
    errorPlacement: function(error, element) {
      if (element.hasClass('select2') && element.next('.select2-container').length) {
        error.insertAfter(element.next('.select2-container'));
      } else {
        error.insertAfter(element);
      }
    },
    messages: {
      tmt_jab: {
        required: "TMT Jab Tidak Boleh Kosong!"
      },
      status_kepegawaian: {
        required: "Status Kepegawaian Tidak Boleh Kosong!"
      },
      pangkat_golongan: {
        required: "Pangkat Golongan Tidak Boleh Kosong!"
      },
      status_gtk:{
        required: "Status GTK Tidak Boleh Kosong!"
      },
      agama:{
        required: "Agama Tidak Boleh Kosong!"
      },
      alamat:{
        required: "Alamat Tidak Boleh Kosong!"
      },
      pendidikan:{
        required: "Pendidikan Tidak Boleh Kosong!"
      },
      bidang_studi_pendidikan:{
        required:"Prodi Tidak Boleh Kosong!"
      },
      tunjangan_pusat:{
        required:"Tunjangan Pusat Tidak Boleh Kosong!"
      },
      tunjangan_pemkot:{
        required:"Tunjangan Pemkot Tidak Boleh Kosong!"
      },
      npwp:{
        required:"Tunjangan Pusat Tidak Boleh Kosong!"
      },
      dapodik:
      {
        required:"Status Terdaftar di Dapodik Tidak Boleh Kosong!"
      }
    },
  }));
</script>