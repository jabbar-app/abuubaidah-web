@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Kelas</h4>
      <a href="{{ route('kelas.create') }}" class="btn btn-md btn-primary">Tambah Kelas</a>
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
        <table id="kelas" class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama</th>
              <th>NIK</th>
              <th>WhatsApp</th>
              <th>Program</th>
              <th>Sesi</th>
              <th>Tindakan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($kelas as $kelas)
              <tr>
                <td>{{ $kelas->id }}</td>
                <td>{{ $kelas->user->id ?? '' }}</td>
                <td>{{ $kelas->user->nik ?? '' }}</td>
                <td>{{ $kelas->user->phone ?? '' }}</td>
                <td>{{ $kelas->program . ', Angkatan ' . $kelas->batch }}</td>
                <td>
                  <ul style="margin-left: -16px" class="mt-3">
                    @php
                      $sessions = json_decode($kelas->session, true); // Decode as array
                      if (!is_array($sessions)) {
                          // Check if the result is not an array
                          $sessions = []; // Set to empty array if not
                      }
                    @endphp

                    @foreach ($sessions as $session)
                      <li>{{ $session }}</li>
                    @endforeach

                  </ul>
                </td>
                <td>
                  <div class="d-inline-block">
                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false" style="box-shadow: none;">
                      <i class="text-primary ti ti-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                      <li>
                        <a href="{{ route('kelas.edit', $kelas->id) }}" class="dropdown-item">Edit Data</a>
                      </li>
                      {{-- <li><a href="javascript:;" class="dropdown-item">Archive</a></li> --}}
                      <div class="dropdown-divider"></div>
                      <li>
                        <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus data ini?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                        </form>
                      </li>
                    </ul>
                  </div>
                  <a href="{{ route('kelas.edit', $kelas->id) }}" class="btn btn-sm btn-icon item-edit" style="box-shadow: none;"><i class="text-primary ti ti-pencil"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>ID</th>
              <th>Nama</th>
              <th>NIK</th>
              <th>WhatsApp</th>
              <th>Program</th>
              <th>Sesi</th>
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
      $('#kelas').DataTable();
    });
  </script>
@endsection
