@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3">
        <a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a>
        Assign Courses to {{ $student->user->name ?? 'Unknown Student' }}
      </h4>
    </div>

    @if (session('success'))
      <div class="col-12">
        <div class="alert alert-success dark alert-dismissible fade show" role="alert">
          <strong>Success!</strong> {{ session('success') }}
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @elseif(session('danger'))
      <div class="col-12">
        <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
          <strong>Failed!</strong> {{ session('danger') }}
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif

    <div class="card">
      <div class="card-body">
        <form action="{{ route('students.assign.save', $student->id) }}" method="POST">
          @csrf
          <table class="table">
            <thead>
              <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Assign</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($courses as $course)
                <tr>
                  <td>{{ $course->kode_mk }}</td>
                  <td>{{ $course->mk }}</td>
                  <td>
                    <input type="checkbox" name="courses[]" value="{{ $course->id }}"
                      {{ $student->courses->contains($course->id) ? 'checked' : '' }}>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <button type="submit" class="btn btn-primary">Save Assignments</button>
        </form>
      </div>
    </div>
  </div>
@endsection
