<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <form id="deleteRombel" action="<?= site_url('pdt_rombongan_belajar/delete'); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" id="type" name="type" value="<?= $data['type'] ?>">
    <input type="hidden" id="id" name="id" value="<?= $data['id'] ?>">

    <div class="row g-2">

      <div class="col-12 form_mapel">
        <div class="col-12 mb-3">
          <div class="alert alert-danger m-0">
            Apakah anda yakin untuk menghapus data <b>Rombongan Belajar</b> ini?
          </div>
        </div>
        <table>
          <tr class="mb-2">
            <td style="min-width: 120px; font-weight: 500;">Sekolah</td>
            <td style="min-width: 10px;">:</td>
            <td style="width: 100%;"><?= check_var($data, 'ket_sekolah', '-') ?></td>
          </tr>
          <tr class="mb-2">
            <td style="min-width: 120px; font-weight: 500;">Jenjang</td>
            <td style="min-width: 10px;">:</td>
            <td style="width: 100%;"><?= check_var($data, 'ket_jenjang', '-') ?></td>
          </tr>
          <tr class="mb-2">
            <td style="min-width: 120px; font-weight: 500;">Kelas</td>
            <td style="min-width: 10px;">:</td>
            <td style="width: 100%;"><?= check_var($data, 'ket_kelas', '-') ?></td>
          </tr>
          <tr class="mb-2">
            <td style="min-width: 120px; font-weight: 500;">Rombel</td>
            <td style="min-width: 10px;">:</td>
            <td style="width: 100%;"><?= check_var($data, 'nama_rombel', '-') ?></td>
          </tr>
        </table>
      </div>

    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-light-secondary" data-bs-dismiss="modal">Batal</button>
  <button id="deleteRombelbtn" type="submit" form="deleteRombel" class="btn btn-sm btn-light-success">Hapus</button>
</div>

<script>
  $('#deleteRombel').validate($.extend({
    submitHandler: function(form, event) {
      var submit = $('#deleteRombelbtn');
      // declare button submit disabling right here if needed
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