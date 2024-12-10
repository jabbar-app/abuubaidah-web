@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard </a>/ Data Mata
        Kuliah</h4>
      <a href="{{ route('courses.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    {{-- <hr class="mb-5"> --}}

    <div class="d-flex justify-content-center">
      <div class="card col-xl-8 col-md-10 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Tambah Data</h5> <small class="text-muted float-end">إضافة بيانات جديدة</small>
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

          <form action="{{ route('courses.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label" for="program_id" >Program</label>
              <select id="program_id" class="select2 form-select" name="program_id" data-allow-clear="true" required>
                <option value="">Pilih</option>
                @foreach ($programs as $program)
                  <option value="{{ $program->id }}">{{ $program->programmable->title ?? 'No Program Title' }}</option>
                @endforeach
              </select>
            </div>
            <div class="row mb-3">
              <label class="form-label" for="multicol-user">Ustadz/Ustadzah</label>
              <select id="multicol-user" class="select2 form-select" name="lecturer_id" data-allow-clear="true" required>
                <option value="">Pilih</option>
                @foreach ($lecturers as $lecturer)
                  <option value="{{ $lecturer->id }}">{{ $lecturer->user->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="code" class="form-label">Kode</label>
              <input type="text" class="form-control" id="code" name="code" required>
            </div>
            <div class="mb-3">
              <label for="title" class="form-label">Mata Kuliah</label>
              <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="mb-3">
              <label for="credits" class="form-label">Jumlah SKS</label>
              <input type="text" class="form-control" id="credits" name="credits">
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-select">
                <option value="1">Aktif</option>
                <option value="0">Non-Aktif</option>
              </select>
            </div>
            <button type="submit" class="btn bt-md btn-primary float-end my-4">Tambah Data</button>
          </form>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection
