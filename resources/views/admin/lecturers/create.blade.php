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

          <form action="{{ route('lecturers.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-user">Ustadz/Ustadzah</label>
              <div class="col-sm-9">
                <select id="multicol-user" class="select2 form-select" name="user_id" data-allow-clear="true"
                  required>
                  <option value="">Pilih</option>
                  @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                  @endforeach
                </select>
              </div>
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
