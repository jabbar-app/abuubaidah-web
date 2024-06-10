@extends('student.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Edit Profil</h4>

    @if (session('success'))
      <div class="row my-2">
        <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>Berhasil!
          </strong> {{ session('success') }}
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @elseif(session('danger'))
      <div class="row my-2">
        <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><strong>Gagal!
          </strong> {{ session('danger') }}
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif

    <div class="card mb-4">
      <h5 class="card-header">Data Akun</h5>
      <!-- Account -->
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
          <img
            src="{{ $user->url_pas_foto ? asset($user->url_pas_foto) : asset('assets/img/mahad/abuubaidah_circle.svg') }}"
            alt="user-avatar" class="d-block w-px-200 h-px-200 rounded" id="uploadedAvatar"
            style="border-radius: 250px !important;" />
          <div class="button-wrapper">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <!-- Hidden input field for profile photo -->
              <input type="file" name="url_pas_foto" id="upload" class="account-file-input"
                accept="image/png, image/jpeg" hidden onchange="previewImage(event)" />

              <!-- Label for file input -->
              <label for="upload" class="btn btn-outline-primary me-2 mb-3" tabindex="0">
                <span class="d-none d-sm-block">Pilih foto profil</span>
                <i class="ti ti-upload d-block d-sm-none"></i>
              </label>

              <!-- Reset button -->
              <button type="button" class="btn btn-label-secondary account-image-reset mb-3" onclick="resetImage()">
                <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                <span class="d-none d-sm-block">Reset</span>
              </button>

              <!-- Additional information -->
              <em class="form-label text-danger">
                <br>
                Wajib tampak wajah dengan jelas!
                <br>
                File Gambar maksimal 2MB.
                <br>
              </em>

              <!-- Submit button -->
              <button type="submit" class="btn btn-primary mt-2">Simpan Update</button>
            </form>
          </div>
        </div>

        <script>
          function previewImage(event) {
            const [file] = event.target.files;
            const avatar = document.getElementById('uploadedAvatar');
            if (file) {
              avatar.src = URL.createObjectURL(file);
            }
          }

          function resetImage() {
            const avatar = document.getElementById('uploadedAvatar');
            const upload = document.getElementById('upload');
            // Reset the file input value
            upload.value = '';
            // Optionally, reset the preview to a default image
            avatar.src = "{{ asset('assets/img/mahad/abuubaidah_circle.svg') }}";
          }
        </script>

      </div>
      <hr class="my-0" />
      <form action="{{ route('profile.update') }}" method="POST" class="card needs-validation was-validated" novalidate>
        @csrf
        <div class="collapse show" id="akun" aria-labelledby="akun" data-parent="#accordionoc">
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label" for="name">Nama Lengkap</label>
                <input class="form-control" name="name" id="name" type="text" value="{{ $user->name }}"
                  required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Tidak boleh kosong!</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="nik">NIK</label>
                <input class="form-control" name="nik" id="nik" type="number" value="{{ $user->nik }}"
                  required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Tidak boleh kosong!</div>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label" for="email">Email</label>
                <div class="input-group left-radius"><span class="input-group-text" id="inputGroupPrepend">@</span>
                  <input class="form-control" name="email" id="email" type="email" value="{{ $user->email }}"
                    aria-describedby="inputGroupPrepend" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">No. WhatsApp</label>
                  <input type="tel" name="phone" value="{{ $user->phone ?: old('phone') }}" placeholder="62XXX"
                    pattern="^62[1-9][0-9]*$" oninput="validatePhoneNumber(this)" class="form-control" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
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
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Tidak boleh kosong!</div>
              </div>
              <div class="col-md-4">
                <label class="form-label" for="password">Password</label>
                <input class="form-control" name="password" id="password" type="password"
                  placeholder="************">
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Tidak boleh kosong!</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                <input class="form-control" name="tempat_lahir" id="tempat_lahir" type="text"
                  value="{{ $user->tempat_lahir }}" placeholder="Sesuai KTP" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Tidak boleh kosong!</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                <input class="form-control" name="tanggal_lahir" id="tanggal_lahir" type="date"
                  value="{{ $user->tanggal_lahir }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Tidak boleh kosong!</div>
              </div>
              <div class="col-md-4">
                <label class="form-label" for="status_perkawinan">Status Perkawinan</label>
                <select class="form-select" name="status_perkawinan" id="status_perkawinan" required>
                  <option selected="" disabled="" value="">- Pilih Data -</option>
                  <option value="Menikah" @if ($user->status_perkawinan == 'Menikah') selected @endif>Menikah
                  </option>
                  <option value="Belum Menikah" @if ($user->status_perkawinan == 'Belum Menikah') selected @endif>Belum
                    Menikah</option>
                  <option value="Janda/Duda" @if ($user->status_perkawinan == 'Janda/Duda') selected @endif>Janda/Duda
                  </option>
                </select>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Tidak boleh kosong!</div>
              </div>
              <div class="col-md-4">
                <label class="form-label" for="agama">Agama</label>
                <select class="form-select" name="agama" id="agama" required>
                  <option value="Islam" selected>Islam</option>
                </select>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Tidak boleh kosong!</div>
              </div>
              <div class="col-md-4">
                <label class="form-label" for="suku">Suku</label>
                <input class="form-control" name="suku" id="suku" type="text" value="{{ $user->suku }}"
                  placeholder="Sesuai KTP" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Tidak boleh kosong!</div>
              </div>

              <div class="col-md-12">
                <label class="form-label" for="address">Alamat</label>
                <textarea name="address" id="address" class="form-control" rows="2" required>{{ $user->address ?? '' }}</textarea>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Tidak boleh kosong!</div>
              </div>

              <div class="col-md-4">
                <label class="col-form-label">Provinsi</label>
                <select class="form-control" name="province" id="provinsi" required>
                  <option value="">Pilih Provinsi</option>
                  @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" {{ $user->province == $province->id ? 'selected' : '' }}>
                      {{ $province->name }}
                    </option>
                  @endforeach
                </select>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Tidak boleh kosong!</div>
              </div>

              @foreach ($regencies as $regency)
                {{ $regency->name }}
              @endforeach
              <div class="col-md-4">
                <label class="col-form-label">Kabupaten/Kota</label>
                <select class="form-control" name="regency" id="regency" required>
                  <option value="">Pilih Kabupaten</option>
                  @foreach ($regencies as $regency)
                    <option value="{{ $regency->id }}" {{ $user->regency == $regency->id ? 'selected' : '' }}>
                      {{ $regency->name }}
                    </option>
                  @endforeach
                </select>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Tidak boleh kosong!</div>
              </div>

              <div class="col-md-4">
                <label class="col-form-label">Kecamatan</label>
                <select class="form-control" name="district" id="district" required>
                  <option value="">Pilih Kecamatan</option>
                  @foreach ($districts as $district)
                    <option value="{{ $district->id }}" {{ $user->district == $district->id ? 'selected' : '' }}>
                      {{ $district->name }}
                    </option>
                  @endforeach
                </select>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Tidak boleh kosong!</div>
              </div>
            </div>

            <button class="btn btn-md btn-primary float-end my-5" type="submit">Update Data Akun</button>
          </div>
        </div>
      </form>
      <!-- /Account -->
    </div>

    <div class="card mb-4">
      <h5 class="card-header">Data Pendidikan</h5>
      <hr class="my-0" />
      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
        class="card needs-validation was-validated" novalidate>
        @csrf
        <div class="collapse show" id="akun" aria-labelledby="akun" data-parent="#accordionoc">
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label" for="nama_sd">Nama Sekolah Dasar</label>
                <input class="form-control" name="nama_sd" id="nama_sd" type="text"
                  value="{{ old('nama_sd', $user->nama_sd) }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="lulus_sd">Tahun Lulus</label>
                <input class="form-control" name="lulus_sd" id="lulus_sd" type="number"
                  value="{{ old('lulus_sd', $user->lulus_sd) }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="nama_smp">Nama Sekolah Menengah Pertama</label>
                <input class="form-control" name="nama_smp" id="nama_smp" type="text"
                  value="{{ old('nama_smp', $user->nama_smp) }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="lulus_smp">Tahun Lulus</label>
                <input class="form-control" name="lulus_smp" id="lulus_smp" type="number"
                  value="{{ old('lulus_smp', $user->lulus_smp) }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="nama_sma">Nama Sekolah Menengah Atas</label>
                <input class="form-control" name="nama_sma" id="nama_sma" type="text"
                  value="{{ old('nama_sma', $user->nama_sma) }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="lulus_sma">Tahun Lulus</label>
                <input class="form-control" name="lulus_sma" id="lulus_sma" type="number"
                  value="{{ old('lulus_sma', $user->lulus_sma) }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="ukuran_almamater">Ukuran Almamater
                  {{ $user->ukuran_almamater }}
                </label>
                <select name="ukuran_almamater" id="ukuran_almamater" class="form-select" required>
                  <option value="">- Pilih Ukuran -</option>
                  <option value="S"
                    {{ old('ukuran_almamater', $user->ukuran_almamater) == 'S' ? 'selected' : '' }}>S</option>
                  <option value="M"
                    {{ old('ukuran_almamater', $user->ukuran_almamater) == 'M' ? 'selected' : '' }}>M</option>
                  <option value="L"
                    {{ old('ukuran_almamater', $user->ukuran_almamater) == 'L' ? 'selected' : '' }}>L</option>
                  <option value="XL"
                    {{ old('ukuran_almamater', $user->ukuran_almamater) == 'XL' ? 'selected' : '' }}>XL</option>
                  <option value="XXL"
                    {{ old('ukuran_almamater', $user->ukuran_almamater) == 'XXL' ? 'selected' : '' }}>XXL</option>
                </select>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="perguruan_tinggi">Nama Perguruan Tinggi</label>
                <input class="form-control" name="perguruan_tinggi" id="perguruan_tinggi" type="text"
                  value="{{ old('perguruan_tinggi', $user->perguruan_tinggi) }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Tidak boleh kosong!</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="nama_ayah">Nama Ayah</label>
                <input class="form-control" name="nama_ayah" id="nama_ayah" type="text"
                  value="{{ old('nama_ayah', $user->nama_ayah) }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="status_ayah">Status Ayah</label>
                <select name="status_ayah" id="status_ayah" class="form-select" required
                  onchange="toggleFatherDetails()">
                  <option value="">- Pilih Data -</option>
                  <option value="Masih Hidup"
                    {{ old('status_ayah', $user->status_ayah) == 'Masih Hidup' ? 'selected' : '' }}>Masih Hidup
                  </option>
                  <option value="Sudah Meninggal"
                    {{ old('status_ayah', $user->status_ayah) == 'Sudah Meninggal' ? 'selected' : '' }}>Sudah
                    Meninggal</option>
                </select>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-4">
                <label class="form-label" for="pekerjaan_ayah">Pekerjaan Ayah</label>
                <input class="form-control" name="pekerjaan_ayah" id="pekerjaan_ayah" type="text"
                  value="{{ old('pekerjaan_ayah', $user->pekerjaan_ayah) }}"
                  data-initial="{{ old('pekerjaan_ayah', $user->pekerjaan_ayah) }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-4">
                <label class="form-label" for="penghasilan_ayah">Penghasilan Ayah</label>
                <input class="form-control" name="penghasilan_ayah" id="penghasilan_ayah" type="number"
                  value="{{ old('penghasilan_ayah', $user->penghasilan_ayah) }}"
                  data-initial="{{ old('penghasilan_ayah', $user->penghasilan_ayah) }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-4">
                <label class="form-label" for="telp_ayah">No. Telp Ayah</label>
                <input class="form-control" name="telp_ayah" id="telp_ayah" type="number"
                  value="{{ old('telp_ayah', $user->telp_ayah) }}"
                  data-initial="{{ old('telp_ayah', $user->telp_ayah) }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>

              <script>
                function toggleFatherDetails() {
                  const statusIbu = document.getElementById('status_ayah').value;
                  const ibuFields = ['pekerjaan_ayah', 'penghasilan_ayah', 'telp_ayah'];

                  ibuFields.forEach(field => {
                    const input = document.getElementById(field);

                    if (statusIbu === 'Sudah Meninggal') {
                      input.value = '-';
                      input.disabled = true;
                    } else {
                      input.disabled = false;
                      input.value = input.dataset.initial || '';
                    }
                  });
                }

                // Initialize the toggle function to handle preselected values
                document.addEventListener('DOMContentLoaded', toggleMotherDetails);
              </script>

              <div class="col-md-6">
                <label class="form-label" for="nama_ibu">Nama Ibu</label>
                <input class="form-control" name="nama_ibu" id="nama_ibu" type="text"
                  value="{{ old('nama_ibu', $user->nama_ibu) }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-6">
                <label class="form-label" for="status_ibu">Status Ibu</label>
                <select name="status_ibu" id="status_ibu" class="form-select" required
                  onchange="toggleMotherDetails()">
                  <option value="">- Pilih Data -</option>
                  <option value="Masih Hidup"
                    {{ old('status_ibu', $user->status_ibu) == 'Masih Hidup' ? 'selected' : '' }}>Masih Hidup
                  </option>
                  <option value="Sudah Meninggal"
                    {{ old('status_ibu', $user->status_ibu) == 'Sudah Meninggal' ? 'selected' : '' }}>Sudah
                    Meninggal</option>
                </select>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-4">
                <label class="form-label" for="pekerjaan_ibu">Pekerjaan Ibu</label>
                <input class="form-control" name="pekerjaan_ibu" id="pekerjaan_ibu" type="text"
                  value="{{ old('pekerjaan_ibu', $user->pekerjaan_ibu) }}"
                  data-initial="{{ old('pekerjaan_ibu', $user->pekerjaan_ibu) }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-4">
                <label class="form-label" for="penghasilan_ibu">Penghasilan Ibu</label>
                <input class="form-control" name="penghasilan_ibu" id="penghasilan_ibu" type="number"
                  value="{{ old('penghasilan_ibu', $user->penghasilan_ibu) }}"
                  data-initial="{{ old('penghasilan_ibu', $user->penghasilan_ibu) }}" required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>
              <div class="col-md-4">
                <label class="form-label" for="telp_ibu">No. Telp Ibu</label>
                <input class="form-control" name="telp_ibu" id="telp_ibu" type="number"
                  value="{{ old('telp_ibu', $user->telp_ibu) }}" data-initial="{{ old('telp_ibu', $user->telp_ibu) }}"
                  required>
                <div class="valid-feedback">Terisi!</div>
                <div class="invalid-feedback">Belum diisi!</div>
              </div>

              <script>
                function toggleMotherDetails() {
                  const statusIbu = document.getElementById('status_ibu').value;
                  const ibuFields = ['pekerjaan_ibu', 'penghasilan_ibu', 'telp_ibu'];

                  ibuFields.forEach(field => {
                    const input = document.getElementById(field);

                    if (statusIbu === 'Sudah Meninggal') {
                      input.value = '-';
                      input.disabled = true;
                    } else {
                      input.disabled = false;
                      input.value = input.dataset.initial || '';
                    }
                  });
                }

                // Initialize the toggle function to handle preselected values
                document.addEventListener('DOMContentLoaded', toggleMotherDetails);
              </script>


              <div class="col-md-6">
                <label class="form-label" for="url_ktp">Upload KTP</label>
                <em class="form-label text-danger">File JPG/PDF maksimal 2MB.</em>
                <input class="form-control" type="file" name="url_ktp" id="url_ktp" accept=".jpg,.jpeg,.pdf"
                  onchange="validateFileSize(this)">
                @if ($user->url_ktp)
                  Berkas: <a href="{{ asset($user->url_ktp) }}" target="_blank" class="mt-2">Lihat</a>
                  <div class="valid-feedback">Terisi!</div>
                @else
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                @endif
              </div>

              <div class="col-md-6">
                <label class="form-label" for="url_kk">Upload KK</label>
                <em class="form-label text-danger">File JPG/PDF maksimal 2MB.</em>
                <input class="form-control" type="file" name="url_kk" id="url_kk" accept=".jpg,.jpeg,.pdf"
                  onchange="validateFileSize(this)">
                @if ($user->url_kk)
                  Berkas: <a href="{{ asset($user->url_kk) }}" target="_blank" class="mt-2">Lihat</a>
                  <div class="valid-feedback">Terisi!</div>
                @else
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                @endif
              </div>

              <div class="col-md-6">
                <label class="form-label" for="url_ijazah">Upload Ijazah</label>
                <em class="form-label text-danger">File JPG/PDF maksimal 2MB.</em>
                <input class="form-control" type="file" name="url_ijazah" id="url_ijazah" accept=".jpg,.jpeg,.pdf"
                  onchange="validateFileSize(this)">
                @if ($user->url_ijazah)
                  Berkas: <a href="{{ asset($user->url_ijazah) }}" target="_blank" class="mt-2">Lihat</a>
                  <div class="valid-feedback">Terisi!</div>
                @else
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                @endif
              </div>

              <div class="col-md-6">
                <label class="form-label" for="url_bilhaq">Upload Bilhaq</label>
                <em class="form-label text-danger">File JPG/PDF maksimal 2MB.</em>
                <input class="form-control" type="file" name="url_bilhaq" id="url_bilhaq" accept=".jpg,.jpeg,.pdf"
                  onchange="validateFileSize(this)">
                @if ($user->url_bilhaq)
                  Berkas: <a href="{{ asset($user->url_bilhaq) }}" target="_blank" class="mt-2">Lihat</a>
                @endif
                <div class="valid-feedback">Opsional!</div>
                <em class="form-label text-danger">Upload Bilhaq khusus untuk pendaftar Tahfizh.</em>
              </div>
            </div>

            <button class="btn btn-md btn-primary float-end my-5" type="submit">Update Data Akun</button>
          </div>
        </div>
      </form>

    </div>

    {{-- <div class="card">
      <h5 class="card-header">Hapus Akun</h5>
      <div class="card-body">
        <div class="mb-3 col-12">
          <div class="alert alert-warning">
            <h3 class="alert-heading mb-1">Apa kamu yakin ingin menghapus akunmu?</h3>
            <p class="my-3">Harap diingat bahwa tindakan ini tidak dapat diulangi. Sekali kamu menghapus
              akun, maka seluruh data akun akan hilang dan tidak dapat dikembalikan lagi..</p>
          </div>
        </div>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
          @csrf
          @method('delete')
          <div class="col-xl-3 col-md-4 col-sm-12 mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-danger">Hapus Akun</button>
        </form>
      </div>
    </div> --}}
    {{-- <form id="formAccountDeactivation" onsubmit="return false">
      <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation" />
        <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
      </div>
      <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
    </form> --}}

  </div>
@endsection

@section('js')
  <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
  <script>
    function validateFileSize(input) {
      const maxSize = 2 * 1024 * 1024; // 2MB in bytes
      if (input.files[0].size > maxSize) {
        alert("Ukuran file tidak boleh melebihi 2MB.");
        input.value = ''; // Clear the input
      }
    }
  </script>
  <script>
    $(document).ready(function() {
      // Function to load options for "Kabupaten/Kota" dropdown based on selected "Provinsi"
      function loadRegencies(provinsiId) {
        $.ajax({
          url: '/regencies/' + provinsiId,
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            $('#regency').html('<option value="">Pilih Kabupaten</option>');
            $.each(data, function(index, regency) {
              $('#regency').append('<option value="' + regency.id + '" ' + (regency.id ==
                selectedRegencyId ? 'selected' : '') + '>' + regency.name + '</option>');
            });
          }
        });
      }

      // Function to load options for "Kecamatan" dropdown based on selected "Kabupaten/Kota"
      function loadDistricts(kabupatenId) {
        $.ajax({
          url: '/districts/' + kabupatenId,
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            $('#district').html('<option value="">Pilih Kecamatan</option>');
            $.each(data, function(index, district) {
              $('#district').append('<option value="' + district.id + '" ' + (district.id ==
                selectedDistrictId ? 'selected' : '') + '>' + district.name + '</option>');
            });
          }
        });
      }


      // Load options for "Provinsi" dropdown on page load
      $.ajax({
        url: '/provinces',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
          $('#provinsi').html('<option value="">Pilih Provinsi</option>');
          $.each(data, function(index, province) {
            $('#provinsi').append('<option value="' + province.id + '">' + province.name + '</option>');
          });

          // Set selected province based on user data
          var selectedProvinceId = '{{ $user->province ?? '' }}';
          if (selectedProvinceId) {
            $('#provinsi').val(selectedProvinceId);
            loadRegencies(selectedProvinceId);
          }
        }
      });

      // Listener for "Provinsi" dropdown change event
      $('#provinsi').change(function() {
        var provinsiId = $(this).val();
        if (provinsiId) {
          loadRegencies(provinsiId); // Load "Kabupaten/Kota" options
        } else {
          $('#regency').html('<option value="">Pilih Kabupaten</option>');
          $('#district').html('<option value="">Pilih Kecamatan</option>');
        }
      });

      // Set selected regency based on user data
      var selectedRegencyId = '{{ $user->regency ?? '' }}';
      if (selectedRegencyId) {
        $('#regency').val(selectedRegencyId);
        loadDistricts(selectedRegencyId);
      }

      // Listener for "Kabupaten/Kota" dropdown change event
      $('#regency').change(function() {
        var kabupatenId = $(this).val();
        if (kabupatenId) {
          loadDistricts(kabupatenId); // Load "Kecamatan" options
        } else {
          $('#district').html('<option value="">Pilih Kecamatan</option>');
        }
      });

      // Set selected district based on user data
      var selectedDistrictId = '{{ $user->district ?? '' }}';
      if (selectedDistrictId) {
        $('#district').val(selectedDistrictId);
      }
    });
  </script>
@endsection
