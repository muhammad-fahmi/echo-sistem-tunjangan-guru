<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-4 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Daftar Usul KAK</h3>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item active">Daftar Usul KAK</li>
        </ol>
    </div>
    <div class="col-md-8 col-12 align-self-center d-none d-md-block">
        <div class="d-flex mt-2 justify-content-end">
            <div class="d-flex me-3 ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>Pagu Anggaran</small></h6>
                    <h4 class="mt-0 text-info"><?= to_rp($data['anggaran']) ?></h4>
                </div>
                <div class="spark-chart">
                    <div id="monthchart"></div>
                </div>
            </div>
            <div class="d-flex ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>Realisasi</small></h6>
                    <h4 class="mt-0 text-primary"><?= to_rp($data['real_keu']) ?></h4>
                </div>
                <div class="spark-chart">
                    <div id="lastmonthchart"></div>
                </div>
            </div>
            <div class="d-flex ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>Fisik</small></h6>
                    <h4 class="mt-0 text-success"><?= to_rp($data['real_fisik'], false) ?>%</h4>
                </div>
                <div class="spark-chart">
                    <div id="nextmonthchart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- -------------------------------------------------------------- -->
<!-- Container fluid  -->
<!-- -------------------------------------------------------------- -->
<div class="container-fluid">
    <!-- -------------------------------------------------------------- -->
    <!-- Start Page Content -->
    <!-- -------------------------------------------------------------- -->
    <!-- basic table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Usul KAK</h4>

                    <div class="row">
                        <div class="col-md-3 col-lg-4 col-xlg-3">
                            <a class="btn btn-success" href="<?= site_url("usul_kak/form/0/save_usul_kak"); ?>"><i class="fas fa-plus"></i>Tambah Usul KAK</a>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table id="table_kak_list" class="table table-bordered fs-3" style="width:100%;">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th width="10px">Tahun</th>
                                    <th width="100px">Unor</th>
                                    <th width="300px">Kegiatan</th>
                                    <th width="150px">Deskripsi</th>
                                    <th width="150px">Target</th>
                                    <th width="100px">Lokasi</th>
                                    <th width="120px">Total Belanja</th>
                                    <th width="100px">Aksi</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th width="10px">Tahun</th>
                                    <th width="100px">Unor</th>
                                    <th width="300px">Kegiatan</th>
                                    <th width="150px">Deskripsi</th>
                                    <th width="150px">Target</th>
                                    <th width="100px">Lokasi</th>
                                    <th width="120px">Total Belanja</th>
                                    <th width="100px">Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- -------------------------------------------------------------- -->
<!-- End Container fluid  -->
<!-- -------------------------------------------------------------- -->
<!-- -------------------------------------------------------------- -->
<!-- JS Script Custom     -->
<!-- -------------------------------------------------------------- -->
<script>
    var urlDatatable = "<?= site_url('usul_kak/get_datatable') ?>";
    var tabel_kak = $("#table_kak_list").DataTable({
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
            [1, "desc"],
        ],
        /* set placeholder dari input search */
        language: {
            searchPlaceholder: "Cari Pegawai.."
        },
        ajax: {
            url: urlDatatable,
            /* parameter yang dikirimkan ke controller */
            data: {
                // kode_unor: function() {
                //     return $('#kode_unor').val();
                // }
            },
            type: 'POST',
            beforeSend: function() {
                // lakukan sesuatu sebelum mulai ajax process
                // $('._loading').addClass('show');
            },
        },
        /* Sesuaikan jumlah kolom dengan id table yang digunakan */
        columns: [{
                data: 'tahun',
                orderable: true,
                className: 'vam',
            },
            {
                data: 'ket_unor',
                orderable: false,
                className: 'vam'
            },
            {
                data: 'uraian_kegiatan',
                orderable: false,
                className: 'vam'
            },
            {
                data: 'deskripsi',
                orderable: false,
                className: 'vam'
            },
            {
                data: 'target',
                orderable: false,
                className: 'vam d-none d-sm-table-cell',
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).html(cellData + "<br> (Volume :" + rowData.volume + " " + rowData.satuan + ")");
                }
            },
            {
                data: 'lokasi',
                orderable: false,
            },
            {
                data: 'total_belanja',
                orderable: false,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).html(cellData + "<br>" + "<a href='<?= site_url("usul_kak/detail_belanja_list/"); ?>" + rowData.id_kak + "' class='btn btn-primary btn-sm'><i class='mdi mdi-magnify'></i> Detail</a>");
                }
            },
            {
                data: 'id_kak',
                orderable: false,
                className: 'vam',
                createdCell: function(td, cellData, rowData, row, col) {
                    var isian = '<a href="<?= site_url("usul_kak/form/"); ?>' + cellData + '/save_usul_kak" class="badge bg-warning">' +
                        '<i class="mdi mdi-table-edit"></i></a>&nbsp' +
                        '<a href="javascript:void(0)" class="badge bg-danger" onclick="modal(\'' + cellData + '\',\'delete_usul_kak\')">' +
                        '<i class="mdi mdi-delete"></i>' +
                        '</a>';

                    $(td).html(isian);
                }
            },
        ],
        /* Lakukan fungsi callback pada bracket ini */
        drawCallback: function(settings) {
            /* gunakan code ini utk mengambil data response ke dalam drawCallback */
            let api = this.api();
            let json = api.ajax.json();
            if (json.status == false) {
                /* jalankan apabila return false */
            }
            /* parameter callback untuk kostumisasi fungsi */
            $('._loading').removeClass('show');
        }
    });

    /* fungsi untuk reload datatable ajax */
    function reload_table() {
        tabel_kak.ajax.reload();
    }

    function modal(param1, param2) {
        var url = "<?= site_url('usul_kak/modal') ?>";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                id: param2,
                type: param1
            },
            success: function(res) {
                if (res.status) {
                    $("#modal-content-lg").html(res.html).show();
                    $("#bs-modal-lg").modal("show");
                    // $("#modal-content-lg").html(res.html).show();
                    // $("#bs-modal-lg").modal("show");
                } else {
                    toastr.error('<b><i class="fas fa-exclamation-triangle me-1"></i>Error!</b><br>' + res.message, 'error');
                }
            }
        });
    }
</script>

<!-- -------------------------------------------------------------- -->
<!-- JS Script Custom END -->
<!-- -------------------------------------------------------------- -->