@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('update.whatsapp.key') }}" method="POST">
      @csrf
      <div class="form-group mb-4">
        <label for="key" class="mb-2">Whatsapp Key:</label>
        <input type="text" name="key" id="key" class="form-control" value="{{ old('key', $key) }}">
      </div>
      <button type="submit" class="btn btn-primary">Update Key</button>
    </form>
  </div>
@endsection
