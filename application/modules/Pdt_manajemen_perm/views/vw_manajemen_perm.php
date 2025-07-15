<?php
$cur_kewenangan = $this->session->userdata('kewenangan');
$cur_unor = $this->session->userdata('kode_unor');
?>
<div class="row page-titles">
  <div class="col-md-4 col-12 align-self-center">
    <h3 class="text-themecolor mb-0">Hak Akses</h3>
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item">
        <a href="javascript:void(0)">Pangkalan Data</a>
      </li>
      <li class="breadcrumb-item active">Manajemen Akses Menu</li>
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
            <h4 class="card-title">SESSION DATA (DEBUG)</h4>
            <small>
              <?php highlight_string("<?php\nSESSION = " . var_export($this->session->userdata(), true) . ";\n?>"); ?>
            </small>
          </div>
        </div>
      </div>
    <?php
    }
    ?>

    <?php
    /// |----------------------------------------------------------------------
    /// | >> DAFTAR MENU YANG BISA DIAKSES PER KEWENANGAN
    /// |----------------------------------------------------------------------
    ?>
    <div class="col-12">
      <div class="card">
        <div class="card-title space-between">
          <div>Daftar Kewenangan</div>
          <div>
            <div class="btn btn-sm btn-success" onclick="on_dev()"><i class="fas fa-plus-square me-1"></i>Tambah Baru</div>
          </div>
        </div>
        <div class="card-body">

          <div class="table-responsive">
            <div class="_loading loading_kewenangan behind-navbar">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table id="tabel_m_kewenangan" class="table table-bordered table-hover fs-3" style="width:100%;">
              <thead>
                <tr class="text-center">
                  <th class="vam" style="min-width: 40px;">#</th>
                  <th class="vam" style="width: 40%;">ID</th>
                  <th class="vam" style="width: 60%;">Keterangan</th>
                  <th class="vam" style="min-width: 60px;">Aksi</th>
                </tr>
              </thead>
            </table>
          </div>

        </div>
      </div>
    </div>

    <?php
    /// |----------------------------------------------------------------------
    /// | >> DAFTAR KOLOM KEWENANGAN
    /// |----------------------------------------------------------------------
    ?>
    <div class="col-12">
      <form id="form_save_kewenangan_menu" action="<?= site_url('pdt_manajemen_perm/save_hak_akses') ?>" method="POST">
        <div class="card">
          <div class="card-title space-between mb-0">
            <div>Manajemen Hak Akses</div>
            <div>
              <select name="id_kewenangan" id="id_kewenangan" class="form-select form-select-sm minw-200 select2 select2-sm select2_id_kewenangan"></select>
            </div>
          </div>
          <div class="card-body">

            <div class="_loading loading_kewenangan_menu behind-navbar">
              <div class="text"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>

            <table class="table table-sm table-bordered table-hover">
              <thead class="sticky_header">
                <tr class="text-center">
                  <th style="width: 100%;">Menu</th>
                  <th style="min-width: 90px;">Read</th>
                  <th style="min-width: 90px;">Insert</th>
                  <th style="min-width: 90px;">Update</th>
                  <th style="min-width: 90px;">Delete</th>
                  <th style="min-width: 90px;">Verif</th>
                  <th style="min-width: 90px;">Semua</th>
                </tr>
              </thead>
              <tbody id="list_kewenangan_menu">
                <tr>
                  <td colspan="7" class="text-center">Kewenangan yang ingin diberikan Hak Akses belum di-set.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="btn_submit_container" class="card-footer text-end d-none">
            <button id="btn_submit_form_kewenangan_menu" type="submit" class="btn btn-sm btn-success"><i class="fas fa-save me-1"></i>Simpan Perubahan</button>
          </div>
        </div>
      </form>
    </div>

  </div>

</div>

<script>
  function modal(the_action, the_id) {
    var url = "<?= site_url('pdt_manajemen_perm/modal') ?>";
    $.ajax({
      type: "POST",
      url: url,
      data: {
        action: the_action,
        id: the_id
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

  function toggle_value(this_menu_id, the_perm) {
    let target_id = this_menu_id + '__' + the_perm;
    let target_element = $('#' + target_id);
    let get_current_value = target_element.val();
    let icon_id = $('#' + target_id + '__icon');
    switch (get_current_value) {
      case '': {
        target_element.val('YES');
        icon_id.removeClass().addClass('fas fa-check-square text-success');
        break;
      }

      case 'YES': {
        target_element.val('NO');
        icon_id.removeClass().addClass('fas fa-window-close text-danger');
        break;
      }

      default: {
        target_element.val('');
        icon_id.removeClass().addClass('fas fa-minus-square text-secondary');
        break;
      }
    }
  }

  function toggle_all(this_menu_id, the_perm) {
    const permList = ['read', 'insert', 'update', 'delete', 'verif'];
    const target_id = `${this_menu_id}__${the_perm}`;
    const $target = $(`#${target_id}`);
    const current = $target.val();

    let newVal, iconClass;

    switch (current) {
      case '':
        newVal = 'YES';
        iconClass = 'fas fa-check-square text-success';
        break;
      case 'YES':
        newVal = 'NO';
        iconClass = 'fas fa-window-close text-danger';
        break;
      default:
        newVal = '';
        iconClass = 'fas fa-minus-square text-secondary';
        break;
    }

    // Apply to main toggled permission
    $target.val(newVal);
    $(`#${target_id}__icon`).removeClass().addClass(iconClass);

    // Apply to all standard permissions
    for (let perm of permList) {
      const inputId = `${this_menu_id}__${perm}`;
      const iconId = `${inputId}__icon`;
      $(`#${inputId}`).val(newVal);
      $(`#${iconId}`).removeClass().addClass(iconClass);
    }
  }

  function get_kewenangan_menu() {
    // you may add more than one param to send
    $.ajax({
      type: "POST",
      url: "<?= site_url('pdt_manajemen_perm/get_kewenangan_menu') ?>",
      data: {
        id_kewenangan: function() {
          return $('#id_kewenangan').val();
        },
      },
      dataType: 'json',
      beforeSend: function(e) {
        // what to do before sending the AJAX
        // for example showing loading element
        $('.loading_kewenangan_menu').addClass('show');
      },
      success: function(e) {
        if (e.status) {
          // what to do when the response status = true
          $('#list_kewenangan_menu').html(e.html);
        } else {
          // what to do when the response status = false
          show_notify('error', e.message);
        }

        setTimeout(() => {
          $('.loading_kewenangan_menu').removeClass('show');
        }, 500);
      },
      error: function(xhr, status, error) {
        show_notify('error', xhr.status + ' : ' + error);
      },
    });
  }

  /// |----------------------------------------------------------------------
  /// | >> DATATABLE KEWENANGAN
  /// |----------------------------------------------------------------------
  var m_profil_sekolah = $("#tabel_m_kewenangan").DataTable({
    responsive: true,
    processing: false,
    serverSide: true,
    orderCellsTop: true,
    dom: '<"row g-2"' +
      '<"col-12 col-sm-6"l><"col-12 col-sm-6"f>' +
      '<"col-12"tr>' +
      '<"col-12 col-sm-6"i><"col-12 col-sm-6"p>' +
      '>',
    /* set kolom yang di sortir secara default */
    order: [
      [1, "asc"],
    ],
    /* set placeholder dari input search */
    language: {
      searchPlaceholder: "Cari data..."
    },
    ajax: {
      url: '<?= site_url('pdt_manajemen_perm/get_data') ?>',
      /* parameter yang dikirimkan ke controller */
      data: {
        f_ukerja: function() {
          return $('#f_master_ukerja').val();
        }
      },
      type: 'POST',
      beforeSend: function() {
        // lakukan sesuatu sebelum mulai ajax process
        $('.loading_kewenangan').addClass('show');
      },
      error: function(xhr, status, error) {
        show_notify('error', xhr.status + ' : ' + error);
        $('.loading_kewenangan').removeClass('show');
      }
    },
    /* Sesuaikan jumlah kolom dengan id table yang digunakan */
    columns: [{
        data: 'no', // index 0
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 'id_kewenangan', // index 1
        orderable: true,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 'ket_kewenangan', // index 2
        orderable: false,
        className: 'true',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + cellData + '</div>');
        }
      },
      {
        data: 'id_kewenangan', // index 3
        orderable: false,
        className: 'vat',
        createdCell: function(td, cellData, rowData, row, col) {
          $(td).html('<div class="text-center">' + rowData.aksi_display + '</div>');
        }
      }
    ],
    /* Lakukan fungsi callback pada bracket ini */
    drawCallback: function(settings) {
      /* gunakan code ini utk mengambil data response ke dalam drawCallback */
      let api = this.api();
      let json = api.ajax.json();
      if (json.status == false) {
        /* jalankan apabila return false */
      }

      $('.loading_kewenangan').removeClass('show');
      /* parameter callback untuk kostumisasi fungsi */
    }
  });

  /* fungsi untuk reload datatable ajax */
  function reload_m_kewenangan() {
    m_profil_sekolah.ajax.reload();
  }

  $(document).ready(function() {
    // do something on document ready
    /// |----------------------------------------
    /// | FORM SUBMIT VIA AJAX
    /// |----------------------------------------
    $('#form_save_kewenangan_menu').validate($.extend({
      submitHandler: function(form, event) {
        // declare element that will be affected
        // by every state of the form submission
        // right here
        let submit = $('#btn_submit_form_kewenangan_menu');

        // declare button submit disabling right here if needed
        submit.attr('disabled', true);

        $(form).ajaxSubmit({
          success: function(e) {
            if (e.status) {
              // what to do when the response status = true
              show_notify('success', e.message);
              get_kewenangan_menu();
              submit.attr('disabled', false);
            } else {
              // what to do when the response status = false
              show_notify('error', e.message);
              submit.attr('disabled', false);
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
      rules: {},
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
        const $el = $(element);
        const closest = $el.closest('.input_block');
        closest.find('.is-invalid').removeClass('is-invalid');
        $('#error_' + $el.attr('id')).html('');
      },
      messages: {},
    }));

    /// |----------------------------------------
    /// | LISTENER & SELECT2
    /// |----------------------------------------
    init_select2('#id_kewenangan',
      'Pilih Kewenangan...',
      '<?= site_url('config/select2_kewenangan') ?>',
      () => ({
        include_semua: 'no',
      })
    );

    // filter listener
    $('#id_kewenangan').on('change', function() {
      get_kewenangan_menu();
      $('#btn_submit_container').removeClass('d-none');
    });

    // change size select2-sm
    $('.select2-sm').siblings('.select2-container')
      .find('.select2-selection--single, .select2-selection__rendered, .select2-selection__arrow')
      .addClass('select2-sm-style');
  });
</script>