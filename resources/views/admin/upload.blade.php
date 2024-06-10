<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Upload NIM Excel</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
</head>

<body>
  <div class="container mt-5">
    <h2>Upload NIM Excel File</h2>
    <form action="{{ route('upload.nims') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="file">Choose Excel File</label>
        <input type="file" name="excel_file" class="form-control" id="file" required>
      </div>
      <button type="submit" class="btn btn-primary">Upload</button>
    </form>
    @if (session('success'))
      <div class="alert alert-success mt-3">
        {{ session('success') }}
      </div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger mt-3">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <h2 class="mt-5">NIMs Data</h2>
    <button id="resetButton" class="btn btn-danger mb-3">Reset Data</button>
    <table id="nimsTable" class="display" style="width:100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>NIM</th>
          <th>Name</th>
          <th>Is Registered</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
  <!-- Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      var table = $('#nimsTable').DataTable({
        ajax: {
          url: '{{ route("nims.data") }}',
          dataSrc: ''
        },
        columns: [
          { data: 'id' },
          { data: 'nim' },
          { data: 'name' },
          { data: 'is_registered' }
        ]
      });

      $('#resetButton').click(function() {
        if (confirm('Are you sure you want to delete all data?')) {
          $.ajax({
            url: '{{ route("nims.reset") }}',
            type: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
              alert('All data deleted successfully.');
              table.ajax.reload();
            },
            error: function(err) {
              console.error(err);
              alert('An error occurred while deleting data.');
            }
          });
        }
      });
    });
  </script>
</body>

</html>
