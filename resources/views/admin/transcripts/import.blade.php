@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Import
        Data Mahasiswa</h4>
    </div>

    <div class="d-flex justify-content-center">
      <div class="card col-xl-8 col-md-10 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Import Data</h5>
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

          @if (session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif

          <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="file" class="form-label">Pilih File Excel</label>
              <input type="file" name="file" id="file" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary mt-4">Import Data</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
