@extends('auth.main')

@section('content')
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
        <!-- Forgot Password -->
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
            <h4 class="mb-1 pt-2">Lupa password? 🔒</h4>
            <p class="mb-4">Jangan khawatir! Input email kamu di form berikut dan kami akan kirimkan link untuk mengatur
              ulang kata sandi kamu.</p>

            <!-- Display Success Message -->
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @endif

            <!-- Display Error Message -->
            {{-- @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif --}}

            <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('password.email') }}">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="nama@email.com"
                  value="{{ old('email') }}" autofocus />
                @error('email')
                  <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
              </div>
              <button class="btn btn-primary d-grid w-100" type="submit">Submit</button>
            </form>
            <div class="text-center">
              <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
                Kembali ke Login
              </a>
            </div>
          </div>
        </div>
        <!-- /Forgot Password -->
      </div>
    </div>
  </div>
@endsection
