<form action="<?= site_url('user/edit_user'); ?>" method="POST" id="edit_user">
  <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">

  <div class="modal-header d-flex align-items-center">
    <div>
      <h3 class="mb-0"><?= $modal_title ?></h3>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>

  <div class="modal-body">
    <div class="row g-2">

      <div class="col-12 mb-1">
        <label for="id_user">Username</label>
        <div id="id_user" class="form-control form-control-sm non-editable"><?= $data['id_user'] ?></div>
      </div>

      <div class="col-12 mb-1">
        <label for="password2">Password</label>
        <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Password baru untuk user, kosongkan jika tidak ada perubahan">
      </div>

      <div class="col-12 mb-1">
        <label for="username">Nama User / Nama Unit Kerja</label>
        <input type="text" class="form-control form-control-sm" id="username" name="username" value="<?= $data['username'] ?>" placeholder="Nama User / Nama Unit Kerja">
      </div>

      <div class="col-12 mb-1">
        <label for="kewenangan">Kewenangan</label>
        <select type="text" class="form-select form-select-sm" name="kewenangan" id="kewenangan">
          <option value="" default hidden>-- Pilih Kewenangan --</option>
          <option value="00" <?= ($data['kewenangan'] == '00') ? 'default selected' : ''; ?>>Super Admin</option>
          <option value="01" <?= ($data['kewenangan'] == '01') ? 'default selected' : ''; ?>>Administrator</option>
          <option value="10" <?= ($data['kewenangan'] == '10') ? 'default selected' : ''; ?>>Admin OPD / Unit Kerja</option>
        </select>
      </div>
      <div class="col-12 mb-1">
        <label for="kewenangan">Unit Kerja</label>
        <select type="text" class="form-select form-select-sm ukerja select2" name="kode_unor" id="kode_unor">
          <?php
          $temp = $data['kode_unor'];
          $ket_temp = $data['kode_unor'] . " - " . $data['ket_ukerja'];
          if ($temp != '') {
            echo '<option value="' . $temp . '" default selected>' . $ket_temp . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="col-12 mb-1">
        <label for="email_user">E-mail</label>
        <input type="text" class="form-control form-control-sm" id="email_user" name="email_user" value="<?= $data['email_user'] ?>" placeholder="E-mail aktif User / Unit Kerja">
      </div>

      <div class="col-12 mb-1">
        <div class="form-check">
          <?php
          $checked = ($data['aktif'] == 'Y') ? 'checked' : '';
          ?>
          <input id="aktif" name="aktif" class="form-check-input form-check-input-sm" type="checkbox" <?= $checked ?>>
          <label class="form-check-label form-check-label-sm" for="aktif">Aktif</label>
        </div>
      </div>

    </div>
    <!-- end of row -->
  </div>
  <!-- end of modal-body -->

  <div class="modal-footer text-end">
    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-sm btn-primary">Update</button>
  </div>

</form>

<script>
  var select2_unit_kerja = $('.ukerja.select2');
  $('.ukerja.select2').select2({
    allowClear: true,
    placeholder: '[<?php echo $data["kode_ukerja"] . " - " . $data["ket_ukerja"]; ?> ]',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_instansi') ?>',
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
    var val = $('.ukerja.select2').val();
  }).on('select2:close', function(e) {
    // what to do when selection closed
    select2_unit_kerja.valid();
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
    select2_unit_kerja.empty();
  });


  $('#edit_user').validate($.extend({
    submitHandler: function(form, event) {
      // declare element that will be affected
      // by every state of the form submission
      // right here
      var submit = $('[type="submit"]');
      // declare button submit disabling right here if needed
      submit.attr('disabled', true);
      $(form).ajaxSubmit({
        success: function(e) {
          if (e.status) {
            // what to do when the response status = true
            $('#whole_modal_id').modal('hide');
            toaster('success', e.message);
            reload_table();
          } else {
            // what to do when the response status = false
            submit.attr('disabled', false);
            toaster('danger', 'Maaf, terjadi kesalahan pada proses penyimpanan user baru. ' + e.message);
          }
        },
        error: function(xhr, status, error) {
          submit.attr('disabled', false);
          toaster('danger', 'Maaf, terjadi kesalahan pada proses penyimpanan user baru. ' + error);
        },
        dataType: 'json'
      });
    },
    rules: {
      username: {
        required: true
      },
      password1: {
        minlength: 3
      },
      password2: {
        minlength: 3,
        maxlength: 12
      },
      nama_lengkap: {
        required: true
      },
      kewenangan: {
        required: true
      },
      no_hp: {
        required: true,
        maxlength: 12
      }
    },
    errorClass: 'is-invalid',
    validClass: 'is-valid',
    /* if there's select2 element, please use this errorPlacement */
    errorPlacement: function(error, element) {
      if (element.hasClass('select2') && element.next('.select2-container').length) {
        error.insertAfter(element.next('.select2-container'));
      } else {
        error.insertAfter(element);
      }
    },
    messages: {
      input_name: {
        required: "error message!",
      }
    },
  }));
</script>