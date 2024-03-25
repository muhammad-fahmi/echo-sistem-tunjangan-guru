<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
  <button class="btn btn-primary" id="loading-button" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> " Proses Integrasi Berjalan! Harap Tunggu "</button>
  <div id="result"></div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-light-secondary" data-bs-dismiss="modal">Batal</button>
</div>

<script>
  $(document).ready(function(){
    //jalankan proses integrasi
  });

  function start_integrasi(){
    var url = "<?= site_url('presensi/integrasi_presensi') ?>";
    var filter_thn = $("#filter_thn").val(); 
    var filter_bln = $("#filter_bln").val(); 
    var kode_ukerja = $("#select_ukerja").val(); 
    $.ajax({
      type: "POST",
      url: url,
      data: {
        filter_thn: filter_thn,
        filter_bln: filter_bln,
        kode_ukerja: kode_ukerja,
      },
      success: function(res) {
        if (res.status) {
          $("#result").html(res.html);
          $("#loading-button").hide();
        } else {
          toaster('warning', 'Error saat integrasi presensi.\n- ' + res.message);
        }
      }
    });
  }
</script>