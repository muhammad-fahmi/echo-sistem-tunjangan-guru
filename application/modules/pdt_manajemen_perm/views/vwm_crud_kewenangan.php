<?php
if ($type == 'add' || $type == 'edit') {
?>
  <form id="form_save_kewenangan" action="<?= site_url('pdt_manajemen_perm/save_kewenangan'); ?>" method="POST">
    <input type="hidden" name="type" value="<?= $type ?>">
    <div class="modal-header d-flex align-items-center">
      <div>
        <h3 class="mb-0"><?= $modal_title ?></h3>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
      <div class="row g-2">

        <?php
        if ($type == 'add') {
        ?>
          <div class="col-12">
            <div class="input_block">
              <label for="id_kewenangan">ID Kewenangan</label>
              <input type="text" id="id_kewenangan" name="id_kewenangan" class="form-control" value="<?= check_var($data, 'id_kewenangan', '') ?>" placeholder="Angka (max: 2 digit)">
              <div class="invalid-feedback" id="error_id_kewenangan"></div>
            </div>
          </div>
        <?php
        } else {
        ?>
          <div class="col-12">
            <div class="input_block">
              <label for="id_kewenangan">ID Kewenangan</label>
              <div class="form-control d-flex justify-content-between align-items-center">
                <div><?= check_var($data, 'id_kewenangan', 'INVALID ID') ?></div>
                <div class="badge bg-warning px-2 py-1"><i class="fas fa-lock me-1"></i>Locked</div>
              </div>
              <input type="hidden" id="id_kewenangan" name="id_kewenangan" value="<?= check_var($data, 'id_kewenangan', '') ?>">
              <div class="invalid-feedback" id="error_id_kewenangan"></div>
            </div>
          </div>
        <?php
        }
        ?>

        <div class="col-12">
          <div class="input_block">
            <label for="ket_kewenangan">Nama Kewenangan</label>
            <input type="text" id="ket_kewenangan" name="ket_kewenangan" class="form-control" value="<?= check_var($data, 'ket_kewenangan', '') ?>" placeholder="Nama / Keterangan dari Kewenangan">
            <div class="invalid-feedback" id="error_ket_kewenangan"></div>
          </div>
        </div>

      </div>
      <!-- end of row -->
    </div>
    <!-- end of modal-body -->

    <div class="modal-footer text-end">
      <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="fas fa-undo-alt me-1"></i>Batal</button>
      <button id="btn_submit_kewenangan" type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
    </div>

  </form>

  <script>
    $('#form_save_kewenangan').validate($.extend({
      submitHandler: function(form, event) {
        // declare element that will be affected
        // by every state of the form submission
        // right here
        let submit = $('#btn_submit_kewenangan');

        // declare button submit disabling right here if needed
        submit.attr('disabled', true);

        $(form).ajaxSubmit({
          success: function(e) {
            if (e.status) {
              // what to do when the response status = true
              show_notify('success', e.message);
              reload_m_kewenangan();
              $('#whole_modal_id').modal('hide');
            } else {
              // what to do when the response status = false
              show_notify('error', e.message);
              submit.attr('disabled', false);
              if (e.error_value) {
                $.each(e.error_value, function(field, error) {
                  const el_input = $('#' + field);
                  const wrapper = el_input.closest('.input_block');
                  const el_flatpickrInput = wrapper.find('.flatpickr');
                  const el_select2Input = wrapper.find('.select2-selection');
                  const el_select2Container = wrapper.find('.select2.select2-container');

                  // Clear old state (optional but recommended)
                  wrapper.find('.is-invalid').removeClass('is-invalid');

                  if (el_select2Input.length) {
                    el_select2Container.addClass('is-invalid');
                    el_select2Input.addClass('is-invalid');
                  } else if (el_flatpickrInput.length) {
                    el_flatpickrInput.addClass('is-invalid');
                  } else {
                    el_input.addClass('is-invalid');
                  }

                  $('#error_' + field).html(error); // Display message
                });
              }
            }
          },
          error: function(xhr, status, error) {
            show_notify('error', xhr.status + ' : ' + error);
            console.error(error);
            submit.attr('disabled', false);
          },
          dataType: 'json'
        });
      },
      rules: {
        // nuptr: {
        //   required: true
        // },
      },
      errorClass: 'is-invalid',
      validClass: 'mv-valid',
      /* if there's select2 element, please use this errorPlacement */
      errorPlacement: function(error, element) {
        const feedback = element.closest('.form-floating').find('.invalid-feedback');
        if (feedback.length) {
          feedback.text(error.text());
        }
      },
      highlight: function(element) {
        $(element).addClass('is-invalid');
      },

      unhighlight: function(element) {
        // Clear error text if valid
        $(element).removeClass('is-invalid');
        let closest = $(element).closest('.input_block');
        closest.find('input, textarea, select').removeClass('is-invalid');
        closest.find('.select2-selection').removeClass('is-invalid');
        closest.find('.select2-container').removeClass('is-invalid');

        const fieldId = $el.attr('id');
        $('#error_' + fieldId).html('');
      },
      messages: {
        // NUPTR: {
        //   required: "Username tidak boleh kosong!",
        // },
        // password: {
        //   required: "Password tidak boleh kosong!",
        //   minlength: "Password minimal 6 karakter!"
        // }
      },
    }));
  </script>
<?php
} else {
?>
  <form id="form_delete_kewenangan" action="<?= site_url('pdt_manajemen_perm/delete_kewenangan'); ?>" method="POST">
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
            Apakah Anda yakin ingin menghapus data kewenangan ini (Semua menu yang terkait dengan kewenangan ini juga akan dihapus)?
          </div>
        </div>

        <div class="col-12">
          <table class="mb-0">
            <tbody>
              <tr>
                <td style="min-width: 150px;">ID</td>
                <td style="min-width: 30px; text-align: center;">:</td>
                <td style="width: 100%;"><?= $data['id_kewenangan'] ?></td>
              </tr>
              <tr>
                <td style="min-width: 150px;">Nama</td>
                <td style="min-width: 30px; text-align: center;">:</td>
                <td style="width: 100%;"><?= $data['ket_kewenangan'] ?></td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
      <!-- end of row -->
    </div>
    <!-- end of modal-body -->

    <div class="modal-footer text-end">
      <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><i class="fas fa-undo-alt me-1"></i>Batal</button>
      <button id="btn_submit_delete_kewenangan" type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash me-1"></i>Hapus</button>
    </div>

  </form>

  <script>
    $('#form_delete_kewenangan').validate($.extend({
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
              $('#whole_modal_id').modal('hide');
              reload_m_kewenangan();
            } else {
              // what to do when the response status = false
              show_notify('error', e.message);
              submit.attr('disabled', false);
            }
          },
          error: function(xhr, status, error) {
            let error_msg = (xhr.responseJSON.message) ?
              xhr.responseJSON.message : '';
            show_notify('error', error_msg + '<br>' + xhr.status + ' : ' + error);
            submit.attr('disabled', false);
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
}
?>