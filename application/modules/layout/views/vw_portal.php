<!DOCTYPE html>
<html dir="ltr">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="" />
  <meta name="description" content="Sistem Penyusunan Kerangka Acuan Kerja Perencanaan Kegiatan" />
  <meta name="robots" content="noindex,nofollow" />
  <title><?php echo $page_title; ?></title>
  <!-- <link rel="canonical" href="https://www.wrappixel.com/templates/materialpro/" /> -->
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url("theme/assets/images/favicon.ico"); ?>" />

  <!-- Custom CSS -->
  <link href="<?php echo base_url("theme/dist/css/style.min.css") ?>" rel="stylesheet" />

  <!-- -------------------------------------------------------------- -->
  <!-- All Required js -->
  <!-- -------------------------------------------------------------- -->
  <script src="<?php echo base_url("theme/assets/pangkalan_data/jquery/jquery-3.5.1.min.js"); ?>"></script>
  <script src="<?php echo base_url("theme/assets/pangkalan_data/jquery/jquery.form.js"); ?>"></script>
  <script src="<?php echo base_url("theme/assets/pangkalan_data/jquery-validation/jquery.validate.min.js"); ?>"></script>
  <script src="<?php echo base_url("theme/assets/pangkalan_data/jquery-validation/additional-methods.min.js"); ?>"></script>
  <script src="<?php echo base_url("theme/assets/pangkalan_data/notifyjs/notify.min.js"); ?>"></script>
  <!-- Bootstrap tether Core JavaScript -->
  <script src="<?php echo base_url("theme/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"); ?>"></script>
  <!-- slimscrollbar scrollbar JavaScript -->
  <script src="<?php echo base_url("theme/dist/libs/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.js"); ?>"></script>
  <script src="<?php echo base_url("theme/dist/libs/jquery-sparkline/jquery.sparkline.min.js"); ?>"></script>
  <!--Wave Effects -->
  <script src="<?php echo base_url("theme/dist/js/waves.js"); ?>"></script>
  <!--Menu sidebar -->
  <!-- <script src="<?php echo base_url("theme/dist/js/sidebarmenu.js"); ?>"></script> -->
  <!--Custom JavaScript -->
  <script src="<?php echo base_url("theme/dist/js/feather.min.js"); ?>"></script>
  <script src="<?php echo base_url("theme/dist/js/custom.min.js"); ?>"></script>
  <script src="<?php echo base_url("theme/dist/js/plugins/toastr-init.js"); ?>"></script>
</head>

