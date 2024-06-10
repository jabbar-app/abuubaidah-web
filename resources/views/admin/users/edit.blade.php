@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data User
      </h4>
      <a href="{{ route('users.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    {{-- <hr class="mb-5"> --}}

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data"
      class="needs-validation was-validated" novalidate>
      @csrf
      @method('PUT')
      <div class="card">
        <div class="row">
          <div class="col-xl-6 col-sm-12">
            <div class="card-header">
              <h5 class="mb-0">Data Akun</h5>
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

              <h4 class="mb-4">Data Akun</h4>
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
                <input type="text" name="name" value="{{ $user->name }}" placeholder="Nama Lengkap"
                  class="form-control" required>
              </div>
              <div class="form-group">
                <label class="col-form-label">NIK</label>
                <input type="number" name="nik" class="form-control" value="{{ $user->nik }}" placeholder="NIK"
                  required>
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
                  <input type="password" id="password" class="form-control" name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password" />
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
                <input type="number" name="phone" value="{{ $user->phone }}" placeholder="62XXX" class="form-control"
                  required>
              </div>

              <input type="hidden" name="religion" value="Islam">

              <div class="row">
                <div class="form-group col-6">
                  <label class="col-form-label">Tempat Lahir</label>
                  <input type="text" name="tempat_lahir" value="{{ $user->tempat_lahir }}" placeholder="Sesuai KTP"
                    class="form-control" required>
                </div>

                <div class="form-group col-6">
                  <label class="col-form-label">Tanggal Lahir</label>
                  <input type="date" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}" placeholder="Sesuai KTP"
                    class="form-control" required>
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
                  <input type="text" name="suku" value="{{ $user->suku }}" placeholder="Suku"
                    class="form-control" required>
                </div>
              </div>

              @php
                $address = json_decode($user->address, true);
              @endphp

              <div class="form-group">
                <label class="col-form-label">Alamat</label>
                <textarea name="address" rows="2" class="form-control" placeholder="Alamat" required>{{ $address['address'] ?? $user->address }}</textarea>
              </div>

              <div class="form-group">
                <label class="col-form-label">Provinsi</label>
                <select class="form-control" name="province" id="provinsi" required>
                  <option value="">Pilih Provinsi</option>
                  <!-- Anda perlu mengisi daftar provinsi di sini -->
                  @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" {{ $provinceName == $province->name ? 'selected' : '' }}>
                      {{ $province->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label class="col-form-label">Kabupaten</label>
                @if (isset($address['regency']))
                  <input type="hidden" name="regency" value="{{ $regencyId }}">
                @endif
                <select class="form-control" name="regency" id="kabupaten"
                  {{ isset($address['district']) ? 'disabled' : '' }} required>
                  <option value="">Pilih Kabupaten</option>
                  <option value="{{ $regencyId }}" {{ $regencyId == $user->regency ? 'selected' : '' }}>
                    {{ $regencyName }}
                  </option>
                </select>
              </div>
              <div class="form-group">
                <label class="col-form-label">Kecamatan</label>
                @if (isset($address['district']))
                  <input type="hidden" name="district" value="{{ $districtId }}">
                @endif
                <select class="form-control" name="district" id="kecamatan"
                  {{ isset($address['district']) ? 'disabled' : '' }} required>
                  <option value="">Pilih Kecamatan</option>
                  <option value="{{ $districtId }}" {{ $districtId == $user->district ? 'selected' : '' }}>
                    {{ $districtName }}
                  </option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-xl-6 col-sm-12">
            <div class="card-header">
              <h5 class="mb-0">Data Pendidikan</h5>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label" for="nama_sd">Nama Sekolah Dasar</label>
                  <input class="form-control" name="nama_sd" id="nama_sd" type="text"
                    value="{{ $user->nama_sd }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="lulus_sd">Tahun Lulus</label>
                  <input class="form-control" name="lulus_sd" id="lulus_sd" type="text"
                    value="{{ $user->lulus_sd }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="nama_smp">Nama Sekolah Menengah Pertama</label>
                  <input class="form-control" name="nama_smp" id="nama_smp" type="text"
                    value="{{ $user->nama_smp }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="lulus_smp">Tahun Lulus</label>
                  <input class="form-control" name="lulus_smp" id="lulus_smp" type="text"
                    value="{{ $user->lulus_smp }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="nama_sma">Nama Sekolah Menengah Atas</label>
                  <input class="form-control" name="nama_sma" id="nama_sma" type="text"
                    value="{{ $user->nama_sma }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="lulus_sma">Tahun Lulus</label>
                  <input class="form-control" name="lulus_sma" id="lulus_sma" type="text"
                    value="{{ $user->lulus_sma }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="ukuran_almamater">Ukuran Almamater
                    {{ $user->ukuran_almamater }}
                  </label>
                  <select name="ukuran_almamater" id="ukuran_almamater" class="form-select" required>
                    <option value="">- Pilih Ukuran -</option>
                    <option value="S" {{ $user->ukuran_almamater == 'S' ? 'selected' : '' }}>S</option>
                    <option value="M" {{ $user->ukuran_almamater == 'M' ? 'selected' : '' }}>M</option>
                    <option value="L" {{ $user->ukuran_almamater == 'L' ? 'selected' : '' }}>L</option>
                    <option value="XL" {{ $user->ukuran_almamater == 'XL' ? 'selected' : '' }}>XL</option>
                    <option value="XXL" {{ $user->ukuran_almamater == 'XXL' ? 'selected' : '' }}>XXL</option>
                  </select>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="perguruan_tinggi">Nama Perguruan Tinggi</label>
                  <input class="form-control" name="perguruan_tinggi" id="perguruan_tinggi" type="text"
                    value="{{ $user->perguruan_tinggi }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="nama_ayah">Nama Ayah</label>
                  <input class="form-control" name="nama_ayah" id="nama_ayah" type="text"
                    value="{{ $user->nama_ayah }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="status_ayah">Status Ayah</label>
                  <select name="status_ayah" id="status_ayah" class="form-select" required>
                    <option value="">- Pilih Data -</option>
                    <option value="Masih Hidup" {{ $user->status_ayah == 'Masih Hidup' ? 'selected' : '' }}>Masih
                      Hidup
                    </option>
                    <option value="Sudah Meninggal" {{ $user->status_ayah == 'Sudah Meninggal' ? 'selected' : '' }}>
                      Sudah
                      Meninggal</option>
                  </select>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label" for="pekerjaan_ayah">Pekerjaan Ayah</label>
                  <input class="form-control" name="pekerjaan_ayah" id="pekerjaan_ayah" type="text"
                    value="{{ $user->pekerjaan_ayah }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label" for="penghasilan_ayah">Penghasilan Ayah</label>
                  <input class="form-control" name="penghasilan_ayah" id="penghasilan_ayah" type="number"
                    value="{{ $user->penghasilan_ayah }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label" for="telp_ayah">No. Telp Ayah</label>
                  <input class="form-control" name="telp_ayah" id="telp_ayah" type="number"
                    value="{{ $user->telp_ayah }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="nama_ibu">Nama Ibu</label>
                  <input class="form-control" name="nama_ibu" id="nama_ibu" type="text"
                    value="{{ $user->nama_ibu }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="status_ibu">Status Ibu</label>
                  <select name="status_ibu" id="status_ibu" class="form-select" required>
                    <option value="">- Pilih Data -</option>
                    <option value="Masih Hidup" {{ $user->status_ibu == 'Masih Hidup' ? 'selected' : '' }}>Masih
                      Hidup
                    </option>
                    <option value="Sudah Meninggal" {{ $user->status_ibu == 'Sudah Meninggal' ? 'selected' : '' }}>
                      Sudah
                      Meninggal</option>
                  </select>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label" for="pekerjaan_ibu">Pekerjaan Ibu</label>
                  <input class="form-control" name="pekerjaan_ibu" id="pekerjaan_ibu" type="text"
                    value="{{ $user->pekerjaan_ibu }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label" for="penghasilan_ibu">Penghasilan Ibu</label>
                  <input class="form-control" name="penghasilan_ibu" id="penghasilan_ibu" type="number"
                    value="{{ $user->penghasilan_ibu }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label" for="telp_ibu">No. Telp Ibu</label>
                  <input class="form-control" name="telp_ibu" id="telp_ibu" type="number"
                    value="{{ $user->telp_ibu }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Belum diisi!</div>
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="url_ktp">Upload KTP</label>
                  <input class="form-control" type="file" name="url_ktp" id="url_ktp">
                  @if ($user->url_ktp)
                    Berkas: <a href="{{ asset($user->url_ktp) }}" target="_blank" class="mt-2">Lihat</a>
                    <div class="valid-feedback">Terisi!</div>
                  @else
                    <div class="invalid-feedback">Tidak boleh kosong!</div>
                  @endif
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="url_kk">Upload KK</label>
                  <input class="form-control" type="file" name="url_kk" id="url_kk">
                  @if ($user->url_kk)
                    Berkas: <a href="{{ asset($user->url_kk) }}" target="_blank" class="mt-2">Lihat</a>
                    <div class="valid-feedback">Terisi!</div>
                  @else
                    <div class="invalid-feedback">Tidak boleh kosong!</div>
                  @endif
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="url_ijazah">Upload Ijazah</label>
                  <input class="form-control" type="file" name="url_ijazah" id="url_ijazah">
                  @if ($user->url_ijazah)
                    Berkas: <a href="{{ asset($user->url_ijazah) }}" target="_blank" class="mt-2">Lihat</a>
                    <div class="valid-feedback">Terisi!</div>
                  @else
                    <div class="invalid-feedback">Tidak boleh kosong!</div>
                  @endif
                </div>

                <div class="col-md-6">
                  <label class="form-label" for="url_bilhaq">Upload Bilhaq</label>
                  <input class="form-control" type="file" name="url_bilhaq" id="url_bilhaq">
                  @if ($user->url_bilhaq)
                    Berkas: <a href="{{ asset($user->url_bilhaq) }}" target="_blank" class="mt-2">Lihat</a>
                  @endif
                  <div class="valid-feedback">Opsional!</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button class="btn btn-primary float-end mt-4 mb-5" type="submit">Update Data</button>
    </form>
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
              $('#kabupaten').append('<option value="' + regency.id + '">' + regency.name +
                '</option>');
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
              $('#kecamatan').append('<option value="' + district.id + '">' + district.name +
                '</option>');
            });
          }
        });
      });
    });
  </script>
@endsection
