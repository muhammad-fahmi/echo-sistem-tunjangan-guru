<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Whoops!</title>
  <style type="text/css">
    .center-msg {
      position: absolute;
      display: block;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .err-container {
      position: relative;
      width: 300px;
      height: 120px;
      font-family: sans-serif;
    }

    .err_num {
      color: #9b9b9b;
      font-size: 2.25rem;
      position: absolute;
      top: 30px;
      left: 50px;
    }

    .separator {
      position: absolute;
      width: 4px;
      height: 58px;
      background-color: #e9abab;
      top: 21px;
      left: 118px;
    }

    .err_msg {
      font-family: sans-serif;
      position: absolute;
      top: 40px;
      right: 15px;
      color: #9b9b9b;
      font-size: 1.25rem;
    }

    .blink_me {
      animation: blinker 1s ease-out infinite;
    }

    @keyframes blinker {
      50% {
        opacity: 0;
      }
    }

    body {
      background-color: #343434;
    }
  </style>
</head>

<body>
  <div class="center-msg">
    <div class="err-container">
      <div class="err_num">404</div>
      <div class="separator"></div>
      <div class="err_msg">Page not found
        <span class="blink_me">_</span>
      </div>
    </div>
  </div>
</body>

</html>