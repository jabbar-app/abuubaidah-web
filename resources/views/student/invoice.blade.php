<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice PDF</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      color: #333;
    }

    .container {
      width: 90%;
      margin: auto;
      padding: 20px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-bottom: 20px;
      border-bottom: 2px solid #ddd;
    }

    .header img {
      margin-top: -10px;
      max-width: 80px;
    }

    .company-details {
      text-align: right;
    }

    .company-details h2 {
      margin: 0;
      font-size: 24px;
    }

    .invoice-details {
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .invoice-details h2 {
      margin: 0;
      font-size: 24px;
    }

    .invoice-details table {
      width: 100%;
      margin-top: 10px;
    }

    .invoice-details th,
    .invoice-details td {
      text-align: left;
      padding: 5px;
    }

    .invoice-details th {
      background-color: #f2f2f2;
    }

    .customer-details {
      margin-top: 20px;
    }

    .customer-details h3 {
      margin-bottom: 5px;
      font-size: 18px;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .table th,
    .table td {
      padding: 10px;
      border: 1px solid #ccc;
    }

    .table th {
      background-color: #f2f2f2;
    }

    .text-right {
      text-align: right;
    }

    .footer {
      margin-top: 40px;
      text-align: center;
      font-size: 12px;
      color: #777;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <div>
        <img src="{{ asset('assets/img/mahad/abuubaidah.png') }}" alt="Abu Ubaidah Bin Al Jarrah">
      </div>
      <div class="company-details" style="margin-top: -150px;">
        <h2>Ma'had Abu Ubaidah Bin Al Jarrah Medan</h2>
        <p>Jl. Kutilang No.22, Sei Sikambing B, Kec. Medan Sunggal <br>
          Kota Medan, Sumatera Utara, 20119</p>
        <p>Email: abuubaidahmedan@gmail.com | Telepon: 0811-6144-482</p>
      </div>
    </div>

    <div class="invoice-details">
      <h2>Invoice #{{ $invoice->external_id }}</h2>
      <table>
        <tr>
          <th>Tanggal</th>
          <td>{{ $invoice->updated_at->format('d M Y') }}</td>
        </tr>
        <tr>
          <th>Deskripsi</th>
          <td>{{ $invoice->description }}</td>
        </tr>
        <tr>
          <th>Status</th>
          <td>{{ $invoice->status }}</td>
        </tr>
      </table>
    </div>

    <div class="customer-details">
      <h3>Detail Pelanggan</h3>
      <p>Nama: {{ $invoice->payer_name }}</p>
      <p>Email: {{ $invoice->payer_email }}</p>
      <p>Nomor Telepon: {{ $user->phone }}</p>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th style="text-align: left;">Item</th>
          <th class="text-right">Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Pendaftaran {{ $invoice->description }}</td>
          <td class="text-right">Rp{{ number_format($invoice->amount, 0, ',', '.') }},-</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th class="text-right">Total</th>
          <th class="text-right">Rp{{ number_format($invoice->amount, 0, ',', '.') }},-</th>
        </tr>
      </tfoot>
    </table>

    <div class="footer">
      <p>&copy; {{ date('Y') }} Abu Ubaidah Bin Al Jarrah Medan. All rights reserved.</p>
    </div>
  </div>
</body>

</html>
