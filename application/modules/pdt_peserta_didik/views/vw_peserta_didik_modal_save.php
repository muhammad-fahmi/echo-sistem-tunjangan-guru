<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <form id="savePesertaDidik" action="<?= site_url('peserta_didik/save'); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="type" value="<?= $data['type'] ?>">
    <input type="hidden" name="id_siswa" value="<?= $data['id_siswa'] ?>">

    <div class="row g-2">
      <div class="col-12 form_mapel">
        <label for="nisn">NISN</label>
        <br>
        <select name="nisn" id="nisn" class="form-control form-control-sm" style="width:100%">
          <?php $selected = ($data["nisn"] != "") ? "selected" : ""; ?>
          <option value=""> - - - Pilih NISN - - - </option>
          <option value="<?php echo $data["nisn"]; ?>" <?php echo $selected ?>><?php echo $data["nisn"]; ?></option>
        </select>
      </div>

      <div class="col-12 form_mapel">
        <label for="nama">Nama Lengkap</label>
        <input type="text" name="nama" id="nama" class="form-control form-control-sm" value="<?= $data['nama']; ?>" readonly=true>
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 form_mapel">
        <label for="nia">NIA</label>
        <input type="text" name="nia" id="nia" class="form-control form-control-sm" value="<?= $data['nia']; ?>" readonly=true>
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 col-lg-12 form_mapel">
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control form-control-sm" value="<?= $data['jenis_kelamin']; ?>" readonly=true>
        <input type="hidden" name="jenis_kelamin" id="jenis_kelamin" class="form-control form-control-sm" value="<?= $data['jenis_kelamin']; ?>" readonly=true>
      </div>

      <div class="col-12 col-lg-12 form_mapel">
        <label for="kode_agama">Agama</label>
        <input type="text" name="kode_agama" id="kode_agama" class="form-control form-control-sm" value="<?= $data['kode_agama']; ?>" readonly=true>
        <input type="hidden" name="kode_agama" id="kode_agama" class="form-control form-control-sm" value="<?= $data['kode_agama']; ?>" readonly=true>
      </div>

      <div class="col-12 col-lg-12 form_mapel">
        <label for="alamat">Alamat</label>
        <input type="text" name="alamat" id="alamat" class="form-control form-control-sm" value="<?= $data['alamat'] ?>">
      </div>

    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-light-secondary" data-bs-dismiss="modal">Batal</button>
  <button id="savePesertaDidikbtn" type="submit" form="savePesertaDidik" class="btn btn-sm btn-light-success">Simpan</button>
</div>

<script>
  $('#nip').select2({
    allowClear: true,
    placeholder: 'Pilih Pegawai yang akan disetup.',
    dropdownParent: $('#whole_modal_id .modal-content'),
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('config/select2_pegawai') ?>',
      delay: 800,
      /* delay before sending ajax request */
      data: function(params) {
        return {
          search: params.term
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
    console.log(e);
    selected_kewenangan = $('#select2_kewenangan').val();
    $("#nama_lengkap").val(e.params.data.nama_lengkap);
    $("#ket_jab").val(e.params.data.ket_jab);
    $("#kode_jab").val(e.params.data.kode_jab);
    $("#ket_ukerja").val(e.params.data.ket_ukerja);
    $("#kode_ukerja").val(e.params.data.kode_ukerja);

  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
    selected_kewenangan = '';
  });


  $('#savePesertaDidik').validate($.extend({
    submitHandler: function(form, event) {
      // declare element that will be affected
      // by every state of the form submission
      // right here
      var submit = $('#savePesertaDidikbtn');
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
      nisn: {
        required: true
      },
      nama: {
        required: true
      },
      jenis_kelamin: {
        required: true
      },
      kode_agama: {
        required: true
      },
      alamat: {
        required: true
      }
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
      nisn: {
        required: "NISN tidak boleh kosong"
      },
      nama: {
        required: "Nama Lengkap tidak boleh kosong"
      },
      jenis_kelamin: {
        required: "Jenis Kelamin tidak boleh kosong"
      },
      kode_agama: {
        required: "Agama tidak boleh kosong"
      },
      alamat: {
        required: "Alamat tidak boleh kosong"
      }
    },
  }));
</script>