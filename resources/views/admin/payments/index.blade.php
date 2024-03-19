@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Transaksi</h4>
      <a href="{{ route('payments.create') }}" class="btn btn-md btn-primary">Tambah Transaksi</a>
    </div>

    <div class="card">
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
@endsection

@section('js')
  <script>
    $(document).ready(function() {
      $('#payments').DataTable();
    });
  </script>
@endsection
