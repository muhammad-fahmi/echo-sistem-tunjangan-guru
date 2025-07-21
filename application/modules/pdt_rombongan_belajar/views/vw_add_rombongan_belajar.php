<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <form id="savePesertaDidik" action="<?= site_url('pdt_rombongan_belajar/save'); ?>" method="POST">
    <input type="hidden" name="type" value="<?= $data['type']; ?>">
    <!-- <input type="hidden" name="id_siswa" value="<?= $data['id_siswa']; ?>"> -->

    <div class="row g-2">
      <div class="col-12 form_mapel mb-2">
        <label for="id_jenjang">Jenjang</label>
        <br>
        <select name="id_jenjang" id="id_jenjang" class="form-select form-select" style="width:100%">
          <?php $selected = ($data["id_jenjang"] != "") ? "selected" : ""; ?>
          <option value="<?php echo $data["id_jenjang"]; ?>" <?php echo $selected ?>><?php echo $data["ket_kelas"]; ?></option>
        </select>
      </div>

      <div class="col-12 col-lg-12 form_mapel mb-2">
        <label for="id_kelas">Kelas</label>
        <br>
        <select name="id_kelas" id="id_kelas" class="form-select form-select" style="width:100%">
          <?php $selected = ($data["id_kelas"] != "") ? "selected" : ""; ?>
          <option value="<?php echo $data["id_kelas"]; ?>" <?php echo $selected ?>><?php echo $data["ket_kelas"]; ?></option>
        </select>
      </div>

      <div class="col-12 col-lg-12 form_mapel mb-2">
        <label for="id_rombel">Rombel</label>
        <br>
        <select name="id_rombel" id="id_rombel" class="form-select form-select" style="width:100%">
          <?php $selected = ($data["id_rombel"] != "") ? "selected" : ""; ?>
          <option value="<?php echo $data["id_rombel"]; ?>" <?php echo $selected ?>><?php echo $data["ket_agama"]; ?></option>
        </select>
      </div>

      <div class="col-12 form_mapel mb-2">
        <label for="nama_ayah">Nama Ayah</label>
        <input type="text" name="nama_ayah" id="nama_ayah" class="form-control form-control-sm" value="<?= $data['nama_ayah']; ?>">
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 form_mapel mb-2">
        <label for="tahun">Tahun Ajar</label>
        <input type="text" name="tahun" id="tahun" class="form-control form-control-sm" value="<?= $data['tahun']; ?>">
        <div class="invalid-feedback"></div>
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
  /// | >> SELECT2 JENJANG
  /// |----------------------------------------------------------------------
  var select2_jenjang = $('#id_jenjang');
  $('#id_jenjang').select2({
    allowClear: true,
    placeholder: '-- Pilih Jenjang --',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_jenjang'); ?>',
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
    select2_jenjang.empty();
  });

  /// |----------------------------------------------------------------------
  /// | >> SELECT2 KELAS
  /// |----------------------------------------------------------------------
  var select2_kelas = $('#id_kelas');
  $('#id_kelas').select2({
    allowClear: true,
    placeholder: '-- Pilih Kelas --',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_id_kelas'); ?>',
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
    select2_kelas.empty();
  });

  /// |----------------------------------------------------------------------
  /// | >> SELECT2 ROMBEL
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