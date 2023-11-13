<div class="login-container">
  <div class="row g-2">
    <div class="col-12 mb-2">
      <div class="panel text-center">
        <h6 class="mb-0">Aplikasi Manajemen Presensi</h6>
        <h3 class="mb-0">Pemerintah Kota Samarinda</h3>
      </div>
    </div>
  </div>
  <div class="row g-2">
    <div class="col-4">
      <div class="panel h img">
        <div class="container">
          <!-- <img src="https://cdn.discordapp.com/attachments/909749687492423680/915516637254385694/unknown.png" alt="map img"> -->
        </div>
      </div>
    </div>
    <div class="col-8">
      <div class="panel h text-end">
        <form id="form-login" action="<?= site_url('login/auth') ?>" method="post">
          <input type="text" name="username" class="form-control form-control-sm" placeholder="Username">
          <input type="password" name="password" class="form-control form-control-sm mt-2" placeholder="Password">
          <button type="submit" class="btn btn-sm btn-outline-warning mt-2">
            <i class="fas fa-sign-in-alt me-2"></i>Login
          </button>
        </form>
      </div>
    </div>
    <div id="msgbox-container" class="col-12 d-none">
      <div class="panel">
        <div id="msgbox" class="alert alert-success mb-0">
          TEST INFO
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('#form-login').validate($.extend({
    submitHandler: function(form, event) {
      var msgc = $('#msgbox-container');
      var msg = $('#msgbox');
      var submit = $('[type="submit"]');
      // declare button submit disabling right here if needed
      submit.attr('disabled', true);
      $(form).ajaxSubmit({
        success: function(e) {
          if (e.status) {
            // tampilkan feedback
            msgc.removeClass('d-none');
            msg.removeClass('alert-danger');
            msg.addClass('alert-success');
            msg.html(e.message);
            setTimeout(() => {
              window.location.href = '<?= site_url('mapel_guru') ?>';
            }, 2000);
          } else {
            // tampilkan feedback
            msgc.removeClass('d-none');
            msg.removeClass('alert-success');
            msg.addClass('alert-danger');
            msg.html(e.message);
            submit.attr('disabled', false);
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
        minlength: 6
      }
    },
    errorClass: 'is-invalid',
    validClass: 'is-valid',
    messages: {
      username: {
        required: "Username tidak boleh kosong!",
      },
      password: {
        required: "Password tidak boleh kosong!",
        minlength: "Password minimal 6 karakter!"
      }
    },
  }));
</script>