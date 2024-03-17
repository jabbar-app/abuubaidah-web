<!doctype html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/') }}" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>{{ isset($title) ? $title . ' | ' : '' }}Ma'had Abu Ubaidah Bin Al Jarrah</title>


  <meta name="description" content="Lembaga Pendidikan Bahasa Arab & Studi Islam" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/mahad/abuubaidah_circle.svg') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
  <!-- Vendor -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/form-validation.css') }}" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
</head>

<body>
  <!-- Content -->

  @yield('content')

  <!-- / Content -->

  <!-- Core JS -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      // Memuat Provinsi
      $.ajax({
        url: '/provinces', // URL endpoint API untuk provinsi
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          $.each(data, function(index, province) {
            $('#provinsi').append('<option value="' + province.id + '">' + province.name + '</option>');
          });
        }
      });

      // Listener untuk perubahan Provinsi
      $('#provinsi').change(function() {
        var provinsiId = $(this).val();
        $('#kabupaten').removeAttr('disabled').html('<option value="">Pilih Kabupaten</option>');
        $.ajax({
          url: '/regencies/' + provinsiId, // URL endpoint API untuk kabupaten berdasarkan provinsi
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            $.each(data, function(index, regency) {
              $('#kabupaten').append('<option value="' + regency.id + '">' + regency.name + '</option>');
            });
          }
        });
      });

      // Listener untuk perubahan Kabupaten
      $('#kabupaten').change(function() {
        var kabupatenId = $(this).val();
        $('#kecamatan').removeAttr('disabled').html('<option value="">Pilih Kecamatan</option>');
        $.ajax({
          url: '/districts/' + kabupatenId, // URL endpoint API untuk kecamatan berdasarkan kabupaten
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            $.each(data, function(index, district) {
              $('#kecamatan').append('<option value="' + district.id + '">' + district.name + '</option>');
            });
          }
        });
      });
    });
  </script>
  <!-- build:js assets/vendor/js/core.js -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Select the toggle text
      const togglePassword = document.querySelector(".input-group-text");

      // Listen for a click on the text
      togglePassword.addEventListener("click", function(e) {
        // Select the password input field
        const password = document.getElementById("password");

        // Check the type of the password field and toggle accordingly
        if (password.type === "password") {
          password.type = "text";
          togglePassword.textContent = 'sembunyikan'; // Change the text to 'Hide'
        } else {
          password.type = "password";
          togglePassword.textContent = 'lihat'; // Change the text back to 'Show'
        }
      });
    });
  </script>
  <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
  <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="{{ asset('assets/vendor/libs/@form-validation/popular.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <!-- Page JS -->
  <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
</body>

</html>
