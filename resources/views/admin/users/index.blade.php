@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        User</h4>
      <a href="{{ route('users.create') }}" class="btn btn-md btn-primary">Tambah User</a>
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

      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data User</h5>
        <div class="float-end">
          <a href="/export-user" class="btn btn-md btn-primary float-end mb-3">Export ke
            Excel</a>
        </div>
      </div>
      <div class="card-datatable table-responsive pt-0">
        <table id="users" class="table">
          <thead>
            <tr>
              <th>Nama User</th>
              <th>NIK</th>
              <th>Email</th>
              <th>WhatsApp</th>
              <th>Tindakan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->nik }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                  <div class="d-inline-block"><a href="javascript:;"
                      class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                      aria-expanded="false"><i class="text-primary ti ti-dots-vertical"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                      <li><a href="{{ route('users.show', $user->id) }}" class="dropdown-item">Details</a></li>
                      <li>
                        <a href="{{ route('user.pdf', $user->id) }}" class="dropdown-item">Download PDF</a>
                      </li>
                      <li><a href="{{ route('users.edit', $user->id) }}" class="dropdown-item">Edit Data</a></li>
                      @if (Auth::user()->hasRole('Super Admin'))
                        <li><a href="/users/{{ $user->id }}/roles" class="dropdown-item">Roles</a></li>
                      @endif
                      {{-- <li><a href="javascript:;" class="dropdown-item">Archive</a></li> --}}
                      <div class="dropdown-divider"></div>
                      <li>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this users?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger delete-record">Hapus</button>
                        </form>
                      </li>
                    </ul>
                  </div>
                  <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-icon item-edit"><i
                      class="text-primary ti ti-user"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Nama User</th>
              <th>NIK</th>
              <th>Email</th>
              <th>WhatsApp</th>
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
      $('#users').DataTable();
    });
  </script>
@endsection
