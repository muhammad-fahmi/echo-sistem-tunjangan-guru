<div class="row g-2">
  <div class="col-12">

    <div class="panel">
      <div class="header space-between">
        <div><?= $modal_title ?></div>
        <i class="fas fa-window-close float right clickable" data-bs-dismiss="modal"></i>
      </div>
      <div class="separator"></div>
      <div class="body mb-2">

        <form id="deleteST" action="<?= site_url('surat_tugas/delete'); ?>" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $data['id'] ?>">

          <div class="row g-2">

            <div class="col-12">
              Apakah Anda yakin ingin menghapus data Surat Tugas berikut ini?
            </div>

            <div class="panel light-1 smalltext">
              <table>
                <tr>
                  <td style="min-width: 70px;">NIP</td>
                  <td style="min-width: 10px;">:</td>
                  <td style="width: 100%;"><?= $data['nip'] ?></td>
                </tr>

                <tr>
                  <td style="min-width: 70px;">NAMA</td>
                  <td style="min-width: 10px;">:</td>
                  <td style="width: 100%;"><?= $data['nama_lengkap'] ?></td>
                </tr>

                <tr>
                  <td style="min-width: 70px;">UNIT KERJA</td>
                  <td style="min-width: 10px;">:</td>
                  <td style="width: 100%;"><?= $data['ket_ukerja'] ?></td>
                </tr>

                <tr>
                  <?php
                  $tgl_mulai = datetime_to_view($data['tgl_mulai']);
                  $tgl_selesai = datetime_to_view($data['tgl_selesai']);

                  $tgl_mulai = $tgl_mulai['date'];
                  $tgl_selesai = $tgl_selesai['date'];
                  ?>
                  <td style="min-width: 150px;">TGL. SURAT TUGAS</td>
                  <td style="min-width: 10px;">:</td>
                  <td style="width: 100%;">
                    <i class="fas fa-play text-info me-1"></i><?= $tgl_mulai ?><br>
                    <i class="fas fa-stop text-warning me-1"></i><?= $tgl_selesai ?>
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 70px;">DISPENSASI</td>
                  <td style="min-width: 10px;">:</td>
                  <td style="width: 100%;">
                    <?php
                    if ($data["dispensasi"] == 1) {
                      echo "MASUK";
                    } elseif ($data["dispensasi"] == 2) {
                      echo "KELUAR";
                    } else {
                      echo "MASUK & KELUAR";
                    }
                    ?>
                  </td>
                </tr>
                <tr>
                  <td style="min-width: 70px;">KETERANGAN</td>
                  <td style="min-width: 10px;">:</td>
                  <td style="width: 100%;"><?= $data['keterangan'] ?></td>
                </tr>

                <?php
                if ($data['dokumen'] != '') {
                  // tampilkan efile yang sudah di upload + from e-file
                  $display_name = str_replace(' ', '_', $data['nip'] . ' - SURAT TUGAS TGL ' . $data['tgl_mulai']);
                ?>
                  <tr>
                    <td style="min-width: 70px;">E-FILE</td>
                    <td style="min-width: 10px;">:</td>
                    <td style="width: 100%;">
                      <div id="link_efile"><a href="<?= site_url("efile/$data[nip]/$data[dokumen]/$display_name") ?>" target="_blank" class="badge bg-warning text-black clickable">E-FILE DOKUMEN</a></div>
                    </td>
                  </tr>
                <?php
                }
                ?>

              </table>
            </div>

          </div>
        </form>

      </div>
      <div class="separator"></div>
      <div class="body text-end">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" form="deleteST" class="btn btn-sm btn-danger">Hapus</button>
      </div>
    </div>

  </div>
</div>

<script>
  $('#deleteST').validate($.extend({
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