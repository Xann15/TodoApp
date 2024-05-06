<?php
require_once 'config.php';

if (isset($_SESSION['user_token'])) {
  header("Location: welcome.php");
} else {


?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="icon.png" type="image/x-icon">

    <title>Todo App</title>
  </head>

  <body>
    <style>
      .content {
        width: 300px;
        height: 350px;
        background-color: blue;

        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -150px;
        /* half width*/
        margin-top: -175px;
        /* half height*/
      }

      .button {
        background: none;
        border: none;
      }

      .button .bloom-container {
        position: relative;
        transition: all 0.2s ease-in-out;
        border: none;
        background: none;
      }

      .button .bloom-container .button-container-main {
        width: 80px;
        aspect-ratio: 1;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
        display: grid;
        place-content: center;
        border-right: 5px solid white;
        border-left: 5px solid rgba(128, 128, 128, 0.147);
        transform: rotate(-20deg);
        transition: all 0.5s ease-in-out;
      }

      .button .bloom-container .button-container-main .button-inner {
        height: 60px;
        aspect-ratio: 1;
        border-radius: 50%;
        position: relative;
        box-shadow: rgba(100, 100, 111, 0.5) -10px 5px 10px 0px;
        transition: all 0.5s ease-in-out;
      }

      .button .bloom-container .button-container-main .button-inner .back {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: linear-gradient(60deg,
            rgb(245, 255, 255) 0%,
            rgb(185, 225, 200) 100%);
      }

      .button .bloom-container .button-container-main .button-inner .front {
        position: absolute;
        inset: 5px;
        border-radius: 50%;
        background: linear-gradient(60deg, rgb(0, 0, 0));
        display: grid;
        place-content: center;
        transform: rotate(20deg);
      }

      .button .bloom-container .button-container-main .button-inner .front .svg {
        fill: #ffffff;
        opacity: 0.5;
        width: 30px;
        aspect-ratio: 1;
        transition: all 0.2s ease-in;
      }

      .button .bloom-container .button-container-main .button-glass {
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg,
            rgba(255, 255, 255, 0) 0%,
            rgba(255, 255, 255, 0.888) 100%);
        transform: translate(0%, -50%) rotate(0deg);
        transform-origin: bottom center;
        transition: all 0.5s ease-in-out;
      }

      .button .bloom-container .bloom {
        height: 1px;
        width: 1px;
        position: absolute;
        background: white;
      }

      .button .bloom-container .bloom1 {
        top: 10px;
        right: 20px;
        box-shadow: rgb(255, 255, 255) 0px 0px 10px 10px,
          rgb(255, 255, 255) 0px 0px 20px 20px;
      }

      .button .bloom-container .bloom2 {
        bottom: 10px;
        left: 20px;
        box-shadow: rgba(255, 255, 255, 0.5) 0px 0px 10px 10px,
          rgba(255, 255, 255, 0.5) 0px 0px 30px 20px;
      }

      .button .bloom-container:hover {
        transform: scale(1.1);
      }

      .button .bloom-container:hover .button-container-main .button-glass {
        transform: translate(0%, -40%);
      }

      .button .bloom-container:hover .button-container-main .button-inner .front .svg {
        opacity: 1;
        filter: drop-shadow(0 0 10px white);
      }

      .button .bloom-container:active {
        transform: scale(0.7);
      }

      .button .bloom-container:active .button-container-main .button-inner {
        transform: scale(1.2);
      }

      body {
        background: url(images/bg.png) no-repeat center center fixed;
        background-size: cover;
        font-family: Satoshi Medium, sans-serif;
        margin: 0;
        background-position: center;
        overflow: overlay;
      }

      .todo {
        backdrop-filter: blur(16px) saturate(180%);
        -webkit-backdrop-filter: blur(16px) saturate(180%);
        background-color: rgba(255, 255, 255, 0.397);
        border-radius: 12px;
      }
    </style>
    <div class="todo content d-flex">
      <button class="button m-auto">
        <p class="fw-bold fs-5">One Tap</p>
        <div class="bloom-container" onclick="window.location.href='<?= $client->createAuthUrl() ?>'">
          <div class="button-container-main">
            <div class="button-inner">
              <div class="back"></div>
              <div class="front">
                <svg aria-hidden="true" class="native svg-icon iconGoogle my-auto" width="45" height="45" viewBox="0 0 18 18">
                  <path fill="#4285F4" d="M16.51 8H8.98v3h4.3c-.18 1-.74 1.48-1.6 2.04v2.01h2.6a7.8 7.8 0 0 0 2.38-5.88c0-.57-.05-.66-.15-1.18Z"></path>
                  <path fill="#34A853" d="M8.98 17c2.16 0 3.97-.72 5.3-1.94l-2.6-2a4.8 4.8 0 0 1-7.18-2.54H1.83v2.07A8 8 0 0 0 8.98 17Z"></path>
                  <path fill="#FBBC05" d="M4.5 10.52a4.8 4.8 0 0 1 0-3.04V5.41H1.83a8 8 0 0 0 0 7.18l2.67-2.07Z"></path>
                  <path fill="#EA4335" d="M8.98 4.18c1.17 0 2.23.4 3.06 1.2l2.3-2.3A8 8 0 0 0 1.83 5.4L4.5 7.49a4.77 4.77 0 0 1 4.48-3.3Z"></path>
                </svg>
              </div>
            </div>
            <div class="button-glass">
              <div class="back"></div>
              <div class="front"></div>
            </div>
          </div>
          <div class="bloom bloom1"></div>
          <div class="bloom bloom2"></div>
        </div>
      </button>
    </div>

  </body>

  </html>
<?php } ?>