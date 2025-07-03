<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <form id="savePesertaDidik" action="<?= site_url('pdt_peserta_didik/save'); ?>" method="POST">
    <input type="hidden" name="type" value="<?= $data['type']; ?>">
    <input type="hidden" name="id_siswa" value="<?= $data['id_siswa']; ?>">

    <div class="row g-2">
      <div class="card bg-warning p-3 m-0">
        <div class="col-12 col-lg-12 text-white">
          <i class="fas fa-exclamation-circle me-1"></i>
          <b>Peringatan :</b><br>
          Untuk penamaan orang tua peserta didik (<b>ayah</b> dan <b>ibu</b>), tidak disarankan mencantumkan <b>gelar</b> apapun <br>(contoh : <b>Hj, Ir, Ustad,</b> dll).
        </div>
      </div>

      <div class="col-12 form_mapel mb-2">
        <label for="nisn">NISN</label>
        <input type="text" name="nisn" id="nisn" class="form-control form-control-sm" value="<?= $data['nisn']; ?>">
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 form_mapel mb-2">
        <label for="nama">Nama Lengkap</label>
        <input type="text" name="nama" id="nama" class="form-control form-control-sm" value="<?= $data['nama']; ?>">
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 form_mapel mb-2">
        <label for="nik">NIK</label>
        <input type="text" name="nik" id="nik" class="form-control form-control-sm" value="<?= $data['nik']; ?>">
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 col-lg-12 form_mapel mb-2">
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <br>
        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select form-select" style="width:100%">
          <?php $selected = ($data["jenis_kelamin"] != "") ? "selected" : ""; ?>
        </select>
      </div>

      <div class="col-12 col-lg-12 form_mapel mb-2">
        <label for="kode_agama">Agama</label>
        <br>
        <select name="kode_agama" id="kode_agama" class="form-select form-select" style="width:100%">
          <?php $selected = ($data["kode_agama"] != "") ? "selected" : ""; ?>
        </select>
      </div>

      <div class="col-12 form_mapel mb-2">
        <label for="nama_ayah">Nama Ayah</label>
        <input type="text" name="nama_ayah" id="nama_ayah" class="form-control form-control-sm" value="<?= $data['nama_ayah']; ?>">
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 form_mapel mb-2">
        <label for="nama_ibu">Nama Ibu</label>
        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control form-control-sm" value="<?= $data['nama_ibu']; ?>">
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 form_mapel mb-2">
        <label for="no_kk">No. KK</label>
        <input type="text" name="no_kk" id="no_kk" class="form-control form-control-sm" value="<?= $data['no_kk']; ?>">
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 col-lg-12 form_mapel mb-2 mb-2">
        <label for="alamat">Alamat</label>
        <input type="text" name="alamat" id="alamat" class="form-control form-control-sm" value="<?= $data['alamat'] ?>">
      </div>

      <div class="col-12 col-lg-12 form_mapel mb-2">
        <input type="checkbox" name="pdpd" id="pdpd" onchange="toggleDisabilitySelect()"> PD Penyandang Disabilitas?
      </div>

      <div id="pdpd_container" class="col-12 col-lg-12 form_mapel mb-2" style="display: none; margin-top: 10px;">
        <label for="pdpd_options">Ragam Disabilitas</label>
        <select id="pdpd_options" name="pdpd_options" class="form-select form-select">
          <?php $selected = ($data["pdpd"] != "") ? "selected" : ""; ?>
        </select>
      </div>

    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-light-secondary" data-bs-dismiss="modal">Batal</button>
  <button id="savePesertaDidikbtn" type="submit" form="savePesertaDidik" class="btn btn-sm btn-light-success">Simpan</button>
</div>

