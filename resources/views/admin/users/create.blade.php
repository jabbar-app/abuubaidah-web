@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data User</h4>
      <a href="{{ route('users.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    {{-- <hr class="mb-5"> --}}

    <div class="d-flex justify-content-center">
      <div class="card col-xl-8 col-md-10 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Tambah User</h5>
          <small class="text-muted float-end">
            إضافة مستخدم
          </small>
        </div>
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('users.store') }}" method="POST" class="theme-form">
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

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
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
@endsection
