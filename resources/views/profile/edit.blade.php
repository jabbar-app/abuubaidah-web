@extends('student.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Edit Profil</h4>

    <div class="card mb-4">
      <h5 class="card-header">Data Akun</h5>
      <!-- Account -->
      {{-- <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
          <img src="{{ asset('assets/img/mahad/abuubaidah_circle.svg') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
          <div class="button-wrapper">
            <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
              <span class="d-none d-sm-block">Upload foto profil</span>
              <i class="ti ti-upload d-block d-sm-none"></i>
              <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
            </label>
            <button type="button" class="btn btn-label-secondary account-image-reset mb-3">
              <i class="ti ti-refresh-dot d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Reset</span>
            </button>

            <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>
          </div>
        </div>
      </div> --}}
      <hr class="my-0" />
      <div class="card-body">
        <form action="{{ route('profile.update') }}" method="POST" class="card needs-validation was-validated" novalidate>
          @csrf
          <div class="card-header">
            <h4>
              Data Akun
              <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#akun" aria-expanded="false" style="font-size: 12px;">Show/Hide</button>
            </h4>
          </div>
          <div class="collapse show" id="akun" aria-labelledby="akun" data-parent="#accordionoc">
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label" for="name">Nama Lengkap</label>
                  <input class="form-control" name="name" id="name" type="text" value="{{ $user->name }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="nik">NIK</label>
                  <input class="form-control" name="nik" id="nik" type="number" value="{{ $user->nik }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label" for="email">Email</label>
                  <div class="input-group left-radius"><span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input class="form-control" name="email" id="email" type="email" value="{{ $user->email }}" aria-describedby="inputGroupPrepend" required>
                    <div class="valid-feedback">Terisi!</div>
                    <div class="invalid-feedback">Tidak boleh kosong!</div>
                  </div>
                </div>
                <div class="col-md-4">
                  <label class="form-label" for="phone">WhatsApp</label>
                  <input class="form-control" name="phone" id="phone" type="number" value="{{ $user->phone }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label" for="password">Password</label>
                  <input class="form-control" name="password" id="password" type="password" placeholder="************">
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                  <input class="form-control" name="tempat_lahir" id="tempat_lahir" type="text" value="{{ $user->tempat_lahir }}" placeholder="Sesuai KTP" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                  <input class="form-control" name="tanggal_lahir" id="tanggal_lahir" type="date" value="{{ $user->tanggal_lahir }}" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                </div>
                <div class="col-md-4">
                  <label class="form-label" for="status_perkawinan">Status Perkawinan</label>
                  <select class="form-select" name="status_perkawinan" id="status_perkawinan" required>
                    <option selected="" disabled="" value="">- Pilih Data -</option>
                    <option value="Menikah" @if ($user->status_perkawinan == 'Menikah') selected @endif>Menikah</option>
                    <option value="Belum Menikah" @if ($user->status_perkawinan == 'Belum Menikah') selected @endif>Belum Menikah</option>
                    <option value="Janda/Duda" @if ($user->status_perkawinan == 'Janda/Duda') selected @endif>Janda/Duda</option>
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
                  <input class="form-control" name="suku" id="suku" type="text" value="{{ $user->suku }}" placeholder="Sesuai KTP" required>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                </div>
                @php
                  $address = json_decode($user->address, true);
                @endphp

                <div class="col-md-12">
                  <label class="form-label" for="address">Alamat</label>
                  <textarea name="address" id="address" class="form-control" rows="2" required>{{ $address['address'] ?? '' }}</textarea>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                </div>

                <div class="col-md-4">
                  <label class="col-form-label">Provinsi</label>
                  <select class="form-control" name="province" id="provinsi" required>
                    <option value="">Pilih Provinsi</option>
                    <!-- Anda perlu mengisi daftar provinsi di sini -->
                    {{-- @foreach ($provinces as $province)
                      <option value="{{ $province->id }}" {{ $provinceName == $province->name ? 'selected' : '' }}>{{ $province->name }}</option>
                    @endforeach --}}

                  </select>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                </div>

                <div class="col-md-4">
                  <label class="col-form-label">Kabupaten/Kota</label>
                  @if (isset($address['regency']))
                    <input type="hidden" name="regency" value="{{ $regencyId }}">
                  @endif
                  <select class="form-control" name="regency" id="kabupaten" {{ isset($address['district']) ? 'disabled' : '' }} required>
                    <option value="">Pilih Kabupaten</option>
                    {{-- <option value="{{ $regencyId }}" {{ isset($address['regency']) && $address['regency'] != '' ? 'selected' : '' }}>{{ $regencyName }}
                    </option> --}}
                  </select>
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                </div>

                <div class="col-md-4">
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
                  <div class="valid-feedback">Terisi!</div>
                  <div class="invalid-feedback">Tidak boleh kosong!</div>
                </div>

                <button class="btn btn-lg btn-primary float-end mt-5" type="submit">Update Data Akun</button>
              </div>
            </div>
          </div>
        </form>
        {{-- <form id="formAccountSettings" method="GET" onsubmit="return false">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="firstName" class="form-label">First Name</label>
              <input class="form-control" type="text" id="firstName" name="firstName" value="John" autofocus />
            </div>
            <div class="mb-3 col-md-6">
              <label for="lastName" class="form-label">Last Name</label>
              <input class="form-control" type="text" name="lastName" id="lastName" value="Doe" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">E-mail</label>
              <input class="form-control" type="text" id="email" name="email" value="john.doe@example.com" placeholder="john.doe@example.com" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="organization" class="form-label">Organization</label>
              <input type="text" class="form-control" id="organization" name="organization" value="Pixinvent" />
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label" for="phoneNumber">Phone Number</label>
              <div class="input-group input-group-merge">
                <span class="input-group-text">US (+1)</span>
                <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" placeholder="202 555 0111" />
              </div>
            </div>
            <div class="mb-3 col-md-6">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name="address" placeholder="Address" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="state" class="form-label">State</label>
              <input class="form-control" type="text" id="state" name="state" placeholder="California" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="zipCode" class="form-label">Zip Code</label>
              <input type="text" class="form-control" id="zipCode" name="zipCode" placeholder="231465" maxlength="6" />
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label" for="country">Country</label>
              <select id="country" class="select2 form-select">
                <option value="">Select</option>
                <option value="Australia">Australia</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Belarus">Belarus</option>
                <option value="Brazil">Brazil</option>
                <option value="Canada">Canada</option>
                <option value="China">China</option>
                <option value="France">France</option>
                <option value="Germany">Germany</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Japan">Japan</option>
                <option value="Korea">Korea, Republic of</option>
                <option value="Mexico">Mexico</option>
                <option value="Philippines">Philippines</option>
                <option value="Russia">Russian Federation</option>
                <option value="South Africa">South Africa</option>
                <option value="Thailand">Thailand</option>
                <option value="Turkey">Turkey</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="United States">United States</option>
              </select>
            </div>
            <div class="mb-3 col-md-6">
              <label for="language" class="form-label">Language</label>
              <select id="language" class="select2 form-select">
                <option value="">Select Language</option>
                <option value="en">English</option>
                <option value="fr">French</option>
                <option value="de">German</option>
                <option value="pt">Portuguese</option>
              </select>
            </div>
            <div class="mb-3 col-md-6">
              <label for="timeZones" class="form-label">Timezone</label>
              <select id="timeZones" class="select2 form-select">
                <option value="">Select Timezone</option>
                <option value="-12">(GMT-12:00) International Date Line West</option>
                <option value="-11">(GMT-11:00) Midway Island, Samoa</option>
                <option value="-10">(GMT-10:00) Hawaii</option>
                <option value="-9">(GMT-09:00) Alaska</option>
                <option value="-8">(GMT-08:00) Pacific Time (US & Canada)</option>
                <option value="-8">(GMT-08:00) Tijuana, Baja California</option>
                <option value="-7">(GMT-07:00) Arizona</option>
                <option value="-7">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                <option value="-7">(GMT-07:00) Mountain Time (US & Canada)</option>
                <option value="-6">(GMT-06:00) Central America</option>
                <option value="-6">(GMT-06:00) Central Time (US & Canada)</option>
                <option value="-6">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                <option value="-6">(GMT-06:00) Saskatchewan</option>
                <option value="-5">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                <option value="-5">(GMT-05:00) Eastern Time (US & Canada)</option>
                <option value="-5">(GMT-05:00) Indiana (East)</option>
                <option value="-4">(GMT-04:00) Atlantic Time (Canada)</option>
                <option value="-4">(GMT-04:00) Caracas, La Paz</option>
              </select>
            </div>
            <div class="mb-3 col-md-6">
              <label for="currency" class="form-label">Currency</label>
              <select id="currency" class="select2 form-select">
                <option value="">Select Currency</option>
                <option value="usd">USD</option>
                <option value="euro">Euro</option>
                <option value="pound">Pound</option>
                <option value="bitcoin">Bitcoin</option>
              </select>
            </div>
          </div>
          <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Save changes</button>
            <button type="reset" class="btn btn-label-secondary">Cancel</button>
          </div>
        </form> --}}
      </div>
      <!-- /Account -->
    </div>
    <div class="card">
      <h5 class="card-header">Hapus Akun</h5>
      <div class="card-body">
        <div class="mb-3 col-12">
          <div class="alert alert-warning">
            <h3 class="alert-heading mb-1">Apa kamu yakin ingin menghapus akunmu?</h3>
            <p class="my-3">Harap diingat bahwa tindakan ini tidak dapat diulangi. Sekali kamu menghapus akun, maka seluruh data akun akan hilang dan tidak dapat dikembalikan lagi..</p>
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
        {{-- <form id="formAccountDeactivation" onsubmit="return false">
          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation" />
            <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
          </div>
          <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
        </form> --}}
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection
