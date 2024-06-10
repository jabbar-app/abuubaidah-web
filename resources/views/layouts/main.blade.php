<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
  data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>{{ isset($title) ? $title . ' | ' : '' }}Ma'had Abu Ubaidah Bin Al Jarrah</title>


  <meta name="description" content="Lembaga Pendidikan Bahasa Arab & Studi Islam" />

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/mahad/abuubaidah_circle.svg') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
    rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/tabler-icons.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet"
    href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
  <link rel="stylesheet"
    href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <!-- Page CSS -->
  @yield('css')

  <!-- Helpers -->
  <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="{{ asset('assets/js/config.js') }}"></script>

  <style>
    .one-line {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  </style>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    @yield('contents')

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
  </div>
  <!-- / Layout wrapper -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  @yield('js')
  <!-- Core JS -->

  <script>
    document.getElementById('program_id').addEventListener('change', function() {
      var programId = this.value;
      if (!programId) {
        document.getElementById('batch').style.display = 'none';
        document.getElementById('gelombang').style.display = 'none';
        return;
      }

      fetch('/get-angkatan/' + programId) // Adjust the endpoint as needed
        .then(response => response.json())
        .then(data => {
          let batchSelect = document.getElementById('batch');
          batchSelect.innerHTML = '<option value="">Select Angkatan</option>';
          data.forEach(function(batch) {
            batchSelect.innerHTML += `<option value="${batch.batchName}">${batch.batchName}</option>`;
          });
          batchSelect.style.display = 'block';
        });

      document.getElementById('batch').addEventListener('change', function() {
        var batchId = this.value;
        if (!batchId) {
          document.getElementById('gelombang').style.display = 'none';
          return;
        }

        fetch('/get-gelombang/' + batchId) // Adjust the endpoint as needed
          .then(response => response.json())
          .then(data => {
            let gelombangSelect = document.getElementById('gelombang');
            gelombangSelect.innerHTML = '<option value="">Select Gelombang</option>';
            data.forEach(function(gelombang) {
              gelombangSelect.innerHTML +=
                `<option value="${gelombang.gelombang}">${gelombang.gelombang}</option>`;
            });
            gelombangSelect.style.display = 'block';
          });
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var table = document.getElementById('kelas');
      var filter = document.getElementById('programFilter');

      filter.onchange = function() {
        var filterValue = this.value.toLowerCase();
        Array.from(table.getElementsByTagName('tr')).forEach(function(row) {
          // Assumes program is in the 5th column (adjust index as needed)
          var cell = row.cells[4] ? row.cells[4].textContent.toLowerCase() : '';
          row.style.display = cell.includes(filterValue) || !filterValue ? '' : 'none';
        });
      };
    });
  </script>
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
  <!-- build:js assets/vendor/js/core.js -->

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
  <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <!-- Page JS -->
  <script src="{{ asset('assets/js/app-academy-dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/form-layouts.js') }}"></script>
  <script src="{{ asset('assets/js/tables-datatables-basic.js') }}"></script>
  <script src="{{ asset('assets/js/dropdown-hover.js') }}"></script>
  <script src="{{ asset('assets/js/cards-analytics.js') }}"></script>
</body>

</html>
