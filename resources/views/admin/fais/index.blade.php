@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        {{ $fais->first()->title }}</h4>
      <a href="{{ route('fais.create') }}" class="btn btn-md btn-primary">Tambah Data</a>
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
        <table id="fais" class="table">
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
            @foreach ($fais as $fai)
              <tr>
                <td class="text-center pe-5">{{ $fai->batch }}</td>
                <td>{{ $fai->title }}</td>
                <td>{{ $fai->description }}</td>
                <td>
                  @if (!is_null(json_decode($fai->option)))
                    @foreach (json_decode($fai->option) as $option)
                      <li style="display: inline;">{{ $option }}</li>
                    @endforeach
                  @endif
                </td>
                <td><span class="badge @if ($fai->status) bg-label-primary @else bg-label-warning @endif">
                    @if ($fai->status)
                      Aktif
                    @else
                      Non-Aktif
                    @endif
                  </span></td>
                <td>
                  <div class="d-inline-block">
                    <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                      data-bs-toggle="dropdown" aria-expanded="false" style="box-shadow: none;">
                      <i class="text-primary ti ti-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                      <li>
                        <a href="{{ route('fais.show', $fai->id) }}" class="dropdown-item">Details</a>
                      </li>
                      <li><a href="{{ route('fais.edit', $fai->id) }}" class="dropdown-item">Edit Data</a></li>
                      {{-- <li><a href="javascript:;" class="dropdown-item">Archive</a></li> --}}
                      <div class="dropdown-divider"></div>
                      <li>
                        <form action="{{ route('fais.destroy', $fai->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this fai?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                        </form>
                      </li>
                    </ul>
                  </div>
                  <a href="{{ route('fais.edit', $fai->id) }}" class="btn btn-sm btn-icon item-edit"
                    style="box-shadow: none;"><i class="text-primary ti ti-pencil"></i></a>
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
      $('#fais').DataTable();
    });
  </script>
@endsection
