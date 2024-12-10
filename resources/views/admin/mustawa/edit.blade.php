@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3">
        <a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Edit Data Mustawa
        {{ ucfirst($type) }}
      </h4>
      <a href="{{ route('mustawa.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    <hr>

    <div class="row">
      <div class="col-sm-12 col-xl-6 m-auto">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('updateMustawa', ['type' => $type, 'id' => $data->id]) }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="kode_mk" class="form-label">Kode MK</label>
                <input type="text" class="form-control" id="kode_mk" name="kode_mk" value="{{ $data->kode_mk }}"
                  required>
              </div>
              <div class="mb-3">
                <label for="mk" class="form-label">Mata Kuliah</label>
                <input type="text" class="form-control" id="mk" name="mk" value="{{ $data->mk }}"
                  required>
              </div>
              <div class="mb-3">
                <label for="sks" class="form-label">SKS</label>
                <input type="number" class="form-control" id="sks" name="sks" value="{{ $data->sks }}"
                  required>
              </div>
              <div class="mb-3">
                <label for="umsu_kode" class="form-label">Kode UMSU</label>
                <input type="text" class="form-control" id="umsu_kode" name="umsu_kode" value="{{ $data->umsu_kode }}"
                  required>
              </div>
              <div class="mb-3">
                <label for="umsu_mk" class="form-label">Nama Mata Kuliah UMSU</label>
                <input type="text" class="form-control" id="umsu_mk" name="umsu_mk" value="{{ $data->umsu_mk }}"
                  required>
              </div>
              <div class="mb-3">
                <label for="umsu_semester" class="form-label">Semester UMSU</label>
                <input type="text" class="form-control" id="umsu_semester" name="umsu_semester"
                  value="{{ $data->umsu_semester }}" required>
              </div>
              <div class="mb-3">
                <label for="stebis_kode" class="form-label">Kode STEBIS</label>
                <input type="text" class="form-control" id="stebis_kode" name="stebis_kode"
                  value="{{ $data->stebis_kode }}" required>
              </div>
              <div class="mb-3">
                <label for="stebis_mk" class="form-label">Nama Mata Kuliah STEBIS</label>
                <input type="text" class="form-control" id="stebis_mk" name="stebis_mk" value="{{ $data->stebis_mk }}"
                  required>
              </div>
              <div class="mb-3">
                <label for="stebis_semester" class="form-label">Semester STEBIS</label>
                <input type="text" class="form-control" id="stebis_semester" name="stebis_semester"
                  value="{{ $data->stebis_semester }}" required>
              </div>
              <button type="submit" class="btn btn-primary mt-4 float-end">Update</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
