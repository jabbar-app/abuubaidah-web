@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Kelas</h4>
      <a href="{{ route('admin.kelas.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    {{-- <hr class="mb-5"> --}}

    <div class="d-flex justify-content-center">
      <div class="card col-xl-8 col-md-10 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Tambah Data</h5>
          <small class="text-muted float-end">
            إضافة البيانات
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


          <form method="POST" action="{{ route('create.invoice') }}">
            @csrf
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-user">Pilih User</label>
              <div class="col-sm-9">
                <select id="multicol-user" class="select2 form-select" name="user_id" data-allow-clear="true" required>
                  <option value="">Pilih</option>
                  @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Pilih Program</label>
              <div class="col-sm-9">
                <select id="multicol-program" class="select2 form-select" name="program_id" data-allow-clear="true" required>
                  <option value="">Pilih</option>
                  @foreach ($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->programmable->title }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Biaya Program</label>
              <div class="col-sm-9">
                <input type="number" name="amount" class="form-control" required>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Level</label>
              <div class="col-sm-9">
                <input type="text" name="level" class="form-control" required>
              </div>
            </div>

            <div class="row mb-3 select2-primary">
              <label class="col-sm-3 col-form-label" for="session-select">Sesi Belajar</label>
              <div class="col-sm-9">
                <select id="session-select" class="select2 form-select" multiple name="session[]">
                  @foreach ($allOptions as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Tipe Kelas</label>
              <div class="col-sm-9">
                <select name="class" id="class" class="form-select" required>
                  <option value="Kelas Offline (Luring)">Kelas Offline (Luring)</option>
                  <option value="Kelas Online (Daring)">Kelas Online (Daring)</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Ruang Kelas</label>
              <div class="col-sm-9">
                <input type="text" name="room" class="form-control" required>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Nilai</label>
              <div class="col-sm-9">
                <input type="text" name="score" class="form-control" required>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Ustadz(ah)</label>
              <div class="col-sm-9">
                <input type="text" name="lecturer" class="form-control" required>
              </div>
            </div>

            <div class="row mb-5">
              <label class="col-sm-3 col-form-label" for="multicol-program">Status</label>
              <div class="col-sm-9">
                <select name="status" id="status" class="form-select" required>
                  <option value="Menunggu Update">Menunggu Update</option>
                  <option value="Aktif">Aktif</option>
                  <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
              </div>
            </div>

            <button type="submit" class="btn btn-primary float-end">Tambah Data</button>
          </form>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection
