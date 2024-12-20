@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Program</h4>
      <a href="{{ route('programs.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    <div class="d-flex justify-content-center">
      <div class="card col-xl-8 col-md-10 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Tambah Program</h5> <small class="text-muted float-end">إضافة برنامج</small>
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

          <form method="POST" action="{{ route('programs.store') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label" for="programmable_type">Program</label>
              <select class="form-select" name="programmable_type" id="programmable_type" required>
                <option value="" selected disabled>- Pilih data -</option>
                @if($tahsins->isNotEmpty())
                  <option value="App\Models\Tahsin">Tahsin Tilawah Al-Qur'an</option>
                @endif
                @if($tahfizs->isNotEmpty())
                  <option value="App\Models\Tahfiz">{{ $tahfizs->first()->title }}</option>
                @endif
                @if($bilhaqs->isNotEmpty())
                  <option value="App\Models\Bilhaq">{{ $bilhaqs->first()->title }}</option>
                @endif
                @if($kiba->isNotEmpty())
                  <option value="App\Models\Kiba">{{ $kiba->first()->title }}</option>
                @endif
                @if($lughoh->isNotEmpty())
                  <option value="App\Models\Lughoh">{{ $lughoh->first()->title }}</option>
                @endif
                @if($fai->isNotEmpty())
                  <option value="App\Models\Fai">{{ $fai->first()->title }}</option>
                @endif
                @if($stebis->isNotEmpty())
                  <option value="App\Models\Stebis">{{ $stebis->first()->title }}</option>
                @endif
              </select>
            </div>

            <div class="mb-3">
              <label for="programmable_id" class="form-label">Nama Program</label>
              <select name="programmable_id" id="programmable_id" class="form-select" disabled>
                <option>Pilih program terlebih dahulu</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="deadline" class="form-label">Batas Pendaftaran</label>
              <input type="date" name="deadline" class="form-control" required>
            </div>
            <div class="mb-5">
              <label for="status" class="form-label">Status</label>
              <select name="status" id="status" class="form-select" required>
                <option value="1">Aktif</option>
                <option value="0">Tidak Aktif</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary float-end">Tambah Program</button>
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
    var kiba = @json($kiba);
    var lughoh = @json($lughoh);
    var fai = @json($fai);
    var stebis = @json($stebis);

    document.addEventListener('DOMContentLoaded', function() {
      var programTypeSelect = document.getElementById('programmable_type');
      var programmableIdSelect = document.getElementById('programmable_id');

      programTypeSelect.addEventListener('change', function() {
        programmableIdSelect.removeAttribute('disabled');
        programmableIdSelect.innerHTML = '';
        var selectedProgramType = this.value;
        var newOptions = [];
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
          case 'App\\Models\\Kiba':
            newOptions = kiba;
            break;
          case 'App\\Models\\Lughoh':
            newOptions = lughoh;
            break;
          case 'App\\Models\\Fai':
            newOptions = fai;
            break;
          case 'App\\Models\\Stebis':
            newOptions = stebis;
            break;
        }

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
