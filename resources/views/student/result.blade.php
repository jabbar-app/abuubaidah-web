<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pengumuman Hasil Ujian Ma'had Abu Ubaidah Bin Al Jarrah</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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
          <div class="col-3"></div>
          <div class="col-6 align-content-center">
            <a href="/pengumuman/tahsin" class="card bg-success-subtle text-success mb-4">
              <div class="card-body">
                Tahsin Tilawah Al-Qur'an
              </div>
            </a>
            <a href="/pengumuman/lughoh" class="card bg-success-subtle text-success mb-4">
              <div class="card-body">
                Program Bahasa Arab & Studi Islam
              </div>
            </a>
            <a href="/pengumuman/kiba" class="card bg-success-subtle text-success mb-4">
              <div class="card-body">
                Kelas Intensif Bahasa Arab
              </div>
            </a>
          </div>
        </div>
      @else
        @if ($program == 'lughoh')
          <form action="{{ route('search.results') }}" method="GET">
            @csrf
            <input type="hidden" name="program" value="{{ $program }}">
            <label for="search" class="form-label">Input NIM</label>
            <div class="mb-3 d-flex">
              <input type="number" name="nim" class="form-control ms-4 me-2" style="border-radius: 50px;"
                id="search" placeholder="NIM" required>
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
                      <h5 class="card-title mt-2">Program Bahasa Arab & Studi Islam</h5>
                      {{-- <h5 class="card-title mt-2">Angkatan: {{ $result->batch }}</h5> --}}
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
                            <th scope="row">Jenis Kelamin</th>
                            <td>: {{ $result->gender }}</td>
                          </tr>
                          <tr>
                            <th scope="row">NIM</th>
                            <td>: {{ $result->nim }}</td>
                          </tr>
                          <tr>
                            <th scope="row">Level</th>
                            <td>: {{ $result->level }}</td>
                          </tr>
                          <tr>
                            <th scope="row">Kelas</th>
                            <td>: {{ $result->class }}</td>
                          </tr>
                          <tr>
                            <th scope="row">Hasil/Nilai</th>
                            <td>
                              <table class="table">
                                <thead>
                                  <th>Mata Kuliah</th>
                                  <th>Nilai</th>
                                </thead>
                                <tbody>
                                  @if ($result->alquran != null)
                                    <tr>
                                      <td>Al-Qur'an</td>
                                      <td>{{ $result->alquran }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->tafsir != null)
                                    <tr>
                                      <td>Tafsir</td>
                                      <td>{{ $result->tafsir }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->alhadits != null)
                                    <tr>
                                      <td>Al Hadits</td>
                                      <td>{{ $result->alhadits }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->fahmulmaqru != null)
                                    <tr>
                                      <td>Fahmul Maqru’</td>
                                      <td>{{ $result->fahmulmaqru }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->tabirtahriry != null)
                                    <tr>
                                      <td>Ta’bir Tahriry</td>
                                      <td>{{ $result->tabirtahriry }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->tabirsyafahiy != null)
                                    <tr>
                                      <td>Ta’bir Syafahiy</td>
                                      <td>{{ $result->tabirsyafahiy }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->alimla != null)
                                    <tr>
                                      <td>Al-Imla’</td>
                                      <td>{{ $result->alimla }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->tauhid != null)
                                    <tr>
                                      <td>Tauhid</td>
                                      <td>{{ $result->tauhid }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->fiqih != null)
                                    <tr>
                                      <td>Fiqih</td>
                                      <td>{{ $result->fiqih }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->aladab != null)
                                    <tr>
                                      <td>Al-Adab</td>
                                      <td>{{ $result->aladab }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->tarikh != null)
                                    <tr>
                                      <td>At-Tarikh Al-Islamiy</td>
                                      <td>{{ $result->tarikh }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->ushulfiqih != null)
                                    <tr>
                                      <td>Ushul fiqih</td>
                                      <td>{{ $result->ushulfiqih }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->ashwat != null)
                                    <tr>
                                      <td>Al-Ashwat</td>
                                      <td>{{ $result->ashwat }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->qawaid != null)
                                    <tr>
                                      <td>Al-Qawaid</td>
                                      <td>{{ $result->qawaid }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->tsaqofah != null)
                                    <tr>
                                      <td>At-Tsaqofah</td>
                                      <td>{{ $result->tsaqofah }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->balagoh != null)
                                    <tr>
                                      <td>Al – Balagoh</td>
                                      <td>{{ $result->balagoh }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->tta != null)
                                    <tr>
                                      <td>Tilawah, Tahsin, Al-Qur'an</td>
                                      <td>{{ $result->tta }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->arob_1 != null)
                                    <tr>
                                      <td>Al Arobiyah 1</td>
                                      <td>{{ $result->arob_1 }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->arob_2 != null)
                                    <tr>
                                      <td>Al Arobiyah 2</td>
                                      <td>{{ $result->arob_2 }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->muhammadiyah != null)
                                    <tr>
                                      <td>Muhammadiyah</td>
                                      <td>{{ $result->muhammadiyah }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->imla_khat != null)
                                    <tr>
                                      <td>Al Imla wal Khat</td>
                                      <td>{{ $result->imla_khat }}</td>
                                    </tr>
                                  @endif

                                  @if ($result->tadribat != null)
                                    <tr>
                                      <td>Tadribat Lughawiyah</td>
                                      <td>{{ $result->tadribat }}</td>
                                    </tr>
                                  @endif
                                </tbody>
                                <tfoot>
                                  <th>Nilai Akhir</th>
                                  <th>{{ $result->score }}</th>
                                </tfoot>
                              </table>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <a href="/register?name={{ urlencode($result->name) }}&email={{ urlencode($result->email) }}&phone={{ urlencode($result->phone) }}"
                      class="btn btn-success float-end mt-4">Daftar Akun</a>
                    <!-- <a href="https://abuubaidah.com/courses/tahsin" class="btn btn-success float-end mt-4">Daftar Ulang</a> -->
                  </div>
                </div>
              @empty
                <div class="alert alert-warning text-black mt-3">Tidak ada hasil ditemukan.</div>
              @endforelse
            </div>
          @endif
        @else
          <form action="{{ route('search.results') }}" method="GET">
            @csrf
            <input type="hidden" name="program" value="{{ $program }}">
            <label for="search" class="form-label">Input Nomor WhatsApp</label>
            <div class="mb-3 d-flex">
              <input type="number" name="phone" class="form-control ms-4 me-2" style="border-radius: 50px;"
                id="search" placeholder="62xxx" required>
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
                    <a href="/register?name={{ urlencode($result->name) }}&email={{ urlencode($result->email) }}&phone={{ urlencode($result->phone) }}"
                      class="btn btn-success float-end mt-4">Daftar Ulang</a>
                    <!-- <a href="https://abuubaidah.com/courses/tahsin" class="btn btn-success float-end mt-4">Daftar Ulang</a> -->
                  </div>
                </div>
              @empty
                <div class="alert alert-warning text-black mt-3">Tidak ada hasil ditemukan.</div>
              @endforelse
            </div>
          @endif
        @endif

      @endif
    </div>
  </div>

  <div style="margin-bottom: 400px;"></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
