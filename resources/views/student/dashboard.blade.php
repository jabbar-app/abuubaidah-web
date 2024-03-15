@extends('student.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <!-- Hour chart  -->
    <div class="card bg-transparent shadow-none my-4 border-0">
      <div class="card-body row p-0 pb-3">
        <div class="col-12 col-md-8 card-separator">
          <h3>Salam, {{ Auth::user()->name }} 👋🏻</h3>
          <div class="col-12 col-lg-7">
            <p>Your progress this week is Awesome. let's keep it up and get a lot of points reward !</p>
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

    <!-- Topic and Instructors -->
    <div class="row mb-4 g-4">
      @foreach ($programs as $program)
        <div class="col-12 col-xl-4 col-md-6">
          <div class="card h-100">
            <div class="card-body">
              <div
                class=" @if ($program->status) bg-label-primary @else bg-label-warning @endif rounded-3 text-center mb-3 pt-4">
                <img class="img-fluid" src="{{ asset('assets/img/mahad/abuubaidah_circle.svg') }}" alt="Card girl image"
                  width="140" style="margin-bottom: 25px" />
              </div>
              <h4 class="mb-2 pb-1">{{ $program->title }}</h4>
              <p class="small" style="height: 64px">
                {{ $program->description }}
              </p>
              @if ($program->status)
                <div class="row mb-3 g-3">
                  <div class="col-6">
                    <div class="d-flex">
                      <div class="avatar flex-shrink-0 me-2">
                        <span class="avatar-initial rounded bg-label-primary"><i
                            class="ti ti-calendar-event ti-md"></i></span>
                      </div>
                      <div style="margin-top: -4px">
                        <small>Batas Pendaftaran</small>
                        <h6 class="mb-0 text-nowrap">17 Nov 23</h6>
                      </div>
                    </div>
                  </div>
                  {{-- <div class="col-6">
                  <div class="d-flex">
                    <div class="avatar flex-shrink-0 me-2">
                      <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-clock ti-md"></i></span>
                    </div>
                    <div>
                      <h6 class="mb-0 text-nowrap">32 minutes</h6>
                      <small>Duration</small>
                    </div>
                  </div>
                </div> --}}
                </div>
                @php $buttonShown = false; @endphp

                @foreach ($statusKelas as $sk)
                  @if (!$buttonShown)
                    @if ($program->id == $sk->program_id)
                      <a href="/my-program" class="btn btn-outline-primary w-100">{{ $sk->status }}</a>
                      @php $buttonShown = true; @endphp
                    @endif
                  @endif
                @endforeach

                @if (!$buttonShown)
                  <a href="/kelas/create/{{ $program->id }}" class="btn btn-primary w-100">Daftar</a>
                @endif
              @else
                <div class="row mb-3 g-3">
                  <div class="col-6">
                    <div class="d-flex">
                      <div class="avatar flex-shrink-0 me-2">
                        <span class="avatar-initial rounded bg-label-light"><i
                            class="ti ti-calendar-event ti-md"></i></span>
                      </div>
                      <div style="margin-top: -4px">
                        <small>Status Pendaftaran</small>
                        <h6 class="mb-0 text-nowrap">Belum dibuka</h6>
                      </div>
                    </div>
                  </div>
                </div>
                <a href="#" class="btn btn-light w-100" @disabled(true)>Belum dibuka</a>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
