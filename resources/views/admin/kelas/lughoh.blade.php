@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Kelas
      </h4>
      <div>
        <a href="{{ route('kelas.create') }}" class="btn btn-md btn-primary mb-2 float-end">Tambah Data</a>
        <form action="{{ route('kelas.import') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="file" name="excel_file" required>
          <button type="submit" class="btn btn-md btn-info">Import</button>
        </form>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-6">
        <form method="GET" action="{{ url()->current() }}" class="d-flex">
          <select name="batch" class="form-control me-2">
            <option value="">- Filter Kelas -</option>
            @foreach ($batches as $batchOption)
              <option value="{{ $batchOption }}" {{ $selectedBatch == $batchOption ? 'selected' : '' }}>
                {{ DB::table('lughohs')->where('batch', $batchOption)->value('title') }} - Angkatan: {{ $batchOption }}
              </option>
            @endforeach
          </select>
          <button type="submit" class="btn btn-primary me-2">Filter</button>
          <a href="{{ url()->current() }}" class="btn btn-outline-primary">Reset</a>
        </form>
      </div>
      <div class="col-6">
        <a href="{{ route('export.kelas', ['programmableType' => $programmableType, 'batch' => request('batch'), 'gelombang' => request('gelombang')]) }}"
          class="btn btn-outline-primary float-end">Export ke Excel</a>
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

    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between mb-lg-n4">
        <div class="card-title">
          <h5 class="mb-0">Program: {{ $program->programmable->title ?? 'No Program Title' }}</h5>
          @if (!empty(request('batch')))
          <small class="text-muted">Angkatan: {{ $selectedBatch }} @if(!empty(request('gelombang'))) | Gelombang: {{ $gelombang }} @endif</small>
          @endif
        </div>
        <div class="dropdown">
          <button class="btn p-0" type="button" id="earningReportsId" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsId">
            <a class="dropdown-item" href="javascript:void(0);">View More</a>
            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-8">
            <div class="border rounded p-3 mt-2">
              <div class="row gap-4 gap-sm-0">
                <div class="col-12 col-sm-4">
                  <div class="d-flex gap-2 align-items-center">
                    <div class="badge rounded bg-label-info p-1"><i class="ti ti-user ti-sm"></i></div>
                    <h6 class="mb-0">Peserta Baru</h6>
                  </div>
                  <h4 class="my-2 pt-1">{{ $new }}</h4>
                  <div class="progress w-75" style="height:4px">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="d-flex gap-2 align-items-center">
                    <div class="badge rounded bg-label-warning p-1"><i class="ti ti-user ti-sm"></i></div>
                    <h6 class="mb-0">Daftar Ulang</h6>
                  </div>
                  <h4 class="my-2 pt-1">{{ $renewed }}</h4>
                  <div class="progress w-75" style="height:4px">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                <div class="col-12 col-sm-4">
                  <div class="d-flex gap-2 align-items-center">
                    <div class="badge rounded bg-label-primary p-1"><i class="ti ti-users ti-sm"></i></div>
                    <h6 class="mb-0">Total Peserta</h6>
                  </div>
                  <h4 class="my-2 pt-1">{{ $total }}</h4>
                  <div class="progress w-75" style="height:4px">
                    <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div class="border rounded p-3 mt-2">
              <div class="row gap-4 gap-sm-0">
                <div class="col-12">
                  <div class="d-flex gap-2 align-items-center">
                    <h6 class="mb-0">Export Data Kelas ke Excel</h6>
                  </div>
                  <a href="{{ route('export.kelas', ['programmableType' => $programmableType, 'batch' => $selectedBatch, 'gelombang' => $gelombang]) }}"
                    class="btn btn-md btn-primary mb-2 mt-3">Export</a>
                  <div class="progress w-100" style="height:4px">
                    <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">

        <div class="card-title header-elements">
          <h5 class="m-0 me-2">Data Kelas</h5>
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
                <th>Pembayaran</th>
                @if (!Auth::user()->hasRole('Accountant'))
                  <th>Tindakan</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach ($kelas as $kelasItem)
                <tr>
                  <td>{{ $kelasItem->id }}</td>
                  <td>{{ $kelasItem->user->name ?? '' }}</td>
                  <td>{{ $kelasItem->user->nik ?? '' }}</td>
                  <td>{{ $kelasItem->user->phone ?? '' }}</td>
                  <td>{{ $kelasItem->program->programmable->title . ', Angkatan ' . $kelasItem->batch }}</td>
                  <td>
                    <ul style="margin-left: -16px" class="mt-3">
                      @php
                        if ($kelasItem->session != 'null') {
                            $sessions = json_decode($kelasItem->session, true);
                            if (is_array($sessions)) {
                                foreach ($sessions as $session) {
                                    echo "<li>{$session}</li>";
                                }
                            } else {
                                if (!empty($kelasItem->session)) {
                                    echo "<li>{$kelasItem->session}</li>";
                                }
                            }
                        }
                      @endphp
                    </ul>
                  </td>
                  <td>
                    @if ($kelasItem->payments->isNotEmpty())
                      <span
                        class="badge @if ($kelasItem->payments->first()->status == 'PAID') bg-label-primary @else bg-label-warning @endif me-1">{{ $kelasItem->payments->first()->status }}</span>
                    @else
                      <span class="badge bg-label-warning me-1">EMPTY</span>
                    @endif
                  </td>
                  @if (!Auth::user()->hasRole('Accountant'))
                    <td>
                      <div class="d-inline-block">
                        <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                          data-bs-toggle="dropdown" aria-expanded="false" style="box-shadow: none;">
                          <i class="text-primary ti ti-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end m-0">
                          <li>
                            <a href="{{ route('kelas.edit', $kelasItem->id) }}" class="dropdown-item">Edit Data</a>
                          </li>
                          <div class="dropdown-divider"></div>
                          <li>
                            <form action="{{ route('kelas.destroy', $kelasItem->id) }}" method="POST"
                              onsubmit="return confirm('Apakah kamu yakin ingin menghapus data ini?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                            </form>
                          </li>
                        </ul>
                      </div>
                      <a href="{{ route('kelas.edit', $kelasItem->id) }}" class="btn btn-sm btn-icon item-edit"
                        style="box-shadow: none;"><i class="text-primary ti ti-pencil"></i></a>
                    </td>
                  @endif
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
                <th>Pembayaran</th>
                @if (!Auth::user()->hasRole('Accountant'))
                  <th>Tindakan</th>
                @endif
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
    $(document).ready(function() {
      $('#kelas').DataTable();
    });
  </script>
@endsection
