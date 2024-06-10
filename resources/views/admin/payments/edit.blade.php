@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Transaksi</h4>
      <a href="{{ route('payments.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    {{-- <hr class="mb-5"> --}}

    <div class="d-flex justify-content-center">
      <div class="card col-xl-8 col-md-10 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Tambah Data</h5>
          <small class="text-muted float-end">
            إضافة البيانات
          </small>
        </div>
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif


          <form method="POST" action="{{ route('payments.update', $payment->id) }}">
            @csrf
            @method('PUT')
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Nama User</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" value="{{ $payment->payer_name }}" disabled>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Nama Program</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" value="{{ $payment->program->programmable->title }}" disabled>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Biaya Program</label>
              <div class="col-sm-9">
                <input type="text" name="amount" class="form-control" value="{{ $payment->amount }}">
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Status Saat Ini</label>
              <div class="col-sm-9">
                <input type="text" name="amount" class="form-control" value="{{ $payment->status }}" disabled>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="method">Metode Pembayaran</label>
              <div class="col-sm-9">
                <select name="method" id="method" class="form-select" required>
                  <option value="" selected disabled>- Pilih Metode -</option>
                  <option value="Xendit" {{ $payment->method == 'Xendit' ? 'selected' : '' }}>Xendit</option>
                  <option value="Offline" {{ $payment->method == 'Offline' ? 'selected' : '' }}>Offline</option>
                </select>
              </div>
            </div>

            <div class="row mb-3" id="status-row">
              <label class="col-sm-3 col-form-label" for="status">Update Status</label>
              <div class="col-sm-9">
                <select name="status" id="status" class="form-select" required>
                  <option value="" selected disabled>- Pilih Data -</option>
                  <option value="PENDING" {{ $payment->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                  <option value="PAID" {{ $payment->status == 'PAID' ? 'selected' : '' }}>LUNAS</option>
                  <option value="CICILAN" {{ $payment->status == 'CICILAN' ? 'selected' : '' }}>CICILAN</option>
                </select>
              </div>
            </div>

            @if ($payment->status == 'CICILAN')
              <div class="row mb-3" id="installment-row">
                <label class="col-sm-3 col-form-label" for="installment">Update Cicilan</label>
                <div class="col-sm-9">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Jumlah</th>
                          <th>Tanggal</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($payment->installments as $index => $installment)
                          <tr>
                            <td>{{ number_format($installment->amount, 0, ',', '.') }}</td>
                            <td>{{ $installment->due_date }}</td>
                            <td>
                              <select name="installments[{{ $index }}][status]" class="form-select">
                                <option value="PENDING" {{ $installment->status == 'PENDING' ? 'selected' : '' }}>PENDING
                                </option>
                                <option value="PAID" {{ $installment->status == 'PAID' ? 'selected' : '' }}>PAID
                                </option>
                              </select>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            @endif

            <div class="row mb-3" id="note-row">
              <label class="col-sm-3 col-form-label" for="note">Catatan</label>
              <div class="col-sm-9">
                <textarea name="note" id="note" rows="3" class="form-control" placeholder="Tambahkan catatan di sini.">{{ $payment->note }}</textarea>
              </div>
            </div>

            <div class="mt-5">
              <button type="submit" class="btn btn-primary float-end">Update Data</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection
