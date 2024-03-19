@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">


    <div class="card bg-transparent shadow-none my-4 border-0">
      <div class="card-body row p-0 pb-3">
        <div class="col-12 col-md-8 card-separator">
          <h3>{{ Auth::user()->roles->first()->name . ' | ' ?? '' }} {{ Auth::user()->name }}</h3>

          <div class="col-12 col-lg-7 mb-5">
            <p>Selamat datang di Ma'had Abu Ubaidah Bin Al Jarrah, <em>Lembaga Pendidikan Bahasa Arab & Studi Islam!</em></p>
          </div>
          <div class="d-flex flex-wrap gap-3 me-5">
            <div class="d-flex align-items-center gap-3 me-5">
              <span class="bg-label-info p-2 rounded">
                <i class="ti ti-chart-bar ti-xl"></i>
              </span>
              <div class="content-right">
                <p class="mb-0">Total Mahasiswa</p>
                <h4 class="text-warning mb-0">{{ $mahasiswa }}</h4>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span class="bg-label-warning p-2 rounded">
                <i class="ti ti-hourglass-empty ti-xl"></i>
              </span>
              <div class="content-right">
                <p class="mb-0">Total Mahasiswa Program {{ $program }}</p>
                <h4 class="text-warning mb-0">{{ $mahasiswa_program }}</h4>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4 ps-md-3 ps-lg-4 pt-3 pt-md-0">

        </div>
      </div>
    </div>


    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Kelas</h4>
      <a href="{{ route('admin.kelas.index') }}" class="btn btn-md btn-light">Data Kelas</a>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Transaksi</h5> <small class="text-muted float-end">إضافة برنامج</small>
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
                            {{-- <a href="{{ route('kelas.show', $kelas->id) }}" class="dropdown-item">Details</a> --}}
                            <a href="#" class="dropdown-item">Details</a>
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
    </div>

    <div style="margin-bottom: 400px;"></div>

    {{-- <div class="row">
      <div class="col-lg-5 col-sm-12 mb-4">
        <div class="card">
          <div class="card-body pb-0">
            <div class="card-icon">
              <span class="badge bg-label-success rounded-pill p-2">
                <i class="ti ti-credit-card ti-sm"></i>
              </span>
            </div>
            <h5 class="card-title mb-0 mt-2">97.5k</h5>
            <small>Revenue Generated</small>
          </div>
          <div id="revenueGenerated"></div>
        </div>
      </div>
    </div> --}}
  </div>
@endsection


@section('js')
  <script>
    $(document).ready(function() {
      $('#kelas').DataTable();
    });
  </script>
@endsection
