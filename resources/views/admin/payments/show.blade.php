@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Transaksi</h4>
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

          <div class="mb-3">
            <small>ID Transaksi</small>
            <h5>{{ $payment->external_id }}</h5>
          </div>
          <div class="mb-3">
            <small>Nama User</small>
            <h5>{{ $payment->payer_name }}</h5>
          </div>
          <div class="mb-3">
            <small>Jumlah</small>
            <h5>Rp{{ number_format($payment->amount, 0, ',', '.') }},-</h5>
          </div>

          <div class="my-5">
            <small>Status</small>
            @if ($payment->status=='PAID')
              <h5 class="badge bg-label-primary">LUNAS</h5>
            @else
              <h5 class="badge bg-label-danger">{{ $payment->status }}</h5>
            @endif
          </div>
          <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-primary float-end">Edit Data</a>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection