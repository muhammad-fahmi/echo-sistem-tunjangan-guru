<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <form id="deletePesertaDidik" action="<?= site_url('pdt_peserta_didik/delete'); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="type" value="<?= $type; ?>">
    <input type="hidden" name="id_siswa" value="<?= $data['id_siswa'] ?>">

    <div class="row g-2">

      <div class="col-12 form_mapel">
        <div class="col-12 mb-3">
          <div class="alert alert-danger m-0">
            Apakah anda yakin untuk menghapus data <b>peserta didik</b> ini?
          </div>
        </div>
        <table>
          <tr class="mb-2">
            <td style="min-width: 120px; font-weight: 500;">NISN</td>
            <td style="min-width: 10px;">:</td>
            <td style="width: 100%;"><?= check_var($data, 'nisn', '-') ?></td>
          </tr>
          <tr class="mb-2">
            <td style="min-width: 120px; font-weight: 500;">Nama Lengkap</td>
            <td style="min-width: 10px;">:</td>
            <td style="width: 100%;"><?= check_var($data, 'nama', '-') ?></td>
          </tr>
          <tr class="mb-2">
            <td style="min-width: 120px; font-weight: 500;">NIK</td>
            <td style="min-width: 10px;">:</td>
            <td style="width: 100%;"><?= check_var($data, 'nik', '-') ?></td>
          </tr>
          <tr class="mb-2">
            <td style="min-width: 120px; font-weight: 500;">Jenis Kelamin</td>
            <td style="min-width: 10px;">:</td>
            <td style="width: 100%;"><?= check_var($data, 'ket_jns_kelamin', '-') ?></td>
          </tr>
          <tr class="mb-2">
            <td style="min-width: 120px; font-weight: 500;">Agama</td>
            <td style="min-width: 10px;">:</td>
            <td style="width: 100%;"><?= check_var($data, 'ket_agama', '-') ?></td>
          </tr>
          <tr class="mb-2">
            <td style="min-width: 120px; font-weight: 500;">Nama Ibu</td>
            <td style="min-width: 10px;">:</td>
            <td style="width: 100%;"><?= check_var($data, 'nama_ibu', '-') ?></td>
          </tr>
          <tr class="mb-2">
            <td style="min-width: 120px; font-weight: 500;">No. KK</td>
            <td style="min-width: 10px;">:</td>
            <td style="width: 100%;"><?= check_var($data, 'no_kk', '-') ?></td>
          </tr>
          <tr class="mb-2">
            <td style="min-width: 120px; font-weight: 500;">Alamat</td>
            <td style="min-width: 10px;">:</td>
            <td style="width: 100%;"><?= check_var($data, 'alamat', '-') ?></td>
          </tr>
          <tr class="mb-2">
            <td style="min-width: 120px; font-weight: 500;">Penyandang Disabilitas</td>
            <td style="min-width: 10px;">:</td>
            <td style="width: 100%;"><?= check_var($data, 'ket_disabilitas', 'Tidak') ?></td>
          </tr>
        </table>
      </div>

    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-light-secondary" data-bs-dismiss="modal">Batal</button>
  <button id="deletePesertaDidikbtn" type="submit" form="deletePesertaDidik" class="btn btn-sm btn-light-success">Hapus</button>
</div>

<script>
  $('#deletePesertaDidik').validate($.extend({
    submitHandler: function(form, event) {
      var submit = $('#deletePesertaDidikbtn');
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