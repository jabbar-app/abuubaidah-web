@extends('auth.main')

@section('content')
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
        <!-- Reset Password -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-4 mt-2">
              <a href="/" class="app-brand-link gap-2">
                <img src="{{ asset('assets/img/mahad/abuubaidah.svg') }}" alt="Abu Ubaidah" width="10%">
                <span class="app-brand-text demo text-body fw-bold ms-1">Ma'had Abu Ubaidah <br>Bin Al Jarrah</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-1 pt-2">Reset Password 🔒</h4>
            <p class="mb-4">Enter your email address and new password to reset your password.</p>

            <!-- Display Success Message -->
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @endif

            <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('password.store') }}">
              @csrf

              <!-- Password Reset Token -->
              <input type="hidden" name="token" value="{{ $request->route('token') }}">

              <!-- Email Address -->
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"
                  value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
                @error('email')
                  <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
              </div>

              <!-- Password -->
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required
                  autocomplete="new-password" />
                @error('password')
                  <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
              </div>

              <!-- Confirm Password -->
              <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                  required autocomplete="new-password" />
                @error('password_confirmation')
                  <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
              </div>

              <button class="btn btn-primary d-grid w-100" type="submit">Reset Password</button>
            </form>
            <div class="text-center">
              <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
                Kembali ke Login
              </a>
            </div>
          </div>
        </div>
        <!-- /Reset Password -->
      </div>
    </div>
  </div>
@endsection
