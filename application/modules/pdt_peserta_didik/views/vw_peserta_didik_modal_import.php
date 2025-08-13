<div class="modal-header">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
  <div class="row">
    <div class="col-sm-12">
      <div class="row my-2">
        <div class="col-sm-5">
          <button class="btn btn-secondary">
            <a href="<?= base_url('template.xlsx'); ?>" style="text-decoration: none;color:inherit;">
              <i class="fas fa-file-excel me-1"></i>Download Template Excel
            </a>
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="row my-2 d-flex">
      <div class="col-md-12 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <button class="btn btn-primary" onclick="$('#i_import_siswa').click();return false;">
            <i class="fas fa-upload me-1"></i> Upload
          </button>
          <div>
            <input type="file" name="i_import_siswa" id="i_import_siswa" />
            <span id="uploaded_file" class="ms-2"></span>
          </div>
        </div>
        <button type="button" class="btn btn-warning mx-2" id="btn_preview" onclick="previewFile()">Preview</button>
      </div>
    </div>
  </div>

  <div class="table-responsive">
    <div class="alert_message d-none">
      <p class="text-danger">Masih ada <span id="kosong_value"></span> data yang kosong!</p>
    </div>
    <table id="preview_response" class="p-3 table table-striped table-bordered table-hover fs-3" style="width:100%">
    </table>
  </div>
</div>

<div class="modal-footer">
  <div class="row">
    <div class="col-md-12 d-flex">
      <button type="button" class="btn btn-danger mx-2" data-bs-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary mx-2 d-none" id="btn_import" onclick="importFile()">Import</button>
    </div>
  </div>
</div>


<script>
  $("#btn_import").show();
  var previewFile = () => {
    const form_data = new FormData();
    form_data.append('file', $('#i_import_siswa')[0].files[0]);

    fetch('<?= base_url('pdt_peserta_didik/preview_data') ?>', {
        method: 'POST',
        body: form_data,
      }).then(response => response.text())
      .then(data => {
        let res_data = JSON.parse(data);
        if (res_data.kosong > 0) {
          $("div.alert_message").removeClass('d-none');
          $("#kosong_value").text(res_data.kosong);
        } else {
          $("div.alert_message").addClass('d-none');
          $("#btn_import").removeClass('d-none').prop('hidden', false);
        }
        $('#preview_response').DataTable({
          // retrieve: true,
          destroy: true,
          responsive: true,
          serverSide: false,
          scrollX: true,
          lengthMenu: [5, 10, 25, 50, 100],
          dom: '<"row g-1"' +
            '<"col-12 col-sm-6"l><"col-12 col-sm-6 vam">' +
            '<"col-12"tr>' +
            '<"col-12 col-sm-6"><"col-12 col-sm-6 mt-3"p>' +
            '>',
          data: res_data['data'],
          columns: [{
              title: "NISN",
              className: "vam",
              data: "nisn",
              createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                if (cellData === null || cellData === '') {
                  $(cell).html('<span class="text-danger">Kosong</span>');
                } else {
                  $(cell).html('<div class="text-center">' + cellData + '</div>');
                }
              }
            },
            {
              title: "Nama",
              className: "vam",
              data: "nama",
              createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                if (cellData === null || cellData === '') {
                  $(cell).html('<span class="text-danger">Kosong</span>');
                } else {
                  $(cell).html('<div class="text-center">' + cellData + '</div>');
                }
              }
            },
            {
              title: "NIK",
              className: "vam",
              data: "nik",
              createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                if (cellData === null || cellData === '') {
                  $(cell).html('<span class="text-danger">Kosong</span>');
                } else {
                  $(cell).html('<div class="text-center">' + cellData + '</div>');
                }
              }
            },
            {
              title: "Jenis Kelamin",
              className: "vam",
              data: "jenis_kelamin",
              createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                if (cellData === null || cellData === '') {
                  $(cell).html('<span class="text-danger">Kosong</span>');
                } else {
                  $(cell).html('<div class="text-center">' + cellData + '</div>');
                }
              }
            },
            {
              title: "Agama",
              className: "vam",
              data: "agama",
              createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                if (cellData === null || cellData === '') {
                  $(cell).html('<span class="text-danger">Kosong</span>');
                } else {
                  $(cell).html('<div class="text-center">' + cellData + '</div>');
                }
              }
            },
            {
              title: "Nama Ayah",
              className: "vam",
              data: "nama_ayah",
              createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                if (cellData === null || cellData === '') {
                  $(cell).html('<span class="text-danger">Kosong</span>');
                } else {
                  $(cell).html('<div class="text-center">' + cellData + '</div>');
                }
              }
            },
            {
              title: "Nama Ibu",
              className: "vam",
              data: "nama_ibu",
              createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                if (cellData === null || cellData === '') {
                  $(cell).html('<span class="text-danger">Kosong</span>');
                } else {
                  $(cell).html('<div class="text-center">' + cellData + '</div>');
                }
              }
            },
            {
              title: "No KK",
              className: "vam",
              data: "no_kk",
              createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                if (cellData === null || cellData === '') {
                  $(cell).html('<span class="text-danger">Kosong</span>');
                } else {
                  $(cell).html('<div class="text-center">' + cellData + '</div>');
                }
              }
            },
            {
              title: "Alamat",
              className: "vam",
              data: "alamat",
              createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                if (cellData === null || cellData === '') {
                  $(cell).html('<span class="text-danger">Kosong</span>');
                } else {
                  $(cell).html('<div class="text-center">' + cellData + '</div>');
                }
              }
            },
            {
              title: "Ragam Disabilitas",
              className: "vam",
              data: "disabilitas",
              createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                if (cellData === null || cellData === '') {
                  $(cell).html('<span class="text-danger">Kosong</span>');
                } else {
                  $(cell).html('<div class="text-center">' + cellData + '</div>');
                }
              }
            },
            // Add more columns as needed
          ],
        });

        // You can also update the UI to show the preview
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

  var importFile = () => {
    const form_data = new FormData();
    form_data.append('file', $('#i_import_siswa')[0].files[0]);

    fetch('<?= base_url('pdt_peserta_didik/import_data') ?>', {
        method: 'POST',
        body: form_data,
      }).then(response => response.text())
      .then(data => {
        let res_data = JSON.parse(data);
        console.log(res_data);
        if (res_data.status) {
          alert(res_data.message);
          // Optionally, you can refresh the page or update the UI
          location.reload();
        } else {
          alert("Error: " + res_data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

  $(function() {
    $("#i_import_siswa").hide();
    $("#uploaded_file").hide();

    $("#i_import_siswa").on('change', function(event) {
      const selectedFiles = event.target.files;
      if (selectedFiles.length > 0) {
        $("#uploaded_file").html(selectedFiles[0].name + " di-upload.");
        $("#uploaded_file").show();
      } else {
        $("#uploaded_file").html("");
        $("#uploaded_file").hide();
      }
    });
  });
</script>