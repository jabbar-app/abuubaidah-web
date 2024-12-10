@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3">
        <a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Mustawa
      </h4>
    </div>

    @if (session('success'))
      <div class="col-12">
        <div class="alert alert-success dark alert-dismissible fade show" role="alert">
          <strong>Success!</strong> {{ session('success') }}
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @elseif(session('danger'))
      <div class="col-12">
        <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
          <strong>Failed!</strong> {{ session('danger') }}
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    @endif

    @foreach (['tamhidie', 'awwal', 'tsani', 'tsalit', 'robi'] as $mustawa)
      @php
        $mustawaData = ${$mustawa . 's'};
      @endphp

      @if (!empty($mustawaData) && $mustawaData->isNotEmpty())
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between">
            @php
              if ($mustawa == 'tamhidie') {
                  $mustawa = 'Tamhidy';
              }
            @endphp
            <h4>Mustawa {{ ucfirst($mustawa) }}</h4>
            <div>
              @php
                if ($mustawa == 'tsalit') {
                    $mustawa = 'tsalits';
                }
              @endphp
              <a href="{{ route('exportMustawa', ['type' => $mustawa]) }}"
                class="btn btn-md btn-outline-primary me-2">Export to Excel</a>
              <form action="{{ route('importMustawa', ['type' => $mustawa]) }}" method="POST"
                enctype="multipart/form-data" style="display: inline;">
                @csrf
                <input type="file" name="file" class="form-control-file d-inline" required>
                <button type="submit" class="btn btn-primary">Import</button>
              </form>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Kode</th>
                  <th>Mata Kuliah</th>
                  <th>SKS</th>
                  <th>Nama Mata Kuliah UMSU</th>
                  <th>Nama Mata Kuliah STEBIS</th>
                  <th>Tindakan</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($mustawaData as $index => $data)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->kode_mk }}</td>
                    <td>{{ $data->mk }}</td>
                    <td class="text-center">{{ $data->sks }}</td>
                    <td>{{ $data->umsu_mk }}</td>
                    <td>{{ $data->stebis_mk }}</td>
                    <td class="text-center">
                      @php
                        if ($mustawa == 'tsalits') {
                            $mustawa = 'tsalit';
                        }
                      @endphp
                      <a href="{{ route('editMustawa', ['type' => $mustawa, 'id' => $data->id]) }}"
                        class="btn btn-sm btn-outline-secondary">Edit</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @endif
    @endforeach

  </div>
@endsection
