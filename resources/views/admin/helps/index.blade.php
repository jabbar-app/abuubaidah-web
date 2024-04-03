@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Laporan Kendala
      </h4>
      <a href="{{ route('helps.create') }}" class="btn btn-md btn-primary">Tambah Data</a>
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
          <h5 class="m-0 me-2">Data Laporan</h5>
        </div>

        <div class="card-datatable table-responsive pt-0">
          <table id="kelas" class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Program</th>
                <th>Kendala</th>
                <th>Tindakan</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($helps as $help)
                <tr>
                  <td>{{ $help->id }}</td>
                  <td>{{ $help->user->name }}</td>
                  <td>{{ $help->program->programmable->title ?? '' }}</td>
                  <td>{{ $help->title }}</td>
                  <td>
                    <div class="d-inline-block">
                      <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                        data-bs-toggle="dropdown" aria-expanded="false" style="box-shadow: none;">
                        <i class="text-primary ti ti-dots-vertical"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                        <li>
                          <a href="{{ route('helps.edit', $help->id) }}" class="dropdown-item">Edit Data</a>
                        </li>
                        {{-- <li><a href="javascript:;" class="dropdown-item">Archive</a></li> --}}
                        <div class="dropdown-divider"></div>
                        <li>
                          <form action="{{ route('helps.destroy', $help->id) }}" method="POST"
                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                          </form>
                        </li>
                      </ul>
                    </div>
                    <a href="{{ route('helps.show', $help->id) }}" class="btn btn-sm btn-icon item-edit"
                      style="box-shadow: none;"><i class="text-primary ti ti-file-description"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Program</th>
                <th>Kendala</th>
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
      var table = document.getElementById('helps');
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
      $('#helps').DataTable();
    });
  </script>
@endsection
