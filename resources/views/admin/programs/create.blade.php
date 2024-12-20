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
              <select class="form-select select2" name="programmable_type" id="programmable_type" required>
                <option value="" selected disabled>- Pilih data -</option>
                @if ($tahsins->isNotEmpty())
                  @foreach ($tahsins as $tahsin)
                    <option value="{{ App\Models\Tahsin }}">{{ $tahsin->title }} - Angkatan: {{ $tahsin->batch }}</option>
                  @endforeach
                @endif
                @if ($tahfizs->isNotEmpty())
                  @foreach ($tahfizs as $tahfiz)
                    <option value="App\Models\Tahfiz">{{ $tahfiz->title }} - Angkatan: {{ $tahfiz->batch }}</option>
                  @endforeach
                @endif
                @if ($bilhaqs->isNotEmpty())
                  @foreach ($bilhaqs as $bilhaq)
                    <option value="App\Models\Bilhaq">{{ $bilhaq->title }} - Angkatan: {{ $bilhaq->batch }}</option>
                  @endforeach
                @endif
                @if ($kiba->isNotEmpty())
                  @foreach ($kiba as $data)
                    <option value="App\Models\Kiba">{{ $data->title }} - Angkatan: {{ $data->batch }}</option>
                  @endforeach
                @endif
                @if ($lughoh->isNotEmpty())
                  @foreach ($lughoh as $data)
                    <option value="App\Models\Lughoh">{{ $data->title }} - Angkatan: {{ $data->batch }}</option>
                  @endforeach
                @endif
                @if ($fai->isNotEmpty())
                  @foreach ($fai as $data)
                    <option value="App\Models\Fai">{{ $data->title }} - Angkatan: {{ $data->batch }}</option>
                  @endforeach
                @endif
                @if ($stebis->isNotEmpty())
                  @foreach ($stebis as $data)
                    <option value="App\Models\Stebis">{{ $data->title }} - Angkatan: {{ $data->batch }}</option>
                  @endforeach
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
        // Menghapus atribut disabled
        programmableIdSelect.removeAttribute('disabled');
        programmableIdSelect.innerHTML = ''; // Menghapus opsi yang ada

        var selectedProgramType = this.value;
        var newOptions = [];

        // Menentukan opsi baru berdasarkan tipe program yang dipilih
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

        // Menambahkan opsi baru ke dropdown
        newOptions.forEach(function(option) {
          var optionElement = document.createElement('option');
          optionElement.value = option.id;
          optionElement.textContent = option.title + ' - Angkatan ' + option.batch;
          programmableIdSelect.appendChild(optionElement);
        });

        // Jika tidak ada opsi baru, tambahkan opsi default
        if (newOptions.length === 0) {
          var defaultOption = document.createElement('option');
          defaultOption.textContent = 'Tidak ada program tersedia';
          programmableIdSelect.appendChild(defaultOption);
        }
      });
    });
  </script>
@endsection
