@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Pengumuman</h4>
      <a href="{{ route('announcements.create') }}" class="btn btn-md btn-primary">Tambah Pengumuman</a>
    </div>


    @if (session('success'))
      <div class="col-12">
        <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>Success!
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
        <table id="announcements" class="table">
          <thead>
            <tr>
              <th>Judul</th>
              <th>Isi</th>
              <th>Program</th>
              <th>Kategori</th>
              <th>Tindakan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($announcements as $announcement)
              <tr>
                <td>{{ $announcement->title }}</td>
                <td>{{ $announcement->description }}</td>
                <td>{{ $announcement->program->programmable->title }}</td>
                <td><span class="badge bg-label-info">{{ $announcement->category }}</span></td>
                <td>
                  <div class="d-inline-block"><a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="text-primary ti ti-dots-vertical"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                      <li><a href="{{ route('announcements.show', $announcement->id) }}" class="dropdown-item">Details</a></li>
                      {{-- <li><a href="javascript:;" class="dropdown-item">Archive</a></li> --}}
                      <div class="dropdown-divider"></div>
                      <li>
                        <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this announcements?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                        </form>
                      </li>
                    </ul>
                  </div>
                  <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn btn-sm btn-icon item-edit"><i class="text-primary ti ti-pencil"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Judul</th>
              <th>Isi</th>
              <th>Program</th>
              <th>Kategori</th>
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
      $('#announcements').DataTable();
    });
  </script>
@endsection
