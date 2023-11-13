<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-4 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Daftar Belanja pada Usul KAK</h3>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= site_url("usul_kak"); ?>">Daftar Usul KAK </a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Daftar Detail Belanja </a>
            </li>
        </ol>
    </div>
    <div class="col-md-8 col-12 align-self-center d-none d-md-block">
        <div class="d-flex mt-2 justify-content-end">
            <div class="d-flex me-3 ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>Pagu Anggaran</small></h6>
                    <h4 class="mt-0 text-info"><?= to_rp($data["pagu_realisasi"]['anggaran']) ?></h4>
                </div>
                <div class="spark-chart">
                    <div id="monthchart"></div>
                </div>
            </div>
            <div class="d-flex ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>Realisasi</small></h6>
                    <h4 class="mt-0 text-primary"><?= to_rp($data["pagu_realisasi"]['real_keu']) ?></h4>
                </div>
                <div class="spark-chart">
                    <div id="lastmonthchart"></div>
                </div>
            </div>
            <div class="d-flex ms-2">
                <div class="chart-text me-2">
                    <h6 class="mb-0"><small>Fisik</small></h6>
                    <h4 class="mt-0 text-success"><?= to_rp($data["pagu_realisasi"]['real_fisik'], false) ?>%</h4>
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
                    <h4 class="card-title">Detail KAK</h4>
                    <div class="row">
                        <table id="table_detail" class="table">
                            <tr>
                                <td>Unor</td>
                                <td>:</td>
                                <td><?= $detail_kak["kode_unor"] . " - " . $detail_kak["ket_unor"]; ?></td>
                            </tr>
                            <tr>
                                <td>Program</td>
                                <td>:</td>
                                <td><?= $detail_kegiatan["kode_program"] . " - " . $detail_kegiatan["uraian_program"]; ?></td>
                            </tr>
                            <tr>
                                <td>Kegiatan</td>
                                <td>:</td>
                                <td><?= $detail_kegiatan["kode_kegiatan"] . " - " . $detail_kegiatan["uraian_kegiatan"]; ?></td>
                            </tr>
                            <tr>
                                <td>Sub Kegiatan</td>
                                <td>:</td>
                                <td><?= $detail_kegiatan["kode_sub_kegiatan"] . " - " . $detail_kegiatan["uraian_sub_kegiatan"]; ?></td>
                            </tr>
                            <tr>
                                <td>Tahun</td>
                                <td>:</td>
                                <td><?= $detail_kak["tahun"]; ?></td>
                            </tr>
                            <tr>
                                <td>Tgl Susun</td>
                                <td>:</td>
                                <td><?= tgl_formal($detail_kak["tgl_susun"]); ?></td>
                            </tr>
                            <tr>
                                <td>Deskripsi</td>
                                <td>:</td>
                                <td><?= $detail_kak["deskripsi"]; ?></td>
                            </tr>
                            <tr>
                                <td>Keluaran</td>
                                <td>:</td>
                                <td><?= $detail_kak["keluaran"]; ?></td>
                            </tr>
                            <tr>
                                <td>Indikator</td>
                                <td>:</td>
                                <td><?= $detail_kak["indikator"]; ?></td>
                            </tr>
                            <tr>
                                <td>Target</td>
                                <td>:</td>
                                <td><?= $detail_kak["target"]; ?></td>
                            </tr>
                            <tr>
                                <td>Volume</td>
                                <td>:</td>
                                <td><?= $detail_kak["volume"]; ?></td>
                            </tr>
                            <tr>
                                <td>Lokasi</td>
                                <td>:</td>
                                <td><?= $detail_kak["lokasi"]; ?></td>
                            </tr>
                            <tr>
                                <td>Metode</td>
                                <td>:</td>
                                <td><?= $detail_kak["metode"]; ?></td>
                            </tr>
                            <tr>
                                <td>IKU</td>
                                <td>:</td>
                                <td><?= $detail_kak["ket_iku"]; ?></td>
                            </tr>
                        </table>
                    </div>
                    <h4 class="card-title">Rincian Belanja</h4>
                    <div class="row">
                        <div class="col-md-3 col-lg-4 col-xlg-3">
                            <button class="btn btn-sm btn-success me-2" onclick="modal(``,`tambah_rincian_belanja`)"><i class="fas fa-plus me-1"></i>Tambah Rincian Belanja</button>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table id="table_kak_list" class="table table-bordered fs-3" style="width:100%;">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th width="100px">Kode Belanja</th>
                                    <th width="300px">Uraian</th>
                                    <th width="150px">Spesifikasi</th>
                                    <th width="150px">Koef</th>
                                    <th width="80px">Satuan</th>
                                    <th width="120px">Harga</th>
                                    <th width="80px">Koef1_p1</th>
                                    <th width="80px">Koef2_p2</th>
                                    <th width="80px">Koef3_p3</th>
                                    <th width="100px">Aksi</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th width="100px">Kode Belanja</th>
                                    <th width="300px">Uraian</th>
                                    <th width="150px">Spesifikasi</th>
                                    <th width="150px">Koef</th>
                                    <th width="80px">Satuan</th>
                                    <th width="120px">Harga</th>
                                    <th width="80px">Koef1_p1</th>
                                    <th width="80px">Koef2_p2</th>
                                    <th width="80px">Koef3_p3</th>
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
                data: 'kode_belanja',
                orderable: true,
                className: 'vam',
            },
            {
                data: 'kakbel_uraian',
                orderable: false,
                className: 'vam'
            },
            {
                data: 'kakbel_spesifikasi',
                orderable: false,
                className: 'vam'
            },
            {
                data: 'kakbel_koef',
                orderable: false,
                className: 'vam'
            },
            {
                data: 'satuan',
                orderable: false,
                className: 'vam d-none d-sm-table-cell',
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).html(cellData + "<br> (Volume :" + rowData.volume + " " + rowData.satuan + ")");
                }
            },
            {
                data: 'harga',
                orderable: false,
            },
            {
                data: 'total_belanja',
                orderable: false,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).html(cellData + "<br>" + "<a href='#' class='btn btn-primary btn-sm'><i class='mdi mdi-magnify'></i> Detail</a>");
                }
            },
            {
                data: 'kakbel_koef_p1',
                orderable: false,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).html(cellData + "<br>" + "<a href='#' class='btn btn-primary btn-sm'><i class='mdi mdi-magnify'></i> Detail</a>");
                }
            },
            {
                data: 'kakbel_koef_p2',
                orderable: false,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).html(cellData + "<br>" + "<a href='#' class='btn btn-primary btn-sm'><i class='mdi mdi-magnify'></i> Detail</a>");
                }
            },
            {
                data: 'kakbel_koef_p3',
                orderable: false,
                createdCell: function(td, cellData, rowData, row, col) {
                    $(td).html(cellData + "<br>" + "<a href='#' class='btn btn-primary btn-sm'><i class='mdi mdi-magnify'></i> Detail</a>");
                }
            },
            {
                data: 'kakbel_id_kak_belanja',
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