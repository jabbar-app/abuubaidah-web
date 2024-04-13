@extends('student.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 mb-4"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Transaksi</h4>

    <div class="row my-4">
      @foreach ($invoices as $invoice)
        <div class="col-xl-4 col-sm-12">
          <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
              <div class="card-title mb-0">
                <em class="m-0 me-2">No. Invoice: <br><span style="font-size: 14pt;">{{ $invoice->external_id }}</span></em>
              </div>
              <div class="dropdown">
                <button class="btn p-0" type="button" id="popularInstructors" data-bs-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="ti ti-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="popularInstructors">
                  <li><a class="dropdown-item" href="{{ $invoice->invoice_url }}" target="_blank">Lihat Detail</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);" onclick="location.reload();">Cek
                      Status</a>
                  </li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li>
                    <form action="{{ route('invoice.regenerate', ['externalId' => $invoice->external_id]) }}"
                      method="POST">
                      @csrf
                      <input type="hidden" name="amount" value="{{ $invoice->amount }}">
                      <input type="submit" class="dropdown-item" value="Buat Ulang">
                    </form>
                  </li>
                </ul>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-borderless border-top">
                <thead class="border-bottom">
                  <tr>
                    <th>Item</th>
                    <th class="text-end">Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Tanggal</td>
                    <td class="text-end">{{ $invoice->updated_at->format('d M Y') }}</td>
                  </tr>
                  <tr>
                    <td>Deskripsi</td>
                    <td class="text-end">{{ $invoice->description }}</td>
                  </tr>
                  <tr>
                    <td>Jumlah</td>
                    <td class="text-end">Rp{{ number_format($invoice->amount, 0, ',', '.') }},-</td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td class="text-end">
                      <span class="badge @if ($invoice->status == 'PAID') bg-label-success @else bg-label-warning @endif">{{ $invoice->status }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>
                        <a href="{{ $invoice->invoice_url }}" target="_blank"
                          class="btn btn-sm btn-primary float-end">Bayar</a>
                      <a href="javascript:void(0);" onclick="location.reload();" class="btn btn-sm btn-warning me-2 float-end">Cek
                        Status</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      @endforeach
    </div>

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
                <td>{{ $p->updated_at->format('d M') }}</td>
                <td>{{ $p->external_id }}</td>
                <td>{{ $p->description }}</td>
                <td>Rp{{ number_format($p->amount, 0, ',', '.') }},-</td>
                <td>
                  <span
                    class="badge @if ($p->status == 'PAID') bg-label-success @else bg-label-warning @endif">{{ $p->status }}</span>
                </td>
                <td>
                  <div class="btn-group dropstart">
                    <button class="btn btn-sm btn-primary dropdown-toggle waves-effect waves-light" type="button"
                      data-bs-toggle="dropdown" aria-expanded="false">Pilih</button>
                    <ul class="dropdown-menu" style="">
                      <li><a class="dropdown-item" href="{{ $p->invoice_url }}" target="_blank">Lihat</a></li>
                      <li><a class="dropdown-item" href="javascript:void(0);" onclick="location.reload();">Cek
                          Status</a>
                      </li>
                      <li>
                        <hr class="dropdown-divider">
                      </li>
                      <li>
                        <form action="{{ route('invoice.regenerate', ['externalId' => $p->external_id]) }}"
                          method="POST">
                          @csrf
                          <input type="hidden" name="amount" value="{{ $p->amount }}">
                          <input type="submit" class="dropdown-item" value="Buat Ulang">
                        </form>
                      </li>
                    </ul>
                  </div>
                </td>
                {{-- <td class="d-flex" style="height: 100%">
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
                </td> --}}
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
