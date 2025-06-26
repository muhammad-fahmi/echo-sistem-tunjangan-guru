<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Update Profil Sekolah</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item">Update Profil Sekolah</li>
    </ol>
  </div>
</div>

<div class="container-fluid">

  <div class="row">

    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title space-between">
            <div>PROFIL KEPALA SEKOLAH</div>
          </h4>
        </div>
        <!-- Form Update Profil Sekolah -->
        <form id="form_profil_sekolah" action="<?= site_url(`pdt_profil_sekolah/save`); ?>" method="post">
          <div class="card-body">
            <input type="hidden" name="id_sekolah" id="id_sekolah" class="form-control form-input-bg" value="<?= check_var($data, 'id_sekolah', '-') ?>">
            <div class="row">
              <!-- FOTO KEPALA SEKOLAH -->
              <div class="col-12 col-lg-4 d-flex-center" style="display: block; align-content: center;">
                <div class="card">
                  <div class="text-center">FOTO KEPSEK</div>
                </div>
                <div class="d-flex">
                  <input type="file" name="foto_sekolah" id="foto_sekolah" class="form-control form-control">
                </div>
              </div>
              <!-- DATA INFORMASI SEKOLAH -->
              <div class="col-12 col-lg-8">
                <table class="table table-sm table-hover">
                  <tr>
                    <td style="min-width: 150px;">NAMA</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="nama" id="nama" class="form-control form-input-bg" value="<?= check_var($data, 'nama', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">NIP</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="nip" id="nip" class="form-control form-input-bg" value="<?= check_var($data, 'nip', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">NUPTR</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="nuptr" id="nuptr" class="form-control form-input-bg" value="<?= check_var($data, 'nuptr', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">NURS</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="nurs" id="nurs" class="form-control form-input-bg" value="<?= check_var($data, 'nurs', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">NRG</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="nrg" id="nrg" class="form-control form-input-bg" value="<?= check_var($data, 'nrg', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">NIK</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="nik" id="nik" class="form-control form-input-bg" value="<?= check_var($data, 'nik', '-') ?>">
                    </td>
                  </tr>
                </table>
              </div>

              <div class="col-12 col-lg-12">
                <table class="table table-sm table-hover">
                  <tr>
                    <td style="min-width: 150px;">JENIS KELAMIN</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <select name="jenis_kelamin" id="jenis_kelamin" class="form-control form-control" style="width:100%">
                        <?php $selected = ($data["jenis_kelamin"] != "") ? "selected" : ""; ?>
                        <option value=""> - - - Pilih Jenis Kelamin - - - </option>
                        <option value="L"> LAKI-LAKI </option>
                        <option value="P"> PEREMPUAN </option>
                      </select>
                      <!-- <input type="text" name="akreditasi" id="akreditasi" class="form-control form-input-bg" value="<?= check_var($data, 'akreditasi', '-') ?>"> -->
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">TGL LAHIR</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control form-input-bg" value="<?= check_var($data, 'tgl_lahir', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">ALAMAT SAAT INI</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="alamat_saat_ini" id="alamat_saat_ini" class="form-control form-input-bg" value="<?= check_var($data, 'alamat_saat_ini', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">STATUS PERNIKAHAN</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <select name="status_pernikahan" id="status_pernikahan" class="form-control form-control" style="width:100%">
                        <?php $selected = ($data["status_pernikahan"] != "") ? "selected" : ""; ?>
                        <option value=""> - - - Pilih Status Pernikahan - - - </option>
                        <option value="M"> SUDAH MENIKAH </option>
                        <option value="B"> BELUM MENIKAH </option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">KODE DIDIK</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="kode_didik" id="kode_didik" class="form-control form-input-bg" value="<?= check_var($data, 'kode_didik', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">PENDIDIKAN</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="pendidikan" id="pendidikan" class="form-control form-input-bg" value="<?= check_var($data, 'pendidikan', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">NO. SERTIFIKAT PENDIDIKAN</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="number" name="no_sertifikat_pendidikan" id="no_sertifikat_pendidikan" class="form-control form-input-bg" value="<?= check_var($data, 'no_sertifikat_pendidikan', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">NO. SERTIFIKAT GP</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="number" name="no_sertifikat_gp" id="no_sertifikat_gp" class="form-control form-input-bg" value="<?= check_var($data, 'no_sertifikat_gp', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">NO. SERTIFIKAT CRS</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="number" name="no_sertifikat_crs" id="no_sertifikat_crs" class="form-control form-input-bg" value="<?= check_var($data, 'no_sertifikat_crs', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">NO. REK BANK</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="number" name="no_rek_bank" id="no_rek_bank" class="form-control form-input-bg" value="<?= check_var($data, 'no_rek_bank', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">NPWP</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="npwp" id="npwp" class="form-control form-input-bg" value="<?= check_var($data, 'npwp', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">MENERIMA TTP INSENTIF</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="menerima_ttp_insentif" id="menerima_ttp_insentif" class="form-control form-input-bg" value="<?= check_var($data, 'menerima_ttp_insentif', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">STATUS</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="status" id="status" class="form-control form-input-bg" value="<?= check_var($data, 'status', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">EMAIL</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="email" name="email" id="email" class="form-control form-input-bg" value="<?= check_var($data, 'email', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">NO. TELEPON / HP</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="no_hp" id="no_hp" class="form-control form-input-bg" value="<?= check_var($data, 'no_hp', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">AGAMA</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <select name="kode_agama" id="kode_agama" class="form-control form-control" style="width:100%">
                        <?php $selected = ($data["kode_agama"] != "") ? "selected" : ""; ?>
                        <option value=""> - - - Pilih Agama - - - </option>
                        <option value="Islam"> ISLAM </option>
                        <option value="Hindu"> HINDU </option>
                        <option value="Protestan"> KRISTEN - PROTESTAN </option>
                        <option value="Khatolik"> KRISTEN - KHATOLIK </option>
                        <option value="Buddha"> BUDDHA </option>
                        <option value="Konghucu"> KONG-HU-CHU </option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">PERIODE</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="periode_ke" id="periode_ke" class="form-control form-input-bg" value="<?= check_var($data, 'periode_ke', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">MASA PENUGASAN (MULAI)</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="masa_penugasan_mulai" id="masa_penugasan_mulai" class="form-control form-input-bg" value="<?= check_var($data, 'masa_penugasan_mulai', '-') ?>">
                    </td>
                  </tr>
                  <tr>
                    <td style="min-width: 150px;">MASA PENUGASAN (SELESAI)</td>
                    <td style="min-width: 20px; text-align: center;">:</td>
                    <td style="width: 100%;">
                      <input type="text" name="masa_penugasan_selesai" id="masa_penugasan_selesai" class="form-control form-input-bg" value="<?= check_var($data, 'masa_penugasan_selesai', '-') ?>">
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class="card-footer text-end p-3">
            <button type="reset" class="btn btn-secondary"><i class="fas fa-undo me-2"></i> RESET</button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> UPDATE</button>
          </div>
        </form>

      </div>
    </div>

  </div>

</div>

<script>
  $('#form_profil_sekolah').validate($.extend({
    submitHandler: function(form, event) {
      var submit = $('[type="submit"]');
      // declare button submit disabling right here if needed
      submit.attr('disabled', true);
      $(form).ajaxSubmit({
        success: function(e) {
          console.log(e);
          if (e.status == 'OK') {
            // what to do when the response status = true
            $.notify('<b><i class="bi-check-square me-1"></i>Success!</b><br>' + e.message, 'success');
            setTimeout(() => {
              // window href template
              // window.location.href = '<?= base_url('url_to_redirect') ?>';
              // modal dismiss
              // $('#modal_whole_id').modal('hide');
              // if using datatable, refresh it's state
              // reload_table();
            }, 500);
          } else {
            submit.attr('disabled', false);
          }
        },
        error: function(e) {
          var msg = (e.message) ? e.message : e.responseJSON.message;
          // $.notify('<b><i class="bi-x-square me-1"></i>Oops!</b><br>' + msg, 'error');
          submit.attr('disabled', false);
        },
        dataType: 'json'
      });
    },
    rules: {
      input_name_rules: {
        required: true
      },
    },
    errorClass: 'mv-error',
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
      input_name_rules: {
        required: "custom_error_message",
      }
    },
  }));
  $(document).ready(function() {
    // do something on document ready
  });
</script>