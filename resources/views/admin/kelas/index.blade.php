@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Kelas
      </h4>
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
      <div class="card-body">

        <div class="card-title header-elements">
          <h5 class="m-0 me-2">{{ $programs }}</h5>
          {{-- <div class="card-title-elements">
            <label class="switch switch-primary switch-sm me-0">
              <input type="checkbox" class="switch-input">
              <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
              </span>
            </label>
          </div> --}}
          <div class="card-title-elements ms-auto">
            <select class="form-select form-select-sm w-auto">
              @foreach ($programs as $program)
                <option value="{{ $program }}">{{ $program }}</option>
              @endforeach
            </select>
            <button type="button" class="btn btn-sm btn-primary waves-effect waves-light">Go</button>
          </div>
        </div>

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
                  <td>{{ $kelas->user->name ?? '' }}</td>
                  <td>{{ $kelas->user->nik ?? '' }}</td>
                  <td>{{ $kelas->user->phone ?? '' }}</td>
                  <td>{{ $kelas->program . ', Angkatan ' . $kelas->batch }}</td>
                  <td>
                    <ul style="margin-left: -16px" class="mt-3">
                      @php
                        // Attempt to decode the session data
                        $sessions = json_decode($kelas->session, true);

                        // Check if decoding was successful and we have an array
                        if (is_array($sessions)) {
                            // If it's an array, we'll loop through it
                            foreach ($sessions as $session) {
                                echo "<li>{$session}</li>";
                            }
                        } else {
                            // If it's not an array, display it directly
                            // Check if session data is not empty or null
                            if (!empty($kelas->session)) {
                                echo "<li>{$kelas->session}</li>";
                            }
                        }
                      @endphp
                    </ul>
                  </td>
                  <td>
                    <div class="d-inline-block">
                      <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                        data-bs-toggle="dropdown" aria-expanded="false" style="box-shadow: none;">
                        <i class="text-primary ti ti-dots-vertical"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                        <li>
                          <a href="{{ route('kelas.edit', $kelas->id) }}" class="dropdown-item">Edit Data</a>
                        </li>
                        {{-- <li><a href="javascript:;" class="dropdown-item">Archive</a></li> --}}
                        <div class="dropdown-divider"></div>
                        <li>
                          <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST"
                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                          </form>
                        </li>
                      </ul>
                    </div>
                    <a href="{{ route('kelas.edit', $kelas->id) }}" class="btn btn-sm btn-icon item-edit"
                      style="box-shadow: none;"><i class="text-primary ti ti-pencil"></i></a>
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
  </div>
@endsection

@section('js')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var table = document.getElementById('kelas');
      var filter = document.getElementById('programFilter');

      filter.onchange = function() {
        var filterValue = this.value.toLowerCase();
        Array.from(table.getElementsByTagName('tr')).forEach(function(row) {
          // Assumes program is in the 5th column (adjust index as needed)
          var cell = row.cells[4] ? row.cells[4].textContent.toLowerCase() : '';
          row.style.display = cell.includes(filterValue) || !filterValue ? '' : 'none';
        });
      };
    });
  </script>

  <script>
    $(document).ready(function() {
      $('#kelas').DataTable();
    });
  </script>
@endsection
