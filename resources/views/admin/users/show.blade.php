@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data User
      </h4>
      <div class="g-3">
        <a href="{{ route('user.pdf', $user->id) }}" class="btn btn-md btn-primary">Download PDF</a>
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-md btn-primary">Edit Data</a>
      </div>
    </div>

    {{-- <hr class="mb-5"> --}}

    <div class="col-12">
      <h6 class="text-muted">{{ $user->name }}</h6>
      <div class="nav-align-top mb-4">
        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
          <li class="nav-item" role="presentation">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#akun"
              aria-controls="akun" aria-selected="true"><i class="tf-icons ti ti-user ti-xs me-1"></i> Detail Akun
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#program"
              aria-controls="program" aria-selected="false" tabindex="-1"><i class="tf-icons ti ti-book ti-xs me-1"></i>
              Data Program</button>
          </li>
          <li class="nav-item" role="presentation">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#payment"
              aria-controls="payment" aria-selected="false" tabindex="-1"><i class="tf-icons ti ti-money ti-xs me-1"></i>
              Riwayat Transaksi</button>
          </li>
        </ul>
        <div class="tab-content">
          {{-- Detail Akun --}}
          <div class="tab-pane fade active show" id="akun" role="tabpanel">
            <div class="row">
              <div class="col-xl-6 col-sm-12">
                <div class="card-header">
                  <h5 class="mb-0">Data Akun</h5>
                </div>
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" value="{{ $user->name }}" class="form-control" readonly>
                  </div>
                  @if ($user->student && $user->student->nim != null)
                    <div class="mb-3">
                      <label class="form-label">NIM Ma'had</label>
                      <input type="text" class="form-control" value="{{ $user->student->nim }}" readonly>
                    </div>
                  @endif
                  <div class="mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text" class="form-control" value="{{ $user->nik }}" readonly>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" value="{{ $user->email }}" class="form-control" readonly>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <input type="text" value="{{ $user->gender }}" class="form-control" readonly>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">No. WhatsApp</label>
                    <input type="text" value="{{ $user->phone }}" class="form-control" readonly>
                  </div>
                  <div class="row mb-3">
                    <div class="col-6">
                      <label class="form-label">Tempat Lahir</label>
                      <input type="text" value="{{ $user->tempat_lahir }}" class="form-control" readonly>
                    </div>

                    <div class="col-6">
                      <label class="form-label">Tanggal Lahir</label>
                      <input type="text" value="{{ $user->tanggal_lahir }}" class="form-control" readonly>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-6">
                      <label class="form-label" for="status_perkawinan">Status Perkawinan</label>
                      <input type="text" value="{{ $user->status_perkawinan }}" class="form-control" readonly>
                    </div>

                    <div class="col-6">
                      <label class="form-label">Suku</label>
                      <input type="text" value="{{ $user->suku }}" class="form-control" readonly>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" rows="2" class="form-control" readonly>{{ $user->address }}</textarea>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Provinsi</label>
                    <input type="text" value="{{ $provinceName }}" class="form-control" readonly>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Kabupaten</label>
                    <input type="text" value="{{ $regencyName }}" class="form-control" readonly>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Kecamatan</label>
                    <input type="text" value="{{ $districtName }}" class="form-control" readonly>
                  </div>
                </div>
              </div>

              <div class="col-xl-6 col-sm-12">
                <div class="card-header">
                  <h5 class="mb-0">Data Pendidikan</h5>
                </div>
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <label class="form-label" for="nama_sd">Sekolah Dasar</label>
                      <input type="text" value="{{ $user->nama_sd }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="lulus_sd">Tahun Lulus</label>
                      <input type="text" value="{{ $user->lulus_sd }}" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="row g-3">

                    <div class="col-md-6">
                      <label class="form-label" for="nama_smp">Sekolah Menengah Pertama</label>
                      <input type="text" value="{{ $user->nama_smp }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="lulus_smp">Tahun Lulus</label>
                      <input type="text" value="{{ $user->lulus_smp }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="nama_sma">Sekolah Menengah Atas</label>
                      <input type="text" value="{{ $user->nama_sma }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="lulus_sma">Tahun Lulus</label>
                      <input type="text" value="{{ $user->lulus_sma }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-8">
                      <label class="form-label" for="perguruan_tinggi">Perguruan Tinggi</label>
                      <input type="text" value="{{ $user->perguruan_tinggi }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="ukuran_almamater">Ukuran Almamater</label>
                      <input type="text" value="{{ $user->ukuran_almamater }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="nama_ayah">Nama Ayah</label>
                      <input type="text" value="{{ $user->nama_ayah }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="status_ayah">Status Ayah</label>
                      <input type="text" value="{{ $user->status_ayah }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="pekerjaan_ayah">Pekerjaan Ayah</label>
                      <input type="text" value="{{ $user->pekerjaan_ayah }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="penghasilan_ayah">Penghasilan Ayah</label>
                      <input type="text" value="{{ $user->penghasilan_ayah }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="telp_ayah">No. Telp Ayah</label>
                      <input type="text" value="{{ $user->telp_ayah }}" class="form-control" readonly>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label" for="nama_ibu">Nama Ibu</label>
                      <input type="text" value="{{ $user->nama_ibu }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label" for="status_ibu">Status Ibu</label>
                      <input type="text" value="{{ $user->status_ibu }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="pekerjaan_ibu">Pekerjaan Ibu</label>
                      <input type="text" value="{{ $user->pekerjaan_ibu }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="penghasilan_ibu">Penghasilan Ibu</label>
                      <input type="text" value="{{ $user->penghasilan_ibu }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label" for="telp_ibu">No. Telp Ibu</label>
                      <input type="text" value="{{ $user->telp_ibu }}" class="form-control" readonly>
                    </div>

                    <div class="col-12">
                      <table class="table" id="attachment">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Nama Berkas</th>
                            <th>Status</th>
                            <th>Link</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1.</td>
                            <td>KTP</td>
                            <td>
                              @if ($user->url_ktp)
                                <div class="badge bg-label-success">Terisi!</div>
                              @else
                                <div class="badge bg-label-danger">Kosong!</div>
                              @endif
                            </td>
                            <td>
                              @if ($user->url_ktp)
                                <a href="{{ asset($user->url_ktp) }}" target="_blank"
                                  class="btn btn-sm btn-primary">Lihat</a>
                              @else
                                -
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td>2.</td>
                            <td>Kartu Keluarga</td>
                            <td>
                              @if ($user->url_kk)
                                <div class="badge bg-label-success">Terisi!</div>
                              @else
                                <div class="badge bg-label-danger">Kosong!</div>
                              @endif
                            </td>
                            <td>
                              @if ($user->url_kk)
                                <a href="{{ asset($user->url_kk) }}" target="_blank"
                                  class="btn btn-sm btn-primary">Lihat</a>
                              @else
                                -
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td>3.</td>
                            <td>Ijazah</td>
                            <td>
                              @if ($user->url_ijazah)
                                <div class="badge bg-label-success">Terisi!</div>
                              @else
                                <div class="badge bg-label-danger">Kosong!</div>
                              @endif
                            </td>
                            <td>
                              @if ($user->url_ijazah)
                                <a href="{{ asset($user->url_ijazah) }}" target="_blank"
                                  class="btn btn-sm btn-primary">Lihat</a>
                              @else
                                -
                              @endif
                            </td>
                          </tr>
                          <tr>
                            <td>4.</td>
                            <td>Sertifikat Bilhaq</td>
                            <td>
                              @if ($user->url_bilhaq)
                                <div class="badge bg-label-success">Terisi!</div>
                              @else
                                <div class="badge bg-label-danger">Kosong!</div>
                              @endif
                            </td>
                            <td>
                              @if ($user->url_bilhaq)
                                <a href="{{ asset($user->url_bilhaq) }}" target="_blank"
                                  class="btn btn-sm btn-primary">Lihat</a>
                              @else
                                -
                              @endif
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- Detail Kelas --}}
          <div class="tab-pane fade" id="program" role="tabpanel">
            <table class="table">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama Program</th>
                  <th>Status</th>
                  <th>Tindakan</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $count = 1;
                @endphp
                @forelse ($programs as $program)
                  <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $program->program->programmable->title . ' | Angkatan: ' . $program->batch }}</td>
                    <td>{{ $program->status }}</td>
                    <td>
                      <div class="d-inline-block">
                        <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                          data-bs-toggle="dropdown" aria-expanded="false" style="box-shadow: none;">
                          <i class="text-primary ti ti-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end m-0">
                          <li>
                            <a href="{{ route('kelas.edit', $program->id) }}" class="dropdown-item">Edit
                              Data</a>
                          </li>
                          <div class="dropdown-divider"></div>
                          <li>
                            <form action="{{ route('kelas.destroy', $program->id) }}" method="POST"
                              onsubmit="return confirm('Apakah kamu yakin ingin menghapus data ini?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                            </form>
                          </li>
                        </ul>
                      </div>
                      <a href="{{ route('kelas.edit', $program->id) }}" class="btn btn-sm btn-icon item-edit"
                        style="box-shadow: none;"><i class="text-primary ti ti-pencil"></i></a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center">Belum ada data.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade" id="payment" role="tabpanel">
            <table class="table">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Keterangan</th>
                  <th>Jumlah</th>
                  <th>Status</th>
                  <th>Tindakan</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $count = 1;
                @endphp
                @forelse ($payments as $payment)
                  <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $payment->description }}</td>
                    <td>Rp{{ number_format($payment->amount, 0, ',', '.') }},-</td>
                    <td>{{ $payment->status }}</td>

                    <td>
                      <div class="d-inline-block"><a href="javascript:;"
                          class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                          aria-expanded="false" style="box-shadow: none;"><i
                            class="text-primary ti ti-dots-vertical"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                          <li><a href="{{ route('payments.show', $payment->id) }}" class="dropdown-item">Details</a>
                          </li>
                          <li>
                            <form action="{{ route('invoice.regenerate', ['externalId' => $payment->external_id]) }}"
                              method="POST">
                              @csrf
                              <input type="hidden" name="amount" value="{{ $payment->amount }}">
                              <input type="submit" class="dropdown-item" value="Buat Ulang Invoice">
                            </form>
                          </li>
                          <li><a href="{{ $payment->invoice_url }}" target="_blank" class="dropdown-item">Lihat
                              Invoice</a>
                          </li>
                          <div class="dropdown-divider"></div>
                          <li>
                            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this payment?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                            </form>
                          </li>
                        </ul>
                      </div>
                      <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-sm btn-icon item-edit"
                        style="box-shadow: none;"><i class="text-primary ti ti-pencil"></i></a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center">Belum ada data.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
    </div>
  @endsection

  @section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
        // Memuat Provinsi
        $.ajax({
          url: '/provinces', // URL endpoint API untuk provinsi
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            $.each(data, function(index, province) {
              $('#provinsi').append('<option value="' + province.id + '">' + province.name + '</option>');
            });
          }
        });

        // Listener untuk perubahan Provinsi
        $('#provinsi').change(function() {
          var provinsiId = $(this).val();
          $('#kabupaten').removeAttr('disabled').html('<option value="">Pilih Kabupaten</option>');
          $.ajax({
            url: '/regencies/' + provinsiId, // URL endpoint API untuk kabupaten berdasarkan provinsi
            type: 'GET',
            dataType: 'json',
            success: function(data) {
              $.each(data, function(index, regency) {
                $('#kabupaten').append('<option value="' + regency.id + '">' + regency.name +
                  '</option>');
              });
            }
          });
        });

        // Listener untuk perubahan Kabupaten
        $('#kabupaten').change(function() {
          var kabupatenId = $(this).val();
          $('#kecamatan').removeAttr('disabled').html('<option value="">Pilih Kecamatan</option>');
          $.ajax({
            url: '/districts/' + kabupatenId, // URL endpoint API untuk kecamatan berdasarkan kabupaten
            type: 'GET',
            dataType: 'json',
            success: function(data) {
              $.each(data, function(index, district) {
                $('#kecamatan').append('<option value="' + district.id + '">' + district.name +
                  '</option>');
              });
            }
          });
        });
      });
    </script>
  @endsection
