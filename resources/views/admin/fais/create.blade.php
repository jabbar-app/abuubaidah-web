@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Program</h4>
      <a href="{{ route('fais.index') }}" class="btn btn-md btn-light">Kembali</a>
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

          <form method="POST" action="{{ route('fais.store') }}">
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Nama Program</label>
              <input type="text" class="form-control" id="title" name="title"
                value="Integrasi S1 Ma'had - FAI UMSU">
            </div>
            <div class="mb-3">
              <label for="batch" class="form-label">Angkatan</label>
              <input type="number" class="form-control" id="batch" name="batch" placeholder="0">
            </div>

            <div class="mb-3">
              <label for="price_pra" class="form-label">Biaya Pendaftaran/Seleksi</label>
              <input type="number" class="form-control" id="price_pra" name="price_pra" value="0">
            </div>
            <div class="mb-3">
              <label for="price_normal" class="form-label">Biaya SPP</label>
              <input type="number" class="form-control" id="price_normal" name="price_normal" value="0">
            </div>
            <div class="mb-3">
              <label for="price_mahad" class="form-label">Biaya Pembangunan Ma'had</label>
              <input type="number" class="form-control" id="price_mahad" name="price_mahad" value="0">
            </div>
            <div class="mb-3">
              <label for="price_s1" class="form-label">Biaya Pembangunan S1</label>
              <input type="number" class="form-control" id="price_s1" name="price_s1" value="0">
            </div>

            <div class="mb-5">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-select">
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary float-end">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection
