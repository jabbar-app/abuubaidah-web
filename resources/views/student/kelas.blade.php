@extends('student.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 mb-4"><a href="{{ route('dashboard') }}" class="text-muted fw-light">Dashboard /</a> Data Kelas</h4>

    <div class="card">
      <div class="card-datatable table-responsive pt-0">
        <table id="datatable" class="table">
          <thead>
            <tr>
              <th>Program</th>
              <th>Angkatan</th>
              <th class="text-center">Detail</th>
              <th class="text-center">Group WA</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($kelas as $k)
              <tr>
                <td>{{ $k->program->programmable->title }}</td>
                <td>{{ $k->batch }}</td>
                {{-- <td>
                    {{ $k->class }}
                    @if (!empty($k->room))
                    <br>Ruang Kelas: {{ $k->room }}
                    @endif
                </td>

                <td>
                  <ul style="margin-left: -16px; padding-top: 16px;">
                    @php
                      $sessions = json_decode($k->session, true); // Decode as array
                      if (!is_array($sessions)) {
                          // Check if the result is not an array
                          $sessions = []; // Set to empty array if not
                      }
                    @endphp

                    @foreach ($sessions as $session)
                      <li>{{ $session }}</li>
                    @endforeach
                  </ul>
                </td> --}}

                <td class="text-center">
                    @if ($k->status == 'Selesai')
                    <a href="/kelas/detail/{{ $k->id }}" class="btn btn-sm btn-info">Lihat Hasil</a>
                    @else
                    <a href="/kelas/detail/{{ $k->id }}" class="btn btn-sm btn-light">Lihat Detail</a>
                    @endif

                </td>
                <td class="text-center">
                  <a href="{{ $k->link_whatsapp ? $k->link_whatsapp : '#' }}" target="_blank" class="fw-medium"
                    id="wa-link">Join Group WhatsApp</a>
                </td>
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    const waLink = document.getElementById('wa-link');
                    waLink.addEventListener('click', function(event) {
                      if (waLink.getAttribute('href') === '#') {
                        event.preventDefault();
                        Swal.fire({
                          icon: 'warning',
                          title: 'Link belum tersedia',
                          text: 'Silakan cek lagi nanti, ya.',
                          confirmButtonText: 'OK'
                        });
                      }
                    });
                  });
                </script>
                <td><span class="badge bg-label-primary">{{ $k->status }}</span></td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th>Program</th>
              <th>Angkatan</th>
              <th class="text-center">Detail</th>
              <th>Status</th>
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
      $('#datatable').DataTable();
    });
  </script>
@endsection
