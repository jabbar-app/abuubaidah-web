@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Transaksi</h4>
      <a href="{{ route('payments.create') }}" class="btn btn-md btn-primary">Tambah Transaksi</a>
    </div>

    @if (session('success'))
      <div class="row my-2">
        <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>Berhasil!
          </strong> {{ session('success') }}
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @elseif(session('danger'))
      <div class="row my-2">
        <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><strong>Gagal!
          </strong> {{ session('danger') }}
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif

    @if (!empty($program))
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between mb-lg-n4">
          <div class="card-title">
            <h5 class="mb-0">Program: {{ $program->programmable->title }}</h5>
            <small class="text-muted">Angkatan: {{ $batch }} | Gelombang:
              {{ $gelombang }}</small>
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
                    <h4 class="my-2 pt-1">{{ $new + $renewed }}</h4>
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
                      <h6 class="mb-0">Export Data Transaksi ke Excel</h6>
                    </div>
                    <a href="/export-payments/{{ $program_id }}/{{ $batch }}/{{ $gelombang }}"
                      class="btn btn-md btn-primary mb-2 mt-3">Export</a>
                    {{-- <a href="/export-all-kelas" class="btn btn-md btn-outline-primary mb-2 mt-3">Export Semua Data</a> --}}
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
    @endif

    <div class="card">
      <div class="card-body">
        <div class="card-title header-elements">
          <h5 class="m-0 me-2">Data Transaksi</h5>
          <div class="card-title-elements ms-auto">
            <form action="{{ route('payment.filter') }}" method="POST">
              @csrf
              <a href="/export-payments" class="btn btn-sm btn-outline-primary mb-2 mt-3 float-end">Export Data
                Transaksi</a>
              <select id="program_id" name="program_id" class="form-select form-select-sm mb-2">
                <option value="">Select Program</option>
                @foreach ($programs as $program)
                  <option value="{{ $program->id }}">
                    {{ $program->programmable->title }}
                  </option>
                @endforeach
              </select>
              <select id="batch" name="batch" class="form-select form-select-sm mb-2" style="display: none;">
                <option value="">Select Angkatan</option>
                {{-- Options will be populated by JavaScript --}}
              </select>
              <select id="gelombang" name="gelombang" class="form-select form-select-sm mb-2" style="display: none;">
                <option value="">Select Gelombang</option>
                {{-- Options will be populated by JavaScript --}}
              </select>
              <div class="d-flex float-end mt-2">
                <a href="{{ route('payments.index') }}" class="btn btn-sm btn-light ms-2">Reset</a>
                <button type="submit" class="btn btn-sm btn-primary waves-effect waves-light ms-2">Filter</button>
              </div>
            </form>
          </div>
        </div>

        <div class="card-datatable table-responsive pt-0">
          <table id="payments" class="table">
            <thead>
              <tr>
                <th>Data Transaksi</th>
                <th>User</th>
                <th>Program</th>
                <th>WhatsApp</th>
                <th>Jumlah</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Tindakan</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($payments as $payment)
                <tr>
                  <td>{{ $payment->external_id }}</td>
                  <td>{{ $payment->payer_name }}</td>
                  <td>
                    {{ $payment->program->programmable->title }} <br>
                    <span class="text-muted" style="font-size: 8pt;">Angkatan:
                      {{ $payment->program->programmable->batch }}</span>
                    <br>
                    <span class="text-muted" style="font-size: 8pt;">
                      ID Kelas: {{ $payment->kelas->id ?? '-' }}
                    </span>
                    {{-- ID Kelas: {{ dd($payment->program->kelas) }} --}}
                  </td>
                  <td>{{ optional($payment->user)->phone }}</td>
                  <td>Rp{{ number_format($payment->amount, 0, ',', '.') }},-</td>
                  <td><span
                      class="badge @if ($payment->method == 'Offline') bg-label-info @else bg-label-primary @endif me-1">{{ $payment->method }}</span>
                  </td>
                  <td><span
                      class="badge @if ($payment->status == 'PAID') bg-label-primary @else bg-label-warning @endif me-1">{{ $payment->status }}</span>
                  </td>
                  <td>
                    @if (Auth::user()->hasRole('Super Admin') || Auth::user()->hasRole('Accountant'))
                      <div class="d-inline-block"><a href="javascript:;"
                          class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                          aria-expanded="false"><i class="text-primary ti ti-dots-vertical"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                          <li><a href="{{ route('payments.show', $payment->id) }}" class="dropdown-item">Details</a>
                          </li>
                          <li>
                            <form action="{{ route('invoice.regenerate', ['externalId' => $payment->external_id]) }}"
                              method="POST">
                              @csrf
                              <input type="hidden" name="amount" value="{{ $payment->amount }}">
                              <input type="submit" class="dropdown-item" value="Buat Ulang Invoice">
                            </form>
                          </li>
                          <li>
                            <a href="{{ $payment->invoice_url }}" target="_blank" class="dropdown-item">Lihat
                              Invoice</a>
                          </li>
                          <div class="dropdown-divider"></div>
                          <li>
                            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this payment?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                            </form>
                          </li>
                        </ul>
                      </div>
                      <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-sm btn-icon item-edit"><i
                          class="text-primary ti ti-pencil"></i></a>
                    @else
                      <a href="{{ route('payments.show', $payment->id) }}"
                        class="btn btn-sm btn-outline-primary">Lihat</a>
                    @endif

                  </td>
                </tr>
              @endforeach

            </tbody>
            <tfoot>
              <tr>
                <th>Data Transaksi</th>
                <th>User</th>
                <th>Program</th>
                <th>WhatsApp</th>
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
@endsection

@section('js')
  <script>
    $(document).ready(function() {
      $('#payments').DataTable({
        "order": [
          [0, "desc"]
        ] // Sort by the first column (index 0) in descending order
      });
    });
  </script>
@endsection
