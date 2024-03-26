@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Program</h4>
      <a href="{{ route('programs.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    {{-- <hr class="mb-5"> --}}

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
                <option value="App\Models\Tahsin">{{ $tahsins->first()->title }}</option>
                <option value="App\Models\Tahfiz">{{ $tahfizs->first()->title }}</option>
                <option value="App\Models\Bilhaq">{{ $bilhaqs->first()->title }}</option>
                <option value="App\Models\Kiba">{{ $kiba->first()->title }}</option>
                <option value="App\Models\Lughoh">{{ $lughoh->first()->title }}</option>
                <option value="App\Models\Fai">{{ $fai->first()->title }}</option>
                <option value="App\Models\Stebis">{{ $stebis->first()->title }}</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="programmable_id" class="form-label">Nama Program</label>
              <select name="programmable_id" id="programmable_id" class="form-select" disabled>
                <option>Pilih program terlebih dahulu</option>
              </select>
            </div>

            <div id="tahsin" style="display: none;">
              <div class="mb-3">
                <label for="price_normal" class="form-label">Biaya Normal</label>
                <input type="number" name="price_normal" value="0" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="price_alumni" class="form-label">Biaya Alumni</label>
                <input type="number" name="price_alumni" value="0" class="form-control" required>
              </div>
            </div>

            <div id="tahfiz" style="display: none;">
              <div class="mb-3">
                <label for="price_normal" class="form-label">Biaya Pendaftaran/Seleksi</label>
                <input type="number" name="price_normal" value="0" class="form-control" required>
              </div>
            </div>

            <div id="kiba" style="display: none;">
              <div class="mb-3">
                <label for="price_normal" class="form-label">Biaya Normal</label>
                <input type="number" name="price_normal" value="0" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="price_alumni" class="form-label">Biaya Alumni</label>
                <input type="number" name="price_alumni" value="0" class="form-control" required>
              </div>
            </div>

            <div id="bilhaq" style="display: none;">
              <div class="mb-3">
                <label for="price" class="form-label">Biaya Pendaftaran</label>
                <input type="number" name="price_normal" value="0" class="form-control" required>
              </div>
            </div>

            <div id="lughoh" style="display: none;">
              <div class="mb-3">
                <label for="price_pra" class="form-label">Biaya Pendaftaran/Seleksi</label>
                <input type="number" name="price_pra" value="0" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="price_normal" class="form-label">Biaya SPP</label>
                <input type="number" name="price_normal" value="0" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="price_mahad" class="form-label">Biaya Pembangunan Ma'had</label>
                <input type="number" name="price_mahad" value="0" class="form-control" required>
              </div>
            </div>

            <div id="stebis" style="display: none;">
              <div class="mb-3">
                <label for="price_pra" class="form-label">Biaya Pendaftaran/Seleksi</label>
                <input type="number" name="price_pra" value="0" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="price_normal" class="form-label">Biaya SPP</label>
                <input type="number" name="price_normal" value="0" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="price_mahad" class="form-label">Biaya Pembangunan Ma'had</label>
                <input type="number" name="price_mahad" value="0" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="price_s1" class="form-label">Biaya Pembangunan S1</label>
                <input type="number" name="price_s1" value="0" class="form-control" required>
              </div>
            </div>

            <div id="fai" style="display: none;">
              <div class="mb-3">
                <label for="price_pra" class="form-label">Biaya Pendaftaran/Seleksi</label>
                <input type="number" name="price_pra" value="0" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="price_normal" class="form-label">Biaya SPP</label>
                <input type="number" name="price_normal" value="0" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="price_mahad" class="form-label">Biaya Pembangunan Ma'had</label>
                <input type="number" name="price_mahad" value="0" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="price_s1" class="form-label">Biaya Pembangunan S1</label>
                <input type="number" name="price_s1" value="0" class="form-control" required>
              </div>
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

      function disableInputs(blockId, disable) {
        var inputs = document.querySelectorAll('#' + blockId + ' input');
        inputs.forEach(function(input) {
          input.disabled = disable;
        });
      }

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

        var programDetailsDivs = document.querySelectorAll(
          '#tahsin, #tahfiz, #bilhaq, #kiba, #lughoh, #fai, #stebis'
        );

        programDetailsDivs.forEach(function(div) {
          div.style.display = 'none';
          disableInputs(div.id, true); // Disable all inputs in hidden blocks
        });

        newOptions.forEach(function(option) {
          var optionElement = document.createElement('option');
          optionElement.value = option.id;
          optionElement.textContent = option.title + ' Angkatan ' + option.batch;
          programmableIdSelect.appendChild(optionElement);
        });

        var selectedBlockId = selectedProgramType.split('\\').pop().toLowerCase();
        var selectedBlock = document.getElementById(selectedBlockId);
        if (selectedBlock) {
          selectedBlock.style.display = 'block';
          disableInputs(selectedBlockId, false);
          if (selectedProgramType === 'App\\Models\\Tahsin') {
            document.querySelector('#tahsin input[name="price_normal"]').value = newOptions.length > 0 ?
              newOptions[0].price_normal : '0';
            document.querySelector('#tahsin input[name="price_alumni"]').value = newOptions.length > 0 ?
              newOptions[0].price_alumni : '0';
          } else if (selectedProgramType === 'App\\Models\\Tahfiz') {
            document.querySelector('#tahfiz input[name="price_normal"]').value = newOptions.length > 0 ?
              newOptions[0].price_normal : '0';
          } else if (selectedProgramType === 'App\\Models\\Kiba') {
            document.querySelector('#kiba input[name="price_normal"]').value = newOptions.length > 0 ? newOptions[
              0].price_normal : '0';
            document.querySelector('#kiba input[name="price_alumni"]').value = newOptions.length > 0 ? newOptions[
              0].price_alumni : '0';
          } else if (selectedProgramType === 'App\\Models\\Bilhaq') {
            document.querySelector('#bilhaq input[name="price_normal"]').value = newOptions.length > 0 ?
              newOptions[0].price_normal : '0';
          } else if (selectedProgramType === 'App\\Models\\Lughoh') {
            document.querySelector('#lughoh input[name="price_pra"]').value = newOptions.length > 0 ? newOptions[
              0].price_pra : '0';
            document.querySelector('#lughoh input[name="price_normal"]').value = newOptions.length > 0 ?
              newOptions[0].price_normal : '0';
            document.querySelector('#lughoh input[name="price_mahad"]').value = newOptions.length > 0 ?
              newOptions[0].price_mahad : '0';
          } else if (selectedProgramType === 'App\\Models\\Fai') {
            document.querySelector('#fai input[name="price_pra"]').value = newOptions.length > 0 ? newOptions[0]
              .price_pra : '0';
            document.querySelector('#fai input[name="price_normal"]').value = newOptions.length > 0 ? newOptions[
              0].price_normal : '0';
            document.querySelector('#fai input[name="price_mahad"]').value = newOptions.length > 0 ? newOptions[0]
              .price_mahad : '0';
            document.querySelector('#fai input[name="price_s1"]').value = newOptions.length > 0 ? newOptions[0]
              .price_s1 : '0';
          } else if (selectedProgramType === 'App\\Models\\Stebis') {
            document.querySelector('#stebis input[name="price_pra"]').value = newOptions.length > 0 ? newOptions[
              0].price_pra : '0';
            document.querySelector('#stebis input[name="price_normal"]').value = newOptions.length > 0 ?
              newOptions[0].price_normal : '0';
            document.querySelector('#stebis input[name="price_mahad"]').value = newOptions.length > 0 ?
              newOptions[0].price_mahad : '0';
            document.querySelector('#stebis input[name="price_s1"]').value = newOptions.length > 0 ? newOptions[0]
              .price_s1 : '0';
          }
        }
      });
    });
  </script>
@endsection
