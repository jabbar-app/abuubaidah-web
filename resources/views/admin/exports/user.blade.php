<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>User Data</title>
  <style>
    body {
      font-family: 'Helvetica', 'Arial', sans-serif;
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
      padding: 8px;
      text-align: left;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>Ma'had Abu Ubaidah Bin Al Jarrah</h1>
    </div>
    <div class="content">
      <h2>Biodata</h2>
      <table class="table">
        <tr>
          <th>Nama Lengkap</th>
          <td>{{ $user->name }}</td>
        </tr>
        <tr>
          <th>NIK</th>
          <td>{{ $user->nik }}</td>
        </tr>
        <tr>
          <th>Email</th>
          <td>{{ $user->email }}</td>
        </tr>
        <tr>
          <th>No. WhatsApp</th>
          <td>{{ $user->phone }}</td>
        </tr>
        <tr>
          <th>Jenis Kelamin</th>
          <td>{{ $user->gender }}</td>
        </tr>
        <tr>
          <th>Berat Badan</th>
          <td>{{ $user->berat_badan }}</td>
        </tr>
        <tr>
          <th>Tinggi Badan</th>
          <td>{{ $user->tinggi_badan }}</td>
        </tr>
        <tr>
          <th>Tempat Lahir</th>
          <td>{{ $user->tempat_lahir }}</td>
        </tr>
        <tr>
          <th>Tanggal Lahir</th>
          <td>{{ $user->tanggal_lahir }}</td>
        </tr>
        <tr>
          <th>Suku</th>
          <td>{{ $user->suku }}</td>
        </tr>
        <tr>
          <th>Status Perkawinan</th>
          <td>{{ $user->status_perkawinan }}</td>
        </tr>
        <tr>
          <th>Alamat</th>
          <td>{{ $user->address }}</td>
        </tr>
        <tr>
          <th>Provinsi</th>
          <td>{{ $provinceName }}</td>
        </tr>
        <tr>
          <th>Kabupaten/Kota</th>
          <td>{{ $regencyName }}</td>
        </tr>
        <tr>
          <th>Kecamatan</th>
          <td>{{ $districtName }}</td>
        </tr>
      </table>
    </div>

    <div class="content">
      <h2>Data Pendidikan</h2>
      <table class="table">
        <tr>
          <th>Sekolah Dasar</th>
          <td>{{ $user->nama_sd }}</td>
        </tr>
        <tr>
          <th>Sekolah Menengah Pertama</th>
          <td>{{ $user->nama_smp }}</td>
        </tr>
        <tr>
          <th>Sekolah Menengah Atas</th>
          <td>{{ $user->nama_sma }}</td>
        </tr>
        <tr>
          <th>Perguruan Tinggi</th>
          <td>{{ $user->perguruan_tinggi }}</td>
        </tr>
        <tr>
          <th>Nama Ayah</th>
          <td>{{ $user->nama_ayah }}</td>
        </tr>
        <tr>
          <th>Status Ayah</th>
          <td>{{ $user->status_ayah }}</td>
        </tr>
        <tr>
          <th>Pekerjaan Ayah</th>
          <td>{{ $user->pekerjaan_ayah }}</td>
        </tr>
        <tr>
          <th>Penghasilan Ayah</th>
          <td>{{ $user->penghasilan_ayah }}</td>
        </tr>
        <tr>
          <th>No. Telp Ayah</th>
          <td>{{ $user->telp_ayah }}</td>
        </tr>
        <tr>
          <th>Nama Ibu</th>
          <td>{{ $user->nama_ibu }}</td>
        </tr>
        <tr>
          <th>Status Ibu</th>
          <td>{{ $user->status_ibu }}</td>
        </tr>
        <tr>
          <th>Pekerjaan Ibu</th>
          <td>{{ $user->pekerjaan_ibu }}</td>
        </tr>
        <tr>
          <th>Penghasilan Ibu</th>
          <td>{{ $user->penghasilan_ibu }}</td>
        </tr>
        <tr>
          <th>No. Telp Ibu</th>
          <td>{{ $user->telp_ibu }}</td>
        </tr>
        <tr>
          <th>KTP</th>
          <td>
            @if ($user->url_ktp)
              {{ asset($user->url_ktp) }}
            @else
              -
            @endif
          </td>
        </tr>
        <tr>
          <th>Kartu Keluarga</th>
          <td>
            @if ($user->url_kk)
              {{ asset($user->url_kk) }}
            @else
              -
            @endif
          </td>
        </tr>
        <tr>
          <th>Ijazah</th>
          <td>
            @if ($user->url_ijazah)
              {{ asset($user->url_ijazah) }}
            @else
              -
            @endif
          </td>
        </tr>
        <tr>
          <th>Sertifikat Bilhaq</th>
          <td>
            @if ($user->url_bilhaq)
              {{ asset($user->url_bilhaq) }}
            @else
              -
            @endif
          </td>
        </tr>
      </table>
    </div>

    <div class="content">
      <h2>Riwayat Kelas</h2>
      <table class="table">
        <thead>
          <tr>
            <th>No.</th>
            <th>Nama Program</th>
            <th>Angkatan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @php
            $count = 1;
          @endphp
          @forelse ($programs as $program)
            <tr>
              <td>{{ $count++ }}</td>
              <td>{{ $program->program->programmable->title }}</td>
              <td>{{ $program->batch }}</td>
              <td>{{ $program->status }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center">Belum ada data.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>



    <div class="content">
      <h2>Riwayat Transaksi</h2>
      <table class="table">
        <thead>
          <tr>
            <th>No.</th>
            <th>Deskripsi</th>
            <th>Jumlah</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @php
            $count = 1;
          @endphp
          @forelse ($payments as $payment)
            <tr>
              <td>{{ $count++ }}</td>
              <td>{{ $payment->description }}</td>
              <td>Rp{{ number_format($payment->amount, 0, ',', '.') }},-</td>
              <td>{{ $payment->status }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center">Belum ada data.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
</body>

</html>
