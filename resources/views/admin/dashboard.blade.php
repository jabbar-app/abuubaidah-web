@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">


    <div class="card bg-transparent shadow-none my-4 border-0">
      <div class="card-body row p-0 pb-3">
        <div class="col-12 col-md-8 card-separator">
          <h3>{{ Auth::user()->roles->first()->name . ' | ' ?? '' }} {{ Auth::user()->name }}</h3>

          <div class="col-12 col-lg-7 mb-5">
            <p>Selamat datang di Ma'had Abu Ubaidah Bin Al Jarrah, <em>Lembaga Pendidikan Bahasa Arab & Studi Islam!</em>
            </p>
          </div>
          <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
            <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
              <span class="bg-label-primary p-2 rounded">
                <i class="ti ti-user ti-xl"></i>
              </span>
              <div class="content-right">
                <p class="mb-0">Total User</p>
                <h4 class="text-primary mb-0">{{ $total_user }}</h4>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span class="bg-label-info p-2 rounded">
                <i class="ti ti-chart-bar ti-xl"></i>
              </span>
              <div class="content-right">
                <p class="mb-0">Total Transaksi Berhasil</p>
                <h4 class="text-info mb-0">{{ $transaksi_berhasil }}</h4>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span class="bg-label-warning p-2 rounded">
                <i class="ti ti-hourglass-empty ti-xl"></i>
              </span>
              <div class="content-right">
                <p class="mb-0">Total Transaksi Pending</p>
                <h4 class="text-warning mb-0">{{ $transaksi_pending }}</h4>
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
              <option value="0">Semua Program</option>
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
      <div class="col-12">
        <div class="card-header">
          <h4>Ringkasan / Overview</h4>
          <hr>
        </div>
      </div>
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
                <h5 class="mb-0 pt-1 text-nowrap ms-lg-n3 ms-xl-0">
                  Rp{{ number_format($total_transaksi_pending, 0, ',', '.') }},-</h5>
                <small class="text-muted">{{ $transaksi_pending }}</small>
              </div>
            </div>
            <div class="d-flex align-items-center mt-4">
              <div class="progress w-100" style="height: 8px">
                <div class="progress-bar bg-success" style="width: 50%" role="progressbar" aria-valuenow="50"
                  aria-valuemin="0" aria-valuemax="100"></div>
                <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50"
                  aria-valuemin="0" aria-valuemax="100"></div>
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
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50"
                      aria-valuemin="0" aria-valuemax="100"></div>
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
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50"
                      aria-valuemin="0" aria-valuemax="100"></div>
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
              <button class="btn p-0" type="button" id="supportTrackerMenu" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
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
              <div class="col-4 position-relative">
                <div class="mt-lg-4 mt-lg-2 mb-lg-4 mb-2 pt-1">
                  <h1 class="mb-0">{{ $totalPrograms }}</h1>
                  <p class="mb-0">Total Program</p>
                </div>
                <ul class="p-0 m-0">
                  <li class="d-flex gap-3 align-items-center mb-lg-3 pt-2 pb-1">
                    <div class="badge rounded bg-label-primary p-1"><i class="ti ti-ticket ti-sm"></i></div>
                    <div>
                      <h6 class="mb-0 text-nowrap">Aktif</h6>
                      <small class="text-muted">{{ $activePrograms }}</small>
                    </div>
                  </li>
                  <li class="d-flex gap-3 align-items-center mb-lg-3 pb-1">
                    <div class="badge rounded bg-label-danger p-1">
                      <i class="ti ti-circle-check ti-sm"></i>
                    </div>
                    <div>
                      <h6 class="mb-0 text-nowrap">Non-Aktif</h6>
                      <small class="text-muted">{{ $nonActivePrograms }}</small>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="col-8">
                <div id="projectStatusChart"></div>
              </div>
            </div>
            <hr>
          </div>
        </div>
      </div>
      <!--/ Support Tracker -->
    </div>

    {{-- <div class="row mb-5">
      <div class="col-12">
        <h6 class="text-muted">Basic</h6>
        <hr>
        <div class="nav-align-top mb-4">
          <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item">
              <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">
                Home
              </button>
            </li>
            <li class="nav-item">
              <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">
                Profile
              </button>
            </li>
            <li class="nav-item">
              <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages"
                aria-selected="false">
                Messages
              </button>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
              <p>
                Icing pastry pudding oat cake. Lemon drops cotton candy caramels cake caramels sesame snaps
                powder. Bear claw candy topping.
              </p>
              <p class="mb-0">
                Tootsie roll fruitcake cookie. Dessert topping pie. Jujubes wafer carrot cake jelly. Bonbon
                jelly-o jelly-o ice cream jelly beans candy canes cake bonbon. Cookie jelly beans marshmallow
                jujubes sweet.
              </p>
            </div>
            <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
              <p>
                Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice
                cream. Gummies halvah tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream
                cheesecake fruitcake.
              </p>
              <p class="mb-0">
                Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu halvah
                cotton candy liquorice caramels.
              </p>
            </div>
            <div class="tab-pane fade" id="navs-pills-top-messages" role="tabpanel">
              <p>
                Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies
                cupcake gummi bears cake chocolate.
              </p>
              <p class="mb-0">
                Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet
                roll icing sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly
                jelly-o tart brownie jelly.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div> --}}

    <div class="row mb-5">
      <div class="col-12">
        <div class="card-header">
          <h4>Program Aktif</h4>
          <hr>
        </div>
      </div>
      @foreach ($programs as $program)
        <div class="col-xl-3 col-sm-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="badge p-2 bg-label-success mb-2 rounded">
                <i class="ti ti-notebook ti-md"></i>
              </div>
              <h5 class="card-title mb-1 pt-2" style="height: 60px;">{{ $program->programmable->title }}</h5>
              <hr>
              <table class="table table-borderless">
                <tbody>
                  @if ($program->programmable_type == 'App\Models\Tahsin' || $program->programmable_type == 'App\Models\Kiba')
                    <tr>
                      <td style="padding: 0;">
                        Peserta Baru
                        <br>
                        <span class="form-label text-danger">Paid:</span>
                        <br>
                        <span class="form-label text-danger">Pending:</span>
                        <br>
                        <span class="form-label text-danger">Expired:</span>
                      </td>
                      <td class="text-primary fw-medium" style="text-align: right;">
                        {{ $program->new_total }}
                        <br>
                        <span class="form-label text-danger">{{ $program->new_paid }}</span>
                        <br>
                        <span class="form-label text-danger">{{ $program->new_pending }}</span>
                        <br>
                        <span class="form-label text-danger">{{ $program->new_expired }}</span>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding: 0;">
                        Daftar Ulang
                        <br>
                        <span class="form-label text-danger">Paid:</span>
                        <br>
                        <span class="form-label text-danger">Pending:</span>
                        <br>
                        <span class="form-label text-danger">Expired:</span>
                      </td>
                      <td class="text-primary fw-medium" style="text-align: right;">
                        {{ $program->renew_total }}
                        <br>
                        <span class="form-label text-danger">{{ $program->renew_paid }}</span>
                        <br>
                        <span class="form-label text-danger">{{ $program->renew_pending }}</span>
                        <br>
                        <span class="form-label text-danger">{{ $program->renew_expired }}</span>
                      </td>
                    </tr>
                  @endif
                  <tr>
                    <td style="padding: 0;">Total Peserta
                      <br>
                      <span class="form-label text-danger">Paid:</span>
                      <br>
                      <span class="form-label text-danger">Pending:</span>
                      <br>
                      <span class="form-label text-danger">Expired:</span>
                    </td>
                    <td class="text-primary fw-medium" style="text-align: right;">
                      {{ $program->total }}
                      <br>
                      <span class="form-label text-danger">{{ $program->total_paid }}</span>
                      <br>
                      <span class="form-label text-danger">{{ $program->total_pending }}</span>
                      <br>
                      <span class="form-label text-danger">{{ $program->total_expired }}</span>
                    </td>
                  </tr>
                </tbody>
              </table>

              {{-- <div class="pt-1">
                <a href="#" class="btn btn-sm btn-primary">Detail</a>
              </div> --}}
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
                    <td>{{ $announcement->program->programmable->title ?? 'Semua Program' }}</td>
                    <td><span class="badge bg-label-info">{{ $announcement->category }}</span></td>
                    <td>
                      <div class="d-inline-block"><a href="javascript:;"
                          class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                          aria-expanded="false"><i class="text-primary ti ti-dots-vertical"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                          <li><a href="{{ route('announcements.show', $announcement->id) }}"
                              class="dropdown-item">Details</a></li>
                          {{-- <li><a href="javascript:;" class="dropdown-item">Archive</a></li> --}}
                          <div class="dropdown-divider"></div>
                          <li>
                            <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this announcements?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                            </form>
                          </li>
                        </ul>
                      </div>
                      <a href="{{ route('announcements.edit', $announcement->id) }}"
                        class="btn btn-sm btn-icon item-edit"><i class="text-primary ti ti-pencil"></i></a>
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
      $('#announcements').DataTable();
    });
  </script>
@endsection
