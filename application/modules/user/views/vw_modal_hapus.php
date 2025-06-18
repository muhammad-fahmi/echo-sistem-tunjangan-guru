<?php
$style_col = 'style="font-size: 12px; font-weight: bold; min-width: 180px;"';
$style_val = 'style="width: 100%;"';

$ket_kewenangan = '';
switch ($data['kewenangan']) {
  case '00':
    $ket_kewenangan = 'Super Admin';
    break;

  case '01':
    $ket_kewenangan = 'Administrator';
    break;

  default:
    $ket_kewenangan = 'Admin OPD / Unit Kerja';
    break;
}
?>

<form action="<?= site_url('user/delete_user') ?>" method="POST" id="delete_user">
  <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">

  <div class="modal-header d-flex align-items-center">
    <div>
      <h3 class="mb-0">Delete Data User</h3>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>

  <div class="modal-body">
    Apakah Anda yakin ingin menghapus data User ini?
    <div class="smalltext mt-2 mb-1">
      <table class="table table-sm table-hover">
        <tr>
          <td <?= $style_col ?>>Username</td>
          <td <?= $style_val ?> class="ps-2"><?= $data['id_user'] ?></td>
        </tr>
        <tr>
          <td <?= $style_col ?>>Nama User /<br>Nama Unit Kerja</td>
          <td class="ps-2"><?= $data['username'] ?></td>
        </tr>
        <tr>
          <td <?= $style_col ?>>Kewenangan</td>
          <td <?= $style_val ?> class="ps-2"><?= $ket_kewenangan ?></td>
        </tr>
        <tr>
          <td <?= $style_col ?>>Unit Kerja</td>
          <td <?= $style_val ?> class="ps-2"><?= isset_nn_nes($data['ket_ukerja'], '-') ?></td>
        </tr>
        <tr>
          <td <?= $style_col ?>>E-mail</td>
          <td <?= $style_val ?> class="ps-2"><?= $data['email_user'] ?></td>
        </tr>
        <tr>
          <td <?= $style_col ?>>Status</td>
          <td <?= $style_val ?> class="ps-2"><?= ($data['aktif'] == 'Y') ? '<span class="badge bg-success mx-1">AKTIF</span>' : '<span class="badge bg-danger mx-1">NON-AKTIF</span>' ?></td>
        </tr>
      </table>
    </div>
  </div>

  <div class="modal-footer text-end">
    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
    <button type="submit" class="ms-1 btn btn-sm btn-danger">Hapus</button>
  </div>

</form>

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