<div class="modal-header d-flex align-items-center">
  <div>
    <h3 class="mb-0"><?= $modal_title ?></h3>
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

  <div class="row g-2">

    <div class="col-12 loading_sync">
      <div>Sinkronisasi SIPD</div>
      <div class="progress mt-1 mb-3">
        <div id="progressbar_app1" class="progress-bar bg-info" style="width: 0%; height:6px;" role="progressbar"></div>
      </div>

      <div class="d-none">Sinkronisasi APP #2</div>
      <div class="d-none" class="progress mt-1 mb-3">
        <div id="progressbar_app2" class="progress-bar bg-info" style="width: 0%; height:6px;" role="progressbar"></div>
      </div>
    </div>

  </div>

</div>
<div class="modal-footer">
  <button type="button" class="btn btn-sm btn-light-secondary" data-bs-dismiss="modal">Batal</button>
  <button id="btnSYNC" type="button" onclick="run_progressbar_ssh()" class="btn btn-sm btn-light-success">Mulai</button>
</div>

<script>
  var progressbar_ssh_1 = $('#progressbar_app1');
  var progressbar_ssh_2 = $('#progressbar_app2');
  var width1 = 0;
  var width2 = 0;
  var progress_finished = false;

  function reset_progressbar() {
    progressbar_ssh_1.removeClass('bg-success').addClass('bg-info').css('width', '0%');
    progressbar_ssh_2.removeClass('bg-success').addClass('bg-info').css('width', '0%');
    width1 = 0;
    width2 = 0;
    progress_finished = false;
  }

  function run_progressbar_ssh() {
    $('#btnSYNC').attr('disabled', true);
    let intervalProgressbar = setInterval(() => {
      if (!progress_finished) {
        if (width1 <= 100) {
          width1 += 10;
          if (width1 <= 100) progressbar_ssh_1.css('width', width1 + '%');
          if (width1 > 100) {
            progress_finished = true;
            progressbar_ssh_1.removeClass('bg-info').addClass('bg-success');
            clearInterval(intervalProgressbar);
            reload_table();
            toaster('success', "Berhasil melakukan sinkronisasi data.")
            setTimeout(() => {
              $('#whole_modal_id').modal('hide');
            }, 500);
          }
        } else {
          width2 += 10;
          if (width2 <= 100) progressbar_ssh_2.css('width', width2 + '%');
          if (width2 > 100) {
            progressbar_ssh_2.removeClass('bg-info').addClass('bg-success');
            progress_finished = true;
            clearInterval(intervalProgressbar);
            reload_table();
            toaster('success', "Berhasil melakukan sinkronisasi data.")
            setTimeout(() => {
              $('#whole_modal_id').modal('hide');
            }, 500);
          }
        }
      }
    }, 200);
  }
</script>