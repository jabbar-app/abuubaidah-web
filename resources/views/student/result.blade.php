<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pengumuman Hasil Ujian Ma'had Abu Ubaidah Bin Al Jarrah</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <style>
    .text-start {
      text-align: start;
    }

    .text-center {
      text-align: center;
    }

    .text-end {
      text-align: end;
    }
  </style>
</head>

<body>
  <div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6 col-sm-12 text-center">
      <h3 class="mt-5">Pengumuman Hasil Ujian</h3>
      <h1 class="mb-5">Ma'had Abu Ubaidah Bin Al Jarrah</h1>
      @if (empty($program))
        <div class="row">
          <div class="col-6">
            <a href="/pengumuman/tahsin" class="card">
              <div class="card-body">
                Tahsin Tilawah Al-Qur'an
              </div>
            </a>
          </div>
          <div class="col-6">
            <a href="/pengumuman/kiba" class="card">
              <div class="card-body">
                Kelas Intensif Bahasa Arab
              </div>
            </a>
          </div>
        </div>
      @else
        <form action="{{ route('search.results') }}" method="GET">
          @csrf
          <input type="hidden" name="program" value="{{ $program }}">
          <label for="search" class="form-label">Input Nomor WhatsApp</label>
          <div class="mb-3 d-flex">
            <input type="number" name="phone" class="form-control ms-4 me-2" style="border-radius: 50px;" id="search" placeholder="62xxx" required>
            <button type="submit" class="btn btn-primary me-4">Cari</button>
          </div>
        </form>

        @if ($results != '')
          <div class="container">
            <h1>Hasil Pencarian</h1>
            @forelse ($results as $result)
              <div class="card mt-5">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center alert alert-success">
                    <h5 class="card-title mt-2">Program: {{ $result->program }}</h5>
                    <h5 class="card-title mt-2">Angkatan: {{ $result->batch }}</h5>
                  </div>

                  <div class="card-text text-start">
                    <table class="table">
                      <tbody>
                        <style>
                          th {
                            width: 30%;
                          }
                        </style>
                        <tr>
                          <th scope="row">Nama Peserta</th>
                          <td>: {{ $result->name }}</td>
                        </tr>
                        <tr>
                          <th scope="row">No. WhatsApp</th>
                          <td>: {{ $result->phone }}</td>
                        </tr>
                        <tr>
                          <th scope="row">Level</th>
                          <td>: {{ $result->level }}</td>
                        </tr>
                        <tr>
                          <th scope="row">Jadwal/Sesi Belajar</th>
                          <td>: {{ $result->session }}</td>
                        </tr>
                        <tr>
                          <th scope="row">Hasil/Nilai</th>
                          <td>: {{ $result->score }}</td>
                        </tr>
                        <tr>
                          <th scope="row">Rekomendasi Kelas</th>
                          <td>: {{ $result->next }}</td>
                        </tr>
                        <tr>
                          <th scope="row">Pengajar</th>
                          <td>: {{ $result->lecturer }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <a href="/register?name={{ urlencode($result->name) }}&email={{ urlencode($result->email) }}&phone={{ urlencode($result->phone) }}" class="btn btn-success float-end mt-4">Daftar Ulang</a>
                  <!-- <a href="https://abuubaidah.com/courses/tahsin" class="btn btn-success float-end mt-4">Daftar Ulang</a> -->
                </div>
              </div>
            @empty
              <div class="alert alert-warning text-black mt-3">Tidak ada hasil ditemukan.</div>
            @endforelse
          </div>
        @endif
      @endif
    </div>
  </div>

  <div style="margin-bottom: 400px;"></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
