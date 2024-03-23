@extends('student.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- Hour chart  -->
    <div class="card bg-transparent shadow-none my-4 border-0">
      <div class="card-body row p-0 pb-3">
        <div class="col-12 col-md-8 card-separator">
          <h3>Salam, {{ Auth::user()->name }} 👋🏻</h3>
          <div class="col-12 col-lg-7">
            <p>Selamat datang di Ma'had Abu Ubaidah Bin Al Jarrah, Lembaga Pendidikan Bahasa Arab & Studi Islam!</p>
          </div>
          {{-- <div class="d-flex justify-content-between flex-wrap gap-3 me-5">
          <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
            <span class="bg-label-primary p-2 rounded">
              <i class="ti ti-device-laptop ti-xl"></i>
            </span>
            <div class="content-right">
              <p class="mb-0">Hours Spent</p>
              <h4 class="text-primary mb-0">34h</h4>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <span class="bg-label-info p-2 rounded">
              <i class="ti ti-bulb ti-xl"></i>
            </span>
            <div class="content-right">
              <p class="mb-0">Test Results</p>
              <h4 class="text-info mb-0">82%</h4>
            </div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <span class="bg-label-warning p-2 rounded">
              <i class="ti ti-discount-check ti-xl"></i>
            </span>
            <div class="content-right">
              <p class="mb-0">Course Completed</p>
              <h4 class="text-warning mb-0">14</h4>
            </div>
          </div>
        </div> --}}
        </div>
        {{-- <div class="col-12 col-md-4 ps-md-3 ps-lg-4 pt-3 pt-md-0">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <div>
              <h5 class="mb-2">Time Spendings</h5>
              <p class="mb-5">Weekly report</p>
            </div>
            <div class="time-spending-chart">
              <h3 class="mb-2">231<span class="text-muted">h</span> 14<span class="text-muted">m</span></h3>
              <span class="badge bg-label-success">+18.4%</span>
            </div>
          </div>
          <div id="leadsReportChart"></div>
        </div>
      </div> --}}
      </div>
    </div>
    <!-- Hour chart End  -->

    <h4 class="py-3 mb-4"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Kelas</h4>

    <div class="card">
      <div class="card-datatable table-responsive pt-0">
        <table id="datatable" class="table">
          <thead>
            <tr>
              <th>Program</th>
              <th>Angkatan</th>
              <th>Kelas</th>
              <th>Sesi</th>
              <th>Nilai</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($kelas as $k)
              <tr>
                <td>{{ $k->program }}</td>
                <td>{{ $k->batch }}</td>
                <td>
                    {{ $k->class }}
                    @if(!empty($k->room))
                    <br>Ruang Kelas: {{ $k->room }}
                    @endif
                </td>

                <td>
                  <ul style="margin-left: -16px; padding-top: 16px;">
                    @php
                      $sessions = json_decode($k->session, true); // Decode as array
                      if (!is_array($sessions)) {
                          // Check if the result is not an array
                          $sessions = []; // Set to empty array if not
                      }
                    @endphp

                    @foreach ($sessions as $session)
                      <li>{{ $session }}</li>
                    @endforeach
                  </ul>
                </td>

                <td><button class="btn btn-sm btn-light">Menunggu</button></td>
                <td><span class="badge bg-label-primary">{{ $k->status }}</span></td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Program</th>
              <th>Angkatan</th>
              <th>Kelas</th>
              <th>Sesi</th>
              <th>Nilai</th>
              <th>Status</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function() {
      $('#datatable').DataTable();
    });
  </script>
@endsection
