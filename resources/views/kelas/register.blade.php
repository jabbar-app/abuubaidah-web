@extends('student.main')


@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Program /</span> {{ $program->programmable->title }}</h4>

    <div class="row">
      <!-- Form Separator -->
      <div class="col-xxl">
        <div class="card mb-4">
          <h5 class="card-header">Form Pendaftaran Program</h5>
          <form action="{{ route('create.invoice') }}" method="POST" class="card-body">
            @csrf
            <input type="hidden" name="is_new" value="{{ $alumni == 'Alumni' ? 'false' : 'true' }}">
            <input type="hidden" name="status" value="Menunggu Update">
            <h6>1. Data Peserta</h6>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-name">Nama Lengkap</label>
              <div class="col-sm-9">
                <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
                <input type="text" id="multicol-name" class="form-control" value="{{ Auth::user()->name }}" readonly />
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-alumni">Status</label>
              <div class="col-sm-9">
                <input type="text" id="multicol-alumni" class="form-control" value="{{ $alumni }}" readonly />
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-price">Biaya Pendaftaran</label>
              <div class="col-sm-9">
                <input type="text" id="multicol-price" class="form-control" value="Rp{{ number_format($price, 0, ',', '.') }},-" readonly />
                <input type="hidden" value="{{ $price }}" name="amount">
              </div>
            </div>
            <hr class="my-4 mx-n4" />
            <h6>2. Data Kelas</h6>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Program</label>
              <div class="col-sm-9">
                <input type="hidden" value="{{ $program->id }}" name="program_id">
                <input type="text" id="multicol-program" class="form-control" value="{{ $program->programmable->title }}" name="program" readonly />
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-batch">Angkatan</label>
              <div class="col-sm-9">
                <input type="text" id="multicol-batch" class="form-control" value="{{ $program->programmable->batch }}" name="batch" readonly />
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-level">Level</label>
              <div class="col-sm-9">
                <input type="text" id="multicol-level" class="form-control" value="{{ $level }}" name="level" readonly />
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-kelas">Pilih Tipe Kelas</label>
              <div class="col-sm-9">
                <select id="multicol-kelas" class="select2 form-select" data-allow-clear="true" name="class" required>
                  <option value="">Select</option>
                  <option value="Online (Daring)">Online (Daring)</option>
                  <option value="Offline (Luring)">Offline (Luring)</option>
                </select>
              </div>
            </div>
            <div class="row mb-3 select2-primary">
              <label class="col-sm-3 col-form-label" for="session-select">Pilih Sesi</label>
              <div class="col-sm-9">
                <select id="session-select" class="select2 form-select" multiple name="session[]">
                  <option value="Sabtu 1 (08.00-10.00 WIB)">Sabtu 1 (08.00-10.00 WIB)</option>
                  <option value="Sabtu 2 (10.15-12.15 WIB)">Sabtu 2 (10.15-12.15 WIB)</option>
                  <option value="Sabtu 3 (13.00-15.00 WIB)">Sabtu 3 (13.00-15.00 WIB)</option>
                  <option value="Sabtu 4 (16.00-18.00 WIB)">Sabtu 4 (16.00-18.00 WIB)</option>
                  <option value="Ahad 1 (08.00-10.00 WIB)">Ahad 1 (08.00-10.00 WIB)</option>
                  <option value="Ahad 2 (10.15-12.15 WIB)">Ahad 2 (10.15-12.15 WIB)</option>
                  <option value="Ahad 3 (13.00-15.00 WIB)">Ahad 3 (13.00-15.00 WIB)</option>
                  <option value="Ahad 4 (16.00-18.00 WIB)">Ahad 4 (16.00-18.00 WIB)</option>
                </select>
                <div class="form-text">Bisa pilih lebih dari satu, klik lagi untuk memilih opsi lainnya. </div>
              </div>
            </div>
            <div class="pt-4">
              <div class="row justify-content-end">
                <div class="col-sm-9">
                  <button type="submit" class="btn btn-primary me-sm-2 me-1">Submit</button>
                  <button type="reset" class="btn btn-label-secondary">Cancel</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
