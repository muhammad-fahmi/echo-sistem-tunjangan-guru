<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <form id="deleteMapel" action="<?= site_url('mapel_guru/delete'); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="type" value="<?= $data['type'] ?>">
    <input type="hidden" name="type" value="<?= $data['id'] ?>">

    <div class="row g-2">

      <div class="col-12 form_mapel">
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
                <td style="min-width: 120px;">Mata Pelajaran</td>
                <td style="min-width: 10px;">:</td>
                <td style="width: 100%;"><?= $data['mapel'] ?></td>
            </tr>
        </table>
      </div>
      
    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-light-secondary" data-bs-dismiss="modal">Batal</button>
  <button id="deleteMapelbtn" type="submit" form="deleteMapel" class="btn btn-sm btn-light-success">Hapus</button>
</div>

<script>
    $('#deleteMapel').validate($.extend({
      submitHandler: function(form, event) {
        // declare element that will be affected
        // by every state of the form submission
        // right here
        var submit = $('#deleteMapelbtn');
        // declare button submit disabling right here if needed
        submit.attr('disabled', true);
        $(form).ajaxSubmit({
          success: function(e) {
            if (e.status) {
              // what to do when the response status = true
              setTimeout(() => {
                // window href template
                // window.location.href = '<?= site_url('url_to_visit_on_success') ?>';
                // modal dismiss
                $('#modal_whole_id').modal('hide');
                // if using datatable, refresh it's state
                reload_table();
                // $.notify('<b><i class="fas fa-check-square me-1"></i>Sukses!</b><br>' + e.message, 'success');
              }, 1000);
            } else {
              // what to do when the response status = false
              // $.notify('<b><i class="fas fa-warning me-1"></i>Gagal!</b><br>' + e.message, 'error');
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