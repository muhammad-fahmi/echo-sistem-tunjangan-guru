<form action="<?= site_url('user/edit_user'); ?>" method="POST" id="edit_user">
  <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">

  <div class="modal-header d-flex align-items-center">
    <div>
      <h3 class="mb-0">Edit Data User</h3>
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
        <label for="username">Nama User / Nama Unit Kerja</label>
        <input type="text" class="form-control form-control-sm" id="username" name="username" value="<?= $data['username'] ?>" placeholder="Nama User / Nama Unit Kerja">
      </div>
      <!-- <div class="col-12 mb-1">
            <label for="password1">Current Password</label>
            <input type="password" class="form-control form-control-sm" id="password1" name="password1" placeholder="Password lama dari user">
          </div> -->
      <div class="col-12 mb-1">
        <label for="password2">New Password</label>
        <input type="password" class="form-control form-control-sm" id="password2" name="password2" placeholder="Password baru untuk user, kosongkan jika tidak ada perubahan">
      </div>
      <div class="col-12 mb-1">
        <label for="nama_lengkap">Nama Lengkap</label>
        <input type="text" class="form-control form-control-sm" id="nama_lengkap" name="nama_lengkap" value="<?= $data['nama_lengkap'] ?>">
      </div>
      <div class="col-12 mb-1">
        <label for="kewenangan">Kewenangan</label>
        <select type="text" class="form-select form-select-sm kewenangan select2" name="kewenangan" id="kewenangan">
          <?php
          $temp = $data['kewenangan'];
          $ket_temp = $data['ket_kewenangan'];
          if ($temp != '') {
            echo '<option value="' . $temp . '" default selected>' . $ket_temp . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="col-12 mb-1">
        <label for="kewenangan">Unit Kerja</label>
        <select type="text" class="form-select form-select-sm ukerja select2" name="kode_ukerja" id="kode_ukerja">
          <?php
          $temp = $data['kode_ukerja'];
          $ket_temp = $data['kode_ukerja'] . " - " . $data['ket_ukerja'];
          if ($temp != '') {
            echo '<option value="' . $temp . '" default selected>' . $ket_temp . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="col-12 mb-1">
        <label for="no_hp">No. HP</label>
        <input type="number" class="form-control form-control-sm" id="no_hp" name="no_hp" value="<?= $data['no_hp'] ?>">
      </div>
      <div class="col-12 mb-1">
        <div class="form-check">
          <?php
          $checked = ($data['aktif'] == 'Y') ? 'checked' : '';
          ?>
          <input id="aktif" class="form-check-input form-check-input-sm" type="checkbox" value="<?= $data['aktif'] ?>" name="aktif" <?= $checked ?>>
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
  // select2 kewenangan
  var select2_kewenangan = $('.kewenangan.select2');
  $('.kewenangan.select2').select2({
    allowClear: true,
    placeholder: '-- Pilih kewenangan --',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_kewenangan') ?>',
      delay: 800,
      /* delay before sending ajax request */
      data: function(params) {
        return {
          search: params.term
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
    var val = $('.kewenangan.select2').val();
  }).on('select2:close', function(e) {
    // what to do when selection closed
    select2_kewenangan.valid();
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
    select2_kewenangan.empty();
  });

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
            $('#my_modal').modal('hide');
            $.notify('<b><i class="fas fa-check-square me-1"></i>Sukses!</b><br>' + e.message, 'success');
            reload_table();
          } else {
            // what to do when the response status = false
            submit.attr('disabled', false);
            $.notify('<b><i class="fas fa-exclamation-triangle me-1"></i>Gagal!</b><br>' + e.message, 'error');
          }
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