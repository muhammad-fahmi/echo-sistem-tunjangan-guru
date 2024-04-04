<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <form id="savePegawaiOut" action="<?= site_url('pegawai_off/save'); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="type" value="<?= $data['type'] ?>">
    <input type="hidden" name="id" value="<?= $data['id'] ?>">

    <div class="row g-2">
      <div class="col-12 form_mapel">
        <label for="nip">NIP</label>
        <br>
        <select name="nip" id="nip" class="form-control form-control-sm" style="width:100%">
          <?php $selected = ($data["nip"] != "") ? "selected" : ""; ?>
          <option value=""> - - - Pilih Pegawai - - - </option>
          <option value="<?php echo $data["nip"]; ?>" <?php echo $selected ?>><?php echo $data["nip"]; ?></option>
        </select>
      </div>

      <!-- <div class="col-12 form_mapel">
        <label for="nama_lengkap">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control form-control-sm" value="<?= $data['nama_lengkap']; ?>" readonly=true>
        <div class="invalid-feedback"></div>
      </div> -->

      <div class="col-12 col-lg-12 form_mapel">
        <label for="ket_jab">Jabatan</label>
        <input type="text" name="ket_jab" id="ket_jab" class="form-control form-control-sm" value="<?= $data['ket_jab']; ?>" readonly=true>
        <input type="hidden" name="kode_jab" id="kode_jab" class="form-control form-control-sm" value="<?= $data['kode_jab']; ?>" readonly=true>
      </div>

      <div class="col-12 col-lg-12 form_mapel">
        <label for="ket_ukerja">Unit Kerja</label>
        <input type="text" name="ket_ukerja" id="ket_ukerja" class="form-control form-control-sm" value="<?= $data['ket_ukerja']; ?>" readonly=true>
        <input type="hidden" name="kode_ukerja" id="kode_ukerja" class="form-control form-control-sm" value="<?= $data['kode_ukerja']; ?>" readonly=true>
      </div>

      <div class="col-12 form_mapel">
        <label for="keterangan_out">Alasan Non Aktif</label>
        <br>
        <select name="keterangan_out" id="keterangan_out" class="form-control form-control-sm" style="width:100%">
         <option value="meninggal" <?php echo ($keterangan_out == "meninggal") ? "selected" : ""; ?>>Meninggal Dunia</option>
         <option value="mutasi" <?php echo ($keterangan_out == "mutasi") ? "selected" : ""; ?>>Mutasi Keluar Pemkot</option>
         <option value="pensiun" <?php echo ($keterangan_out == "pensiun") ? "selected" : ""; ?>>Pensiun</option>
        </select>
      </div>
      <div class="col-12 col-lg-12 form_mapel">
        <label for="tmt_out">Tmt Non Aktif</label>
        <input type="date" name="tmt_out" id="tmt_out" class="form-control form-control-sm" value="<?= $data['tmt_mulai'] ?>">
      </div>
    </div>
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-light-secondary" data-bs-dismiss="modal">Batal</button>
  <button id="savePegawaiOutbtn" type="submit" form="savePegawaiOut" class="btn btn-sm btn-light-success">Simpan</button>
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

  // Select2 utk Tugas Tambahan
  $('#kode_tgs_tambahan').select2({
    allowClear: true,
    placeholder: 'Pilih Tugas tambahan yang akan disetup.',
    dropdownParent: $('#whole_modal_id .modal-content'),
    ajax: {
      type: 'POST',
      dataType: 'json',
      url: '<?= site_url('pegawai_off/select2_tgs_tambahan') ?>',
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
    // $("#kode_tgs_tambahan").val(e.params.data.kode_tgs_tambahan);

  }).on('select2:close', function(e) {
    // what to do when selection closed
  }).on('select2:clear', function(e) {
    // what to do when clearing (only if allowClear: true)
    selected_kewenangan = '';
  });


  $('#savePegawaiOut').validate($.extend({
    submitHandler: function(form, event) {
      // declare element that will be affected
      // by every state of the form submission
      // right here
      var submit = $('#savePegawaiOutbtn');
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
      nip: {
        required: true
      },
      
      ket_jab: {
        required: true
      },
      ket_ukerja: {
        required: true
      },
      tmt_out: {
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
      nip: {
        required: "NIP tidak boleh kosong"
      },
      // nama_lengkap: {
      //   required: "Nama Lengkap tidak boleh kosong"
      // },
      ket_jab: {
        required: "Keterangan Jabatan tidak boleh kosong"
      },
      ket_ukerja: {
        required: "Keterangan unit kerja tidak boleh kosong"
      },
      // kode_tgs_tambahan: {
      //   required: "Tugas Tambahan tidak boleh kosong"
      // },
      tmt_out: {
        required: "Tanggal mulai Non Aktif tidak boleh kosong"
      }
      // tmt_selesai: {
      //   required: "Tanggal selesai Tugas Tambahan tidak boleh kosong"
      // }
    },
  }));
</script>