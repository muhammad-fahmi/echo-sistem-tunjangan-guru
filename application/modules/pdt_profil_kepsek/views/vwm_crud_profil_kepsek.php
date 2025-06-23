<script>
  // GLOBAL MODAL TYPE SCRIPT
  function init_select2(d_element_selector, d_placeholder, d_url) {
    $('' + d_element_selector).select2({
      allowClear: false,
      placeholder: d_placeholder,
      ajax: {
        type: 'POST',
        dataType: 'json',
        url: d_url,
        delay: 800,
        /* delay before sending ajax request */
        data: function(params) {
          return {
            search: params.term,
          }
        },
        processResults: function(data) {
          return {
            results: data
          };
        },
      }
    });
  }
</script>
<?php
$cur_kewenangan = $this->session->userdata('kewenangan');
$cur_unor = $this->session->userdata('kode_unor');
switch ($type) {
  case 'add': {
?>
      <form id="form_add_usulan_profil_kepsek" action="<?= site_url('pdt_profil_kepsek/save') ?>" method="POST">
        <input type="hidden" name="type" value="<?= $type ?>">

        <div class="modal-header d-flex align-items-center">
          <div>
            <h3 class="mb-0"><?= $modal_title ?></h3>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-2">

            <div class="col-12">
              <label for="nip_select2">NIP / Nama</label>
              <select name="nip" id="nip_select2" class="form-select form-select-sm nip_select2"></select>
            </div>

            <?php
            // kalau yang login super admin bisa milih kode ukerja pake select2
            if ($cur_kewenangan == '00') {
            ?>
              <div class="col-12">
                <label for="kode_ukerja">Unit Kerja</label>
                <select name="kode_ukerja" id="kode_ukerja" class="form-select form-select-sm select2_ukerja"></select>
              </div>
            <?php
            } else {
              // kalau yang login admin disdik / upt, fixed kode ukerja dari login session
            ?>
              <input type="hidden" name="kode_ukerja" id="kode_ukerja" value="<?= $cur_unor ?>">
            <?php
            }
            ?>

            <div class="col-6">
              <?php
              $array_bulan = array_periode_bulan();
              ?>
              <label for="periode_bln">Periode (Bulan)</label>
              <select name="periode_bulan" id="periode_bulan" class="form-select form-select-sm">
                <option value="" default>- Bulan -</option>
                <?php
                foreach ($array_bulan as $key => $value) {
                  $selected = (em_date('m') == $key) ? 'selected default' : '';
                  echo '<option value="' .  $key . '" ' . $selected . '>' . $value . '</option>';
                }
                ?>
              </select>
            </div>

            <div class="col-6">
              <label for="periode_thn">Periode (Tahun)</label>
              <input name="periode_thn" id="periode_thn" type="number" step="1" min="1" class="form-control form-control-sm" placeholder="- Tahun -" value="<?= em_date('Y') ?>">
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <div class="text-end">
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-undo-alt me-1"></i>Batal</button>
            <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-save me-1"></i>Simpan</button>
          </div>
        </div>

      </form>
      <script>
        // ADD TYPE SCRIPT
        $(document).ready(function() {
          init_select2('#nip_select2', 'Cari NIP / Nama...', '<?= site_url('config/select2_pegawai') ?>');
          init_select2('#kode_ukerja', 'Pilih Kode Unit Kerja...', '<?= site_url('config/select2_instansi') ?>');

          $('#form_add_usulan_profil_kepsek').validate($.extend({
            submitHandler: function(form, event) {
              var submit = $('[type="submit"]');
              submit.attr('disabled', true);
              $(form).ajaxSubmit({
                success: function(e) {
                  if (e.status) {
                    show_notify('success', e.message);
                    setTimeout(() => {
                      // window href template
                      // window.location.href = '<?= base_url('url_to_redirect') ?>';
                      // modal dismiss
                      // $('#modal_whole_id').modal('hide');
                      // if using datatable, refresh it's state
                      // reload_table();
                    }, 500);
                  } else {
                    show_notify('error', e.message);
                    submit.attr('disabled', false);
                  }
                },
                error: function(xhr, status, error) {
                  show_notify('error', xhr.status + ' : ' + error);
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
            messages: {
              input_name_rules: {
                required: "custom_error_message",
              }
            },
          }));
        });
      </script>
    <?php
      break;
    }

  case 'edit': {
    ?>
      <div class="modal-header d-flex align-items-center">
        <div>
          <h3 class="mb-0"><?= $modal_title ?></h3>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"></div>
      <script>
        // EDIT TYPE SCRIPT
      </script>
    <?php
      break;
    }

  case 'update': {
    ?>
      <div class="modal-header d-flex align-items-center">
        <div>
          <h3 class="mb-0"><?= $modal_title ?></h3>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"></div>
      <script>
        // UPDATE TYPE SCRIPT
      </script>
    <?php
      break;
    }

  case 'delete': {
    ?>
      <div class="modal-header d-flex align-items-center">
        <div>
          <h3 class="mb-0"><?= $modal_title ?></h3>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"></div>
      <script>
        // DELETE TYPE SCRIPT
      </script>
    <?php
      break;
    }

  default: {
    ?>
      <div class="modal-header d-flex align-items-center">
        <div>
          <h3 class="mb-0">Invalid Modal</h3>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"></div>
<?php
      break;
    }
}
?>