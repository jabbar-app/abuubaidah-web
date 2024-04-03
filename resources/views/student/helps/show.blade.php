@extends('student.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Laporan Kendala</h4>
      <a href="{{ route('helps.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    {{-- <hr class="mb-5"> --}}

    <div class="d-flex justify-content-center">
      <div class="card col-xl-8 col-md-10 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Detail Laporan</h5>
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

          <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Program</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" value="{{ $help->program->programmable->title }}" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Judul Kendala</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" value="{{ $help->title }}" readonly>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Deskripsi</label>
            <div class="col-sm-9">
              <textarea rows="2" class="form-control" readonly>{{ $help->description }}</textarea>
            </div>
          </div>
          <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Berkas</label>
            <div class="col-sm-9">
              <img src="{{ asset('uploads/' . $help->file_upload) }}" alt="Image" style="width: 100%; height: auto;">
              <a href="{{ asset('uploads/' . $help->file_upload) }}" target="_blank"
                class="btn btn-sm btn-outline-info mt-3">Lihat Berkas</a>
            </div>
          </div>

          <a href="{{ route('student.helps.edit', $help->id) }}" class="btn btn-primary float-end">Edit Data</a>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection
