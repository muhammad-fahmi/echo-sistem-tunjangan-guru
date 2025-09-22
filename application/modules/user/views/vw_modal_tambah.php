<form action="<?= site_url('user/add_user'); ?>" method="POST" id="add_user">
  <div class="modal-header d-flex align-items-center">
    <div>
      <h3 class="mb-0">Tambah Data User</h3>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>

  <div class="modal-body">
    <div class="row g-2">

      <div class="col-12 mb-1">
        <label for="username">Username</label>
        <input type="text" class="form-control form-control-sm" id="id_user" name="id_user" placeholder="Username untuk user baru">
      </div>
      <div class="col-12 mb-1">
        <label for="password">Password</label>
        <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Password untuk user baru">
      </div>
      <div class="col-12 mb-1">
        <label for="nama_lengkap">Nama User / Nama Unit Kerja</label>
        <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Nama User Baru / Nama Unit Kerja">
      </div>
      <div class="col-12 mb-1">
        <label for="kewenangan">Kewenangan</label>
        <select type="text" class="form-select form-select-sm" name="kewenangan" id="kewenangan">
          <option value="" default selected hidden>-- Pilih Kewenangan --</option>
          <option value="00">Super Admin</option>
          <option value="01">Administrator</option>
          <option value="02">Admin Disdik</option>
          <option value="10">Admin OPD / Unit Kerja</option>
        </select>
      </div>
      <div class="col-12 mb-1">
        <label for="kewenangan">Unit Kerja</label>
        <select type="text" class="form-select form-select-sm ukerja select2" name="kode_unor" id="kode_unor">
        </select>
      </div>
      <div class="col-12 mb-1">
        <label for="email_user">E-mail</label>
        <input type="text" class="form-control form-control-sm" id="email_user" name="email_user" placeholder="E-mail aktif Anda / Unit Kerja">
      </div>
      <div class="col-12 mb-1">
        <div class="form-check">
          <input class="form-check-input form-check-input-sm" type="checkbox" name="aktif" id="aktif">
          <label class="form-check-label form-check-label-sm" for="aktif">
            Aktif
          </label>
        </div>
      </div>

    </div>
    <!-- end of row -->
  </div>
  <!-- end of modal-body -->

  <div class="modal-footer text-end">
    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
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
            $('#whole_modal_id').modal('hide');
            toaster('success', e.message);
            reload_table();
          } else {
            // what to do when the response status = false
            submit.attr('disabled', false);
            toaster('danger', e.message);
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