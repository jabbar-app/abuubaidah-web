@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Transaksi Bilhaq</h4>
      <a href="{{ route('payments.create') }}" class="btn btn-md btn-primary">Tambah Transaksi</a>
    </div>

    <div class="row mb-4">
      <div class="col-6">
        <form method="GET" action="{{ url()->current() }}" class="d-flex">
          <select name="batch" class="form-control me-2">
            <option value="">- Pilih Angkatan -</option>
            @foreach ($batches as $batch)
              <option value="{{ $batch }}" {{ $selectedBatch == $batch ? 'selected' : '' }}>
                {{ $batch }}
              </option>
            @endforeach
          </select>
          <button type="submit" class="btn btn-primary me-2">Filter</button>
          <a href="{{ url()->current() }}" class="btn btn-outline-primary">Reset</a>
        </form>
      </div>

      <div class="col-6">
        <a href="{{ route('export.payment.bilhaq', ['batch' => request('batch')]) }}" class="btn btn-outline-primary float-end">Export ke Excel</a>
      </div>
    </div>

    @if (session('success'))
      <div class="row my-2">
        <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>Berhasil!</strong>
          {{ session('success') }}
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @elseif(session('danger'))
      <div class="row my-2">
        <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><strong>Gagal!</strong>
          {{ session('danger') }}
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif

    <div class="card">
      <div class="card-body">
        <div class="card-title header-elements">
          <h5 class="m-0 me-2">Data Transaksi Bilhaq</h5>
          <div class="card-title-elements ms-auto">
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
                    <span class="text-muted" style="font-size: 8pt;">ID Kelas: {{ $payment->kelas->id ?? '-' }}</span>
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
                      <div class="d-inline-block">
                        <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                          data-bs-toggle="dropdown" aria-expanded="false"><i
                            class="text-primary ti ti-dots-vertical"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                          <li><a href="{{ route('payments.show', $payment->id) }}" class="dropdown-item">Details</a></li>
                          <li>
                            <form action="{{ route('invoice.regenerate', ['externalId' => $payment->external_id]) }}"
                              method="POST">
                              @csrf
                              <input type="hidden" name="amount" value="{{ $payment->amount }}">
                              <input type="submit" class="dropdown-item" value="Buat Ulang Invoice">
                            </form>
                          </li>
                          <li>
                            <a href="{{ $payment->invoice_url }}" target="_blank" class="dropdown-item">Lihat Invoice</a>
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
