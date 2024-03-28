@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Program</h4>
      <a href="{{ route('programs.index') }}" class="btn btn-md btn-light">Kembali</a>
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


          <form action="{{ route('results.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Nama Peserta</label>
              <input type="text" class="form-control" id="name" name="name">
            </div>

            <div class="mb-3">
              <label for="nik" class="form-label">NIK</label>
              <input type="text" class="form-control" id="nik" name="nik">
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="text" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
              <label class="form-label">Jenis Kelamin</label>
              <select name="gender" class="form-control" required>
                <option value="" disabled>- Pilih Data -</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">Nomor WhatsApp</label>
              <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="mb-3">
              <label for="program" class="form-label">Nama Program</label>
              <input type="text" class="form-control" id="program" name="program">
            </div>
            <div class="mb-3">
              <label for="batch" class="form-label">Angkatan</label>
              <input type="text" class="form-control" id="batch" name="batch">
            </div>
            <div class="mb-3">
              <label for="level" class="form-label">Level Saat Ini</label>
              <input type="text" class="form-control" id="level" name="level">
            </div>
            <div class="mb-3">
              <label for="session" class="form-label">Sesi Belajar</label>
              <input type="text" class="form-control" id="session" name="session">
            </div>
            <div class="mb-3">
              <label for="class" class="form-label">Ruang Kelas</label>
              <input type="text" class="form-control" id="class" name="class">
            </div>
            <div class="mb-3">
              <label for="score" class="form-label">Nilai</label>
              <input type="text" class="form-control" id="score" name="score">
            </div>
            <div class="mb-3">
              <label for="next" class="form-label">Rekomendasi Level Selanjutnya</label>
              <input type="text" class="form-control" id="next" name="next">
            </div>
            <div class="mb-3">
              <label for="lecturer" class="form-label">Nama Ustadz/ah</label>
              <input type="text" class="form-control" id="lecturer" name="lecturer">
            </div>

            <button type="submit" class="btn btn-primary float-end mt-4">Submit</button>
          </form>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection
