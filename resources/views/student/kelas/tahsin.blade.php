@extends('student.main')


@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Program /</span> {{ $program->programmable->title ?? 'No Program Title' }}</h4>

    <div class="row">
      <!-- Form Separator -->
      <div class="col-xxl">
        <div class="card mb-4">
          <h5 class="card-header">Form Pendaftaran Program</h5>
          <form action="{{ route('create.invoice') }}" method="POST" class="card-body">
            @csrf
            <input type="hidden" name="status" value="Menunggu Update">
            <input type="hidden" name="is_new" value="{{ $alumni == 'Alumni' ? '0' : '1' }}">
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
                <input type="text" id="multicol-price" class="form-control"
                  value="Rp{{ number_format($price, 0, ',', '.') }},-" readonly />
                <input type="hidden" value="{{ $price }}" name="amount">
              </div>
            </div>
            <hr class="my-4 mx-n4" />
            <h6>2. Data Kelas</h6>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Program</label>
              <div class="col-sm-9">
                <input type="hidden" value="{{ $program->id }}" name="program_id">
                <input type="text" id="multicol-program" class="form-control"
                  value="{{ $program->programmable->title ?? 'No Program Title' }}" name="program" readonly />
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-batch">Angkatan</label>
              <div class="col-sm-9">
                <input type="text" id="multicol-batch" class="form-control"
                  value="{{ $program->programmable->batch ?? 'No Program Batch' }}" name="batch" readonly />
              </div>
            </div>
            @if ($level != 'TAMHIDY')
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="multicol-level">Level</label>
                <div class="col-sm-9">
                  <input type="text" id="multicol-level" class="form-control" value="{{ $level }}"
                    name="level" readonly />
                </div>
              </div>
            @endif
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-kelas">Pilih Tipe Kelas</label>
              <div class="col-sm-9">
                <select id="multicol-kelas" class="select2 form-select" data-allow-clear="true" name="class" required>
                  <option value="">- Pilih Data -</option>
                  @php
                    $class_type = json_decode($program->programmable->option, true);
                  @endphp
                  @foreach ($class_type as $class)
                    <option value="{{ $class }}">{{ $class }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="row mb-3 select2-primary">
              <label class="col-sm-3 col-form-label" for="session-select">Pilih Sesi</label>
              <div class="col-sm-9">
                <select id="session-select" class="select2 form-select" multiple name="session[]">
                  @php
                    $sessions = json_decode($program->programmable->session, true);
                  @endphp
                  @foreach ($sessions as $session)
                    <option value="{{ $session }}">{{ $session }}</option>
                  @endforeach
                </select>
                <div class="form-text">Bisa pilih lebih dari satu, klik lagi untuk memilih opsi lainnya. </div>
              </div>
            </div>
            <div class="pt-4">
              <div class="row justify-content-end">
                <div class="col-sm-9">
                  <button type="submit" class="btn btn-primary me-sm-2 me-1">Submit</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
