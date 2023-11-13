<div class="modal-header d-flex align-items-center">
    <h4 class="modal-title" id="myLargeModalLabel">
        <?= $modal_title ?>
    </h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form id="savekak" action="<?= site_url('usul_kak/save'); ?>" method="POST" class="form-material mt-4" enctype="multipart/form-data">
        <input type="hidden" name="id_kak" value="<?= $data['id_kak']; ?>">
        <input type="hidden" name="kode_unor" value="<?= $data['kode_unor']; ?>">
        <div class="row g-2">
            <div class="col-12">
                <label for="program">Program</label>
                <input type="text" name="ket_program" id="ket_program" value="" class="form-control" disabled="true">
                <input type="hidden" name="id_program" id="id_program" value="">
            </div>
            <div class="col-12">
                <label for="program">Kegiatan</label>
                <input type="text" name="ket_kegiatan" id="ket_kegiatan" value="" class="form-control" disabled="true">
                <input type="hidden" name="id_kegiatan_program" id="id_kegiatan_program" value="">
            </div>
            <div class="col-12">
                <label for="sub_kegiatan">Sub Kegiatan</label>
                <select class="form-select select2-data-ajax" name="kode_sub_kegiatan" id="kode_sub_kegiatan" placeholder="Pilih sub kegiatan">
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
                    <?php for ($i = 2023; $i <= date('Y') + 1; $i++) {
                        $selected = ($i == $data["tahun"]) ? "selected" : "";
                        echo '<option value="' . $i . '"> ' . $i . '</option>';
                    } ?>
                </select>
            </div>
            <div class="col-6">
                <label for="program">Tanggal Susun</label>
                <input type="text" name="tgl_susun" id="tgl_susun" value="<?= tgl_formal($data["tgl_susun"]); ?>" class="form-control" required>
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
                <select class="form-select form-select-sm select2" name="id_iku" placeholder="Pilih IKU">
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
                <select class="form-select form-select-sm select2" name="var_iku" placeholder="Pilih prioritas IKU">
                    <option value="Langsung" <?= ($data["var_iku"] == "Langsung") ? "selected" : ""; ?>>Langsung</option>
                    <option value="Tidak Langsung" <?= ($data["var_iku"] == "Tidak Langsung") ? "selected" : ""; ?>>Tidak Langsung</option>
                    <option value="Pendukung" <?= ($data["var_iku"] == "Pendukung") ? "selected" : ""; ?>>Pendukung</option>
                </select>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="
                                  btn btn-light-danger
                                  text-danger
                                  font-weight-medium
                                  waves-effect
                                  text-start
                                " data-bs-dismiss="modal">
        Tutup
    </button>
    <button type="submit" form="savekak" class="btn btn-sm btn-success">Simpan</button>
</div>

<script>
    /* fungsi select2 filter_ukerja dashboard; */
    $("#kode_sub_kegiatan").select2({
        placeholder: "Loading remote data",
        dropdownParent: $('#myModal'),
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
        minimumInputLength: 1,
        //templateResult: formatRepo, // omitted for brevity, see the source of this page
        //templateSelection: formatRepoSelection, // omitted for brevity, see the source of this page
    });
</script>