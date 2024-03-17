@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Program</h4>
      <a href="{{ route('tahfizs.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    {{-- <hr class="mb-5"> --}}

    <div class="d-flex justify-content-center">
      <div class="card col-xl-8 col-md-10 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Tambah Program</h5> <small class="text-muted float-end">إضافة برنامج</small>
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
            <small>Nama Program</small>
            <h5>{{ $tahfiz->title }}</h5>
          </div>
          <div class="mb-3">
            <small>Angkatan</small>
            <h5>{{ $tahfiz->batch }}</h5>
          </div>
          <div class="mb-3">
            <small>Tipe Kelas</small>
            @php
              $selectedOptions = json_decode($tahfiz->option);
            @endphp
            <div class="d-flex mt-1">
              @foreach ($selectedOptions as $option)
                <span class="badge bg-label-info me-2">{{ $option }}</span>
              @endforeach
            </div>
          </div>
          <div class="mb-3">
            <small>Deskripsi</small>
            <p>{{ $tahfiz->description }}</p>
          </div>
          <div class="mb-3">
            <small>Biaya Normal</small>
            <h5>Rp{{ number_format($tahfiz->price_normal, 0, ',', '.') }},-</h5>
          </div>
          <div class="mb-3">
            <small>Biaya Alumni</small>
            <h5>Rp{{ number_format($tahfiz->price_alumni, 0, ',', '.') }},-</h5>
          </div>
          <div class="my-5">
            <small>Status</small>
            @if ($tahfiz->status)
              <h5 class="badge bg-label-primary">Aktif</h5>
            @else
              <h5 class="badge bg-label-danger">Tidak Aktif</h5>
            @endif
          </div>
          <a href="{{ route('tahfizs.edit', $tahfiz->id) }}" class="btn btn-primary float-end">Edit Data</a>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection
