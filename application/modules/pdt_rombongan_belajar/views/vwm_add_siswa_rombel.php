<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <form id="saveSiswaRombel" action="<?= site_url('pdt_rombongan_belajar/save_siswa'); ?>" method="POST">
    <input type="hidden" id="type" name="type" value="<?= $data['type']; ?>">
    <input type="hidden" id="id_rombel" name="id_rombel" value="<?= $data['id']; ?>">

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
        <label for="id_siswa">Siswa</label>
        <select name="id_siswa" id="id_siswa" class="form-select form-select" style="width: 100%;">
          <?php $selected = ($data["id_siswa"] != "") ? "selected" : ""; ?>
          <option value="<?php echo $data["id_siswa"]; ?>" <?php echo $selected ?>><?php echo $data["nama"]; ?></option>
        </select>
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 form_mapel mb-2">
        <label for="nisn">NISN</label>
        <input type="text" id="nisn" name="nisn" class="form-control form-control" value="<?= isset_nn_nes($data['nisn'], ''); ?>" disabled>
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 form_mapel mb-2">
        <label for="nama">Nama Siswa</label>
        <input type="text" id="nama" name="nama" class="form-control form-control" value="<?= isset_nn_nes($data['nama'], ''); ?>" disabled>
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 form_mapel mb-2">
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <input type="text" id="jenis_kelamin" name="jenis_kelamin" class="form-control form-control" value="<?= isset_nn_nes($data['ket_jenis_kelamin'], ''); ?>" disabled>
        <div class="invalid-feedback"></div>
      </div>

    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-light-secondary" data-bs-dismiss="modal">Batal</button>
  <button id="saveSiswaRombelbtn" type="submit" form="saveSiswaRombel" class="btn btn-sm btn-light-success">Simpan</button>
</div>

<script>
  /// |----------------------------------------------------------------------
  /// | >> SELECT2 JENJANG
  /// |----------------------------------------------------------------------
  var select2_siswa = $('#id_siswa');
  $('#id_siswa').select2({
    allowClear: true,
    placeholder: '-- Pilih Siswa --',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_siswa'); ?>',
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
    $('#nisn').val(e.params.data.nisn);
    $('#nama').val(e.params.data.nama);
    $('#jenis_kelamin').val(e.params.data.ket_jns_kelamin);
  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
    select2_siswa.empty();
    $('#nisn').val();
    $('#nama').val();
    $('#jenis_kelamin').val();
  });

  /// |----------------------------------------
  /// | FORM AJAX
  /// |----------------------------------------
  $('#saveSiswaRombel').validate($.extend({
    submitHandler: function(form, event) {
      var submit = $('#saveSiswaRombelbtn');
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
      id_rombel: {
        required: true
      },
      id_siswa: {
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
      id_rombel: {
        required: "ID Rombel tidak boleh kosong!"
      },
      id_siswa: {
        required: "ID Siswa tidak boleh kosong!"
      }
    },
  }));
</script>