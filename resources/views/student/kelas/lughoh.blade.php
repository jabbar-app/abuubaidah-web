@extends('student.main')


@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Program /</span> {{ $program->programmable->title }}</h4>

    <div class="row">
      <!-- Form Separator -->
      <div class="col-xxl">
        <div class="card mb-4">
          <h5 class="card-header">Form Pendaftaran Program</h5>
          <form action="{{ route('create.invoice') }}" method="POST" class="card-body">
            @csrf
            <input type="hidden" name="status" value="Menunggu Update">
            <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
            @if (!empty($step->status) && $step->status == 'Daftar Ulang')
              <input type="hidden" value="{{ $program->programmable->price_normal + $program->programmable->price_mahad }}" name="amount">
            @else
              <input type="hidden" value="{{ $program->programmable->price_pra }}" name="amount">
            @endif
            <input type="hidden" value="{{ $program->id }}" name="program_id">
            <input type="hidden" name="is_new" value="1">
            <h6>1. Data Peserta</h6>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-name">Nama Lengkap</label>
              <div class="col-sm-9">
                <input type="text" id="multicol-name" class="form-control" value="{{ Auth::user()->name }}" readonly />
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-status">Status</label>
              <div class="col-sm-9">
                @if (empty($status->nama_sma))
                  <input type="text" id="multicol-status" class="form-control" value="Belum Melengkapi Profil"
                    readonly />
                @else
                  <input type="text" id="multicol-status" class="form-control" value="Sudah Melengkapi Profil"
                    readonly />
                @endif
              </div>
            </div>

            <hr class="my-4 mx-n4" />
            <h6>2. Data Kelas</h6>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Program</label>
              <div class="col-sm-9">
                <input type="text" id="multicol-program" class="form-control"
                  value="{{ $program->programmable->title }}" name="program" readonly />
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-batch">Angkatan</label>
              <div class="col-sm-9">
                <input type="text" id="multicol-batch" class="form-control" value="{{ $program->programmable->batch }}"
                  name="batch" readonly />
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-batch">Status Pendaftaran</label>
              <div class="col-sm-9">
                <input type="text" id="multicol-batch" class="form-control" value="{{ $step->status ?? 'Daftar Baru' }}"
                  name="step" readonly />
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-price">Biaya Pendaftaran</label>
              <div class="col-sm-9 table-responsive text-nowrap">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Deskripsi</th>
                      <th>Biaya</th>
                      <th class="text-center">Dibayarkan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <span class="fw-medium">Biaya Pendaftaran</span>
                      </td>
                      <td>Rp{{ number_format($program->programmable->price_pra, 0, ',', '.') }},-</td>
                      <td class="text-center"><span class="badge bg-label-primary me-1">1 Kali</span></td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fw-medium">Biaya SPP</span>
                      </td>
                      <td>Rp{{ number_format($program->programmable->price_normal, 0, ',', '.') }},-</td>
                      <td class="text-center"><span class="badge bg-label-info me-1">Per Semester</span></td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fw-medium">Biaya Pembangunan Ma'had</span>
                      </td>
                      <td>Rp{{ number_format($program->programmable->price_mahad, 0, ',', '.') }},-</td>
                      <td class="text-center"><span class="badge bg-label-primary me-1">1 Kali</span></td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fw-medium">Total Biaya</span>
                      </td>
                      @php
                        $total = $program->programmable->price_pra + $program->programmable->price_normal + $program->programmable->price_mahad + $program->programmable->price_s1;
                      @endphp
                      <td colspan="2" class="text-center fw-bold bg-light">
                        Rp{{ number_format($total, 0, ',', '.') }},-</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="pt-4">
              <div class="row justify-content-end">
                <div class="col-sm-9">
                  @if (empty($status->nama_sma))
                    <a href="/profile" class="btn btn-primary float-end me-1">Lengkapi Profil</a>
                  @else
                    <button type="submit" class="btn btn-lg btn-primary">{{ $step->status ?? 'Lanjutkan Pendaftaran' }}</button>
                  @endif
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const inputSection = document.getElementById('inputNIM');
      const yesOption = document.getElementById('hasNIMyes');
      const noOption = document.getElementById('hasNIMno');
      const studentNIM = "{{ $student->nim ?? '' }}";

      // Initialize visibility of the input section based on the student's NIM presence
      inputSection.style.display = studentNIM ? '' : 'none';
      yesOption.checked = !!studentNIM;
      noOption.checked = !studentNIM;

      // Show input section when 'Yes' is selected
      yesOption.addEventListener('change', function() {
        if (this.checked) {
          inputSection.style.display = '';
        }
      });

      // Hide input section when 'No' is selected
      noOption.addEventListener('change', function() {
        if (this.checked) {
          inputSection.style.display = 'none';
        }
      });
    });
  </script>
@endsection
