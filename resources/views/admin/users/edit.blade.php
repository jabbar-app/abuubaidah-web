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

          <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
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
              <input type="text" name="name" value="{{ $user->name }}" placeholder="Nama Lengkap" class="form-control" required>
            </div>
            <div class="form-group">
              <label class="col-form-label">NIK</label>
              <input type="number" name="nik" class="form-control" value="{{ $user->nik }}" placeholder="NIK" required>
            </div>
            <div class="form-group mb-3">
              <label class="col-form-label">Email</label>
              <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="col-form-label" for="password">Password</label>
                @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}" class="mt-2">
                    <small>Kirim link reset password</small>
                  </a>
                @endif
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <small class="input-group-text cursor-pointer" style="font-size: 12px;">lihat</small>
              </div>
            </div>
            <div class="form-group">
              <label class="col-form-label">Jenis Kelamin</label>
              <select name="gender" class="form-control" required>
                <option value="Laki-laki" {{ $user->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ $user->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
              </select>
            </div>
            <div class="form-group">
              <label class="col-form-label">No. WhatsApp</label>
              <input type="number" name="phone" value="{{ $user->phone }}" placeholder="62XXX" class="form-control" required>
            </div>

            <input type="hidden" name="religion" value="Islam">

            <div class="row">
              <div class="form-group col-6">
                <label class="col-form-label">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ $user->tempat_lahir }}" placeholder="Sesuai KTP" class="form-control" required>
              </div>

              <div class="form-group col-6">
                <label class="col-form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}" placeholder="Sesuai KTP" class="form-control" required>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-6">
                <label class="col-form-label" for="status_perkawinan">Status Perkawinan</label>
                <select class="form-select" name="status_perkawinan" id="status_perkawinan" required>
                  <option selected="" disabled="" value="">- Pilih Data -</option>
                  <option value="Menikah" @if ($user->status_perkawinan == 'Menikah') selected @endif>Menikah</option>
                  <option value="Belum Menikah" @if ($user->status_perkawinan == 'Belum Menikah') selected @endif>Belum Menikah</option>
                  <option value="Janda/Duda" @if ($user->status_perkawinan == 'Janda/Duda') selected @endif>Janda/Duda</option>
                </select>
              </div>

              <div class="form-group col-6">
                <label class="col-form-label">Suku</label>
                <input type="text" name="suku" value="{{ $user->suku }}" placeholder="Suku" class="form-control" required>
              </div>
            </div>

            @php
              $address = json_decode($user->address, true);
            @endphp

            <div class="form-group">
              <label class="col-form-label">Alamat</label>
              <textarea name="address" rows="2" class="form-control" placeholder="Alamat" required>{{ $address['address'] ?? '' }}</textarea>
            </div>

            <div class="form-group">
              <label class="col-form-label">Provinsi</label>
              <select class="form-control" name="province" id="provinsi" required>
                <option value="">Pilih Provinsi</option>
                <!-- Anda perlu mengisi daftar provinsi di sini -->
                @foreach ($provinces as $province)
                  <option value="{{ $province->id }}" {{ $provinceName == $province->name ? 'selected' : '' }}>{{ $province->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label class="col-form-label">Kabupaten</label>
              @if (isset($address['regency']))
                <input type="hidden" name="regency" value="{{ $regencyId }}">
              @endif
              <select class="form-control" name="regency" id="kabupaten" {{ isset($address['district']) ? 'disabled' : '' }} required>
                <option value="">Pilih Kabupaten</option>
                <option value="{{ $regencyId }}" {{ isset($address['regency']) && $address['regency'] != '' ? 'selected' : '' }}>{{ $regencyName }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label class="col-form-label">Kecamatan</label>
              @if (isset($address['district']))
                <input type="hidden" name="district" value="{{ $districtId }}">
              @endif
              <select class="form-control" name="district" id="kecamatan" {{ isset($address['district']) ? 'disabled' : '' }} required>
                <option value="">Pilih Kecamatan</option>
                <!-- Anda perlu mengisi daftar kecamatan di sini -->
                <option value="{{ $districtId }}" {{ isset($address['district']) ? 'selected' : '' }}>{{ $districtName }}
                </option>
              </select>
            </div>

            <button class="btn btn-primary float-end mt-4" type="submit">Update Data</button>
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
