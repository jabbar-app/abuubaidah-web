@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data {{ $tahfizs->first()->title }}</h4>
      <a href="{{ route('tahfizs.create') }}" class="btn btn-md btn-primary">Tambah Data</a>
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
        <table id="tahfizs" class="table">
          <thead>
            <tr>
              <th>Angkatan</th>
              <th>Nama Program</th>
              <th>Deskripsi</th>
              <th>Opsi</th>
              <th>Status</th>
              <th>Tindakan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($tahfizs as $tahfiz)
              <tr>
                <td class="text-center pe-5">{{ $tahfiz->batch }}</td>
                <td>{{ $tahfiz->title }}</td>
                <td>{{ $tahfiz->description }}</td>
                <td>
                  @foreach (json_decode($tahfiz->option) as $option)
                    <li style="display: inline;">{{ $option }}</li>
                  @endforeach
                </td>
                <td><span class="badge @if ($tahfiz->status) bg-label-primary @else bg-label-warning @endif">
                    @if ($tahfiz->status)
                      Aktif
                    @else
                      Non-Aktif
                    @endif
                  </span></td>
                <td>
                  <div class="d-inline-block">
                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false" style="box-shadow: none;">
                      <i class="text-primary ti ti-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                      <li>
                        <a href="{{ route('tahfizs.show', $tahfiz->id) }}" class="dropdown-item">Details</a>
                      </li>
                      {{-- <li><a href="javascript:;" class="dropdown-item">Archive</a></li> --}}
                      <div class="dropdown-divider"></div>
                      <li>
                        <form action="{{ route('tahfizs.destroy', $tahfiz->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this tahfiz?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                        </form>
                      </li>
                    </ul>
                  </div>
                  <a href="{{ route('tahfizs.edit', $tahfiz->id) }}" class="btn btn-sm btn-icon item-edit" style="box-shadow: none;"><i class="text-primary ti ti-pencil"></i></a>
                </td>
              </tr>
            @endforeach

          </tbody>
          <tfoot>
            <tr>
              <th>Angkatan</th>
              <th>Nama Program</th>
              <th>Deskripsi</th>
              <th>Opsi</th>
              <th>Status</th>
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
      $('#tahfizs').DataTable();
    });
  </script>
@endsection
