<!DOCTYPE html>
<html lang="en-US">

<head>
  <title>Just a moment...</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="robots" content="noindex,nofollow">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0
    }

    html {
      line-height: 1.15;
      -webkit-text-size-adjust: 100%;
      color: #313131
    }

    button,
    html {
      font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh
    }

    .main-content {
      margin: 8rem auto;
      max-width: 60rem;
      width: 100%
    }

    .text-center {
      text-align: center
    }

    .loading-spinner {
      height: 76.391px
    }

    .lds-ring {
      display: inline-block;
      position: relative
    }

    .lds-ring,
    .lds-ring div {
      height: 1.875rem;
      width: 1.875rem
    }

    .lds-ring div {
      animation: lds-ring 1.2s cubic-bezier(.5, 0, .5, 1) infinite;
      border: .3rem solid transparent;
      border-radius: 50%;
      border-top-color: #313131;
      box-sizing: border-box;
      display: block;
      position: absolute
    }

    .lds-ring div:first-child {
      animation-delay: -.45s
    }

    .lds-ring div:nth-child(2) {
      animation-delay: -.3s
    }

    .lds-ring div:nth-child(3) {
      animation-delay: -.15s
    }

    @keyframes lds-ring {
      0% {
        transform: rotate(0)
      }

      to {
        transform: rotate(1turn)
      }
    }
  </style>
</head>

<body class="no-js">
  <div class="main-wrapper" role="main">
    <div class="main-content">
      <div class="text-center">
        <h4 class="mb-1 pt-2">Securing your login...</h4>
        <p class="mb-4">Please wait while we check your request.</p>
        <div class="loading-spinner" style="margin: 24px;">
          <div class="lds-ring">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
          </div>
        </div>
        <div style="margin: 48px;">
          <!-- Adsense Code -->
          <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2050040983829954"
            crossorigin="anonymous"></script>
          <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2050040983829954"
            data-ad-slot="3786022839" data-ad-format="auto" data-full-width-responsive="true"></ins>
          <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
        </div>
      </div>
      <script>
        setTimeout(function() {
          window.location.href = "{{ route('spam.check.redirect') }}";
        }, 5000); // 5 seconds
      </script>
    </div>
  </div>
</body>

</html>
