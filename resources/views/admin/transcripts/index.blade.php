@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Hasil
        Studi</h4>
      <a href="{{ route('transcripts.create') }}" class="btn btn-md btn-primary">Tambah Data</a>
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
              <th>NIM</th>
              <th>Nama Mahasiswa</th>
              <th>Program</th>
              <th>Angkatan</th>
              <th>Tindakan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($students as $student)
              <tr>
                <td>{{ $student->nim }}</td>
                <td>{{ $student->user->name }}</td>
                <td>{{ $student->program->programmable->title }}</td>
                <td>{{ $student->program->programmable->batch }}</td>
                <td>
                  <div class="btn-group dropstart">
                    <button class="btn btn-sm btn-primary dropdown-toggle waves-effect waves-light" type="button"
                      data-bs-toggle="dropdown" aria-expanded="false">Pilih</button>
                    <ul class="dropdown-menu" style="">
                      <li><a class="dropdown-item" href="/students/{{ $student->id }}/assign">Atur Mata Kuliah</a></li>
                      <li><a class="dropdown-item" href="/students/{{ $student->id }}/grades">Atur Nilai KHS</a></li>
                    </ul>
                  </div>
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
