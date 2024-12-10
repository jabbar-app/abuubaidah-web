@extends('admin.main')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h2>Send WhatsApp Message Test</h2>

    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif

    <form action="{{ route('whatsapp.send') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required>
        @error('phone')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="message">Message:</label>
        <textarea id="message" name="message" class="form-control" required>{{ old('message') }}</textarea>
        @error('message')
          <span class="text-danger">{{ $message }}</span>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Send</button>
    </form>
  </div>
@endsection
