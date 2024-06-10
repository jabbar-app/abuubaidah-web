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
            <input type="hidden" name="is_new" value="1">
            <input type="hidden" name="status" value="Menunggu Update">
            <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
            <input type="hidden" value="{{ $program->id }}" name="program_id">

            @if (!empty($step->status) && $step->status == 'Daftar Ulang')
              @php
                $initial_total =
                    $program->programmable->price_normal +
                    $program->programmable->price_mahad +
                    $program->programmable->price_s1;
              @endphp
              <input type="hidden" value="{{ $initial_total }}" name="amount">
            @else
              <input type="hidden" value="{{ $program->programmable->price_pra }}" name="amount">
            @endif

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
                <input type="text" id="multicol-batch" class="form-control"
                  value="{{ $step->status ?? 'Daftar Baru' }}" name="step" readonly />
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
                      <td class="text-center"><span class="badge bg-label-info me-1">Per Tahun (2 Semester)</span></td>
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
                        <span class="fw-medium">Biaya Pembangunan S1</span>
                      </td>
                      <td>Rp{{ number_format($program->programmable->price_s1, 0, ',', '.') }},-</td>
                      <td class="text-center"><span class="badge bg-label-primary me-1">1 Kali</span></td>
                    </tr>
                    <tr>
                      <td>
                        <span class="fw-medium">Total Biaya</span>
                      </td>
                      @php
                        if (empty($step->status)) {
                            $total = $program->price_pra;
                        } else {
                            $total =
                                $program->price_pra +
                                $program->price_normal +
                                $program->price_mahad +
                                $program->price_s1;
                        }
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
              <h6>3. Data NIM</h6>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label" for="multicol-program">Apakah kamu sudah memiliki NIM
                  Ma'had?</label>
                <div class="col-sm-9">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="hasNIM" id="hasNIMyes" value="true">
                    <label class="form-check-label" for="hasNIMyes">Ya, sudah.</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="hasNIM" id="hasNIMno" value="false">
                    <label class="form-check-label" for="hasNIMno">Belum.</label>
                  </div>
                </div>
              </div>
              <div class="row mb-3" id="inputNIM">
                <label class="col-sm-3 col-form-label" for="nim">Input NIM</label>
                <div class="col-sm-9">
                  <div class="input-group mb-1">
                    <input type="number" id="nim" class="form-control" name="nim" value="0">
                    <button type="button" id="checkNIMButton" class="btn btn-primary">Check NIM</button>
                  </div>
                  <div id="nimStatus"></div>
                </div>
              </div>
            @endif

            <div class="pt-4">
              <div class="row justify-content-end">
                <div class="col-sm-9">
                  @if (empty($status->nama_sma))
                    <a href="/profile" class="btn btn-primary float-end me-1">Lengkapi Profil</a>
                  @else
                    <button type="submit" class="btn btn-primary">Submit</button>
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
  <script type="text/javascript">
    $(document).ready(function() {
      $('#checkNIMButton').click(function() {
        var nim = $('#nim').val();
        $.ajax({
          url: '/check-nim',
          method: 'POST',
          data: {
            nim: nim,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            console.log('AJAX Response:', response);
            if (response.status === 'valid') {
              $('#nimStatus').html('<span class="text-success">NIM valid: ' + response.name + '</span>');
              updatePricesWithNim(response.is_registered);
            } else {
              $('#nimStatus').html('<span class="text-danger">NIM tidak valid</span>');
              resetPrices();
            }
          }
        });
      });

      function updatePricesWithNim(isRegistered) {
        var program = @json($program);
        var updatedPrices = {
          price_pra: isRegistered ? 0 : Number(program.price_pra_nim),
          price_normal: Number(program.price_normal_nim),
          price_mahad: Number(program.price_mahad_nim),
          price_s1: isRegistered ? 0 : Number(program.price_s1_nim)
        };

        console.log('Updated Prices:', updatedPrices);

        $('td:contains("Biaya Pendaftaran")').next().text(isRegistered ? 'Rp0,-' : 'Rp' + number_format(updatedPrices
          .price_pra, 0, ',', '.') + ',-');
        $('td:contains("Biaya SPP")').next().text('Rp' + number_format(updatedPrices.price_normal, 0, ',', '.') +
          ',-');
        $('td:contains("Biaya Pembangunan Ma\'had")').next().text('Rp' + number_format(updatedPrices.price_mahad, 0,
          ',', '.') + ',-');
        $('td:contains("Biaya Pembangunan S1")').next().text('Rp' + number_format(updatedPrices.price_s1, 0, ',',
          '.') + ',-');

        var total = updatedPrices.price_pra + updatedPrices.price_normal + updatedPrices.price_mahad + updatedPrices
          .price_s1;
        console.log('Total:', total);
        $('.fw-bold.bg-light').text('Rp' + number_format(total, 0, ',', '.') + ',-');
        $('input[name="amount"]').val(total);
      }

      function resetPrices() {
        var program = @json($program);
        var originalPrices = {
          price_pra: Number(program.price_pra),
          price_normal: Number(program.price_normal),
          price_mahad: Number(program.price_mahad),
          price_s1: Number(program.price_s1)
        };

        console.log('Original Prices:', originalPrices);

        $('td:contains("Biaya Pendaftaran")').next().text('Rp' + number_format(originalPrices.price_pra, 0, ',',
          '.') + ',-');
        $('td:contains("Biaya SPP")').next().text('Rp' + number_format(originalPrices.price_normal, 0, ',', '.') +
          ',-');
        $('td:contains("Biaya Pembangunan Ma\'had")').next().text('Rp' + number_format(originalPrices.price_mahad, 0,
          ',', '.') + ',-');
        $('td:contains("Biaya Pembangunan S1")').next().text('Rp' + number_format(originalPrices.price_s1, 0, ',',
          '.') + ',-');

        var total = originalPrices.price_pra;
        console.log('Total:', total);
        $('.fw-bold.bg-light').text('Rp' + number_format(total, 0, ',', '.') + ',-');
        $('input[name="amount"]').val(total);
      }

      function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
          prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
          sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
          dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
          s = '',
          toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k).toFixed(prec);
          };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
          s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
          s[1] = s[1] || '';
          s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
      }
    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const inputSection = document.getElementById('inputNIM');
      const yesOption = document.getElementById('hasNIMyes');
      const noOption = document.getElementById('hasNIMno');
      const studentNIM = "{{ $student->nim ?? '' }}";
      const nimInput = document.getElementById('nim');

      // Initialize visibility of the input section based on the student's NIM presence
      inputSection.style.display = studentNIM ? '' : 'none';
      yesOption.checked = !!studentNIM;
      noOption.checked = !studentNIM;
      nimInput.value = studentNIM || '';

      // Show input section when 'Yes' is selected
      yesOption.addEventListener('change', function() {
        if (this.checked) {
          inputSection.style.display = '';
          nimInput.value = studentNIM || '';
        }
      });

      // Hide input section when 'No' is selected
      noOption.addEventListener('change', function() {
        if (this.checked) {
          inputSection.style.display = 'none';
          nimInput.value = '';
        }
      });
    });
  </script>
@endsection
