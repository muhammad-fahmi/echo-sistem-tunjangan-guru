<?php
if ($type == 'ganti_password') {
?>
  <form id="form_gp" action="<?= site_url('ganti_password/action'); ?>" method="POST">
    <input type="hidden" name="type" value="<?= check_var($type, null, '') ?>">
    <input type="hidden" name="id_kewenangan" value="<?= check_var($data, 'id_kewenangan', '') ?>">

    <div class="modal-header d-flex align-items-center">
      <div>
        <h3 class="mb-0"><?= $modal_title ?></h3>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
      <div class="row g-2">

        <div class="col-12">
          <div class="alert alert-danger mb-0">
            Silahkan masukkan password lama (1 kali) dan password baru (2 kali) untuk konfirmasi proses penggantian password. Apabila proses penggantian password berhasil Anda akan keluar dari aplikasi secara otomatis dan diminta untuk login ulang dengan password baru.
          </div>
        </div>

        <div class="col-12">
          <div class="input_block">
            <label for="password_old">Password lama</label>
            <input type="password" class="form-control" id="password_old" name="password_old" placeholder="Karakter atau Angka">
          </div>
        </div>

        <div class="col-12">
          <div class="input_block">
            <label for="password_new">Password baru</label>
            <input type="password" class="form-control" id="password_new" name="password_new" placeholder="Karakter atau Angka">
          </div>
        </div>

        <div class="col-12">
          <div class="input_block">
            <label for="password_new2">Konfirmasi password baru</label>
            <input type="password" class="form-control" id="password_new2" name="password_new2" placeholder="Karakter atau Angka">
          </div>
        </div>

      </div>
      <!-- end of row -->
    </div>
    <!-- end of modal-body -->

    <div class="modal-footer text-end">
      <button type="submit" class="btn btn-success">
        <i class="fas fa-key me-1"></i>
        Ganti Password
      </button>
    </div>

  </form>

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
<?php
} elseif ($type = "upload_gambar") {
?>
  <form id="form_upload_gambar" action="<?= site_url('pdt_profile/upload_image'); ?>" method="POST">
    <input type="hidden" name="type" value="<?= check_var($type, null, '') ?>">

    <div class="modal-header d-flex align-items-center">
      <div>
        <h3 class="mb-0"><?= $modal_title ?></h3>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
      <div class="row g-2">

        <div class="col-12">
          <div class="alert alert-primary mb-0">
            Silahkan Pilih Gambar yang akan di-upload sebagai Profile Image
          </div>
        </div>

        <div class="col-12 text-center d-flex justify-content-center align-items-center">
          <?php
          $profile_img = check_var($data, 'profile_img', false);
          $url_profile_img = ($profile_img) ? site_url('pdt_profile/image') : '';
          ?>
          <div style="position: relative;">
            <div class="profil_img_container">
              <img id="modal_profile_img" src="<?= $url_profile_img ?>" onerror="this.onerror=null; this.src='<?= base_url('theme/assets/images/logo/logo_tut_wuri_handayani.png') ?>';" alt="ALT_Description">
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="input_block">
            <label for="file">File Gambar <span class="ms-1"><sub><i>JPG/JPEG/PNG/WEBP</i></sub></span></label>
            <input type="file" class="form-control" id="file" name="file" placeholder="File Gambar">
          </div>
        </div>

      </div>
      <!-- end of row -->
    </div>
    <!-- end of modal-body -->

    <div class="modal-footer text-end">
      <button id="btn_submit_gambar" type="submit" class="btn btn-success">
        <i class="fas fa-upload me-1"></i>
        Upload Gambar
      </button>
    </div>

  </form>

  <script>
    $('#file').on('change', function(e) {
      const file = e.target.files[0];
      if (!file) return;

      const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
      if ($.inArray(file.type, validTypes) === -1) {
        alert('Format gambar tidak didukung. Hanya JPG, JPEG, PNG, dan WEBP yang diperbolehkan.');
        $(this).val(''); // Reset input
        return;
      }

      const reader = new FileReader();
      reader.onload = function(e) {
        $('#modal_profile_img').attr('src', e.target.result);
      };
      reader.readAsDataURL(file);
    });

    $('#form_upload_gambar').validate($.extend({
      submitHandler: function(form, event) {
        // declare element that will be affected
        // by every state of the form submission
        // right here
        var submit = $('#btn_submit_gambar');
        // declare button submit disabling right here if needed
        submit.attr('disabled', true);
        $(form).ajaxSubmit({
          success: function(e) {
            if (e.status) {
              // what to do when the response status = true
              show_notify('success', e.message);
              $('#profile_img').attr('src', '<?= site_url('pdt_profile/image/') ?>' + e.filename);
              $('#sidebar_profile_img').attr('src', '<?= site_url('pdt_profile/image/') ?>' + e.filename);
              setTimeout(() => {
                $('#whole_modal_id').modal('hide');
              }, 500);
            } else {
              // what to do when the response status = false
              show_notify('error', e.message);
              submit.attr('disabled', false);
            }
          },
          dataType: 'json'
        });
      },
      rules: {},
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
<?php
} else {
?>
  <form id="form_update_profile" action="<?= site_url('pdt_profile/save'); ?>" method="POST">
    <input type="hidden" name="type" value="<?= check_var($type, null, '') ?>">
    <input type="hidden" name="id_user" value="<?= check_var($data, 'id_user', '') ?>">

    <div class="modal-header d-flex align-items-center">
      <div>
        <h3 class="mb-0"><?= $modal_title ?></h3>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
      <div class="row g-2">

        <div class="col-12">
          <div class="desc_block">
            <label>Username</label>
            <div><?= check_var($data, 'id_user', '-') ?></div>
          </div>
        </div>

        <div class="col-12">
          <div class="desc_block">
            <label for="ket_kewenangan">Kewenangan</label>
            <div><?= check_var($data, 'ket_kewenangan', '') ?></div>
          </div>
        </div>

        <div class="col-12">
          <div class="input_block">
            <label for="username">Nama / Instansi</label>
            <input type="text" name="username" class="form-control" value="<?= check_var($data, 'username', '') ?>" placeholder="Masukkan nama / instansi">
          </div>
        </div>

        <div class="col-12">
          <div class="input_block">
            <label for="email_user">E-mail</label>
            <input type="text" name="email_user" class="form-control" value="<?= check_var($data, 'email_user', '') ?>" placeholder="(contoh: progurinda@gmail.com)">
          </div>
        </div>

        <div class="col-12">
          <div class="input_block">
            <label for="no_hp">No. HP</label>
            <input type="text" name="no_hp" class="form-control" value="<?= check_var($data, 'no_hp', '') ?>" placeholder="(Angka)">
          </div>
        </div>

      </div>
      <!-- end of row -->
    </div>
    <!-- end of modal-body -->

    <div class="modal-footer text-end">
      <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="fas fa-undo-alt me-1"></i>Batal</button>
      <button id="btn_submit_delete_kewenangan" type="submit" class="btn btn-sm btn-success"><i class="fas fa-edit me-1"></i>Update</button>
    </div>

  </form>

  <script>
    $('#form_update_profile').validate($.extend({
      submitHandler: function(form, event) {
        // declare element that will be affected
        // by every state of the form submission
        // right here
        var submit = $('#btn_submit_delete_kewenangan');
        // declare button submit disabling right here if needed
        submit.attr('disabled', true);
        $(form).ajaxSubmit({
          success: function(e) {
            if (e.status) {
              // what to do when the response status = true
              show_notify('success', e.message);
              get_updated_profile();
              setTimeout(() => {
                $('#whole_modal_id').modal('hide');
              }, 500);
            } else {
              // what to do when the response status = false
              show_notify('error', e.message);
              submit.attr('disabled', false);
            }
          },
          error: function(xhr, status, error) {
            show_notify('error', error);
            console.error(error);
            submit.attr('disabled', false);
          },
          dataType: 'json'
        });
      },
      rules: {
        input_name_rules: {
          required: true
        },
      },
      errorClass: 'mv-error',
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
        input_name_rules: {
          required: "custom_error_message",
        }
      },
    }));
  </script>
<?php
}
?>