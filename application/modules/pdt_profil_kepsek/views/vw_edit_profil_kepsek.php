<?php
$cur_kewenangan = $this->session->userdata('kewenangan');
?>
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Edit Dokumen</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?= site_url('pdt_profil_kepsek') ?>">Update Profil Kepala Sekolah</a>
      </li>
      <li class="breadcrumb-item active">Edit Dokumen</li>
    </ol>
  </div>
</div>

<div class="container-fluid">

  <div class="row">

    <?php
    $show_debug = false;
    if ($show_debug) {
    ?>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">DATA (DEBUG)</h4>
            <small>
              <?php highlight_string("<?php\nSESSION = " . var_export($this->session->userdata(), true) . ";\n\n?>"); ?>
              <?php highlight_string("<?php\nDATA = " . var_export($data, true) . ";\n\n?>"); ?>
            </small>
          </div>
        </div>
      </div>
    <?php
    }
    ?>

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title space-between">
            <div><i class="fas fa-file me-2"></i>Data Dokumen</div>
            <div></div>
          </h4>
          <div>

            <div class="row g-1">

              <table style="width: 100%;" class="table table-hover mb-1">
                <tr>
                  <td style="min-width: 150px;">Periode</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= check_var($data, 'periode_bln', '-') . '/' . check_var($data, 'periode_thn', '-')  ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Dibuat Pada</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;"><?= em_date('j F Y, H:i:s', 'set', check_var($data, 'create_on', '')) ?></td>
                </tr>

                <tr>
                  <td style="min-width: 150px;">Status Dokumen</td>
                  <td style="min-width: 15px; text-align: center;">:</td>
                  <td style="width: 100%;">
                    <?php
                    $ket_status = check_var($data, 'ket_status_dokumen', '-');
                    $col_status = check_var($data, 'col_status_dokumen', 'secondary');
                    echo '<span class="badge bg-' . $col_status . '">' . $ket_status . '</span>';
                    ?>
                  </td>
                </tr>

              </table>

            </div>

          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <form id="form_edit_profil_kepsek" action="<?= site_url('pdt_profil_kepsek/edit') ?>" method="POST">
        <input type="hidden" name="id_dokumen" value="<?= check_var($data, 'id_dokumen', '') ?>">
        <input type="hidden" name="nip" value="<?= check_var($data, 'nip', '') ?>">

        <div class="card">
          <div class="card-body">
            <h4 class="card-title space-between mb-3">
              <div><i class="fas fa-user me-2"></i>Profil Kepala Sekolah</div>
              <div></div>
            </h4>

            <div class="row g-2">
              <div class="col-12 col-lg-3 col-xl-1">
                <div class="img_profil_md">
                  <img src="http://36.66.236.83/simpeg/foto/<?= check_var($data, 'nip', '0000') ?>.jpg" onerror="this.onerror=null; this.src='<?= base_url('theme/assets/images/default-profile.jpg') ?>';" alt="ALT_Description">
                </div>
              </div>

              <div class="col-12 col-lg-9 col-xl-11">
                <div class="row g-2">

                  <div class="col-12">
                    <div class="desc_block">
                      <label>Sekolah / Unit Kerja</label>
                      <div><?= check_var($data, 'ket_ukerja', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label>NIP</label>
                      <div><?= check_var($data, 'nip', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label>Status</label>
                      <div><?= check_var($data, 'ket_status', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label>Nama</label>
                      <div><?= check_var($data, 'nama', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label>Tgl. Lahir</label>
                      <div><?= em_date('j F Y', 'set', check_var($data, 'tgl_lahir', '')) ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label>Jenis Kelamin</label>
                      <div>
                        <?php
                        $jkelamin = check_var($data, 'jenis_kelamin', '');
                        if ($jkelamin == 'P') {
                          echo 'Perempuan';
                        } elseif ($jkelamin == 'L') {
                          echo 'Laki-Laki';
                        } else {
                          echo '-';
                        }
                        ?>
                      </div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label>Agama</label>
                      <div><?= check_var($data, 'ket_agama', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label>Status Pernikahan</label>
                      <div><?= check_var($data, 'ket_status_pernikahan', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="desc_block">
                      <label>Pendidikan</label>
                      <div><?= check_var($data, 'kode_didik', '-') . ' / ' . check_var($data, 'pendidikan', '-') ?></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="alamat_saat_ini">Alamat saat ini</label>
                      <textarea type="text" class="form-control form-input-bg" id="alamat_saat_ini" name="alamat_saat_ini" rows="3"><?= check_var($data, "alamat_saat_ini", '') ?></textarea>
                      <div class="invalid-feedback" id="error_alamat_saat_ini"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="nuptr">NUPTR</label>
                      <input type="text" class="form-control form-input-bg" id="nuptr" name="nuptr" value="<?= check_var($data, "nuptr", '') ?>" />
                      <div class="invalid-feedback" id="error_nuptr"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="nurs">NURS</label>
                      <input type="text" class="form-control form-input-bg" id="nurs" name="nurs" value="<?= check_var($data, "nurs", '') ?>" />
                      <div class="invalid-feedback" id="error_nurs"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="nrg">NRG</label>
                      <input type="text" class="form-control form-input-bg" id="nrg" name="nrg" value="<?= check_var($data, "nrg", '') ?>" />
                      <div class="invalid-feedback" id="error_nrg"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="nik">NIK</label>
                      <input type="text" class="form-control form-input-bg" id="nik" name="nik" value="<?= check_var($data, "nik", '') ?>" />
                      <div class="invalid-feedback" id="error_nik"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="no_sertifikat_pendidik">No. Sertifikat Pendidik</label>
                      <input type="text" class="form-control form-input-bg" id="no_sertifikat_pendidik" name="no_sertifikat_pendidik" value="<?= check_var($data, "no_sertifikat_pendidik", '') ?>" />
                      <div class="invalid-feedback" id="error_no_sertifikat_pendidik"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="no_sertifikat_gp">No. Sertifikat GP</label>
                      <input type="text" class="form-control form-input-bg" id="no_sertifikat_gp" name="no_sertifikat_gp" value="<?= check_var($data, "no_sertifikat_gp", '') ?>" />
                      <div class="invalid-feedback" id="error_no_sertifikat_gp"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="no_sertifikat_crs">No. Sertifikat CRS</label>
                      <input type="text" class="form-control form-input-bg" id="no_sertifikat_crs" name="no_sertifikat_crs" value="<?= check_var($data, "no_sertifikat_crs", '') ?>" />
                      <div class="invalid-feedback" id="error_no_sertifikat_crs"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="no_rek_bank">No. Rekening Bank</label>
                      <input type="text" class="form-control form-input-bg" id="no_rek_bank" name="no_rek_bank" value="<?= check_var($data, "no_rek_bank", '') ?>" />
                      <div class="invalid-feedback" id="error_no_rek_bank"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="npwp">NPWP</label>
                      <input type="text" class="form-control form-input-bg" id="npwp" name="npwp" value="<?= check_var($data, "npwp", '') ?>" />
                      <div class="invalid-feedback" id="error_npwp"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <?php
                    $mttpi = (check_var($data, 'menerima_ttp_insentif', '-'));
                    ?>
                    <div class="input_block">
                      <label for="menerima_ttp_insentif">Menerima TTP Insentif</label>
                      <select name="menerima_ttp_insentif" id="menerima_ttp_insentif" class="form-select">
                        <option value="" default hidden>- Pilih Status TTP Insentif -</option>
                        <option value="Y" <?= ($mttpi == 'Y') ? 'selected' : '' ?>>Ya, Menerima TTP Insentif</option>
                        <option value="N" <?= ($mttpi == 'N') ? 'selected' : '' ?>>Tidak Menerima TTP Insentif</option>
                      </select>
                      <div class="invalid-feedback" id="error_menerima_ttp_insentif"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="email">E-mail</label>
                      <input type="text" class="form-control form-input-bg" id="email" name="email" value="<?= check_var($data, "email", '') ?>" />
                      <div class="invalid-feedback" id="error_email"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="no_hp">No. HP</label>
                      <input type="text" class="form-control form-input-bg" id="no_hp" name="no_hp" value="<?= check_var($data, "no_hp", '') ?>" />
                      <div class="invalid-feedback" id="error_no_hp"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="periode_ke">Periode Ke</label>
                      <input type="text" class="form-control form-input-bg" id="periode_ke" name="periode_ke" value="<?= check_var($data, "periode_ke", '') ?>" />
                      <div class="invalid-feedback" id="error_periode_ke"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="masa_penugasan_mulai">Masa / Tgl. Penugasan (Mulai)</label>
                      <input type="text" class="form-control form-input-bg flatpickr" id="masa_penugasan_mulai" name="masa_penugasan_mulai" value="<?= check_var($data, "masa_penugasan_mulai", '') ?>" />
                      <div class="invalid-feedback" id="error_masa_penugasan_mulai"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="masa_penugasan_selesai">Masa / Tgl. Penugasan (Selesai)</label>
                      <input type="text" class="form-control form-input-bg flatpickr" id="masa_penugasan_selesai" name="masa_penugasan_selesai" value="<?= check_var($data, "masa_penugasan_selesai", '') ?>" />
                      <div class="invalid-feedback" id="error_masa_penugasan_selesai"></div>
                    </div>
                  </div>

                  <div class="col-12">
                    <div class="input_block">
                      <label for="s_aktif">Status Riwayat</label>
                      <select name="s_aktif" id="s_aktif" class="form-select">
                        <option value="" default hidden>- Pilih Status Riwayat -</option>
                        <option value="1" <?= (check_var($data, 's_aktif', null) == '1') ? 'selected' : '' ?>>Riwayat Terbaru (Aktif)</option>
                        <option value="0" <?= (check_var($data, 's_aktif', null) == '0') ? 'selected' : '' ?>>Bukan Riwayat Terbaru (Non-Aktif)</option>
                      </select>
                      <div class="invalid-feedback" id="error_s_aktif"></div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="col-12 text-end">
                <button type="button" class="form_action_button btn btn-info ms-2" onclick="save_draft()"><i class="fas fa-save me-2"></i>Simpan Draft</button>
                <button type="button" class="form_action_button btn btn-success ms-2" onclick="submit_draft()"><i class="fas fa-paper-plane me-2"></i>Submit Draft</button>
              </div>

            </div>

          </div>
        </div>

      </form>
    </div>

  </div>

</div>

<script>
  function modal(d_action, d_id) {
    var url = "<?= site_url('pdt_profil_kepsek/modal') ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {
        action: d_action,
        id: d_id
      },
      success: function(res) {
        if (res.status) {
          $("#modal_content_id").html(res.html).show();
          $("#whole_modal_id").modal("show");
        } else {
          show_notify('error', res.message);
        }
      },
      error: function(xhr, status, error) {
        show_notify('error', xhr.status + ' : ' + error);
      }
    });
  }

  $(".flatpickr").flatpickr({
    enableTime: false,
    altFormat: "j M Y",
    altInput: true,
    dateFormat: "Y-m-d",
    disableMobile: true,
    locale: {
      firstDayOfWeek: 1,
      weekdays: {
        shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
        longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
      },
      months: {
        shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
      }
    }
  });

  var form_action_url = '<?= site_url('pdt_profil_kepsek/edit_draft') ?>';

  function save_draft() {
    form_action_url = '<?= site_url('pdt_profil_kepsek/edit_draft') ?>';
    $('#form_edit_profil_kepsek').submit();
  }

  function submit_draft() {
    form_action_url = '<?= site_url('pdt_profil_kepsek/submit_draft') ?>';
    $('#form_edit_profil_kepsek').submit();
  }

  $(document).ready(function() {
    $('#form_edit_profil_kepsek').on('keydown', function(e) {
      if (e.key === 'Enter') {
        // prevent Enter key from triggering form submission
        if (e.target.tagName !== 'TEXTAREA') {
          e.preventDefault();
          return false;
        }
      }
    });

    // do something on document ready
    $('#form_edit_profil_kepsek').validate($.extend({
      submitHandler: function(form, event) {
        // declare element that will be affected
        // by every state of the form submission
        // right here
        let submit = $('.form_action_button');

        // declare button submit disabling right here if needed
        submit.attr('disabled', true);

        // change url based on which button pressed
        $(form).attr('action', form_action_url);

        $(form).ajaxSubmit({
          success: function(e) {
            if (e.status) {
              // what to do when the response status = true
              show_notify('success', e.message);
              setTimeout(() => {
                window.location.href = '<?= site_url('pdt_profil_kepsek') ?>/' + e.redirect + '/<?= $data['id_dokumen'] ?>';
              }, 2000);
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
  });
</script>