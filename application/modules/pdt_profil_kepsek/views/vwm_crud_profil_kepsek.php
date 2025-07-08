<?php
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
              <div class="input_block">
                <label for="nip_select2">NIP / Nama</label>
                <select name="nip" id="nip_select2" class="form-select form-select-sm nip_select2"></select>
              </div>
            </div>

            <?php
            // kalau yang login super admin bisa milih kode ukerja pake select2
            if (is_admin()) {
            ?>
              <div class="input_block">
                <div class="col-12">
                  <label for="kode_ukerja">Sekolah</label>
                  <select name="kode_ukerja" id="kode_ukerja" class="form-select form-select-sm select2_ukerja"></select>
                </div>
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
              <div class="input_block">
                <label for="periode_bln">Periode (Bulan)</label>
                <select name="periode_bln" id="periode_bln" class="form-select">
                  <option value="" default>- Bulan -</option>
                  <?php
                  foreach ($array_bulan as $key => $value) {
                    $selected = (em_date('m') == $key) ? 'selected default' : '';
                    echo '<option value="' .  $key . '" ' . $selected . '>' . $value . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="col-6">
              <div class="input_block">
                <label for="periode_thn">Periode (Tahun)</label>
                <input name="periode_thn" id="periode_thn" type="number" step="1" min="1" class="form-control" placeholder="- Tahun -" value="<?= em_date('Y') ?>">
              </div>
            </div>

            <div class="col-12">
              <div class="input_block">
                <label for="s_aktif">Status Riwayat</label>
                <select name="s_aktif" id="s_aktif" class="form-select">
                  <option value="" default hidden>- Pilih Status Riwayat -</option>
                  <option value="1">Riwayat Terbaru (Aktif)</option>
                  <option value="0">Bukan Riwayat Terbaru (Non-Aktif)</option>
                </select>
              </div>
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
          <?php
          if (is_admin()) {
          ?>
            init_select2('#kode_ukerja', 'Pilih Sekolah...', '<?= site_url('config/select2_sekolah') ?>');
          <?php
          }
          ?>

          $('#form_add_usulan_profil_kepsek').validate($.extend({
            submitHandler: function(form, event) {
              var submit = $('[type="submit"]');
              submit.attr('disabled', true);
              $(form).ajaxSubmit({
                success: function(e) {
                  if (e.status) {
                    show_notify('success', e.message);
                    reload_r_profil_table();
                    setTimeout(() => {
                      $('#whole_modal_id').modal('hide');
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

  case 'update': {
    ?>
      <form id="form_update_usulan_profil_kepsek" action="<?= site_url('pdt_profil_kepsek/save') ?>" method="POST">
        <input type="hidden" name="id_kepsek" value="<?= $data['id_kepsek'] ?>">
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
              <div class="input_block">
                <label for="nip_select2">NIP / Nama</label>
                <div class="form-control"><?= check_var($data, 'nip', '-') . ' / ' . check_var($data, 'nama', '-') ?></div>
              </div>
            </div>

            <?php
            // kalau yang login super admin bisa milih kode ukerja pake select2
            if (is_admin()) {
            ?>
              <div class="col-12">
                <div class="input_block">
                  <label for="kode_ukerja">Sekolah</label>
                  <select name="kode_ukerja" id="kode_ukerja" class="form-select form-select-sm select2_ukerja">
                    <?php
                    if (check_var($data, 'kode_ukerja')) {
                      echo '<option value="' . $data['kode_ukerja'] . '" selected>' . $data['ket_ukerja'] . ' [' . $data['kode_ukerja'] . ']</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
            <?php
            } else {
              // kalau yang login admin disdik / upt, fixed kode ukerja dari login session
            ?>
              <input type="hidden" name="kode_ukerja" id="kode_ukerja" value="<?= $cur_unor ?>">
              <div class="form-control"><?= check_var($data, 'kode_ukerja', '...') . ' - ' . check_var($data, 'ket_ukerja', '...') ?></div>
            <?php
            }
            ?>

            <div class="col-6">
              <div class="input_block">
                <?php
                $array_bulan = array_periode_bulan();
                ?>
                <label for="periode_bln">Periode (Bulan)</label>
                <select name="periode_bln" id="periode_bln" class="form-select">
                  <option value="" default>- Bulan -</option>
                  <?php
                  foreach ($array_bulan as $key => $value) {
                    $selected = (em_date('m') == $key) ? 'selected default' : '';
                    echo '<option value="' .  $key . '" ' . $selected . '>' . $value . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="col-6">
              <div class="input_block">
                <label for="periode_thn">Periode (Tahun)</label>
                <input name="periode_thn" id="periode_thn" type="number" step="1" min="1" class="form-control" placeholder="- Tahun -" value="<?= em_date('Y') ?>">
              </div>
            </div>

            <div class="col-12">
              <div class="input_block">
                <label for="s_aktif">Status Riwayat</label>
                <select name="s_aktif" id="s_aktif" class="form-select">
                  <option value="" default hidden>- Pilih Status Riwayat -</option>
                  <option value="1">Riwayat Terbaru (Aktif)</option>
                  <option value="0">Bukan Riwayat Terbaru (Non-Aktif)</option>
                </select>
              </div>
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
        // UPDATE TYPE SCRIPT
        $(document).ready(function() {
          init_select2('#nip_select2', 'Cari NIP / Nama...', '<?= site_url('config/select2_pegawai') ?>');
          <?php
          if (is_admin()) {
          ?>
            init_select2('#kode_ukerja', 'Pilih Sekolah...', '<?= site_url('config/select2_sekolah') ?>');
          <?php
          }
          ?>

          $('#form_update_usulan_profil_kepsek').validate($.extend({
            submitHandler: function(form, event) {
              var submit = $('[type="submit"]');
              submit.attr('disabled', true);
              $(form).ajaxSubmit({
                success: function(e) {
                  if (e.status) {
                    show_notify('success', e.message);
                    reload_r_profil_table();
                    setTimeout(() => {
                      $('#whole_modal_id').modal('hide');
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

  case 'delete': {
    ?>
      <form id="form_delete_usulan_profil_kepsek" action="<?= site_url('pdt_profil_kepsek/delete') ?>" method="POST">
        <input type="hidden" name="id_dokumen" value="<?= check_var($data, 'id_dokumen', '') ?>">

        <div class="modal-header d-flex align-items-center">
          <div>
            <h3 class="mb-0"><?= $modal_title ?></h3>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-2">

            <div class="col-12">
              <div class="alert alert-danger mb-0">Apakah Anda yakin ingin menghapus dokumen usulan profil kepala sekolah ini?</div>
            </div>

            <div class="col-12">
              <table style="width: 100%;">
                <tr>
                  <td style="min-width: 150px;">Nama</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'nama', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">NIP</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'nip', '-') ?></td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">Periode</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <?= check_var($data, 'periode_bln', '-') . '/' .
                      check_var($data, 'periode_thn', '-');
                    ?>
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 150px;">Dibuat Pada</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= em_date('j F Y, H:i:s', 'set', check_var($data, 'create_on', '')) ?></td>
                </tr>
              </table>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <div class="text-end">
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-undo-alt me-1"></i>Batal</button>
            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash me-1"></i>Ya, Hapus</button>
          </div>
        </div>

      </form>
      <script>
        // DELETE TYPE SCRIPT
        $(document).ready(function() {
          $('#form_delete_usulan_profil_kepsek').validate($.extend({
            submitHandler: function(form, event) {
              var submit = $('[type="submit"]');
              submit.attr('disabled', true);
              $(form).ajaxSubmit({
                success: function(e) {
                  if (e.status) {
                    show_notify('success', e.message);
                    reload_r_profil_table();
                    setTimeout(() => {
                      $('#whole_modal_id').modal('hide');
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