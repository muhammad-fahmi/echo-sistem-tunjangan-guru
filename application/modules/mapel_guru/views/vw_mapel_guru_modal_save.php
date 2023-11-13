<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <form id="saveSSH" action="<?= site_url('usul_ssh/save'); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="type" value="<?= $data['type'] ?>">

    <div class="row g-2">

      <div class="col-4 form_ssh">
        <label for="i_tahun">Tahun</label>
        <?php
        $tahun_anggaran = $this->session->userdata('tahun_anggaran');
        if (isset_nn_nes($tahun_anggaran)) {
        ?>
          <input type="hidden" name="tahun" value="<?= $tahun_anggaran ?>">
          <div id="i_tahun" class="form-control form-control-sm"><?= $tahun_anggaran ?></div>
        <?php
        } else {
        ?>
          <select name="tahun" id="i_tahun" class="form-select form-select-sm">
            <option value="2023">2022</option>
            <option value="2023" default selected>2023</option>
            <option value="2023">2024</option>
          </select>
        <?php
        }
        ?>
      </div>

      <div class="col-8 form_ssh">
        <label for="i_kode_standar">Kode Standar</label>
        <input type="text" name="kode_standar" id="i_kode_standar" class="form-control form-control-sm" value="<?= $data['kode_standar'] ?>">
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 col-lg-6 form_ssh">
        <label for="i_uraian_standar">Uraian Standar</label>
        <input type="text" name="uraian_standar" id="i_uraian_standar" class="form-control form-control-sm" value="<?= $data['uraian_standar'] ?>">
      </div>

      <div class="col-12 col-lg-6 form_ssh">
        <label for="i_spesifikasi_standar">Spesifikasi Standar</label>
        <input type="text" name="spesifikasi_standar" id="i_spesifikasi_standar" class="form-control form-control-sm" value="<?= $data['spesifikasi_standar'] ?>">
      </div>

      <div class="col-12 col-lg-6 form_ssh">
        <label for="i_volume_standar">Volume Standar</label>
        <?php
        if ($select_volume != '') {
        ?>
          <select name="volume_standar" id="i_volume_standar" class="form-select form-select-sm">
            <?php
            foreach ($select_volume as $value) {
              $selected = ($value['volume_standar'] == $data['volume_standar']) ? 'default selected' : '';
              echo '<option value="' . $value['volume_standar'] . '" ' . $selected . '>' . strtoupper($value['volume_standar']) . '</option>';
            }
            ?>
          </select>
        <?php
        } else {
        ?>
          <input type="text" name="volume_standar" id="i_volume_standar" class="form-control form-control-sm" value="<?= $data['volume_standar'] ?>">
        <?php
        }
        ?>
      </div>

      <div class="col-12 col-lg-6 form_ssh">
        <label for="i_harga_standar">Harga Standar</label>
        <input type="text" name="harga_standar" id="i_harga_standar" class="form-control form-control-sm" value="<?= $data['harga_standar'] ?>">
      </div>

      <div class="col-12 col-lg-6 form_ssh">
        <label for="i_pdn_standar">PDN Standar</label>
        <input type="text" name="pdn_standar" id="i_pdn_standar" class="form-control form-control-sm" value="<?= $data['pdn_standar'] ?>">
      </div>

      <div class="col-12 col-lg-6 form_ssh">
        <label for="i_jenis_standar">Jenis Standar</label>
        <select name="jenis_standar" id="i_jenis_standar" class="form-select form-select-sm">
          <option value="SSH" default selected>SSH</option>
          <option value="SBU">SBU</option>
          <option value="HSPK">HSPK</option>
          <option value="ASB">ASB</option>
        </select>
      </div>

    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-light-secondary" data-bs-dismiss="modal">Batal</button>
  <button id="saveSSHbtn" type="submit" form="saveSSH" class="btn btn-sm btn-light-success">Simpan</button>
</div>

<script>
  $('#saveSSH').validate($.extend({
    submitHandler: function(form, event) {
      // declare element that will be affected
      // by every state of the form submission
      // right here
      var submit = $('#saveSSHbtn');
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
    rules: {
      kode_standar: {
        required: true
      },
      uraian_standar: {
        required: true
      },
      spesifikasi_standar: {
        required: true
      },
      volume_standar: {
        required: true
      },
      harga_standar: {
        required: true,
        number: true
      },
      pdn_standar: {
        required: true,
        number: true
      },
      jenis_standar: {
        required: true
      },
    },
    errorClass: 'is-invalid',
    validClass: 'mv-valid',
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