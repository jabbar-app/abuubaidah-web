@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center my-4">
      <h4 class="text-primary mt-3"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data
        Transaksi</h4>
      <a href="{{ route('payments.index') }}" class="btn btn-md btn-light">Kembali</a>
    </div>

    {{-- <hr class="mb-5"> --}}

    <div class="d-flex justify-content-center">
      <div class="card col-xl-8 col-md-10 col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Tambah Data</h5>
          <small class="text-muted float-end">
            إضافة البيانات
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


          <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-user">Pilih User</label>
              <div class="col-sm-9">
                <select id="multicol-user" class="select2 form-select" name="user_id" data-allow-clear="true" required>
                  <option value="">Pilih</option>
                  @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program-id">Pilih Program</label>
              <div class="col-sm-9">
                <select id="multicol-program-id" class="select2 form-select" name="program_id" data-allow-clear="true"
                  required>
                  <option value="">Pilih</option>
                  @foreach ($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->programmable->title }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-kelas">Pilih Kelas ID</label>
              <div class="col-sm-9">
                <select id="multicol-kelas" class="select2 form-select" name="kelas_id" data-allow-clear="true" required>
                  <option value="">Pilih</option>
                  @foreach ($kelas as $kelas)
                    <option value="{{ $kelas->id }}">
                      {{ 'ID: ' . $kelas->id . ' - ' . $kelas->program->programmable->title }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="multicol-program">Biaya Program</label>
              <div class="col-sm-9">
                <input type="number" name="amount" class="form-control" required>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="method">Metode Pembayaran</label>
              <div class="col-sm-9">
                <select name="method" id="method" class="form-select" required>
                  <option value="" selected disabled>- Pilih Metode -</option>
                  <option value="Xendit">Xendit</option>
                  <option value="Offline">Offline</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="status">Status</label>
              <div class="col-sm-9">
                <select name="status" id="status" class="form-select" required>
                  <option value="" selected disabled>- Pilih Status -</option>
                  <option value="PENDING">PENDING</option>
                  <option value="PAID">PAID</option>
                  <option value="CICILAN">CICILAN</option>
                </select>
              </div>
            </div>

            <div class="row mb-3" id="installments-container" style="display: none;">
              <label class="col-sm-3 col-form-label">Pembayaran Cicilan</label>
              <div class="col-sm-9">
                <button type="button" class="btn btn-secondary" onclick="addInstallmentRow()">Tambah Cicilan</button>
              </div>
            </div>

            <div class="mt-5">
              <button type="submit" class="btn btn-primary float-end">Tambah Data</button>
            </div>
          </form>

          <script>
            document.getElementById('method').addEventListener('change', function() {
              const paymentMethod = this.value;
              const paymentStatus = document.getElementById('status').value;
              toggleInstallmentSection(paymentMethod, paymentStatus);
            });

            document.getElementById('status').addEventListener('change', function() {
              const paymentMethod = document.getElementById('method').value;
              const paymentStatus = this.value;
              toggleInstallmentSection(paymentMethod, paymentStatus);
            });

            function toggleInstallmentSection(method, status) {
              const installmentSection = document.getElementById('installments-container');
              if (method === 'Offline' && status === 'CICILAN') {
                installmentSection.style.display = 'block';
              } else {
                installmentSection.style.display = 'none';
              }
            }

            function addInstallmentRow() {
              const container = document.getElementById('installments-container');
              const count = container.children.length; // Get the current number of installment sections to index them

              const row = document.createElement('div');
              row.className = 'row mb-3';
              row.innerHTML = `
                <div class="col-sm-4">
                    <input type="number" name="installments[${count}][amount]" class="form-control" placeholder="Jumlah Cicilan" required>
                </div>
                <div class="col-sm-3">
                    <input type="date" name="installments[${count}][due_date]" class="form-control" placeholder="Tanggal Jatuh Tempo" required>
                </div>
                <div class="col-sm-3">
                    <select name="installments[${count}][status]" class="form-select" required>
                        <option value="">Select Status</option>
                        <option value="PENDING">PENDING</option>
                        <option value="PAID">PAID</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-danger" onclick="removeInstallmentRow(this)">Hapus</button>
                </div>
            `;
              container.appendChild(row);
            }


            // function addInstallmentRow() {
            //   const container = document.getElementById('installments-container');
            //   const row = document.createElement('div');
            //   row.className = 'row mb-3';
            //   row.innerHTML = `
  //         <div class="col-sm-4">
  //             <input type="number" name="installments[][amount]" class="form-control" placeholder="Jumlah Cicilan" required>
  //         </div>
  //         <div class="col-sm-3">
  //             <input type="date" name="installments[][due_date]" class="form-control" placeholder="Tanggal Jatuh Tempo" required>
  //         </div>
  //         <div class="col-sm-3">
  //             <select name="installments[][status]" class="form-select" required>
  //                 <option value="PENDING">PENDING</option>
  //                 <option value="PAID">PAID</option>
  //             </select>
  //         </div>
  //         <div class="col-sm-2">
  //             <button type="button" class="btn btn-danger" onclick="removeInstallmentRow(this)">Hapus</button>
  //         </div>
  //     `;
            //   container.appendChild(row);
            // }

            function removeInstallmentRow(button) {
              button.closest('.row').remove();
            }
          </script>



        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  {{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
      const methodSelect = document.getElementById('method');
      const statusRow = document.getElementById('status-row');

      methodSelect.addEventListener('change', function() {
        // Show the status dropdown only if 'Offline' is selected
        if (this.value === 'Offline') {
          statusRow.style.display = '';
        } else {
          statusRow.style.display = 'none';
        }
      });
    });
  </script> --}}
@endsection
