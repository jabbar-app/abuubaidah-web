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

            <input type="hidden" name="program_id" value="{{ $program->id }}">
            <input type="hidden" value="{{ $program->price_pra }}" name="amount">

            <h6>1. Data Peserta</h6>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-name">Nama Lengkap</label>
              <div class="col-sm-9">
                <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
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
                      <td>Rp{{ number_format($program->price_pra, 0, ',', '.') }},-</td>
                      <td class="text-center"><span class="badge bg-label-primary me-1">1 Kali</span></td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fw-medium">Biaya Asrama</span>
                      </td>
                      <td>Rp{{ number_format($program->price_normal, 0, ',', '.') }},-</td>
                      <td class="text-center"><span class="badge bg-label-primary me-1">1 Kali</span></td>
                    </tr>

                    <tr>
                      <td>
                        <span class="fw-medium">Total Biaya</span>
                      </td>
                      @php
                        $total =
                            $program->price_pra + $program->price_normal + $program->price_mahad + $program->price_s1;
                      @endphp
                      <td colspan="2" class="text-center fw-bold bg-light">
                        Rp{{ number_format($total, 0, ',', '.') }},-</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>


            @if (!empty($status->nama_sma))
              <hr class="my-4 mx-n4" />
              <h6>2. Data Bilhaq</h6>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="multicol-program">Apakah kamu memiliki sertifikat
                  Bilhaq?</label>
                <div class="col-sm-9">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="hasBilhaqCert" id="hasBilhaqCertYes"
                      value="Ada Sertifikat">
                    <label class="form-check-label" for="hasBilhaqCertYes">Ya, sudah.</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="hasBilhaqCert" id="hasBilhaqCertNo"
                      value="Tidak Ada">
                    <label class="form-check-label" for="hasBilhaqCertNo">Belum.</label>
                  </div>
                </div>
              </div>
              <div class="row mb-3" id="uploadBilhaqCert">
                <label class="col-sm-3 col-form-label" for="url_bilhaq">Upload Sertifikat Bilhaq</label>
                <div class="col-sm-9">
                  <input type="file" id="url_bilhaq" class="form-control mb-1" name="url_bilhaq">
                  <!-- Link to view the file, will be shown only if url_bilhaq is not empty -->
                  <a href="{{ asset($user->url_bilhaq) }}" id="viewBilhaqCert" target="_blank"
                    style="display: none;">Lihat Sertifikat</a>
                </div>
              </div>
            @endif

            <div class="pt-4">
              <div class="row justify-content-end">
                <div class="col-sm-9">
                  @if (empty($status->nama_sma))
                    <a href="/profile" class="btn btn-primary float-end me-sm-2 me-1">Lengkapi Profil</a>
                  @else
                    <button type="submit" class="btn btn-primary float-end me-sm-2 me-1">Submit</button>
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
      const uploadSection = document.getElementById('uploadBilhaqCert');
      const yesOption = document.getElementById('hasBilhaqCertYes');
      const noOption = document.getElementById('hasBilhaqCertNo');
      const viewLink = document.getElementById('viewBilhaqCert');
      const urlBilhaq = "{{ $user->url_bilhaq }}";

      if (urlBilhaq) {
        yesOption.checked = true;
        uploadSection.style.display = '';
        viewLink.style.display = ''; // Show the view link if url_bilhaq is not empty
      } else {
        noOption.checked = true;
        uploadSection.style.display = 'none';
      }

      yesOption.addEventListener('change', function() {
        if (this.checked) {
          uploadSection.style.display = '';
        }
      });

      noOption.addEventListener('change', function() {
        if (this.checked) {
          uploadSection.style.display = 'none';
        }
      });
    });
  </script>
@endsection
