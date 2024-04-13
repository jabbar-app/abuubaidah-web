@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Kelas
      </h4>
      <a href="{{ route('kelas.create') }}" class="btn btn-md btn-primary">Tambah Data</a>
    </div>


    @if (session('success'))
      <div class="col-12">
        <div class="alert alert-success dark alert-dismissible fade show" role="alert"><strong>Berhasil!
          </strong> {{ session('success') }}
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @elseif(session('danger'))
      <div class="col-12">
        <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><strong>Gagal!
          </strong> {{ session('danger') }}
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif

    @if (!empty($program))
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between mb-lg-n4">
          <div class="card-title">
            <h5 class="mb-0">Program: {{ $program->programmable->title }}</h5>
            <small class="text-muted">Angkatan: {{ $batch }} | Gelombang:
              {{ $gelombang }}</small>
          </div>
          <div class="dropdown">
            <button class="btn p-0" type="button" id="earningReportsId" data-bs-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false">
              <i class="ti ti-dots-vertical ti-sm text-muted"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsId">
              <a class="dropdown-item" href="javascript:void(0);">View More</a>
              <a class="dropdown-item" href="javascript:void(0);">Delete</a>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-8">
              <div class="border rounded p-3 mt-2">
                <div class="row gap-4 gap-sm-0">
                  <div class="col-12 col-sm-4">
                    <div class="d-flex gap-2 align-items-center">
                      <div class="badge rounded bg-label-info p-1"><i class="ti ti-user ti-sm"></i></div>
                      <h6 class="mb-0">Peserta Baru</h6>
                    </div>
                    <h4 class="my-2 pt-1">{{ $new }}</h4>
                    <div class="progress w-75" style="height:4px">
                      <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4">
                    <div class="d-flex gap-2 align-items-center">
                      <div class="badge rounded bg-label-warning p-1"><i class="ti ti-user ti-sm"></i></div>
                      <h6 class="mb-0">Daftar Ulang</h6>
                    </div>
                    <h4 class="my-2 pt-1">{{ $renewed }}</h4>
                    <div class="progress w-75" style="height:4px">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-4">
                    <div class="d-flex gap-2 align-items-center">
                      <div class="badge rounded bg-label-primary p-1"><i class="ti ti-users ti-sm"></i></div>
                      <h6 class="mb-0">Total Peserta</h6>
                    </div>
                    <h4 class="my-2 pt-1">{{ $new + $renewed }}</h4>
                    <div class="progress w-75" style="height:4px">
                      <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="border rounded p-3 mt-2">
                <div class="row gap-4 gap-sm-0">
                  <div class="col-12">
                    <div class="d-flex gap-2 align-items-center">
                      <h6 class="mb-0">Export Data Kelas ke Excel</h6>
                    </div>
                    <a href="/export-kelas/{{ $program_id }}/{{ $batch }}/{{ $gelombang }}" class="btn btn-md btn-primary mb-2 mt-3">Export</a>
                    {{-- <a href="/export-all-kelas" class="btn btn-md btn-outline-primary mb-2 mt-3">Export Semua Data</a> --}}
                    <div class="progress w-100" style="height:4px">
                      <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endif

    <div class="card">
      <div class="card-body">

        <div class="card-title header-elements">
          <h5 class="m-0 me-2">Data Kelas</h5>
          {{-- <div class="card-title-elements">
            <label class="switch switch-primary switch-sm me-0">
              <input type="checkbox" class="switch-input">
              <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
              </span>
            </label>
          </div> --}}
          <div class="card-title-elements ms-auto">
            <form action="{{ route('kelas.filter') }}" method="POST">
              @csrf
              <a href="/export-all-kelas" class="btn btn-sm btn-outline-primary mb-2 mt-3 float-end">Export Semua Data</a>
              <select id="program_id" name="program_id" class="form-select form-select-sm mb-2">
                <option value="">Select Program</option>
                @foreach ($programs as $program)
                  <option value="{{ $program->id }}">
                    {{ $program->programmable->title }}
                  </option>
                @endforeach
              </select>
              <select id="batch" name="batch" class="form-select form-select-sm mb-2" style="display: none;">
                <option value="">Select Angkatan</option>
                {{-- Options will be populated by JavaScript --}}
              </select>
              <select id="gelombang" name="gelombang" class="form-select form-select-sm mb-2" style="display: none;">
                <option value="">Select Gelombang</option>
                {{-- Options will be populated by JavaScript --}}
              </select>
              <div class="d-flex float-end mt-2">
                <a href="{{ route('admin.kelas.index') }}" class="btn btn-sm btn-light ms-2">Reset</a>
                <button type="submit" class="btn btn-sm btn-primary waves-effect waves-light ms-2">Filter</button>
              </div>
            </form>
          </div>
        </div>

        <div class="card-datatable table-responsive pt-0">
          <table id="kelas" class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>WhatsApp</th>
                <th>Program</th>
                <th>Sesi</th>
                <th>Tindakan</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($kelas as $kelas)
                <tr>
                  <td>{{ $kelas->id }}</td>
                  <td>{{ $kelas->user->name ?? '' }}</td>
                  <td>{{ $kelas->user->nik ?? '' }}</td>
                  <td>{{ $kelas->user->phone ?? '' }}</td>
                  <td>{{ $kelas->program . ', Angkatan ' . $kelas->batch }}</td>
                  <td>
                    <ul style="margin-left: -16px" class="mt-3">
                      @php
                        // Attempt to decode the session data
                        $sessions = json_decode($kelas->session, true);

                        // Check if decoding was successful and we have an array
                        if (is_array($sessions)) {
                            // If it's an array, we'll loop through it
                            foreach ($sessions as $session) {
                                echo "<li>{$session}</li>";
                            }
                        } else {
                            // If it's not an array, display it directly
                            // Check if session data is not empty or null
                            if (!empty($kelas->session)) {
                                echo "<li>{$kelas->session}</li>";
                            }
                        }
                      @endphp
                    </ul>
                  </td>
                  <td>
                    <div class="d-inline-block">
                      <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow"
                        data-bs-toggle="dropdown" aria-expanded="false" style="box-shadow: none;">
                        <i class="text-primary ti ti-dots-vertical"></i>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                        <li>
                          <a href="{{ route('kelas.edit', $kelas->id) }}" class="dropdown-item">Edit Data</a>
                        </li>
                        {{-- <li><a href="javascript:;" class="dropdown-item">Archive</a></li> --}}
                        <div class="dropdown-divider"></div>
                        <li>
                          <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST"
                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                          </form>
                        </li>
                      </ul>
                    </div>
                    <a href="{{ route('kelas.edit', $kelas->id) }}" class="btn btn-sm btn-icon item-edit"
                      style="box-shadow: none;"><i class="text-primary ti ti-pencil"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>WhatsApp</th>
                <th>Program</th>
                <th>Sesi</th>
                <th>Tindakan</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    document.getElementById('program_id').addEventListener('change', function() {
      var programId = this.value;
      if (!programId) {
        document.getElementById('batch').style.display = 'none';
        document.getElementById('gelombang').style.display = 'none';
        return;
      }

      fetch('/get-angkatan/' + programId) // Adjust the endpoint as needed
        .then(response => response.json())
        .then(data => {
          let batchSelect = document.getElementById('batch');
          batchSelect.innerHTML = '<option value="">Select Angkatan</option>';
          data.forEach(function(batch) {
            batchSelect.innerHTML += `<option value="${batch.batchName}">${batch.batchName}</option>`;
          });
          batchSelect.style.display = 'block';
        });

      document.getElementById('batch').addEventListener('change', function() {
        var batchId = this.value;
        if (!batchId) {
          document.getElementById('gelombang').style.display = 'none';
          return;
        }

        fetch('/get-gelombang/' + batchId) // Adjust the endpoint as needed
          .then(response => response.json())
          .then(data => {
            let gelombangSelect = document.getElementById('gelombang');
            gelombangSelect.innerHTML = '<option value="">Select Gelombang</option>';
            data.forEach(function(gelombang) {
              gelombangSelect.innerHTML +=
                `<option value="${gelombang.gelombang}">${gelombang.gelombang}</option>`;
            });
            gelombangSelect.style.display = 'block';
          });
      });
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var table = document.getElementById('kelas');
      var filter = document.getElementById('programFilter');

      filter.onchange = function() {
        var filterValue = this.value.toLowerCase();
        Array.from(table.getElementsByTagName('tr')).forEach(function(row) {
          // Assumes program is in the 5th column (adjust index as needed)
          var cell = row.cells[4] ? row.cells[4].textContent.toLowerCase() : '';
          row.style.display = cell.includes(filterValue) || !filterValue ? '' : 'none';
        });
      };
    });
  </script>

  <script>
    $(document).ready(function() {
      $('#kelas').DataTable();
    });
  </script>
@endsection
