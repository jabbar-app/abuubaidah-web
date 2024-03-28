@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Program</h4>
      <div class="d-flex">
        <form action="{{ route('import.result') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="file" name="excel_file" required>
          <button type="submit" class="btn btn-md btn-info">Import</button>
        </form>
        <a href="{{ route('results.create') }}" class="btn btn-md btn-primary ms-3">Tambah Data</a>
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
        <table id="results" class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>NIK</th>
              <th>Email</th>
              <th>Gender</th>
              <th>Phone</th>
              <th>Program</th>
              <th>Tindakan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($results as $result)
              <tr>
                <td>{{ $result->name }}</td>
                <td>{{ $result->nik }}</td>
                <td>{{ $result->email }}</td>
                <td>{{ $result->gender }}</td>
                <td>{{ $result->phone }}</td>
                <td>{{ $result->program }}</td>
                <td>
                  <div class="d-inline-block"><a href="javascript:;"
                      class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                      aria-expanded="false"><i class="text-primary ti ti-dots-vertical"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end m-0">
                      {{-- <li><a href="{{ route('results.show', $result->id) }}" class="dropdown-item">Details</a></li> --}}
                      <li><a href="{{ route('results.edit', $result->id) }}" class="dropdown-item">Edit Data</a></li>
                      <div class="dropdown-divider"></div>
                      <li>
                        <form action="{{ route('results.destroy', $result->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this results?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                        </form>
                      </li>
                    </ul>
                  </div><a href="{{ route('results.edit', $result->id) }}" class="btn btn-sm btn-icon item-edit"><i
                      class="text-primary ti ti-pencil"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Name</th>
              <th>NIK</th>
              <th>Email</th>
              <th>Gender</th>
              <th>Phone</th>
              <th>Program</th>
              <th>Tindakan</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="{{ asset('assets/js/tables-datatables-basic.js') }}"></script>
  <script>
    $(document).ready(function() {
      $('#results').DataTable();
    });
  </script>
@endsection
