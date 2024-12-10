@extends('student.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 mb-4"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard </a>/ Transkrip Nilai
    </h4>

    <div class="row invoice-preview">
      <!-- Invoice -->
      <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4 mx-auto">
        <div class="card invoice-preview-card">
          <div class="card-body">
            <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
              <div class="col-6 mb-xl-0 mb-4">
                <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                  <div class="app-brand-logo" style="height: 100px; width: auto;">
                    <img src="{{ asset('assets/img/mahad/abuubaidah.svg') }}" alt="Abu Ubaidah" style="height: 100%;">
                  </div>
                  <span class="app-brand-text fw-bold fs-4">
                    Ma'had Abu Ubaidah <br> Bin Al Jarrah Medan
                  </span>
                </div>
                <p class="mb-0">Jl. Kutilang No.22, Sei Sikambing B,</p>
                <p class="mb-0">Kec. Medan Sunggal, Kota Medan, Sumatera Utara, 20119.</p>
                <p class="mb-0">+62 811-6144-482</p>
              </div>
              <div class="col-2"></div>
              <div class="col-4">
                <h3 class="fw-medium mb-2">TRANSKRIP NILAI</h3>
                <div class="row">
                  <div class="col-4">
                    <p class="mb-1">Nama</p>
                    <p class="mb-1">NIM</p>
                  </div>
                  <div class="col-8">
                    <p class="mb-1 fw-bold">{{ $student->user->name }}</p>
                    <p class="mb-1 fw-bold">{{ $student->nim }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr class="my-0">
          <div class="table-responsive border-top card-body mx-3">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width: 40px;">No.</th>
                  <th class="text-center">Kode</th>
                  <th>Mata Kuliah</th>
                  <th class="text-center">SKS</th>
                  <th class="text-center">Nilai</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $count = 0;
                  $credit = 0;
                  $grade = 0;
                @endphp
                @foreach ($transcripts as $transcript)
                  @php
                    $count++;
                    $credit = $credit + $transcript->course->credits;
                    $grade = $grade + $transcript->grade;
                  @endphp
                  <tr>
                    <td>{{ $count }}</td>
                    <td class="text-center">{{ $transcript->course->kode_mk }}</td>
                    <td class="text-nowrap">{{ $transcript->course->mk }}</td>
                    <td class="text-center">{{ $transcript->course->sks }}</td>
                    <td class="text-center">{{ $transcript->grade }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="card-body mx-3">
            <div class="row mb-5">
              <div class="col-8"></div>
              <div class="col-4">
                <h5>Mahasiswa</h5>
                <br><br>
                <h5 class="mb-0" style="text-decoration: underline;">{{ $student->user->name }}</h5>
                <h5>{{ $student->nim }}</h5>
              </div>
            </div>
          </div>
          <div class="card-body mx-3">
            <a href="{{ route('generatePdf', ['id' => $student->id]) }}" class="btn btn-primary">Download PDF</a>
          </div>
        </div>
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
