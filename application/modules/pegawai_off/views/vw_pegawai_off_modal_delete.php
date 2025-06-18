<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <form id="deletePegawaiOut" action="<?= site_url('pegawai_off/delete'); ?>" method="POST" enctype="multipart/form-data">
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
              <td style="min-width: 120px;">Alasan Non Aktif</td>
              <td style="min-width: 10px;">:</td>
              <td style="width: 100%;"><?php
              $keterangan = "-";
              switch ($data["keterangan_out"]) {
                case 'meninggal':
                  $keterangan = "Meninggal Dunia";
                  break;
                case 'mutasi':
                  $keterangan = "Mutasi keluar Pemkot";
                  break;
                case 'pensiun':
                  $keterangan = "Pensiun";
                  break;
                case 'cltn':
                  $keterangan = "Cuti diluar tanggungan negara";
                  break;
                case 'tugas_belajar':
                  $keterangan = "Tugas Belajar";
                  break;       
                case 'tanpa_kabar':
                  $keterangan = "Tanpa Kabar";
                  break; 
                case 'hukuman_disiplin':
                  $keterangan = "Hukuman Disiplin";
                  break; 
                case 'sakit':
                  $keterangan = "Sakit";
                  break; 
                default:
                  $keterangan = "-";
                  break;
              }
              echo $keterangan; ?></td>
            </tr>
            <tr>
              <td style="min-width: 120px;">TNT Non Aktif</td>
              <td style="min-width: 10px;">:</td>
              <td style="width: 100%;"><?= tglFormat($data['tmt_out'],"d M yyyy"); ?></td>
            </tr>
        </table>
      </div>
      
    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-light-secondary" data-bs-dismiss="modal">Batal</button>
  <button id="deletePegawaiOutbtn" type="submit" form="deletePegawaiOut" class="btn btn-sm btn-light-success">Hapus</button>
</div>

<script>
  $('#deletePegawaiOut').validate($.extend({
    submitHandler: function(form, event) {
      var submit = $('#deletePegawaiOutbtn');
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