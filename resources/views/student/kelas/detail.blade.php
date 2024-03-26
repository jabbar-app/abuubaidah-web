@extends('student.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /
        </a>{{ $program->programmable->title }}</h4>
    </div>

    {{-- <hr class="mb-5"> --}}

    <div class="d-flex justify-content-center">
      <div class="card col-xl-8 col-md-10 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Detail Program</h5> <small class="text-muted float-end">برنامج التفاصيل</small>
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
            <h5>{{ $kelas->program }}</h5>
          </div>
          <div class="mb-4">
            <small>Tanggal Diupdate</small>
            <h5>{{ $kelas->updated_at->format('d M Y') }}</h5>
          </div>
          @if (
              $program->programmable_type == 'App\Models\Lughoh' ||
                  $program->programmable_type == 'App\Models\Fai' ||
                  $program->programmable_type == 'App\Models\Stebis')
            <div class="table-responsive text-nowrap">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="bg-light">Data</th>
                    <th class="bg-light">Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Nama Peserta</td>
                    <td>
                      <span class="fw-medium">{{ Auth::user()->name }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td>
                      <span class="fw-medium">{{ $kelas->status }}</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          @elseif ($program->programmable_type == 'App\Models\Tahfiz')
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="bg-light">Data</th>
                  <th class="bg-light">Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Nama Peserta</td>
                  <td>
                    <span class="fw-medium">{{ Auth::user()->name }}</span>
                  </td>
                </tr>
                <tr>
                  <td>Status</td>
                  <td>
                    <span class="fw-medium">{{ $kelas->status }}</span>
                  </td>
                </tr>
              </tbody>
            </table>
          @elseif ($program->programmable_type == 'App\Models\Bilhaq')
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th class="bg-light">Data</th>
                  <th class="bg-light">Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Nama Peserta</td>
                  <td>
                    <span class="fw-medium">{{ Auth::user()->name }}</span>
                  </td>
                </tr>
                <tr>
                  <td>Status</td>
                  <td>
                    <span class="fw-medium">{{ $kelas->status }}</span>
                  </td>
                </tr>
              </tbody>
            </table>
          @else
            <div class="table-responsive text-nowrap">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="bg-light">Data</th>
                    <th class="bg-light">Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Nama Peserta</td>
                    <td>
                      <span class="fw-medium">{{ Auth::user()->name }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>Program</td>
                    <td>
                      <span class="fw-medium">{{ $kelas->program }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>Angkatan</td>
                    <td>
                      <span class="fw-medium">{{ $kelas->batch }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>Level</td>
                    <td>
                      <span class="fw-medium">{{ $kelas->level }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>Tipe Kelas</td>
                    <td>
                      <span class="fw-medium">{{ $kelas->class }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>Sesi Belajar</td>
                    <td>
                      <span class="fw-medium">
                        @php
                          $sessions = json_decode($kelas->session, true);
                        @endphp
                        <ul>
                          @foreach ($sessions as $session)
                            <li>{{ $session }}</li>
                          @endforeach
                        </ul>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td>Ruang Kelas</td>
                    <td>
                      <span class="fw-medium">{{ $kelas->room ?? 'Belum ada ruang kelas.' }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>Nilai</td>
                    <td>
                      <span class="fw-medium">{{ $kelas->score ?? 'Belum ada nilai.' }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>Ustadz(ah)</td>
                    <td>
                      <span class="fw-medium">{{ $kelas->lecturer ?? 'Belum ada Ustadz/ah.' }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td>
                      <span class="fw-medium">{{ $kelas->status }}</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          @endif

          <a href="{{ route('my.program') }}" class="btn btn-light float-end mt-5 mb-3">Kembali</a>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
@endsection
