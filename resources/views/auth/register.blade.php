@extends('auth.main')

@section('content')
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
        <!-- Login -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-4 mt-2">
              <a href="/" class="app-brand-link gap-2">
                <img src="{{ asset('assets/img/mahad/abuubaidah.svg') }}" alt="Abu Ubaidah" width="10%">
                <span class="app-brand-text demo text-body fw-bold ms-1">Ma'had Abu Ubaidah <br>Bin Al Jarrah</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-1 pt-2">Assalamu'alaykum! 👋</h4>
            <p class="mb-4">Silakan input email dan password kamu untuk melanjutkan.</p>

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
                <input type="text" name="name" value="{{ request()->query('name') ?: old('name') }}"
                  placeholder="Nama Lengkap" class="form-control" required>
              </div>
              <div class="form-group">
                <label class="col-form-label">NIK</label>
                <input type="number" name="nik" class="form-control" value="{{ old('nik') }}" placeholder="NIK"
                  required>
              </div>
              <div class="form-group">
                <label class="col-form-label">Email</label>
                <input type="email" name="email" value="{{ request()->query('email') ?: old('email') }}"
                  class="form-control" required>
              </div>
              <div class="form-group">
                <label class="col-form-label">Password</label>
                <div class="form-input position-relative">
                  <input class="form-control" type="password" name="password" value="{{ old('password') }}" required=""
                    placeholder="*********">
                  <div class="show-hide"><span class="show"></span></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-form-label">Ketik Ulang Password</label>
                <div class="form-input position-relative">
                  <input class="form-control" type="password" name="password_confirmation"
                    value="{{ old('password_confirmation') }}" required="" placeholder="*********">
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
                <input type="tel" name="phone" value="{{ request()->query('phone') ?: old('phone') }}"
                  placeholder="62XXX" pattern="^62[1-9][0-9]*$" oninput="validatePhoneNumber(this)" class="form-control"
                  required>
                <small class="text-muted">Awalan input yang diperbolehkan adalah 62.</small>
              </div>

              <script>
                function validatePhoneNumber(input) {
                  // Remove all non-digit characters
                  let sanitizedInput = input.value.replace(/\D/g, '');

                  // Check if the first two digits are "62"
                  if (!sanitizedInput.startsWith('62')) {
                    sanitizedInput = '62';
                  }

                  // Remove leading zeroes after "62"
                  sanitizedInput = sanitizedInput.replace(/^62[0]*/, '62');

                  // Update the input value with the sanitized version
                  input.value = sanitizedInput;
                }
              </script>


              <input type="hidden" name="religion" value="Islam">

              <div class="row">
                <div class="form-group col-6">
                  <label class="col-form-label">Tempat Lahir</label>
                  <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Sesuai KTP"
                    class="form-control" required>
                </div>

                <div class="form-group col-6">
                  <label class="col-form-label">Tanggal Lahir</label>
                  <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" placeholder="Sesuai KTP"
                    class="form-control" required>
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
                  <input type="text" name="suku" value="{{ old('suku') }}" placeholder="Suku"
                    class="form-control" required>
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
              <p class="mt-4 mb-0 text-center">Sudah punya akun?<a class="ms-2"
                  href="{{ route('login') }}">Login</a></p>
            </form>

            <div class="divider my-4">
              <div class="divider-text">Atau</div>
            </div>

            <div class="d-flex justify-content-center">
              {{-- <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                                <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                                <i class="tf-icons fa-brands fa-google fs-5"></i>
                            </a> --}}

              <a href="https://abuubaidah.com/" class="small">
                {{-- <i class="tf-icons fa-brands fa-twitter fs-5"></i> --}}
                Kembali ke Landing Page
              </a>
            </div>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>
@endsection
