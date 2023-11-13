<div class="row g-2">
  <div class="col-12">
    <div class="panel">
      <div class="header space-between">
        <div><?= $modal_title ?></div>
        <i class="fas fa-window-close float right clickable" data-bs-dismiss="modal"></i>
      </div>
      <div class="separator"></div>
      <div class="body mb-2">
        <form id="savekak" action="<?= site_url('usul_kak/save'); ?>" method="POST" class="form-material mt-4" enctype="multipart/form-data">
          <input type="hidden" name="id_kak" value="<?= $data['id_kak']; ?>">
          <input type="hidden" name="kode_unor" value="<?= $data['kode_unor']; ?>">
          <div class="row g-2">
            <div class="col-12">
              <label for="program">Program</label>
              <input type="text" name="ket_program" id="ket_program" value="" class="form-control" disabled="true">
              <input type=" hidden" name="id_kegiatan_program" id="id_kegiatan_program" value="">
            </div>
            <div class="col-12">
              <label for="program">Kegiatan</label>
              <input type="text" name="ket_program" id="ket_kegiatan" value="" class="form-control" disabled="true">
              <input type="hidden" name="id_kegiatan_program" id="id_kegiatan_program" value="">
            </div>
            <div class="col-12">
              <label for="sub_kegiatan">Sub Kegiatan</label>
              <select class="form-select form-select-sm select2" name="kode_kegiatan" placeholder="Pilih sub kegiatan">
                <?php
                if ($data["kode_kegiatan"] != "") {
                  echo '<option value="' . $data['nip'] . '" default selected>' . $data['nip'] . ' - ' . $data['nama_lengkap'] . '</option>';
                } else {
                  echo '<option value="0" default selected> - - - Pilih Sub kegiatan - - -</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-6">
              <label for="tahun">Tahun</label>
              <select class="form-select select2" name="tahun" id="tahun">
                <?php for ($i = 2023; $i <= date('Y') + 1; $i++) {
                  $selected = ($i == $data["tahun"]) ? "selected" : "";
                  echo '<option value="' . $i . '"> ' . $i . '</option>';
                } ?>
              </select>
            </div>
            <div class="col-6">
              <label for="program">Tanggal Susun</label>
              <input type="text" name="tgl_susun" id="tgl_susun" value="<?= tgl_formal($data["tgl_susun"]); ?>" class="form-control">
            </div>

            <div class="col-12">
              <label for="keterangan">Deskripsi</label>
              <textarea name="deskripsi" class="form-control form-control-sm" rows="3" placeholder="Keterangan singkat tentang usul KAK ini"><?= $data['keterangan'] ?></textarea>
            </div>
            <div class="col-12">
              <label for="program">Keluaran</label>
              <input type="text" name="keluaran" id="keluaran" value="" class="form-control">
            </div>
            <div class="col-12">
              <label for="program">Indikator</label>
              <input type="text" name="keluaran" id="keluaran" value="" class="form-control">
            </div>
            <div class="col-12">
              <label for="program">Target</label>
              <input type="text" name="keluaran" id="keluaran" value="" class="form-control">
            </div>
            <div class="col-6">
              <label for="program">Volume</label>
              <input type="text" name="keluaran" id="keluaran" value="" class="form-control">
            </div>
            <div class="col-6">
              <label for="program">Satuan</label>
              <input type="text" name="keluaran" id="keluaran" value="" class="form-control">
            </div>
            <div class="col-12">
              <label for="program">Lokasi</label>
              <input type="text" name="lokasi" id="lokasi" value="" class="form-control">
            </div>
            <div class="col-12">
              <label for="program">Metode</label>
              <input type="text" name="metode" id="metode" value="" class="form-control">
            </div>
            <div class="col-12">
              <label for="sub_kegiatan">IKU</label>
              <select class="form-select form-select-sm select2" name="id_iku" placeholder="Pilih IKU">
                <?php
                if ($data["id_iku"] != "") {
                  echo '<option value="' . $data['id_iku'] . '" default selected>' . $data['ket_iku'] . '</option>';
                } else {
                  echo '<option value="0" default selected> - - - Pilih IKU - - -</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-12">
              <label for="sub_kegiatan">Prioritas IKU</label>
              <select class="form-select form-select-sm select2" name="var_iku" placeholder="Pilih prioritas IKU">
                <option value="Langsung" <?= ($data["var_iku"] == "Langsung") ? "selected" : ""; ?>>Langsung</option>
                <option value="Tidak Langsung" <?= ($data["var_iku"] == "Tidak Langsung") ? "selected" : ""; ?>>Tidak Langsung</option>
                <option value="Pendukung" <?= ($data["var_iku"] == "Pendukung") ? "selected" : ""; ?>>Pendukung</option>
              </select>
            </div>

          </div>
        </form>

      </div>
      <div class="separator"></div>
      <div class="body text-end">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" form="saveST" class="btn btn-sm btn-success">Simpan</button>
      </div>
    </div>

  </div>
</div>

<script>
  $('.select2.nip').select2({
    allowClear: false,
    placeholder: 'Pilih Pegawai',
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_pegawai_jab') ?>',
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
  }).on('select2:select', function(e) {
    // what to do when option selected
  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
  });

  $('#saveST').validate($.extend({
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
            reload_table();
            $.notify('<b><i class="fas fa-check-square me-1"></i>Sukses!</b><br>' + e.message, 'success');
            setTimeout(() => {
              // modal dismiss
              $('#my_modal').modal('hide');
            }, 350);
          } else {
            // what to do when the response status = false
            $.notify('<b><i class="fas fa-exclamation-triangle me-1"></i>Gagal!</b><br>' + e.message, 'error');
            submit.attr('disabled', false);
          }
        },
        dataType: 'json'
      });
    },
    rules: {
      nip: {
        required: true
      },
      tgl_mulai: {
        required: true
      },
      tgl_selesai: {
        required: true
      },
      dispensasi: {
        required: true
      },
      keterangan: {
        required: true
      },
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