@extends('auth.main')

@section('content')
  <div class="authentication-wrapper authentication-cover authentication-bg">
    <div class="authentication-inner row">
      <!-- /Left Text -->
      <div class="d-none d-lg-flex col-lg-7 p-0">
        <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
          <img src="{{ asset('assets/img/mahad/abuubaidah.jpeg') }}" alt="auth-register-cover" class="img-fluid my-5 auth-illustration" data-app-light-img="mahad/abuubaidah.jpeg" data-app-dark-img="illustrations/auth-register-illustration-dark.png" style="border-radius: 24px;" />
          <img src="{{ asset('assets/img/illustrations/bg-shape-image-light.png') }}" alt="auth-register-cover" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png" />
        </div>
      </div>
      <!-- /Left Text -->

      <!-- Register -->
      <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
        <div class="w-px-400 mx-auto">
          <!-- Logo -->
          <div class="app-brand mb-4">
            <a href="/" class="app-brand-link gap-2">
              <img src="{{ asset('assets/img/mahad/abuubaidah.svg') }}" alt="" width="10%">
            </a>
          </div>
          <!-- /Logo -->
          <h3 class="mb-1">Buat Akun</h3>
          <p class="mb-4">Ma'had Abu Ubaidah Bin Al Jarrah</p>

          <form action="{{ route('register') }}" method="POST" class="theme-form">
            @csrf
            <h4 class="mb-4">Buat Akun</h4>
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <div class="form-group">
              <label class="col-form-label">Nama Lengkap</label>
              <input type="text" name="name" value="{{ request()->query('name') ?: old('name') }}" placeholder="Nama Lengkap" class="form-control" required>
            </div>
            <div class="form-group">
              <label class="col-form-label">NIK</label>
              <input type="number" name="nik" class="form-control" value="{{ old('nik') }}" placeholder="NIK" required>
            </div>
            <div class="form-group">
              <label class="col-form-label">Email</label>
              <input type="email" name="email" value="{{ request()->query('email') ?: old('email') }}" class="form-control" required>
            </div>
            <div class="form-group">
              <label class="col-form-label">Password</label>
              <div class="form-input position-relative">
                <input class="form-control" type="password" name="password" value="{{ old('password') }}" required="" placeholder="*********">
                <div class="show-hide"><span class="show"></span></div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-form-label">Jenis Kelamin</label>
              <select name="gender" class="form-control" required>
                <option value="" disabled {{ old('gender') ? '' : 'selected' }}>- Pilih Data -</option>
                <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
              </select>
            </div>
            <div class="form-group">
              <label class="col-form-label">No. WhatsApp</label>
              <input type="number" name="phone" value="{{ request()->query('phone') ?: old('phone') }}" placeholder="62XXX" class="form-control" required>
            </div>

            <input type="hidden" name="religion" value="Islam">

            <div class="row">
              <div class="form-group col-6">
                <label class="col-form-label">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Sesuai KTP" class="form-control" required>
              </div>

              <div class="form-group col-6">
                <label class="col-form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" placeholder="Sesuai KTP" class="form-control" required>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-6">
                <label class="col-form-label" for="status_perkawinan">Status Perkawinan</label>
                <select class="form-select" name="status_perkawinan" id="status_perkawinan" required>
                  <option selected="" disabled="" value="">- Pilih Data -</option>
                  <option value="Menikah">Menikah</option>
                  <option value="Belum Menikah">Belum Menikah</option>
                  <option value="Janda/Duda">Janda/Duda</option>
                </select>
              </div>

              <div class="form-group col-6">
                <label class="col-form-label">Suku</label>
                <input type="text" name="suku" value="{{ old('suku') }}" placeholder="Suku" class="form-control" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-form-label">Alamat</label>
              <textarea name="address" rows="2" class="form-control" placeholder="Alamat" required>{{ old('address') }}</textarea>
            </div>
            <div class="form-group">
              <label class="col-form-label">Provinsi</label>
              <select class="form-control" name="province" id="provinsi" required>
                <option value="">Pilih Provinsi</option>
              </select>
            </div>
            <div class="form-group">
              <label class="col-form-label">Kabupaten</label>
              <select class="form-control" name="regency" id="kabupaten" required disabled>
                <option value="">Pilih Kabupaten</option>
              </select>
            </div>
            <div class="form-group">
              <label class="col-form-label">Kecamatan</label>
              <select class="form-control" name="district" id="kecamatan" required disabled>
                <option value="">Pilih Kecamatan</option>
              </select>
            </div>
            <button class="btn btn-primary btn-block w-100 mt-4" type="submit">Daftar</button>
            <p class="mt-4 mb-0 text-center">Sudah punya akun?<a class="ms-2" href="{{ route('login') }}">Login</a></p>
          </form>

          <p class="text-center">
            <span>Already have an account?</span>
            <a href="auth-login-cover.html">
              <span>Sign in instead</span>
            </a>
          </p>

          <div class="divider my-4">
            <div class="divider-text">or</div>
          </div>

          <div class="d-flex justify-content-center">
            <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
              <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
              <i class="tf-icons fa-brands fa-google fs-5"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon btn-label-twitter">
              <i class="tf-icons fa-brands fa-twitter fs-5"></i>
            </a>
          </div>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
@endsection

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
