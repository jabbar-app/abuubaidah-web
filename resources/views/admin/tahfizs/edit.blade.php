@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Program</h4>
      <a href="{{ route('tahfizs.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    {{-- <hr class="mb-5"> --}}

    <div class="d-flex justify-content-center">
      <div class="card col-xl-8 col-md-10 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Tambah Program</h5> <small class="text-muted float-end">إضافة برنامج</small>
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

          <form action="{{ route('tahfizs.update', $tahfiz->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="title" class="form-label">Nama Program</label>
              <input type="text" class="form-control" id="title" name="title" value="{{ $tahfiz->title }}">
            </div>
            <div class="mb-3">
              <label for="batch" class="form-label">Angkatan</label>
              <input type="number" class="form-control" id="batch" name="batch" value="{{ $tahfiz->batch }}">
            </div>
            <div class="mb-3">
              <label for="gelombang" class="form-label">Gelombang</label>
              <input type="number" class="form-control" id="gelombang" name="gelombang" value="{{ $tahfiz->gelombang }}">
            </div>
            <div class="mb-3 select2-primary">
              <label class="col-sm-3 col-form-label" for="option-select">Tipe Kelas</label>
              <div class="col-12">
                @php
                  $selectedOptions = json_decode($tahfiz->option);
                @endphp
                <select id="option-select" class="select2 form-select" multiple name="option[]">
                  <option value="Kelas Online (Daring)" @if (in_array('Kelas Online (Daring)', $selectedOptions)) selected @endif>Kelas Online
                    (Daring)</option>
                  <option value="Kelas Offline (Luring)" @if (in_array('Kelas Offline (Luring)', $selectedOptions)) selected @endif>Kelas Offline
                    (Luring)</option>
                </select>
                <div class="form-text">Bisa pilih lebih dari satu, klik lagi untuk memilih opsi lainnya.</div>
              </div>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description">{{ $tahfiz->description }}</textarea>
            </div>
            <div class="mb-3">
              <label for="price_normal" class="form-label">Biaya Pendaftaran</label>
              <input type="number" class="form-control" id="price_normal" name="price_normal"
                value="{{ $tahfiz->price_normal }}">
            </div>
            {{-- <div class="mb-3 select2-primary">
              <label class="col-sm-3 col-form-label" for="option-select">Sesi Belajar</label>
              <div class="col-12">
                <label class="form-label">Sesi</label>
                @php
                  $selectedOptions = json_decode($tahfiz->session, true);
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
            </div> --}}
            <div class="mb-5">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-select">
                <option value="1" @if ($tahfiz->status) selected @endif>Aktif</option>
                <option value="0" @if (!$tahfiz->status) selected @endif>Tidak Aktif</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary float-end">Submit</button>
          </form>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection
