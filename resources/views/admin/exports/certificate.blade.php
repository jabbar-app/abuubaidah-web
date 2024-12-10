<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Transkrip Nilai</title>
  <style>
    body {
      font-family: 'Helvetica', 'Arial', sans-serif;
      font-size: 10px;
      /* Shrink font size to fit the table */
    }

    .container {
      width: 100%;
      margin: 0 auto;
    }

    .header,
    .content {
      margin: 20px 0;
    }

    .header {
      text-align: center;
    }

    .content table {
      width: 100%;
      border-collapse: collapse;
    }

    .content table,
    .content th,
    .content td {
      border: 1px solid rgb(210, 210, 210);
    }

    .content th,
    .content td {
      padding: 12px 6px;
      /* Reduce padding to fit more content */
      text-align: left;
      /* Center align text */
    }

    .content th {
      text-align: left;
    }

    .content .biodata-table th,
    .content .biodata-table td {
      border: none;
      padding: 4px;
      text-align: left;
    }

    .content .biodata-table th {
      width: 20%;
    }

    .content .biodata-table td {
      width: 80%;
    }

    .qr {
      width: 120px;
      float: right;
      margin-top: 48px;
    }
  </style>
</head>

<body>
  <div class="container" style="max-width: 80%; margin: auto;">

    <div class="header">
      <img src="{{ asset('assets/img/pdf/header_program.png') }}" alt="Ma'had Abu Ubaidah Bin Al Jarrah Medan"
        width="100%">
    </div>

    <center>
      <h1 style="margin-bottom: 24px;">{{ $kelas->program->programmable->title }}</h1>
    </center>

    <div class="content">
      {{-- <h2>Detail Kelas</h2> --}}
      <table style="border: none; font-size: 16px; max-width: 50%; margin: auto;">
        <thead style="background-color: rgb(238, 238, 238)">
          <tr>
            <th class="bg-light" style="padding: 18px 6px !important;">Data</th>
            <th class="bg-light" style="padding: 18px 6px !important;">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Nama Peserta</td>
            <td>
              <span class="fw-medium">{{ Auth::user()->name }}</span>
            </td>
          </tr>
          <tr>
            <td>Status</td>
            <td>
              <span class="fw-medium">{{ $kelas->status }}</span>
            </td>
          </tr>
          @if ($program->programmable_type == 'App\Models\Bilhaq')
            <tr>
              <td>Program</td>
              <td>
                <span class="fw-medium">{{ $kelas->program->programmable->title }}</span>
              </td>
            </tr>
            <tr>
              <td>Angkatan</td>
              <td>
                <span class="fw-medium">{{ $kelas->batch }}</span>
              </td>
            </tr>
            <tr>
              <td>Tipe Kelas</td>
              <td>
                <span class="fw-medium">{{ $kelas->class }}</span>
              </td>
            </tr>
            <tr>
              <td>Lokasi</td>
              <td>
                <span class="fw-medium">{{ $kelas->room ?? 'Belum ada lokasi.' }}</span>
              </td>
            </tr>
            <tr>
              <td>Nilai</td>
              <td>
                <span class="fw-medium">{{ $kelas->score ?? 'Belum ada nilai.' }}</span>
              </td>
            </tr>
            <tr>
              <td>Predikat</td>
              <td>
                <span class="fw-medium">{{ $kelas->lecturer ?? 'Belum ada predikat.' }}</span>
              </td>
            </tr>
            {{-- <tr>
              <td>Group WA</td>
              <td>
                <a href="{{ $kelas->link_whatsapp ? $kelas->link_whatsapp : '#' }}" target="_blank" class="fw-medium"
                  id="wa-link">Join Group WhatsApp</a>
              </td>
            </tr> --}}
          @else
            <tr>
              <td>Program</td>
              <td>
                <span class="fw-medium">{{ $kelas->program->programmable->title }}</span>
              </td>
            </tr>
            <tr>
              <td>Angkatan</td>
              <td>
                <span class="fw-medium">{{ $kelas->batch }}</span>
              </td>
            </tr>
            <tr>
              <td>Level</td>
              <td>
                <span class="fw-medium">{{ $kelas->level }}</span>
              </td>
            </tr>
            <tr>
              <td>Tipe Kelas</td>
              <td>
                <span class="fw-medium">{{ $kelas->class }}</span>
              </td>
            </tr>
            <tr>
              <td>Sesi Belajar</td>
              <td>
                <span class="fw-medium">
                  @php
                    $sessions = json_decode($kelas->session, true);
                  @endphp
                  @foreach ($sessions as $session)
                    {{ $session }} <br>
                  @endforeach
                </span>
              </td>
            </tr>
            <tr>
              <td>Ruang Kelas</td>
              <td>
                <span class="fw-medium">{{ $kelas->room ?? 'Belum ada ruang kelas.' }}</span>
              </td>
            </tr>
            <tr>
              <td>Nilai</td>
              <td>
                <span class="fw-medium">{{ $kelas->score ?? 'Belum ada nilai.' }}</span>
              </td>
            </tr>
            <tr>
              <td>Ustadz(ah)</td>
              <td>
                <span class="fw-medium">{{ $kelas->lecturer ?? 'Belum ada Ustadz/ah.' }}</span>
              </td>
            </tr>
            {{-- <tr>
              <td>Group WA</td>
              <td>
                <a href="{{ $kelas->link_whatsapp ? $kelas->link_whatsapp : '#' }}" target="_blank" class="fw-medium"
                  id="wa-link">Join Group WhatsApp</a>
              </td>
            </tr> --}}
          @endif
        </tbody>
      </table>

      <img src="{{ asset('assets/img/pdf/qr_abuubaidah.png') }}" alt="Ma'had Abu Ubaidah Bin Al Jarrah Medan"
        class="qr">
    </div>
  </div>
</body>

</html>
