<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <form id="deleteTgsTambahan" action="<?= site_url('tugas_tambahan/delete'); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="type" value="<?= $data['type'] ?>">
    <input type="hidden" name="id" value="<?= $data['id'] ?>">

    <div class="row g-2">

      <div class="col-12 form_mapel">
        <div class="mb-3">
          Apakah anda yakin untuk menghapus data ini?
        </div>
        <table>
            <tr>
              <td style="min-width: 120px;">NIP</td>
              <td style="min-width: 10px;">:</td>
              <td style="width: 100%;"><?= $data['nip'] ?></td>
            </tr>
            <tr>
              <td style="min-width: 120px;">Nama Lengkap</td>
              <td style="min-width: 10px;">:</td>
              <td style="width: 100%;"><?= $data['nama_lengkap'] ?></td>
            </tr>
            <tr>
              <td style="min-width: 120px;">Jabatan</td>
              <td style="min-width: 10px;">:</td>
              <td style="width: 100%;"><?= $data['ket_jab'] ?></td>
            </tr>
            <tr>
              <td style="min-width: 120px;">Unit Kerja</td>
              <td style="min-width: 10px;">:</td>
              <td style="width: 100%;"><?= $data['ket_ukerja'] ?></td>
            </tr>
            <tr>
              <td style="min-width: 120px;">Tugas Tambahan</td>
              <td style="min-width: 10px;">:</td>
              <td style="width: 100%;"><?= $data['kode_tgs_tambahan'] ?></td>
            </tr>
            <tr>
              <td style="min-width: 120px;">Tgl Mulai Tugas Tambahan</td>
              <td style="min-width: 10px;">:</td>
              <td style="width: 100%;"><?= $data['tmt_mulai'] ?></td>
            </tr>
            <tr>
              <td style="min-width: 120px;">Tgl Selesai Tugas Tambahan</td>
              <td style="min-width: 10px;">:</td>
              <td style="width: 100%;"><?= $data['tmt_selesai'] ?></td>
            </tr>
        </table>
      </div>
      
    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-light-secondary" data-bs-dismiss="modal">Batal</button>
  <button id="deleteTgsTambahanbtn" type="submit" form="deleteTgsTambahan" class="btn btn-sm btn-light-success">Hapus</button>
</div>

<script>
  $('#deleteTgsTambahan').validate($.extend({
    submitHandler: function(form, event) {
      var submit = $('#deleteTgsTambahanbtn');
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