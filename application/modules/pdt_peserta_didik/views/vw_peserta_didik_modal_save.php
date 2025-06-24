<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <form id="savePesertaDidik" action="<?= site_url('pdt_peserta_didik/save'); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="type" value="<?= $data['type'] ?>">
    <!-- <input type="hidden" name="id_siswa" value="<?= $data['id_siswa'] ?>"> -->

    <div class="row g-2">
      <div class="col-12 form_mapel">
        <label for="id_siswa">ID Siswa</label>
        <br>
        <select name="id_siswa" id="id_siswa" class="form-select form-select" style="width:100%">
          <?php $selected = ($data["id_siswa"] != "") ? "selected" : ""; ?>
          <option value=""> - - - Pilih ID Siswa - - - </option>
          <option value="<?php echo $data["id_siswa"]; ?>" <?php echo $selected ?>><?php echo $data["id_siswa"]; ?></option>
          <option value="1234567890">Jonah</option>
          <option value="9123456789">Jontor</option>
        </select>
      </div>

      <div class="col-12 form_mapel">
        <label for="nisn">NISN</label>
        <br>
        <select name="nisn" id="nisn" class="form-select form-select" style="width:100%">
          <?php $selected = ($data["nisn"] != "") ? "selected" : ""; ?>
          <option value=""> - - - Pilih NISN - - - </option>
          <option value="<?php echo $data["nisn"]; ?>" <?php echo $selected ?>><?php echo $data["nisn"]; ?></option>
          <option value="1234567890">1234567890</option>
          <option value="9123456789">9123456789</option>
        </select>
      </div>

      <div class="col-12 form_mapel">
        <label for="nama">Nama Lengkap</label>
        <input type="text" name="nama" id="nama" class="form-control form-control-sm" value="<?= $data['nama']; ?>">
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 form_mapel">
        <label for="nia">NIA</label>
        <input type="text" name="nia" id="nia" class="form-control form-control-sm" value="<?= $data['nia']; ?>">
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 col-lg-12 form_mapel">
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <br>
        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select form-select" style="width:100%">
          <?php $selected = ($data["jenis_kelamin"] != "") ? "selected" : ""; ?>
          <option value=""> - - - Pilih Jenis Kelamin - - - </option>
          <option value="L">Laki - Laki</option>
          <option value="P">Perempuan</option>
        </select>
      </div>

      <div class="col-12 col-lg-12 form_mapel">
        <label for="kode_agama">Agama</label>
        <br>
        <select name="kode_agama" id="kode_agama" class="form-select form-select" style="width:100%">
          <?php $selected = ($data["kode_agama"] != "") ? "selected" : ""; ?>
          <option value=""> - - - Pilih Jenis Kelamin - - - </option>
          <option value="00">Islam</option>
          <option value="01">Hindu</option>
          <option value="02">Kristen - Protestan</option>
          <option value="03">Kristen - Katolik</option>
          <option value="04">Buddha</option>
          <option value="05">Konghucu</option>
        </select>
      </div>

      <div class="col-12 form_mapel">
        <label for="nama_ayah">Nama Ayah</label>
        <input type="text" name="nama_ayah" id="nama_ayah" class="form-control form-control-sm" value="<?= $data['nama_ayah']; ?>">
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 form_mapel">
        <label for="nama_ibu">Nama Ibu</label>
        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control form-control-sm" value="<?= $data['nama_ibu']; ?>">
        <div class="invalid-feedback"></div>
      </div>

      <div class="col-12 form_mapel">
        <label for="no_kk">No. KK</label>
        <input type="text" name="no_kk" id="no_kk" class="form-control form-control-sm" value="<?= $data['no_kk']; ?>">
        <div class="invalid-feedback"></div>
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
  // $('#nip').select2({
  //   allowClear: true,
  //   placeholder: 'Pilih Pegawai yang akan disetup.',
  //   dropdownParent: $('#whole_modal_id .modal-content'),
  //   ajax: {
  //     type: 'POST',
  //     dataType: 'json',
  //     url: '<?= site_url('config/select2_pegawai') ?>',
  //     delay: 800,
  //     /* delay before sending ajax request */
  //     data: function(params) {
  //       return {
  //         search: params.term
  //       }
  //     },
  //     processResults: function(data) {
  //       return {
  //         results: data
  //       };
  //     },
  //   }
  // }).on('select2:select', function(e) {
  //   // what to do when option selected
  //   console.log(e);
  //   selected_kewenangan = $('#select2_kewenangan').val();
  //   $("#nama_lengkap").val(e.params.data.nama_lengkap);
  //   $("#ket_jab").val(e.params.data.ket_jab);
  //   $("#kode_jab").val(e.params.data.kode_jab);
  //   $("#ket_ukerja").val(e.params.data.ket_ukerja);
  //   $("#kode_ukerja").val(e.params.data.kode_ukerja);

  // }).on('select2:close', function(e) {
  //   // what to do when selection closed
  // }).on('select2:clear', function(e) {
  //   // what to do when clearing (only if allowClear: true)
  //   selected_kewenangan = '';
  // });


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