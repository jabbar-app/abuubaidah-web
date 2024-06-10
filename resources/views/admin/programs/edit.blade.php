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
                <option value="App\Models\Tahsin" @if ($program->programmable_type == 'App\Models\Tahsin') selected @endif>
                  {{ $tahsins->first()->title }}</option>
                <option value="App\Models\Tahfiz" @if ($program->programmable_type == 'App\Models\Tahfiz') selected @endif>
                  {{ $tahfizs->first()->title }}</option>
                <option value="App\Models\Bilhaq" @if ($program->programmable_type == 'App\Models\Bilhaq') selected @endif>
                  {{ $bilhaqs->first()->title }}</option>
                <option value="App\Models\Kiba" @if ($program->programmable_type == 'App\Models\Kiba') selected @endif>
                  {{ $kiba->first()->title }}</option>
                <option value="App\Models\Lughoh" @if ($program->programmable_type == 'App\Models\Lughoh') selected @endif>
                  {{ $lughoh->first()->title }}</option>
                <option value="App\Models\Fai" @if ($program->programmable_type == 'App\Models\Fai') selected @endif>
                  {{ $fai->first()->title }}</option>
                <option value="App\Models\Stebis" @if ($program->programmable_type == 'App\Models\Stebis') selected @endif>
                  {{ $stebis->first()->title }}</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="programmable_id" class="form-label">Nama Program</label>
              <select name="programmable_id" id="programmable_id" class="form-select">
                <option value="{{ $program->programmable_id }}">
                  {{ $program->programmable->title . ' Angkatan ' . $program->programmable->batch }}</option>
              </select>
            </div>

            <div id="tahsin" style="display: none;">
              <div class="mb-3">
                <label for="price_normal" class="form-label">Biaya Normal</label>
                <input type="number" name="price_normal" value="{{ $program->price_normal }}" class="form-control"
                  required>
              </div>
              <div class="mb-3">
                <label for="price_alumni" class="form-label">Biaya Alumni</label>
                <input type="number" name="price_alumni" value="{{ $program->price_alumni }}" class="form-control"
                  required>
              </div>
            </div>

            <div id="tahfiz" style="display: none;">
              <div class="mb-3">
                <label for="price_normal" class="form-label">Biaya Pendaftaran/Seleksi</label>
                <input type="number" name="price_normal" value="{{ $program->price_normal }}" class="form-control"
                  required>
              </div>
            </div>

            <div id="kiba" style="display: none;">
              <div class="mb-3">
                <label for="price_normal" class="form-label">Biaya Normal</label>
                <input type="number" name="price_normal" value="{{ $program->price_normal }}" class="form-control"
                  required>
              </div>
              <div class="mb-3">
                <label for="price_alumni" class="form-label">Biaya Alumni</label>
                <input type="number" name="price_alumni" value="{{ $program->price_alumni }}" class="form-control"
                  required>
              </div>
            </div>

            <div id="bilhaq" style="display: none;">
              <div class="mb-3">
                <label for="price" class="form-label">Biaya Pendaftaran</label>
                <input type="number" name="price_normal" value="{{ $program->price_normal }}" class="form-control"
                  required>
              </div>
            </div>

            <div id="lughoh" style="display: none;">
              <div class="mb-3">
                <label for="price_pra" class="form-label">Biaya Pendaftaran/Seleksi</label>
                <input type="number" name="price_pra" value="{{ $program->price_pra }}" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="price_normal" class="form-label">Biaya SPP</label>
                <input type="number" name="price_normal" value="{{ $program->price_normal }}" class="form-control"
                  required>
              </div>
              <div class="mb-3">
                <label for="price_mahad" class="form-label">Biaya Pembangunan Ma'had</label>
                <input type="number" name="price_mahad" value="{{ $program->price_mahad }}" class="form-control"
                  required>
              </div>
            </div>

            <div id="fai" style="display: none;">
              <div class="mb-3">
                <label for="price_pra" class="form-label">Biaya Pendaftaran/Seleksi</label>
                <input type="number" name="price_pra" value="{{ $program->price_pra }}" class="form-control"
                  required>
              </div>
              <div class="mb-3">
                <label for="price_normal" class="form-label">Biaya SPP</label>
                <input type="number" name="price_normal" value="{{ $program->price_normal }}" class="form-control"
                  required>
              </div>
              <div class="mb-3">
                <label for="price_mahad" class="form-label">Biaya Pembangunan Ma'had</label>
                <input type="number" name="price_mahad" value="{{ $program->price_mahad }}" class="form-control"
                  required>
              </div>
              <div class="mb-3">
                <label for="price_s1" class="form-label">Biaya Pembangunan S1</label>
                <input type="number" name="price_s1" value="{{ $program->price_s1 }}" class="form-control" required>
              </div>
            </div>

            <div id="stebis" style="display: none;">
              <div class="mb-3">
                <label for="price_pra" class="form-label">Biaya Pendaftaran/Seleksi</label>
                <input type="number" name="price_pra" value="{{ $program->price_pra }}" class="form-control"
                  required>
              </div>
              <div class="mb-3">
                <label for="price_normal" class="form-label">Biaya SPP</label>
                <input type="number" name="price_normal" value="{{ $program->price_normal }}" class="form-control"
                  required>
              </div>
              <div class="mb-3">
                <label for="price_mahad" class="form-label">Biaya Pembangunan Ma'had</label>
                <input type="number" name="price_mahad" value="{{ $program->price_mahad }}" class="form-control"
                  required>
              </div>
              <div class="mb-3">
                <label for="price_s1" class="form-label">Biaya Pembangunan S1</label>
                <input type="number" name="price_s1" value="{{ $program->price_s1 }}" class="form-control" required>
              </div>
            </div>

            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline Program</label>
                <input type="date" name="deadline" class="form-control" value="{{ $program->deadline }}">
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
    var kiba = @json($kiba);
    var lughoh = @json($lughoh);
    var fai = @json($fai);
    var stebis = @json($stebis);

    document.addEventListener('DOMContentLoaded', function() {
      var programTypeSelect = document.getElementById('program_type');
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
