<div class="row g-2">
  <div class="col-12">
    <form action="<?= site_url('user/add_user'); ?>" method="POST" id="add_user">
      <div class="panel">
        <div class="header space-between">
          <div class="header">Tambah Data User</div>
          <i class="fas fa-window-close float right clickable" data-bs-dismiss="modal"></i>
        </div>
        <div class="separator"></div>
        <div class="body">
          <div class="col-12 mb-1">
            <label for="username">Username</label>
            <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Username untuk user baru">
          </div>
          <div class="col-12 mb-1">
            <label for="password">Password</label>
            <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Password untuk user baru">
          </div>
          <div class="col-12 mb-1">
            <label for="nama_lengkap">Nama Lengkap</label>
            <input type="text" class="form-control form-control-sm" id="nama_lengkap" name="nama_lengkap" placeholder="Nama lengkap user baru">
          </div>
          <div class="col-12 mb-1">
            <label for="kewenangan">Kewenangan</label>
            <select type="text" class="form-select form-select-sm kewenangan select2" name="kewenangan" id="kewenangan">
            </select>
          </div>
          <div class="col-12 mb-1">
            <label for="kewenangan">Unit Kerja</label>
            <select type="text" class="form-select form-select-sm ukerja select2" name="kode_ukerja" id="kode_ukerja">
            </select>
          </div>
          <div class="col-12 mb-1">
            <label for="no_hp">No. HP</label>
            <input type="number" class="form-control form-control-sm" id="no_hp" name="no_hp" placeholder="No. hp user baru">
          </div>
          <div class="col-12 mb-1">
            <div class="form-check">
              <input class="form-check-input form-check-input-sm" type="checkbox" name="aktif" id="aktif">
              <label class="form-check-label form-check-label-sm" for="aktif">
                Aktif
              </label>
            </div>
          </div>
          <div class="mb-1"></div>
        </div>
        <div class="separator"></div>
        <div class="body text-end">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
        </div>
      </div>
    </form>
  </div>
</div>

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
    placeholder: '-- Pilih Unit Kerja --',
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

  $('#add_user').validate($.extend({
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
      password: {
        required: true,
        minlength: 3,
        maxlength: 12
      },
      nama_lengkap: {
        required: true
      },
      kewenangan: {
        required: true
      },
      kode_ukerja: {
        required: true
      },
      no_hp: {
        maxlength: 20
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
    messages: {},
  }));
</script>