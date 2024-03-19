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
                <p class="mb-0">Total Transaksi Berhasil</p>
                <h4 class="text-info mb-0">Rp{{ number_format($total_transaksi_berhasil, 0, ',', '.') }},-</h4>
              </div>
            </div>
            <div class="d-flex align-items-center gap-3">
              <span class="bg-label-warning p-2 rounded">
                <i class="ti ti-hourglass-empty ti-xl"></i>
              </span>
              <div class="content-right">
                <p class="mb-0">Total Transaksi Pending</p>
                <h4 class="text-warning mb-0">Rp{{ number_format($total_transaksi_pending, 0, ',', '.') }},-</h4>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4 ps-md-3 ps-lg-4 pt-3 pt-md-0">

        </div>
      </div>
    </div>

    <div class="row mb-5">
      <div class="col-lg-12 col-sm-12 mb-4">
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
                  <h4 class="my-2 pt-1">Rp{{ number_format($total_transaksi_berhasil, 0, ',', '.') }},-</h4>
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
                  <h4 class="my-2 pt-1">Rp{{ number_format($total_transaksi_berhasil, 0, ',', '.') }},-</h4>
                  <div class="progress w-75" style="height: 4px">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Transaksi</h5> <small class="text-muted float-end">إضافة برنامج</small>
          </div>
          <div class="card-datatable table-responsive pt-0">
            <table id="payments" class="table">
                <thead>
                  <tr>
                    <th>User</th>
                    <th>Program</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($payments as $payment)
                    <tr>
                      <td>{{ $payment->payer_name }}</td>
                      <td>{{ $payment->program->programmable->title }}</td>
                      <td>{{ $payment->description }}</td>
                      <td>Rp{{ number_format($payment->amount, 0, ',', '.') }},-</td>
                      <td><span class="badge @if($payment->method=='Offline') bg-label-info @else bg-label-primary @endif me-1">{{ $payment->method }}</span></td>
                      <td><span class="badge @if($payment->status=='PAID') bg-label-primary @else bg-label-warning @endif me-1">{{ $payment->status }}</span></td>
                      <td>
                        <div class="d-inline-block"><a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"><i class="text-primary ti ti-dots-vertical"></i></a>
                          <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                            <li><a href="{{ route('payments.show', $payment->id) }}" class="dropdown-item">Details</a></li>
                            <li><a href="{{ $payment->invoice_url }}" target="_blank" class="dropdown-item">Lihat Invoice</a></li>
                            <div class="dropdown-divider"></div>
                            <li>
                              <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                              </form>
                            </li>
                          </ul>
                        </div><a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-sm btn-icon item-edit"><i class="text-primary ti ti-pencil"></i></a>
                      </td>
                    </tr>
                  @endforeach

                </tbody>
                <tfoot>
                  <tr>
                    <th>User</th>
                    <th>Program</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Metode</th>
                    <th>Status</th>
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
      $('#payments').DataTable();
    });
  </script>
@endsection
