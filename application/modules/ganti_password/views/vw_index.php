<div class="row g-2">
  <div class="col-12">
    <div class="panel">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= site_url('dashboard'); ?>">
            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
          </a>
        </li>
        <li class="breadcrumb-item active">
          <a href="#">Ganti Password</a>
        </li>
      </ol>
    </div>
  </div>
  <div class="col-12 col-md-8 col-lg-6 col-xl-5">
    <div class="panel">
      <div class="header"><?= $this->session->userdata('nama_lengkap'); ?></div>
      <div class="separator"></div>
      <div class="body">
        <form id="form_gp" action="<?= site_url('ganti_password/action'); ?>" method="POST">
          <div class="row g-2 justify-content-center">
            <div class="col-12">
              <div class="alert alert-danger mb-0">
                Silahkan masukkan password lama (1 kali) dan password baru (2 kali) untuk konfirmasi proses penggantian password. Apabila proses penggantian password berhasil Anda akan keluar dari aplikasi secara otomatis dan diminta untuk login ulang dengan password baru.
              </div>
            </div>

            <div class="col-12 col-lg-7">
              <label for="password_old">Password lama</label>
              <input type="password" class="form-control form-control-sm" id="password_old" name="password_old" placeholder="Karakter atau Angka">
            </div>

            <div class="col-12 col-lg-7">
              <label for="password_new">Password baru</label>
              <input type="password" class="form-control form-control-sm" id="password_new" name="password_new" placeholder="Karakter atau Angka">
            </div>

            <div class="col-12 col-lg-7">
              <label for="password_new2">Konfirmasi password baru</label>
              <input type="password" class="form-control form-control-sm" id="password_new2" name="password_new2" placeholder="Karakter atau Angka">
            </div>

            <div class="col-6 text-center">
              <button type="submit" class="btn btn-sm btn-success">
                <i class="fas fa-key me-1"></i>
                Ganti Password
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#form_gp').validate($.extend({
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
            $.notify('<b><i class="fas fa-check-square me-1"></i>Sukses!</b><br>' + e.message, 'success');
            setTimeout(() => {
              // window href template
              window.location.href = '<?= site_url('login') ?>';
            }, 1500);
          } else {
            // what to do when the response status = false
            $.notify('<b><i class="fas fa-exclamation-triangle me-1"></i>Gagal!</b><br>' + e.message, 'error');
            submit.attr('disabled', false);
          }
        },
        dataType: 'json'
      });
    },
    rules: {
      password_old: {
        required: true
      },
      password_new: {
        required: true
      },
      password_new2: {
        required: true,
        equalTo: '#password_new'
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