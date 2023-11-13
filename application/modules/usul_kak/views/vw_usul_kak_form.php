<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Form Usul KAK</h3>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="<?= site_url("usul_kak") ?>">Daftar Usul KAK</a>
            </li>
            <li class="breadcrumb-item active">Form</li>
        </ol>
    </div>
    <div class="col-md-7 col-12 align-self-center d-none d-md-block">
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Usul KAK</h4>
                    <h6 class="card-subtitle">
                        Isian untuk tambah/edit usul KAK.
                    </h6>
                    <form id="savekak" action="<?= site_url('usul_kak/save'); ?>" method="POST" class="form-material mt-4" enctype="multipart/form-data">
                        <input type="hidden" name="id_kak" value="<?= $data['id_kak']; ?>">
                        <input type="hidden" name="kode_unor" id="kode_unor" value="<?= $data['kode_unor']; ?>">
                        <div class="row g-2">
                            <div class="col-12">
                                <label for="program">Program</label>
                                <input type="text" name="ket_program" id="ket_program" value="<?= $data["ket_program"]; ?>" class="form-control" disabled="true">
                                <input type="hidden" name="id_program" id="id_program" value="">
                            </div>
                            <div class="col-12">
                                <label for="program">Kegiatan</label>
                                <input type="text" name="ket_kegiatan" id="ket_kegiatan" value="<?= $data["ket_kegiatan"]; ?>" class="form-control" disabled="true">
                                <input type="hidden" name="id_kegiatan_program" id="id_kegiatan_program" value="">
                            </div>
                            <div class="col-12">
                                <label for="sub_kegiatan">Sub Kegiatan</label>
                                <select class="form-control select2" name="kode_sub_kegiatan" id="kode_sub_kegiatan" placeholder="Pilih sub kegiatan" style="width: 100%; height: 36px">
                                    <?php
                                    if ($data["kode_kegiatan"] != "") {
                                        echo '<option value="' . $data['kode_kegiatan'] . '" default selected>' . $data['uraian_kegiatan'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="tahun">Tahun</label>
                                <select class="form-select select2" name="tahun" id="tahun">
                                    <?php for ($i = 2022; $i <= date('Y') + 1; $i++) {
                                        $selected = ($i == $data["tahun"]) ? "selected" : "";
                                        echo '<option value="' . $i . '" ' . $selected . '> ' . $i . '</option>';
                                    } ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="program">Tanggal Susun</label>
                                <!-- <input type="text" name="tgl_susun" id="tgl_susun" value="<?= tgl_formal($data["tgl_susun"]); ?>" class="form-control" required> -->
                                <div class="input-group">
                                    <input type="text" name="tgl_susun" id="tgl_susun" class="form-control mydatepicker" placeholder="mm/dd/yyyy" value="<?= tgl_formal($data["tgl_susun"]); ?>" required />
                                    <span class="input-group-text">
                                        <i data-feather="calendar" class="feather-sm"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="keterangan">Deskripsi</label>
                                <textarea name="deskripsi" rows="5" placeholder="Isi Deskripsi KAK" class="form-control form-control-sm" placeholder="Keterangan singkat tentang usul KAK ini"><?= $data['deskripsi'] ?></textarea>
                            </div>
                            <div class="col-12">
                                <label for="program">Keluaran</label>
                                <input type="text" name="keluaran" id="keluaran" value="<?= $data["keluaran"] ?>" placeholder="Isi Keluaran KAK" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label for="program">Indikator</label>
                                <input type="text" name="indikator" id="indikator" value="<?= $data["indikator"] ?>" class="form-control" placeholder="Isi Indikator KAK" required>
                            </div>
                            <div class="col-12">
                                <label for="program">Target</label>
                                <input type="text" name="target" id="target" value="<?= $data["target"] ?>" class="form-control" placeholder="Isi Target KAK" required>
                            </div>
                            <div class="col-6">
                                <label for="program">Volume</label>
                                <input type="text" name="volume" id="volume" value="<?= $data["volume"] ?>" class="form-control" placeholder="Isi Volume KAK" required>
                            </div>
                            <div class="col-6">
                                <label for="program">Satuan</label>
                                <input type="text" name="satuan" id="satuan" value="<?= $data["satuan"] ?>" class="form-control" placeholder="Satuan dari KAK" required>
                            </div>
                            <div class="col-12">
                                <label for="program">Lokasi</label>
                                <input type="text" name="lokasi" id="lokasi" value="<?= $data["lokasi"] ?>" class="form-control" placeholder="Lokasi dari KAK" required>
                            </div>
                            <div class="col-12">
                                <label for="program">Metode</label>
                                <input type="text" name="metode" id="metode" value="<?= $data["metode"] ?>" class="form-control" placeholder="Metode dari KAK" required>
                            </div>
                            <div class="col-12">
                                <label for="sub_kegiatan">IKU</label>
                                <select class="form-select select2" name="id_iku" id="id_iku" placeholder="Pilih IKU" style="width: 100%; height: 36px">
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
                                <select class="form-select select2" name="var_iku" placeholder="Pilih prioritas IKU">
                                    <option value="Langsung" <?= ($data["var_iku"] == "Langsung") ? "selected" : ""; ?>>Langsung</option>
                                    <option value="Tidak Langsung" <?= ($data["var_iku"] == "Tidak Langsung") ? "selected" : ""; ?>>Tidak Langsung</option>
                                    <option value="Pendukung" <?= ($data["var_iku"] == "Pendukung") ? "selected" : ""; ?>>Pendukung</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="realisasi_bln">Realisasi Bulan</label>
                            </div>
                            <div class="col-12">
                                <div class="row mt4">
                                    <div class="col-md-3 mb-3">
                                        <input type="checkbox" id="real_bln1" name="real_bln1" <?php echo ($data["real_bln1"] == 1) ? "checked" : "";  ?> class="material-inputs chk-col-blue" />
                                        <label for="real_bln1">1</label>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="checkbox" id="real_bln2" name="real_bln2" <?php echo ($data["real_bln2"] == 1) ? "checked" : "";  ?> class="material-inputs chk-col-blue" />
                                        <label for="real_bln2">2</label>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="checkbox" id="real_bln3" name="real_bln3" <?php echo ($data["real_bln3"] == 1) ? "checked" : "";  ?> class="material-inputs chk-col-blue" />
                                        <label for="real_bln3">3</label>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="checkbox" id="real_bln4" name="real_bln4" <?php echo ($data["real_bln4"] == 1) ? "checked" : "";  ?> class="material-inputs chk-col-blue" />
                                        <label for="real_bln4">4</label>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="checkbox" id="real_bln5" name="real_bln5" <?php echo ($data["real_bln5"] == 1) ? "checked" : "";  ?> class="material-inputs chk-col-blue" />
                                        <label for="real_bln5">5</label>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="checkbox" id="real_bln6" name="real_bln6" <?php echo ($data["real_bln6"] == 1) ? "checked" : "";  ?> class="material-inputs chk-col-blue" />
                                        <label for="real_bln6">6</label>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="checkbox" id="real_bln7" name="real_bln7" <?php echo ($data["real_bln7"] == 1) ? "checked" : "";  ?> class="material-inputs chk-col-blue" />
                                        <label for="real_bln7">7</label>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="checkbox" id="real_bln8" name="real_bln8" <?php echo ($data["real_bln8"] == 1) ? "checked" : "";  ?> class="material-inputs chk-col-blue" />
                                        <label for="real_bln8">8</label>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="checkbox" id="real_bln9" name="real_bln9" <?php echo ($data["real_bln9"] == 1) ? "checked" : "";  ?> class="material-inputs chk-col-blue" />
                                        <label for="real_bln9">9</label>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="checkbox" id="real_bln10" name="real_bln10" <?php echo ($data["real_bln10"] == 1) ? "checked" : "";  ?> class="material-inputs chk-col-blue" />
                                        <label for="real_bln10">10</label>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="checkbox" id="real_bln11" name="real_bln11" <?php echo ($data["real_bln11"] == 1) ? "checked" : "";  ?> class="material-inputs chk-col-blue" />
                                        <label for="real_bln11">11</label>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="checkbox" id="real_bln12" name="real_bln12" <?php echo ($data["real_bln12"] == 1) ? "checked" : "";  ?> class="material-inputs chk-col-blue" />
                                        <label for="real_bln12">12</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-3" style="margin-top:20px">
                                <button type="submit" form="savekak" id="saveKAKbtn" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /* fungsi select2 filter_ukerja dashboard; */
    $("#kode_sub_kegiatan").select2({
        placeholder: "Loading remote data",
        ajax: {
            url: "<?= site_url("config/select2_sub_kegiatan"); ?>",
            dataType: "json",
            delay: 250,
            data: function(params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function(data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: params.page * 30 < data.total_count,
                    },
                };
            },
            cache: true,
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 2,
        templateResult: formatKegiatan, // omitted for brevity, see the source of this page
        templateSelection: formatKegiatanSelection, // omitted for brevity, see the source of this page
    }).on('select2:select', function(e) {
        // what to do when option selected
        console.log(e);
        //reset cloud id filter
        $("#ket_kegiatan").val(
            e.params.data.uraian_kegiatan
        );
        $("#ket_program").val(
            e.params.data.uraian_program
        );
        $("#kode_unor").val(
            e.params.data.kode_unor
        );

    }).on('select2:close', function(e) {
        // what to do when selection closed
    }).on('select2:clear', function(e) {
        // what to do when clearing (only if allowClear: true)
    });

    function formatKegiatan(repo) {
        if (repo.loading) return repo.text;

        var markup =
            repo.text;

        return markup;
    }

    function formatKegiatanSelection(repo) {
        return repo.full_name || repo.text;
    }

    $("#id_iku").select2({
        placeholder: "Loading remote data",
        ajax: {
            url: "<?= site_url("config/select2_iku"); ?>",
            dataType: "json",
            delay: 250,
            data: function(params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function(data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: params.page * 30 < data.total_count,
                    },
                };
            },
            cache: true,
        },
        escapeMarkup: function(markup) {
            return markup;
        }, // let our custom formatter work
        minimumInputLength: 2,
        templateResult: formatIku, // omitted for brevity, see the source of this page
        templateSelection: formatIkuSelection, // omitted for brevity, see the source of this page
    }).on('select2:select', function(e) {
        // what to do when option selected
        //console.log(e);
    }).on('select2:close', function(e) {
        // what to do when selection closed
    }).on('select2:clear', function(e) {
        // what to do when clearing (only if allowClear: true)
    });

    function formatIku(repo) {
        if (repo.loading) return repo.text;

        var markup =
            repo.text;

        return markup;
    }

    function formatIkuSelection(repo) {
        return repo.full_name || repo.text;
    }

    $(".mydatepicker, #datepicker, .input-group.date").datepicker({
        todayHighlight: true,
        format: "dd-mm-yyyy"
    });

    $('#savekak').validate($.extend({
        submitHandler: function(form, event) {
            // declare element that will be affected
            // by every state of the form submission
            // right here
            var submit = $('#saveKAKbtn');
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
                        toaster('success', e.message);
                        setTimeout(() => {
                            // redirect to list kak
                            window.location.replace("<?= site_url("usul_kak") ?>");;
                        }, 1000);
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
            tgl_susun: {
                required: true
            },
            deskripsi: {
                required: true
            },
            keluaran: {
                required: true
            },
            indikator: {
                required: true
            },
            target: {
                required: true
            },
            volume: {
                required: true
            },
            satuan: {
                required: true
            },
            metode: {
                required: true
            }
        },
        errorClass: 'is-invalid',
        validClass: 'mv-valid',
        // if there's select2 element, please use this errorPlacement
        errorPlacement: function(error, element) {
            if (element.hasClass('select2') && element.next('.select2-container').length) {
                error.insertAfter(element.next('.select2-container'));
            } else {
                error.insertAfter(element);
            }
        },
        messages: {
            tgl_susun: {
                required: "Tanggal Susun wajib diisi!"
            },
            deskripsi: {
                required: "Deskripsi wajib diisi!"
            },
            keluaran: {
                required: "Keluaran wajib diisi!"
            },
            indikator: {
                required: "Indikator wajib diisi!"
            },
            target: {
                required: "Target wajib diisi!"
            },
            volume: {
                required: "Volume wajib diisi!"
            },
            satuan: {
                required: "Satuan wajib diisi!"
            },
            metode: {
                required: "Metode wajib diisi!"
            }
        },
    }));
</script>