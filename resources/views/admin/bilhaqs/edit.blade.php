@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Program</h4>
      <a href="{{ route('bilhaqs.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

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

          <form action="{{ route('bilhaqs.update', $bilhaq->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="title" class="form-label">Nama Program</label>
              <input type="text" class="form-control" id="title" name="title"
                value="{{ old('title', $bilhaq->title) }}">
            </div>
            <div class="mb-3">
              <label for="batch" class="form-label">Angkatan</label>
              <input type="number" class="form-control" id="batch" name="batch"
                value="{{ old('batch', $bilhaq->batch) }}">
            </div>
            <div class="mb-3 select2-primary">
              <label class="col-sm-3 col-form-label" for="option-select">Tipe Kelas</label>
              <div class="col-12">
                @php
                  $selectedOptions = json_decode($bilhaq->option, true) ?? [];
                @endphp
                <select id="option-select" class="select2 form-select" multiple name="option[]">
                  <option value="Kelas Online (Daring)" @if (in_array('Kelas Online (Daring)', $selectedOptions)) selected @endif>Kelas Online
                    (Daring)</option>
                  <option value="Kelas Offline (Luring)" @if (in_array('Kelas Offline (Luring)', $selectedOptions)) selected @endif>Kelas Offline
                    (Luring)</option>
                </select>
                <div class="form-text">Bisa pilih lebih dari satu, klik lagi untuk memilih opsi lainnya.</div>
              </div>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description">{{ old('description', $bilhaq->description) }}</textarea>
            </div>
            <div class="mb-3">
              <label for="price_normal" class="form-label">Biaya Pendaftaran</label>
              <input type="number" class="form-control" id="price_normal" name="price_normal"
                value="{{ old('price_normal', $bilhaq->price_normal) }}" min="0">
            </div>
            <div class="mb-5">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-select">
                <option value="1" @if (old('status', $bilhaq->status) == 1) selected @endif>Aktif</option>
                <option value="0" @if (old('status', $bilhaq->status) == 0) selected @endif>Tidak Aktif</option>
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
