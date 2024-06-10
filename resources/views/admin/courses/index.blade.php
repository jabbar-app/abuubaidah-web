@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Mata
        Kuliah</h4>
      <a href="{{ route('courses.create') }}" class="btn btn-md btn-primary">Tambah Data</a>
    </div>

    @if (session('success'))
      <div class="col-12">
        <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>Berhasil!
          </strong> {{ session('success') }}
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @elseif(session('danger'))
      <div class="col-12">
        <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><strong>Gagal!
          </strong> {{ session('danger') }}
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif

    <div class="card">
      <div class="card-datatable table-responsive pt-0">
        <table id="datatable" class="table">
          <thead>
            <tr>
              <th>Program</th>
              <th>Mata Kuliah</th>
              <th>Jumlah SKS</th>
              <th>Ustadz/Ustadzah</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($courses as $course)
              <tr>
                <td>{{ $course->program->programmable->title }}</td>
                <td>{{ $course->title }}</td>
                <td>{{ $course->credits }}</td>
                <td>{{ $course->lecturer->user->name }}</td>
                <td>
                  @if ($course->status)
                    Aktif
                  @else
                    Non-Aktif
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Program</th>
              <th>Mata Kuliah</th>
              <th>Jumlah SKS</th>
              <th>Ustadz/Ustadzah</th>
              <th>Status</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function() {
      $('#datatable').DataTable();
    });
  </script>
@endsection
