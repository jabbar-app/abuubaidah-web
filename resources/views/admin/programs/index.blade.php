@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Program</h4>
      <a href="{{ route('programs.create') }}" class="btn btn-md btn-primary">Tambah Program</a>
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

    <div class="card">
      <div class="card-datatable table-responsive pt-0">
        <table id="programs" class="table">
          <thead>
            <tr>
              <th>Program</th>
              <th>Angkatan</th>
              <th>Biaya</th>
              <th>Tipe Kelas</th>
              <th>Status</th>
              <th>Tindakan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($programs as $program)
              <tr>
                <td>{{ $program->programmable->title ?? 'No Program Title' }}</td>
                <td>{{ $program->programmable->batch ?? 'No Program Batch' }}</td>
                <td>
                  @if (!empty($program->programmable->price_pra) && $program->programmable->price_pra > 0)
                    <li>
                      <span class="small text-primary">Seleksi: </span>
                      Rp{{ number_format($program->programmable->price_pra, 0, ',', '.') }},-
                    </li>
                  @endif
                  @if (!empty($program->programmable->price_alumni) && $program->programmable->price_alumni > 0)
                    <li>
                      <span class="small text-primary">Alumni: </span>
                      Rp{{ number_format($program->programmable->price_alumni, 0, ',', '.') }},-
                    </li>
                  @endif
                  @if (!empty($program->programmable->price_normal) && $program->programmable->price_normal > 0)
                    <li>
                      <span class="small text-primary">
                        @if (
                            $program->programmable_type == 'App\Models\Lughoh' ||
                                $program->programmable_type == 'App\Models\Fai' ||
                                $program->programmable_type == 'App\Models\Stebis')
                          SPP:
                        @else
                          Normal:
                        @endif
                      </span>
                      Rp{{ number_format($program->programmable->price_normal, 0, ',', '.') }},-
                    </li>
                  @endif
                  @if (!empty($program->programmable->price_mahad) && $program->programmable->price_mahad > 0)
                    <li>
                      <span class="small text-primary">BP Ma'had: </span>
                      Rp{{ number_format($program->programmable->price_mahad, 0, ',', '.') }},-
                    </li>
                  @endif
                  @if (!empty($program->programmable->price_s1) && $program->programmable->price_s1 > 0)
                    <li>
                      <span class="small text-primary">BP S1: </span>
                      Rp{{ number_format($program->programmable->price_s1, 0, ',', '.') }},-
                    </li>
                  @endif
                </td>
                <td>
                  @if (!empty($program->programmable->option) && $program->programmable->option)
                    @php
                      $options = json_decode($program->programmable->option);
                    @endphp

                    @if ($options)
                      @foreach ($options as $option)
                        <li>{{ $option }}</li>
                      @endforeach
                    @else
                      <li>No options available</li>
                    @endif
                  @else
                    <li>No options available</li>
                  @endif

                </td>
                <td><span class="badge @if ($program->status) bg-label-primary @else bg-label-warning @endif">
                    @if ($program->status)
                      Aktif
                    @else
                      Non-Aktif
                    @endif
                  </span></td>
                <td>
                  <div class="d-inline-block"><a href="javascript:;"
                      class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                      aria-expanded="false"><i class="text-primary ti ti-dots-vertical"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end m-0" style="">
                      <li><a href="{{ route('programs.edit', $program->id) }}" class="dropdown-item">Edit Data</a></li>
                      {{-- <li><a href="javascript:;" class="dropdown-item">Archive</a></li> --}}
                      <div class="dropdown-divider"></div>
                      <li>
                        <form action="{{ route('programs.destroy', $program->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this program?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="dropdown-item text-danger delete-record">Delete</button>
                        </form>
                      </li>
                    </ul>
                  </div><a href="{{ route('programs.edit', $program->id) }}" class="btn btn-sm btn-icon item-edit"><i
                      class="text-primary ti ti-pencil"></i></a>
                </td>
              </tr>
            @endforeach

          </tbody>
          <tfoot>
            <tr>
              <th>Program</th>
              <th>Angkatan</th>
              <th>Biaya</th>
              <th>Tipe Kelas</th>
              <th>Status</th>
              <th>Tindakan</th>
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
      $('#programs').DataTable();
    });
  </script>
@endsection
