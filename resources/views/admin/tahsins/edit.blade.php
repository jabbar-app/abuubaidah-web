@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Program</h4>
      <a href="{{ route('tahsins.index') }}" class="btn btn-md btn-light">Kembali</a>
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

          <form action="{{ route('tahsins.update', $tahsin->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="title" class="form-label">Nama Program</label>
              <input type="text" class="form-control" id="title" name="title" value="Tahsin Tilawah Al-Qur'an">
            </div>
            <div class="mb-3">
              <label for="batch" class="form-label">Angkatan</label>
              <input type="number" class="form-control" id="batch" name="batch" value="{{ $tahsin->batch }}">
            </div>
            <div class="mb-3 select2-primary">
              <label class="col-sm-3 col-form-label" for="option-select">Tipe Kelas</label>
              <div class="col-12">
                @php
                  $selectedOptions = json_decode($tahsin->option);
                @endphp
                <select id="option-select" class="select2 form-select" multiple name="option[]">
                  <option value="Kelas Online (Daring)" @if (in_array('Kelas Online (Daring)', $selectedOptions)) selected @endif>Kelas Online (Daring)</option>
                  <option value="Kelas Offline (Luring)" @if (in_array('Kelas Offline (Luring)', $selectedOptions)) selected @endif>Kelas Offline (Luring)</option>
                </select>
                <div class="form-text">Bisa pilih lebih dari satu, klik lagi untuk memilih opsi lainnya.</div>
              </div>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description">{{ $tahsin->description }}</textarea>
            </div>
            <div class="mb-3">
              <label for="price_normal" class="form-label">Biaya Normal</label>
              <input type="number" class="form-control" id="price_normal" name="price_normal" value="{{ $tahsin->price_normal }}">
            </div>
            <div class="mb-3">
              <label for="price_alumni" class="form-label">Biaya Alumni</label>
              <input type="number" class="form-control" id="price_alumni" name="price_alumni" value="{{ $tahsin->price_alumni }}">
            </div>
            <div class="mb-3 select2-primary">
              <label class="col-sm-3 col-form-label" for="option-select">Sesi Belajar</label>
              <div class="col-12">
                <label class="form-label">Sesi</label>
                @php
                  $selectedOptions = json_decode($tahsin->session, true);
                  if (!is_array($selectedOptions)) {
                      $selectedOptions = [$selectedOptions];
                  }
                @endphp

                <select id="session-select" class="select2 form-select" multiple name="session[]">
                  @foreach ($allOptions as $option)
                    <option value="{{ $option }}" @if (in_array($option, $selectedOptions)) selected @endif>{{ $option }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="mb-5">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-select">
                <option value="1" @if ($tahsin->status) selected @endif>Aktif</option>
                <option value="0" @if (!$tahsin->status) selected @endif>Tidak Aktif</option>
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
