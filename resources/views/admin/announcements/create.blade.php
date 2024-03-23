@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Program</h4>
      <a href="#" class="btn btn-md btn-light">Kembali</a>
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

          <form action="{{ route('announcements.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="program_id" class="form-label">Program</label>
              <select name="program_id" id="program_id" class="form-select">
                @foreach ($programs as $program)
                  <option value="{{ $program->id }}">{{ $program->programmable->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="mb-3">
              <label for="category" class="form-label">Category</label>
              <select name="category" id="category" class="form-select">
                <option value="main">Main</option>
                <option value="general">General</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection
