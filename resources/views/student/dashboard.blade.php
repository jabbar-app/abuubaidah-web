@extends('student.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">

    @include('student.notification')

    <h4 class="py-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Semua Kelas</h4>
    <hr class="mb-4">

    <!-- Topic and Instructors -->
    <div class="row mb-4 g-4">
      @forelse ($programs as $program)
        <div class="col-12 col-xl-4 col-md-6">
          <div class="card h-100">
            <div class="card-body">
              <div
                class=" @if ($program->status) bg-label-primary @else bg-label-warning @endif rounded-3 text-center mb-3 pt-4">
                <img class="img-fluid" src="{{ asset('assets/img/mahad/abuubaidah_circle.svg') }}" alt="Card girl image"
                  width="140" style="margin-bottom: 25px" />
              </div>
              <h4 class="mb-2 pb-1">{{ $program->programmable->title }}</h4>
              <p class="small" style="height: 64px">
                {{ $program->programmable->description }}
              </p>
              @if ($program->status)
                <div class="row mb-3 g-3">
                  <div class="col-12">
                    <div class="d-flex mt-2">
                      <div class="avatar flex-shrink-0 me-2">
                        <span class="avatar-initial rounded bg-label-primary"><i
                            class="ti ti-calendar-event ti-md"></i></span>
                      </div>
                      <div style="margin-top: -4px">
                        <small>Batas Pendaftaran</small>
                        <h6 class="mb-0 text-nowrap">{{ Carbon\Carbon::parse($program->deadline)->format('j M Y') }}</h6>
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
                  <div class="col-12">
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
      @empty
        <div class="col-12">
          <div class="alert alert-light text-center" role="alert">
            Belum ada program.
          </div>
        </div>
      @endforelse
    </div>
  </div>
@endsection