<body>
  <div class="main-wrapper">
    <!-- -------------------------------------------------------------- -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- -------------------------------------------------------------- -->
    <div class="preloader">
      <svg class="tea lds-ripple" width="37" height="48" viewbox="0 0 37 48" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z" stroke="#1e88e5" stroke-width="2"></path>
        <path d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34" stroke="#1e88e5" stroke-width="2"></path>
        <path id="teabag" fill="#1e88e5" fill-rule="evenodd" clip-rule="evenodd" d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z"></path>
        <path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="#1e88e5"></path>
        <path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="#1e88e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
      </svg>
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- -------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------- -->
    <!-- Login box.scss -->
    <!-- -------------------------------------------------------------- -->
    <div class="row auth-wrapper gx-0">
      <div class="col-lg-3 bg-info auth-box-2 on-sidebar">
        <div class="h-100 d-flex align-items-center justify-content-center">
          <div class="row justify-content-center text-center">
            <div class="col-md-7 col-lg-12 col-xl-9">
              <div>
                <span class="db"><img style="width:100px;" src="<?php echo base_url("theme/assets/images/logo/logo_pemkot.png"); ?>" alt="logo" /></span>
                <span class="db"><img style="width:100px;" src="<?php echo base_url("theme/assets/images/logo/logo_tut_wuri_handayani.png"); ?>" alt="logo" /></span>
              </div>
              <h2 class="text-white mt-4">
                PEMERINTAH KOTA SAMARINDA <br>
                DINAS PENDIDIKAN DAN KEBUDAYAAN
              </h2>
              <h3 class="text-white mt-4 fw-light">
                SIMDIKS
              </h3>
              <h4 class="text-white mt-4 fw-light">
                Sistem Informasi Manajemen Pendidikan Samarinda
              </h4>
            </div>
          </div>
        </div>
      </div>
      <div class="
            col-lg-9
            d-flex
            align-items-center
            justify-content-center
          " style="background-image:url('<?php echo base_url("theme/assets/images/background/login-bg-1.jpg"); ?>')">
        <div class="row justify-content-center w-100 mt-4 mt-lg-0">
          <div class="col-lg-4 col-md-6">
            <div class="card" id="loginform">
              <div class="card-body">
                <h2>Selamat Datang,</h2>
                <form id="form-auth" class="form-horizontal mt-4 pt-4 needs-validation" method="POST" action="<?= site_url('login/auth') ?>">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control form-input-bg" id="tb-email" name="username" placeholder="admin" />
                    <label for="tb-email">Username</label>
                    <div class="text-danger" id="invalid_feedback_display"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <div class=" form-floating mb-3 d-flex">
                      <input type="password" class="form-control form-input-bg" name="password" id="text-password" placeholder="*****" />
                      <label for="text-password" class="form-label">Password</label>
                      <span class="input-group-text" id="password_toggle">
                        <i class="fas fa-eye" id="password_show"></i>
                        <i class="fas fa-eye-slash" id="password_hide"></i>
                      </span>
                    </div>
                    <div>
                      <div class="text-danger" id="invalid_feedback_display"></div>
                    </div>
                  </div>
                  <div class="d-flex align-items-stretch button-group mt-4 pt-2">
                    <button type="submit" class="btn btn-info btn-lg px-4">
                      Masuk
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- -------------------------------------------------------------- -->
    <!-- Login box.scss -->
    <!-- -------------------------------------------------------------- -->
  </div>
  <script>
    $(".preloader").fadeOut();
    // ---------------------------
    // Login and Recover Password
    // ---------------------------
    $("#to-recover").on("click", function() {
      $("#loginform").hide();
      $("#recoverform").fadeIn();
    });

    $("#to-login").on("click", function() {
      $("#loginform").fadeIn();
      $("#recoverform").hide();
    });

    $("#to-register").on("click", function() {
      $("#loginform").hide();
      $("#registerform").fadeIn();
    });

    $("#to-login2").on("click", function() {
      $("#loginform").fadeIn();
      $("#registerform").hide();
    });

    /// |----------------------------------------
    /// | FUNC SHOW NOTIFY
    /// |----------------------------------------
    $.notify.addStyle("mynotif", {
      html: "<div>" + '<div class="message"><span data-notify-html/></div>' + "</div>",
      classes: {
        base: {
          "min-width": "230px",
          "max-width": "300px",
          "background-color": "white",
          padding: "10px",
          "border-radius": "4px",
          border: "2px solid #777777",
        },
        success: {
          "background-color": "#5cb85c",
          border: "2px solid #217921",
          color: "white",
        },
        error: {
          "background-color": "#d9534f",
          border: "2px solid #862522",
          color: "white",
        },
        info: {
          "background-color": "#337ab7",
          border: "2px solid #1c466b",
          color: "white",
        },
      },
    });

    $.notify.defaults({
      autoHide: true,
      autoHideDelay: 10000,
      style: "mynotif",
      gap: 4,
    });

    function show_notify(status, message) {
      let icon, title;
      switch (status) {
        case "success": {
          icon = '<i class="fas fa-check-circle me-1"></i>';
          title = "Sukses!";
          break;
        }
        case "info": {
          icon = '<i class="fas fa-info-circle me-1"></i>';
          title = "Info";
          break;
        }
        default: {
          title = "Gagal!";
          icon = '<i class="fas fa-exclamation-triangle me-1"></i>';
          break;
        }
      }
      $.notify("<b>" + icon + title + "</b><br>" + message, status);
    }

    /// |----------------------------------------
    /// | DOCUMENT READY
    /// |----------------------------------------
    $(document).ready(function() {

      /// |--------------------------------------
      /// | INIT FORM AJAX
      /// |--------------------------------------
      $('#form-auth').validate($.extend({
        submitHandler: function(form, event) {
          // declare element that will be affected
          // by every state of the form submission
          // right here
          var submit = $('[type="submit"]');
          // declare button submit disabling right here if needed
          submit.attr('disabled', true);
          $(form).ajaxSubmit({
            success: function(e) {
              if (e.status) {
                // what to do when the response status = true
                show_notify('success', e.message);
                setTimeout(() => {
                  window.location.href = '<?= site_url('portal') ?>';
                }, 2000);
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
        rules: {
          username: {
            required: true
          },
          password: {
            required: true,
            minlength: 6
          }
        },
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        /* if there's select2 element, please use this errorPlacement */
        errorPlacement: function(error, element) {
          const feedback = element.closest('.form-floating').find('#invalid_feedback_display');
          const feedbackDisplay = element.closest('.form-floating').siblings().find('#invalid_feedback_display');
          if (feedback.length) {
            feedback.text(error.text());
          } else {
            feedbackDisplay.text(error.text());
          }
        },
        highlight: function(element) {
          $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element) {
          $(element).removeClass('is-invalid').addClass('is-valid');
          const feedback = $(element).closest('.form-floating').find('#invalid_feedback_display');
          const feedbackDisplay = $(element).closest('.form-floating').siblings().find('#invalid_feedback_display');
          if (feedback.length) {
            feedback.text('');
          } else {
            feedbackDisplay.text('');
          }
          // // Clear error text if valid
          // $(element).closest('.form-floating').find('#invalid_feedback_display').text('');
        },
        messages: {
          username: {
            required: "Username tidak boleh kosong!",
          },
          password: {
            required: "Password tidak boleh kosong!",
            minlength: "Password minimal 6 karakter!"
          }
        },
      }));

      $("#password_hide").hide();
      $("#password_toggle").on("click", function() {
        const passwordField = $("#text-password");
        const passwordType = passwordField.attr("type") === "password" ? "text" : "password";
        passwordField.attr("type", passwordType);
        $("#password_show").toggle();
        $("#password_hide").toggle();
      });

    });
  </script>
</body>

</html>