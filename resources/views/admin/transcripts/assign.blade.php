@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard </a>/ Data Mata
        Kuliah</h4>
      <a href="{{ route('transcripts.index') }}" class="btn btn-md btn-light">Kembali</a>
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

          <h3>Atur Mata Kuliah untuk: {{ $student->user->name }}</h3>
          <form action="{{ route('students.assignCourses', $student->id) }}" method="POST">
            @csrf
            <table class="table table-border-bottom-0">
              <thead>
                <th>Mata Kuliah</th>
                <th>Pengajar</th>
                <th class="text-center">Tambahkan</th>
              </thead>
              @foreach ($courses as $course)
                <tr>
                  <td>{{ $course->title }}</td>
                  <td>{{ $course->lecturer->user->name }}</td>
                  <td class="text-center"><input class="form-input" type="checkbox" name="courses[]" value="{{ $course->id }}"
                      {{ in_array($course->id, $assignedCourses) ? 'checked' : '' }}></td>
                </tr>
              @endforeach
              <tfoot>
                <th>Mata Kuliah</th>
                <th>Pengajar</th>
                <th class="text-center">Tambahkan</th>
              </tfoot>
            </table>
            <button type="submit" class="btn btn-primary mt-4 float-end">Simpan Mata Kuliah</button>
          </form>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection
