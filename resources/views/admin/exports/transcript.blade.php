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
      border: 1px solid black;
    }

    .content th,
    .content td {
      padding: 4px;
      /* Reduce padding to fit more content */
      text-align: center;
      /* Center align text */
    }

    .content th {
      text-align: center;
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
  </style>
</head>

<body>
  <div class="container">

    <div class="header">
      <img src="{{ asset('assets/img/pdf/header.png') }}" alt="Ma'had Abu Ubaidah Bin Al Jarrah Medan" width="100%">
    </div>
    <div class="content">
      <table class="biodata-table" style="border: none">
        <tr>
          <td>
            Nama <br>
            NIM
          </td>
          <td>
            : {{ $student->user->name }} <br>
            : {{ $student->nim }}
          </td>
          <td style="width: 40%;"></td>
          <td>
            Kewarganegaraan <br>
            Angkatan
          </td>
          <td>
            : Indonesia <br>
            : {{ $student->program->programmable->batch }}
          </td>
        </tr>
        <tr>

        </tr>
      </table>
    </div>

    <div class="content">
      <h2>Transkrip Nilai</h2>
      <table>
        <thead>
          <tr>
            <th rowspan="3">No.</th>
            <th rowspan="3">Mata Kuliah</th>
            <th colspan="12">Mustawa</th>
          </tr>
          <tr>
            <th colspan="3">Awwal</th>
            <th colspan="3">Tsani</th>
            <th colspan="3">Tsalits</th>
            <th colspan="3">Rabi'</th>
          </tr>
          <tr>
            <th>SKS</th>
            <th>Nilai</th>
            <th>Jumlah</th>
            <th>SKS</th>
            <th>Nilai</th>
            <th>Jumlah</th>
            <th>SKS</th>
            <th>Nilai</th>
            <th>Jumlah</th>
            <th>SKS</th>
            <th>Nilai</th>
            <th>Jumlah</th>
          </tr>
        </thead>
        <tbody>
          @php
            $count = 1;
            $total_sks = 0;
            $total_nilai = 0;
            $groupedTranscripts = $transcripts->groupBy('course.mk');
          @endphp
          @foreach ($groupedTranscripts as $mk => $group)
            @php
              $sks = $group->first()->course->sks;
              $total_sks += $sks;
            @endphp
            <tr>
              <td>{{ $count++ }}</td>
              <td>{{ $mk }}</td>
              <td>{{ $sks }}</td>
              <td>
                @if ($group->where('mustawa', 'Awwal')->isNotEmpty())
                  {{ $group->where('mustawa', 'Awwal')->first()->grade }}
                @endif
              </td>
              <td>
                @if ($group->where('mustawa', 'Awwal')->isNotEmpty())
                  {{ $sks * $group->where('mustawa', 'Awwal')->first()->grade }}
                  @php $total_nilai += $sks * $group->where('mustawa', 'Awwal')->first()->grade; @endphp
                @endif
              </td>
              <td>{{ $sks }}</td>
              <td>
                @if ($group->where('mustawa', 'Tsani')->isNotEmpty())
                  {{ $group->where('mustawa', 'Tsani')->first()->grade }}
                @endif
              </td>
              <td>
                @if ($group->where('mustawa', 'Tsani')->isNotEmpty())
                  {{ $sks * $group->where('mustawa', 'Tsani')->first()->grade }}
                  @php $total_nilai += $sks * $group->where('mustawa', 'Tsani')->first()->grade; @endphp
                @endif
              </td>
              <td>{{ $sks }}</td>
              <td>
                @if ($group->where('mustawa', 'Tsalits')->isNotEmpty())
                  {{ $group->where('mustawa', 'Tsalits')->first()->grade }}
                @endif
              </td>
              <td>
                @if ($group->where('mustawa', 'Tsalits')->isNotEmpty())
                  {{ $sks * $group->where('mustawa', 'Tsalits')->first()->grade }}
                  @php $total_nilai += $sks * $group->where('mustawa', 'Tsalits')->first()->grade; @endphp
                @endif
              </td>
              <td>{{ $sks }}</td>
              <td>
                @if ($group->where('mustawa', 'Rabi')->isNotEmpty())
                  {{ $group->where('mustawa', 'Rabi')->first()->grade }}
                @endif
              </td>
              <td>
                @if ($group->where('mustawa', 'Rabi')->isNotEmpty())
                  {{ $sks * $group->where('mustawa', 'Rabi')->first()->grade }}
                  @php $total_nilai += $sks * $group->where('mustawa', 'Rabi')->first()->grade; @endphp
                @endif
              </td>
            </tr>
          @endforeach
          <tr>
            <td colspan="14"><br><br></td>
          </tr>
          <tr>
            <td colspan="2">Total Nilai Persemester</td>
            <td colspan="3"></td>
            <td colspan="3"></td>
            <td colspan="3"></td>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td colspan="2">Nilai Rata-rata Persemester</td>
            <td colspan="3"></td>
            <td colspan="3"></td>
            <td colspan="3"></td>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td colspan="2">Nilai Rata-rata Persemester</td>
            <td colspan="3"></td>
            <td colspan="3"></td>
            <td colspan="3"></td>
            <td colspan="3"></td>
          </tr>
          <tr>
            <td colspan="14"><br><br></td>
          </tr>
          <tr>
            <th style="text-align: left;" colspan="11">Total SKS</th>
            <td colspan="3">{{ $total_sks }}</td>
          </tr>
          <tr>
            <th style="text-align: left;" colspan="11">Total Nilai</th>
            <td colspan="3">{{ $total_nilai }}</td>
          </tr>
          <tr>
            <th style="text-align: left;" colspan="11">Nilai Rata-Rata Kumulatif</th>
            <td colspan="3">{{ $total_nilai / $total_sks }}</td>
          </tr>
          <tr>
            <th style="text-align: left;" colspan="11">Predikat</th>
            <td colspan="3">{{ $predikat ?? '' }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>