<script>
  /// |----------------------------------------------------------------------
  /// | >> CHECKBOX FUNCTION
  /// |----------------------------------------------------------------------
  function toggleDisabilitySelect() {
    const checkbox = document.getElementById('pdpd');
    const select_pd = document.getElementById('pdpd_container');
    select_pd.style.display = checkbox.checked ? 'block' : 'none';
  }

  /// |----------------------------------------------------------------------
  /// | >> SELECT2 AGAMA
  /// |----------------------------------------------------------------------
  var select2_agama = $('#kode_agama');
  $('#kode_agama').select2({
    allowClear: true,
    placeholder: '-- Pilih agama --',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_agama'); ?>',
      delay: 800,
      /* delay before sending ajax request */
      data: function(params) {
        return {
          search: params.term,
        }
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
    }
  }).on('select2:select', function(e) {
    // what to do when option selected
  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
    select2_agama.empty();
  });

  /// |----------------------------------------------------------------------
  /// | >> SELECT2 JENIS KELAMIN
  /// |----------------------------------------------------------------------
  var select2_jns_kelamin = $('#jenis_kelamin');
  $('#jenis_kelamin').select2({
    allowClear: true,
    placeholder: '-- Pilih jenis kelamin --',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_jenis_kelamin'); ?>',
      delay: 800,
      /* delay before sending ajax request */
      data: function(params) {
        return {
          search: params.term,
        }
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
    }
  }).on('select2:select', function(e) {
    // what to do when option selected
  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
    select2_jns_kelamin.empty();
  });

  /// |----------------------------------------------------------------------
  /// | >> SELECT2 DISABILITAS
  /// |----------------------------------------------------------------------
  var select_pdpd = $('#pdpd_options');
  $('#pdpd_options').select2({
    allowClear: true,
    placeholder: '-- Pilih Ragam Disabilitas --',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_disabilitas') ?>',
      delay: 800,
      /* delay before sending ajax request */
      data: function(params) {
        return {
          search: params.term,
        }
      },
      processResults: function(data) {
        return {
          results: data
        };
      },
    }
  }).on('select2:select', function(e) {
    // what to do when option selected
  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
    select_pdpd.empty();
  });

  // Custom Validator
  $.validator.addMethod("noTitles", function(value, element) {
    const titlePattern = /\b(prof|dr|drs|mrs|mr|ms|ir|hj|haji|habib|ustadz|kyai|s\.pd|s\.kom|s\.e|s\.h|s\.ag|m\.pd|m\.kom|m\.si|m\.sc|m\.m|phd|msc|b\.eng|b\.sc)\b/i;
    return this.optional(element) || !titlePattern.test(value);
  });

  $('#savePesertaDidik').validate($.extend({
    submitHandler: function(form, event) {
      var submit = $('#savePesertaDidikbtn');
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
            reload_table();
            toaster('success', e.message);
            setTimeout(() => {
              // modal dismiss
              $('#whole_modal_id').modal('hide');
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
      nisn: {
        required: true
      },
      nama: {
        required: true
      },
      nik: {
        required: true
      },
      jenis_kelamin: {
        required: true
      },
      kode_agama: {
        required: true
      },
      nama_ayah: {
        required: true,
        noTitles: true
      },
      nama_ibu: {
        required: true,
        noTitles: true
      },
      no_kk: {
        required: true
      },
      alamat: {
        required: true
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
      nisn: {
        required: "NISN tidak boleh kosong"
      },
      nama: {
        required: "Nama Lengkap tidak boleh kosong"
      },
      nik: {
        required: "NIK tidak boleh kosong"
      },
      jenis_kelamin: {
        required: "Jenis Kelamin tidak boleh kosong"
      },
      kode_agama: {
        required: "Agama tidak boleh kosong"
      },
      nama_ayah: {
        required: "Nama Ayah tidak boleh kosong",
        noTitles: "Nama Ayah tidak boleh mengandung gelar seperti Prof, Dr, PhD, dll."
      },
      nama_ibu: {
        required: "Nama Ibu tidak boleh kosong",
        noTitles: "Nama Ayah tidak boleh mengandung gelar seperti Prof, Dr, PhD, dll."
      },
      no_kk: {
        required: "No. KK tidak boleh kosong"
      },
      alamat: {
        required: "Alamat tidak boleh kosong"
      }
    },
  }));
</script>