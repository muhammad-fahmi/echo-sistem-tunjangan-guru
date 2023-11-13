<div class="row g-2">
  <div class="col-12">
    <form action="<?= site_url('user/delete_user') ?>" method="POST" id="delete_user">
      <input type="hidden" name="username" value="<?= $data['username'] ?>">
      <div class="panel">
        <div class="header space-between">
          <div class="header">Delete User</div>
          <i class="fas fa-window-close float-right clickable" data-bs-dismiss="modal"></i>
        </div>
        <div class="separator"></div>
        <div class="body">
          Apakah Anda yakin ingin menghapus data User ini?
          <div class="smalltext mt-2 mb-1">
            <table>
              <tr>
                <td>Username</td>
                <td class="ps-2"><?= $data['username'] ?></td>
              </tr>
              <tr>
                <td>Nama Lengkap</td>
                <td class="ps-2"><?= $data['nama_lengkap'] ?></td>
              </tr>
              <tr>
                <td>Kewenangan</td>
                <td class="ps-2"><?= $data['kewenangan'] ?></td>
              </tr>
              <tr>
                <td>No. HP</td>
                <td class="ps-2"><?= $data['no_hp'] ?></td>
              </tr>
              <tr>
                <td>Status</td>
                <td class="ps-2"><?= $data['aktif'] ?></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="separator"></div>
        <div class="body text-end">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="ms-1 btn btn-sm btn-danger">Hapus</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  $('#delete_user').validate($.extend({
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
            // modal dismiss
            $('#my_modal').modal('hide');
            $.notify('<b><i class="fas fa-check-square me-1"></i>Sukses!</b><br>' +
              e.message, 'success');
            reload_table();
          } else {
            // what to do when the response status = false
            submit.attr('disabled', false);
            $.notify('<b><i class="fas fa-exclamation-triangle me-1"></i>Gagal!</b><br>' +
              e.message, 'error');
          }
        },
        dataType: 'json'
      });
    },
    rules: {
      username: {
        required: true
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