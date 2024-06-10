@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Ustadz/Ustadzah</h4>
      <a href="{{ route('lecturers.create') }}" class="btn btn-md btn-primary">Tambah Data</a>
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
        <table id="lecturers" class="table">
          <thead>
            <tr>
              <th>Nama Dosen</th>
              <th>Email</th>
              <th>No. WhatsApp</th>
              <th>Mata Kuliah</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($lecturers as $lecturer)
              <tr>
                <td>{{ $lecturer->user->name }}</td>
                <td>{{ $lecturer->user->email }}</td>
                <td>{{ $lecturer->user->phone }}</td>
                <td>
                  <ol>
                    @foreach ($lecturer->courses as $course)
                      <li>{{ $course->title }}</li>
                    @endforeach
                  </ol>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Nama Dosen</th>
              <th>Email</th>
              <th>No. WhatsApp</th>
              <th>Mata Kuliah</th>
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
      $('#lecturers').DataTable();
    });
  </script>
@endsection
