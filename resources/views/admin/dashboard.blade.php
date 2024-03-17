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
          <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
            <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
              <span class="bg-label-primary p-2 rounded">
                <i class="ti ti-user ti-xl"></i>
              </span>
              <div class="content-right">
                <p class="mb-0">Jumlah User</p>
                <h4 class="text-primary mb-0">{{ $total_user }}</h4>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span class="bg-label-info p-2 rounded">
                <i class="ti ti-chart-bar ti-xl"></i>
              </span>
              <div class="content-right">
                <p class="mb-0">Total Transaksi Berhasil</p>
                <h4 class="text-info mb-0">Rp{{ number_format($transaksi_berhasil, 0, ',', '.') }},-</h4>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span class="bg-label-warning p-2 rounded">
                <i class="ti ti-hourglass-empty ti-xl"></i>
              </span>
              <div class="content-right">
                <p class="mb-0">Total Transaksi Pending</p>
                <h4 class="text-warning mb-0">Rp{{ number_format($transaksi_pending, 0, ',', '.') }},-</h4>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4 ps-md-3 ps-lg-4 pt-3 pt-md-0">
          <div class="d-flex align-items-center justify-content-between">
            <h5>Buat Pengumuman</h5>
            <a href="{{ route('announcements.index') }}" class="small text-primary pb-3">Lihat semua</a>
          </div>
          <form action="{{ route('announcements.store') }}" method="POST">
            @csrf
            <select name="program_id" id="program_id" class="form-select mb-1" required>
              <option value="" selected disabled>- Pilih Program -</option>
              @foreach ($programs as $program)
                <option value="{{ $program->id }}">{{ $program->programmable->title }}</option>
              @endforeach
            </select>
            <input type="text" class="form-control mb-1" id="title" name="title" placeholder="Judul">
            <textarea class="form-control mb-1" id="description" name="description" placeholder="Isi"></textarea>
            <select name="category" id="category" class="form-select mb-2" required>
              <option value="" selected disabled>- Pilih Kategori -</option>
              <option value="main">Main</option>
              <option value="general">General</option>
            </select>
            <button type="submit" class="btn btn-primary float-end">Submit</button>
          </form>
        </div>
      </div>
    </div>

    <div class="row mb-5">
      <div class="col-lg-7 col-sm-12 mb-4">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between">
              <small class="d-block mb-1 text-muted">Total Transaksi</small>
              <a href="{{ route('payments.index') }}" class="card-text text-success small">Lihat semua</a>
            </div>
            <h4 class="card-title mb-1">Rp{{ number_format($total_transaksi, 0, ',', '.') }},-</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-4">
                <div class="d-flex gap-2 align-items-center mb-2">
                  <span class="badge bg-label-success p-1 rounded"><i class="ti ti-checklist ti-xs"></i></span>
                  <p class="mb-0">Selesai</p>
                </div>
                <h5 class="mb-0 pt-1 text-nowrap">Rp{{ number_format($total_transaksi_berhasil, 0, ',', '.') }},-</h5>
                <small class="text-muted">{{ $transaksi_berhasil }}</small>
              </div>
              <div class="col-4">
                <div class="divider divider-vertical">
                  <div class="divider-text">
                    <span class="badge-divider-bg bg-label-secondary">VS</span>
                  </div>
                </div>
              </div>
              <div class="col-4 text-end">
                <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                  <p class="mb-0">Pending</p>
                  <span class="badge bg-label-warning p-1 rounded"><i class="ti ti-hourglass-empty ti-xs"></i></span>
                </div>
                <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">Rp{{ number_format($total_transaksi_pending, 0, ',', '.') }},-</h5>
                <small class="text-muted">{{ $transaksi_pending }}</small>
              </div>
            </div>
            <div class="d-flex align-items-center mt-4">
              <div class="progress w-100" style="height: 8px">
                <div class="progress-bar bg-success" style="width: 50%" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="border rounded p-3 mt-4">
              <div class="row gap-4 gap-sm-0">
                <div class="col-6">
                  <div class="d-flex gap-2 align-items-center">
                    <div class="badge rounded bg-label-info p-1">
                      <i class="ti ti-notebook ti-sm"></i>
                    </div>
                    <h6 class="mb-0">Payment Gateway</h6>
                  </div>
                  <h4 class="my-2 pt-1">Rp{{ number_format($xendit, 0, ',', '.') }},-</h4>
                  <div class="progress w-75" style="height: 4px">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="d-flex gap-2 align-items-center">
                    <div class="badge rounded bg-label-info p-1">
                      <i class="ti ti-notebook ti-sm"></i>
                    </div>
                    <h6 class="mb-0">Pembayaran Offline</h6>
                  </div>
                  <h4 class="my-2 pt-1">Rp{{ number_format($offline, 0, ',', '.') }},-</h4>
                  <div class="progress w-75" style="height: 4px">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--/ Sales Overview -->


      <!-- Support Tracker -->
      <div class="col-lg-5 col-sm-12 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between pb-0">
            <div class="card-title mb-0">
              <h5 class="mb-0">Program Status</h5>
              <a href="{{ route('programs.index') }}" class="text-muted small">Lihat detail</a>
            </div>
            <div class="dropdown">
              <button class="btn p-0" type="button" id="supportTrackerMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="supportTrackerMenu">
                <a class="dropdown-item" href="{{ route('programs.index') }}">Lihat Program</a>
                <a class="dropdown-item" href="{{ route('kelas.index') }}">Lihat Kelas</a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12 col-sm-4 col-md-12 col-lg-4">
                <div class="mt-lg-4 mt-lg-2 mb-lg-4 mb-2 pt-1">
                  <h1 class="mb-0">7</h1>
                  <p class="mb-0">Total Program</p>
                </div>
                <ul class="p-0 m-0">
                  <li class="d-flex gap-3 align-items-center mb-lg-3 pt-2 pb-1">
                    <div class="badge rounded bg-label-primary p-1"><i class="ti ti-ticket ti-sm"></i></div>
                    <div>
                      <h6 class="mb-0 text-nowrap">Aktif</h6>
                      <small class="text-muted">7</small>
                    </div>
                  </li>
                  <li class="d-flex gap-3 align-items-center mb-lg-3 pb-1">
                    <div class="badge rounded bg-label-danger p-1">
                      <i class="ti ti-circle-check ti-sm"></i>
                    </div>
                    <div>
                      <h6 class="mb-0 text-nowrap">Non-Aktif</h6>
                      <small class="text-muted">0</small>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="col-12 col-sm-8 col-md-12 col-lg-8">
                {{-- <div id="supportTracker"></div> --}}
                <div id="totalEarningChart"></div>
              </div>
            </div>
            <hr>
          </div>
        </div>
      </div>
      <!--/ Support Tracker -->
    </div>

    <div class="row mb-5">
      @foreach ($programs as $program)
        <div class="col-xl-3 col-sm-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="badge p-2 bg-label-success mb-2 rounded">
                <i class="ti ti-notebook ti-md"></i>
              </div>
              <h5 class="card-title mb-1 pt-2">{{ $program->programmable->title }}</h5>
              <small class="text-muted">Jumlah User</small>
              <h4 class="mb-2 mt-1">{{ number_format($program->kelas->count()) }}</h4>
              <div class="pt-1">
                <a href="#" class="btn btn-sm btn-primary">Detail</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Atur Pengumuman</h5> <small class="text-muted float-end">إضافة برنامج</small>
          </div>
          <div class="card-datatable table-responsive pt-0">
            <table id="datatable" class="table border-top">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                  <th>Name</th>
                  <th>Leader</th>
                  <th>Team</th>
                  <th class="w-px-200">Status</th>
                  <th>Action</th>
                </tr>
              </thead>
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
      $('#datatable').DataTable();
    });
  </script>
@endsection
