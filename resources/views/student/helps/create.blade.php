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
          <h5 class="mb-0">Edit Data</h5>
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

          <form method="POST" action="{{ route('student.helps.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-user">Program</label>
              <div class="col-sm-9">
                <select id="multicol-program" class="select2 form-select" name="program_id" data-allow-clear="true"
                  required>
                  <option value="">Pilih</option>
                  @foreach ($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->programmable->title }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Judul Kendala</label>
              <div class="col-sm-9">
                <input type="text" name="title" class="form-control" required>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Deskripsi</label>
              <div class="col-sm-9">
                <textarea name="description" class="form-control" required></textarea>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Upload Berkas</label>
              <div class="col-sm-9">
                <input type="file" name="file_upload" class="form-control" required>
              </div>
            </div>

            <button type="submit" class="btn btn-primary float-end">Buat Laporan</button>
          </form>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection
