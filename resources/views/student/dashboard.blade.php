@extends('student.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">

    @include('student.notification')

    @if (!empty($classActive))
      <h4 class="py-3" id="kelas-aktif"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Kelas
        Aktif</h4>
      <hr class="mb-4">
      <div class="row mb-4 g-4">
        @foreach ($classActive as $class)
          <div class="col-12 col-xl-6">
            <div class="card h-100 bg-label-primary">
              <div class="card-body">
                <div class="d-flex">
                  <div class="bg-primary p-4 rounded-3 d-none d-md-block me-4">
                    <img class="img-fluid p-1" src="{{ asset('assets/img/mahad/abuubaidah_circle.svg') }}"
                      style="height: 120px;" />
                  </div>
                  <div class="w-100">
                    @if (isset($class->program->programmable) && isset($class->program->programmable->title))
                      <h4 class="mb-2 pb-1">{{ $class->program->programmable->title ?? 'No Program Title' }}</h4>
                    @else
                      <h4 class="mb-2 pb-1">No Program Title Available</h4>
                    @endif

                    @if (isset($class->program->programmable) && isset($class->program->programmable->description))
                      <p class="text-black">{{ $class->program->programmable->description }}</p>
                    @else
                      <p class="text-black">No Program Description Available</p>
                    @endif
                    <p>Angkatan: {{ $class->program->programmable->batch }}</p>
                    @if ($class->program->programmable_type == 'App\Models\Lughoh')
                      @if (empty($student->nim))
                        <form action="{{ route('generate-nim') }}" method="POST">
                          @csrf
                          <input type="hidden" name="program_id" value="{{ $class->program->id }}">
                          <input type="hidden" name="kelas_id" value="{{ $class->id }}">
                          <button type="submit" class="btn btn-lg btn-primary">Kartu Hasil Studi</button>
                        </form>
                      @else
                        <a href="{{ route('khs') }}" class="btn btn-lg btn-primary">Kartu Hasil Studi</a>
                      @endif
                    @else
                      <a href="/kelas/detail/{{ $class->id }}" class="btn btn-lg btn-outline-primary">Lihat
                        Kelas</a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif

    <h4 class="py-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Semua Kelas</h4>
    <hr class="mb-4">

    <!-- Topic and Instructors -->
    @php
      $sortedPrograms = $programs->sortBy(function ($program) use ($statusKelas) {
          foreach ($statusKelas as $sk) {
              if ($program->id == $sk->program_id && $sk->status == 'Daftar Ulang') {
                  return 0;
              }
          }
          return 1;
      });
    @endphp

    <div class="row mb-4 g-4">
      @forelse ($sortedPrograms as $program)
        <div class="col-12 col-xl-6">
          <div class="card h-100">
            <div class="card-body">
              <div class="d-flex">
                <div
                  class="@if ($program->status) bg-label-primary @else bg-label-warning @endif p-4 rounded-3 d-none d-md-block me-4">
                  <img class="img-fluid p-1" src="{{ asset('assets/img/mahad/abuubaidah_circle.svg') }}"
                    style="height: 120px;" />
                </div>
                <div class="w-100">
                  @if (isset($program->programmable) && isset($program->programmable->title))
                    <h4 class="mb-2 pb-1">{{ $program->programmable->title ?? 'No Program Title' }}</h4>
                  @else
                    <h4 class="mb-2 pb-1">No Program Title Available</h4>
                  @endif

                  <p class="small">
                    @if (isset($program->programmable) && isset($program->programmable->description))
                      {{ $program->programmable->description }}
                    @else
                      No Program Description Available
                    @endif
                  </p>
                  <div class="d-flex justify-content-between mt-4">
                    @if ($program->status)
                      <div class="d-flex">
                        <div class="avatar flex-shrink-0 me-2">
                          <span class="avatar-initial rounded bg-label-primary"><i
                              class="ti ti-calendar-event ti-md"></i></span>
                        </div>
                        <div style="margin-top: -4px">
                          <small>Batas Pendaftaran</small>
                          <h6 class="mb-0 text-nowrap">
                            {{ Carbon\Carbon::parse($program->deadline)->format('j M Y') }}
                          </h6>
                        </div>
                      </div>
                      @php $buttonShown = false; @endphp

                      @foreach ($statusKelas as $sk)
                        @if (!$buttonShown)
                          @if ($program->id == $sk->program_id)
                            @if ($sk->status == 'Daftar Ulang')
                              <a href="/kelas/daftar/{{ $program->id }}" class="btn btn-info">Daftar
                                Ulang</a>
                            @elseif ($sk->status == 'Daftar Bilhaq')
                              <a href="{{ route('daftar.bilhaq', 'App\\Models\\Bilhaq') }}" class="btn btn-info">Daftar
                                Bilhaq</a>
                            @elseif ($sk->status == 'Aktif')
                              <a href="#kelas-aktif" class="btn btn-outline-primary">{{ $sk->status }}</a>
                            @else
                              <a href="/my-program" class="btn btn-outline-primary">{{ $sk->status }}</a>
                            @endif
                            @php $buttonShown = true; @endphp
                          @endif
                        @endif
                      @endforeach

                      @if (!$buttonShown)
                        <a href="/kelas/daftar/{{ $program->id }}" class="btn btn-primary">Daftar</a>
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
                      <a href="#" class="btn btn-light" @disabled(true)>Belum dibuka</a>
                    @endif
                  </div>
                </div>
              </div>


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


    @include('layouts.whatsapp')
  </div>
@endsection
