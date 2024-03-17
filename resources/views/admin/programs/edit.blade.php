@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Program</h4>
      <a href="{{ route('programs.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    {{-- <hr class="mb-5"> --}}

    <div class="d-flex justify-content-center">
      <div class="card col-xl-8 col-md-10 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Edit Program</h5>
          <small class="text-muted float-end">
            تحرير البرنامج
          </small>
        </div>
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif


          <form method="POST" action="{{ route('programs.update', $program->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label" for="program_type">Program</label>
              <select class="form-select" name="program_type" id="program_type" required>
                <option value="App\Models\Tahsin" @if ($program->programmable_type == 'App\Models\Tahsin') selected @endif>Tahsin</option>
                <option value="App\Models\Tahfiz" @if ($program->programmable_type == 'App\Models\Tahfiz') selected @endif>Tahfiz</option>
                <option value="App\Models\Bilhaq" @if ($program->programmable_type == 'App\Models\Bilhaq') selected @endif>Bilhaq</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="programmable_id" class="form-label">Nama Program</label>
              <select name="programmable_id" id="programmable_id" class="form-select">
                <option value="{{ $program->programmable_id }}">{{ $program->programmable->title . ' Angkatan ' . $program->programmable->batch }}</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="price_pra" class="form-label">Biaya Seleksi</label>
              <input type="number" name="price_pra" value="{{ $program->price_pra }}" class="form-control">
            </div>
            <div class="mb-3">
              <label for="price_normal" class="form-label">Biaya Normal</label>
              <input type="number" name="price_normal" value="{{ $program->price_normal }}" class="form-control">
            </div>
            <div class="mb-3">
              <label for="price_alumni" class="form-label">Biaya Alumni</label>
              <input type="number" name="price_alumni" value="{{ $program->price_alumni }}" class="form-control">
            </div>
            <div class="mb-3">
              <label for="deadline" class="form-label">Batas Pendaftaran</label>
              <input type="date" name="deadline" value="{{ $program->deadline }}" class="form-control">
            </div>
            <div class="mb-5">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-select">
                <option value="1" @if ($program->status) selected @endif>Aktif</option>
                <option value="0" @if (!$program->status) selected @endif>Tidak Aktif</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary float-end">Update Program</button>
          </form>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    var tahsins = @json($tahsins);
    var tahfizs = @json($tahfizs);
    var bilhaqs = @json($bilhaqs);

    document.addEventListener('DOMContentLoaded', function() {
      var programTypeSelect = document.getElementById('program_type');
      var programmableIdSelect = document.getElementById('programmable_id');

      programTypeSelect.addEventListener('change', function() {
        // Enable the programmable_id select box
        programmableIdSelect.removeAttribute('disabled');

        // Determine which program type was selected
        var selectedProgramType = this.value;

        // Clear previous options
        programmableIdSelect.innerHTML = '';

        // Variable to hold the new options
        var newOptions = [];

        // Determine which array to use based on the selected program type
        switch (selectedProgramType) {
          case 'App\\Models\\Tahsin':
            newOptions = tahsins;
            break;
          case 'App\\Models\\Tahfiz':
            newOptions = tahfizs;
            break;
          case 'App\\Models\\Bilhaq':
            newOptions = bilhaqs;
            break;
        }

        // Add new options to the programmable_id select box
        newOptions.forEach(function(option) {
          var optionElement = document.createElement('option');
          optionElement.value = option.id;
          optionElement.textContent = option.title + ' Angkatan ' + option.batch;
          programmableIdSelect.appendChild(optionElement);
        });
      });
    });
  </script>
@endsection
