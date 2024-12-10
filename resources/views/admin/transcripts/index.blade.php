@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Hasil
        Studi</h4>
      <div>
        <a href="{{ route('students.export') }}" class="btn btn-md btn-outline-primary">Export Data</a>
        <!-- Import Data Form -->
        <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data"
          style="display: inline;">
          @csrf
          <input type="file" name="file" class="form-control d-inline-block"
            style="width: auto; display: inline-block;" required>
          <button type="submit" class="btn btn-md btn-outline-primary">Import Data</button>
        </form>
        <!-- Sinkronisasi Mata Kuliah Button -->
        <form action="{{ route('students.synchronize') }}" method="POST" style="display: inline;">
          @csrf
          <button type="submit" class="btn btn-md btn-outline-primary">Sinkronisasi Mata Kuliah</button>
        </form>
      </div>
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
              <th>ID</th>
              <th>NIM</th>
              <th>Nama Mahasiswa</th>
              <th>Program</th>
              <th>Mustawa</th>
              <th>Angkatan</th>
              <th>Nilai Komprehensif</th>
              <th>Tindakan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($students as $student)
              <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->nim }}</td>
                <td>{{ $student->user->name ?? 'Data tidak ditemukan' }}</td>
                <td>{{ $student->program->programmable->title ?? '' }}</td>
                <td>{{ $student->mustawa }}</td>
                <td>{{ $student->program->programmable->batch ?? '' }}</td>
                <td class="text-center">{{ $student->nilai_comphre ?? '' }}</td>
                <td class="d-flex">
                  @if (empty($student->user))
                    <form action="{{ route('students.destroy', $student->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                  @else
                    <a href="{{ route('students.khs', $student) }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-info ms-2">Edit</a>
                    {{-- <div class="btn-group dropstart">
                      <button class="btn btn-sm btn-primary dropdown-toggle waves-effect waves-light" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">Pilih</button>
                      <ul class="dropdown-menu" style="">
                        <li>
                          <a class="dropdown-item" href="{{ route('students.assign', $student->id) }}">Atur Mata
                            Kuliah</a>
                        </li>
                        <li>
                          <a class="dropdown-item" href="{{ route('students.grades', $student->id) }}">Atur Nilai KHS</a>
                        </li>
                      </ul>
                    </div> --}}
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>NIM</th>
              <th>Nama Mahasiswa</th>
              <th>Program</th>
              <th>Angkatan</th>
              <th>Tindakan</th>
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
