<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <form id="saveRombel" action="<?= site_url('pdt_rombongan_belajar/save'); ?>" method="POST">
    <input type="hidden" name="type" value="<?= $data['type']; ?>">

    <div class="row g-2">

      <?php
      /// |----------------------------------------
      /// | SHOW DEBUG
      /// |----------------------------------------
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

      <div class="col-12 form_mapel mb-2">
        <label for="id_sekolah">Sekolah</label>
        <input type="hidden" id="id_sekolah" name="id_sekolah" class="form-control form-control" value="<?= $this->session->userdata("kode_unor"); ?>">
        <input type="text" id="ket_sekolah" name="ket_sekolah" class="form-control form-control" value="<?= $this->session->userdata("ket_unor"); ?>" disabled>
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 form_mapel mb-2">
        <label for="id_jenjang">Jenjang</label>
        <br>
        <select name="id_jenjang" id="id_jenjang" class="form-select form-select" style="width:100%">
          <?php $selected = ($data["id_jenjang"] != "") ? "selected" : ""; ?>
          <option value="<?php echo $data["id_jenjang"]; ?>" <?php echo $selected ?>><?php echo $data["ket_jenjang"]; ?></option>
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

      <div class="col-12 col-lg-6 form_mapel mb-2">
        <label for="nama_rombel">Rombel</label>
        <br>
        <input type="text" name="nama_rombel" id="nama_rombel" class="form-control form-control" value="<?= $data["nama_rombel"]; ?>">
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 col-lg-6 form_mapel mb-2">
        <label for="id_tahun_ajaran">Tahun Ajar</label>
        <br>
        <select name="id_tahun_ajaran" id="id_tahun_ajaran" class="form-select form-select" style="width:100%">
          <?php $selected = ($data["id_tahun_ajaran"] != "") ? "selected" : ""; ?>
          <option value="<?php echo $data["id_tahun_ajaran"]; ?>" <?php echo $selected ?>><?php echo $data["ket_tahun_ajaran"]; ?></option>
        </select>
        <div class="invalid-feedback"></div>
      </div>

    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-light-secondary" data-bs-dismiss="modal">Batal</button>
  <button id="saveRombelbtn" type="submit" form="saveRombel" class="btn btn-sm btn-light-success">Simpan</button>
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
      url: '<?= site_url('config/select2_kelas'); ?>',
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
  /// | >> SELECT2 TAHUN AJARAN
  /// |----------------------------------------------------------------------
  var select2_tahun_ajar = $('#id_tahun_ajaran');
  $('#id_tahun_ajaran').select2({
    allowClear: true,
    placeholder: '-- Pilih Tahun Ajaran --',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_tahun_ajaran') ?>',
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
    select2_tahun_ajar.empty();
  });

  /// |----------------------------------------
  /// | FORM AJAX
  /// |----------------------------------------
  $('#saveRombel').validate($.extend({
    submitHandler: function(form, event) {
      var submit = $('#saveRombelbtn');
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
      id_sekolah: {
        required: true
      },
      id_jenjang: {
        required: true
      },
      id_kelas: {
        required: true
      },
      nama_rombel: {
        required: true
      },
      id_tahun_ajaran: {
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
      id_sekolah: {
        required: "Sekolah tidak boleh kosong!"
      },
      id_jenjang: {
        required: "Jenjang tidak boleh kosong!"
      },
      id_kelas: {
        required: "Kelas tidak boleh kosong!"
      },
      nama_rombel: {
        required: "Nama Rombel tidak boleh kosong!"
      },
      id_tahun_ajaran: {
        required: "Tahun Ajaran tidak boleh kosong!"
      }
    },
  }));
</script>