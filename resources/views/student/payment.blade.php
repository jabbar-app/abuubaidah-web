@extends('student.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 mb-4"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Transaksi</h4>

    <div class="card">
      <div class="card-datatable table-responsive pt-0">
        <table id="datatable" class="table">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>No. Transaksi</th>
              <th>Deskripsi</th>
              <th>Jumlah</th>
              <th>Status</th>
              <th>Invoice</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($payment as $p)
              <tr>
                <td>{{ $p->updated_at->format('d M Y') }}</td>
                <td>{{ $p->external_id }}</td>
                <td>{{ $p->description }}</td>
                <td>Rp{{ number_format($p->amount, 0, ',', '.') }},-</td>
                <td>
                  <span
                    class="badge @if ($p->status == 'PAID') bg-label-success @else bg-label-warning @endif">{{ $p->status }}</span>
                </td>
                <td class="d-flex" style="height: 100%">
                  @if ($p->status == 'PAID')
                    @if ($p->method == 'Xendit')
                      <a href="{{ $p->invoice_url }}" target="_blank" class="btn btn-sm btn-info me-2">Lihat</a>
                    @else
                      <div class="btn btn-sm btn-info me-2">Pembayaran Offline</div>
                    @endif
                  @else
                    <a href="{{ $p->invoice_url }}" target="_blank" class="btn btn-sm btn-danger me-2">Bayar</a>
                    <form action="{{ route('invoice.regenerate', ['externalId' => $p->external_id]) }}" method="POST">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-primary">Buat Ulang</button>
                    </form>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Tanggal</th>
              <th>No. Transaksi</th>
              <th>Deskripsi</th>
              <th>Jumlah</th>
              <th>Status</th>
              <th>Invoice</th>
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
      $('#datatable').DataTable();
    });
  </script>
@endsection
