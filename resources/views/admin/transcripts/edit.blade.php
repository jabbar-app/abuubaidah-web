@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Edit
        Student</h4>
      <a href="{{ route('transcripts.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    <div class="d-flex justify-content-center">
      <div class="card col-xl-8 col-md-10 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Edit Student</h5> <small class="text-muted float-end">تحرير الطالب</small>
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

          <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label for="user_id" class="form-label">User ID</label>
              <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $student->user_id }}"
                readonly>
            </div>

            <div class="mb-3">
              <label for="name" class="form-label">Nama Mahasiswa</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ $student->user->name }}"
                readonly>
            </div>

            <div class="mb-3">
              <label for="nim" class="form-label">NIM</label>
              <input type="text" class="form-control" id="nim" name="nim" value="{{ $student->nim }}">
            </div>

            <div class="mb-3">
              <label for="mustawa" class="form-label">Mustawa</label>
              <input type="text" class="form-control" id="mustawa" name="mustawa" value="{{ $student->mustawa }}">
            </div>

            <div class="mb-3">
              <label for="nilai_comphre" class="form-label">Nilai Comphre</label>
              <input type="text" class="form-control" id="nilai_comphre" name="nilai_comphre"
                value="{{ $student->nilai_comphre }}">
            </div>

            {{-- <div class="mb-5">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-select">
                <option value="1" @if ($student->status) selected @endif>Aktif</option>
                <option value="0" @if (!$student->status) selected @endif>Tidak Aktif</option>
              </select>
            </div> --}}

            <button type="submit" class="btn btn-primary float-end">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection
