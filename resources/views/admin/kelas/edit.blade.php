@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Program</h4>
      <a href="{{ route('admin.kelas.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    {{-- <hr class="mb-5"> --}}

    <div class="d-flex justify-content-center">
      <div class="card col-xl-8 col-md-10 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Edit Program</h5>
          <small class="text-muted float-end">
            تحرير البرنامج
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


          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-user">Nama User</label>
              <div class="col-sm-9">
                <select id="multicol-user" name="user_id" class="select2 form-select" data-allow-clear="true" required>
                  <option value="">Pilih</option>
                  @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $kelas->user_id ? 'selected' : '' }}>
                      {{ $user->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Program</label>
              <div class="col-sm-9">
                <select id="multicol-program" name="program_id" class="select2 form-select" data-allow-clear="true"
                  required>
                  <option value="">Pilih</option>
                  @foreach ($programs as $program)
                    <option value="{{ $program->id }}" {{ $program->id == $kelas->program_id ? 'selected' : '' }}>
                      {{ $program->programmable->title . ', Angkatan ' . $program->programmable->batch }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-class">Tipe Kelas</label>
              <div class="col-sm-9">
                <select name="class" id="class" class="form-select" required>
                  <option value="Kelas Offline (Luring)"
                    {{ $kelas->class == 'Kelas Offline (Luring)' ? 'selected' : '' }}>Kelas Offline (Luring)</option>
                  <option value="Kelas Online (Daring)" {{ $kelas->class == 'Kelas Online (Daring)' ? 'selected' : '' }}>
                    Kelas Online (Daring)</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-level">Level</label>
              <div class="col-sm-9">
                <input type="text" name="level" class="form-control" value="{{ $kelas->level }}">
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-level">Rekomendasi Level Selanjutnya</label>
              <div class="col-sm-9">
                <input type="text" name="next" class="form-control" value="{{ $kelas->next }}">
              </div>
            </div>

            <div class="row mb-3 select2-primary">
              <label class="col-sm-3 col-form-label" for="session-select">Sesi Belajar</label>
              <div class="col-sm-9">
                @php
                  $selectedOptions = json_decode($kelas->session, true);
                  if (!is_array($selectedOptions)) {
                      $selectedOptions = [$selectedOptions];
                  }
                @endphp

                <select id="session-select" class="select2 form-select" multiple name="session[]">
                  @foreach ($allOptions as $option)
                    <option value="{{ $option }}" @if (in_array($option, $selectedOptions)) selected @endif>
                      {{ $option }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-room">Ruang Kelas</label>
              <div class="col-sm-9">
                <input type="text" name="room" class="form-control" value="{{ $kelas->room }}">
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-score">Nilai</label>
              <div class="col-sm-9">
                <input type="text" name="score" class="form-control" value="{{ $kelas->score }}">
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-lecturer">Ustadz(ah)</label>
              <div class="col-sm-9">
                <input type="text" name="lecturer" class="form-control" value="{{ $kelas->lecturer }}">
              </div>
            </div>

            @if (!empty($kelas->nim_temp))
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="multicol-nim_temp">NIM</label>
                <div class="col-sm-9">
                  <input type="number" name="nim_temp" class="form-control" value="{{ $kelas->nim_temp }}">
                </div>
              </div>

              <div class="row mb-5">
                <label class="col-sm-3 col-form-label" for="multicol-nim_valid">Validasi NIM</label>
                <div class="col-sm-9">
                  <select name="nim_valid" id="nim_valid" class="form-select" required>
                    <option value="1" @if ($kelas->nim_valid == true) selected @endif>Valid</option>
                    <option value="0" @if ($kelas->nim_valid == false) selected @endif>Tidak Valid</option>
                  </select>
                </div>
              </div>
            @endif

            @if (!empty($kelas->user->url_bilhaq))
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="multicol-nim_temp">Sertifikat BILHAQ</label>
                <div class="col-sm-9">
                    <a href="{{ asset($kelas->user->url_bilhaq) }}" target="_blank" class="btn btn-outline-primary">Lihat Sertifikat</a>
                </div>
              </div>

              <div class="row mb-5">
                <label class="col-sm-3 col-form-label" for="multicol-nim_valid">Validasi BILHAQ</label>
                <div class="col-sm-9">
                  <select name="nim_valid" id="nim_valid" class="form-select" required>
                    <option value="1">Valid</option>
                    <option value="0">Tidak Valid</option>
                  </select>
                </div>
              </div>
            @endif

            <div class="row mb-5">
              <label class="col-sm-3 col-form-label" for="multicol-status">Status</label>
              <div class="col-sm-9">
                <select name="status" id="status" class="form-select" required>
                  <option value="Menunggu Update" @if ($kelas->status == 'Menunggu Update') selected @endif>Menunggu Update
                  </option>
                  <option value="Sudah Ujian" @if ($kelas->status == 'Sudah Ujian') selected @endif>Sudah Ujian</option>
                  <option value="Daftar Ulang" @if ($kelas->status == 'Daftar Ulang') selected @endif>Daftar Ulang</option>
                  <option value="Daftar Bilhaq" @if ($kelas->status == 'Daftar Bilhaq') selected @endif>Daftar Bilhaq</option>
                  <option value="Aktif" @if ($kelas->status == 'Aktif') selected @endif>Aktif</option>
                  <option value="Tidak Aktif" @if ($kelas->status == 'Tidak Aktif') selected @endif>Tidak Aktif</option>
                  <option value="Selesai" @if ($kelas->status == 'Selesai') selected @endif>Selesai</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-link_whatsapp">Group WA</label>
              <div class="col-sm-9">
                <input type="text" name="link_whatsapp" id="link_whatsapp" class="form-control"
                  value="{{ $kelas->link_whatsapp }}">
              </div>
            </div>

            <button type="submit" class="btn btn-primary float-end">Update</button>
          </form>


        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection
