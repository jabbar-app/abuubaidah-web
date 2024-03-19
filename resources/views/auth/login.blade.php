@extends('auth.main')

@section('content')
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner py-4">
        <!-- Login -->
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
            <h4 class="mb-1 pt-2">Assalamu'alaykum! 👋</h4>
            <p class="mb-4">Silakan input email dan password kamu untuk melanjutkan.</p>

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="formAuthentication" class="mb-3">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="email@domain.com" autofocus />
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                  @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                      <small>Lupa Password?</small>
                    </a>
                  @endif
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                  <small class="input-group-text cursor-pointer" style="font-size: 12px;">lihat</small>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                  <label class="form-check-label" for="remember-me"> Ingat saya </label>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">بِسْمِ اللَّهِ</button>
              </div>
            </form>

            <p class="text-center">
              <span>Belum punya akun?</span>
              <a href="{{ route('register') }}">
                <span>Daftar</span>
              </a>
            </p>

            <div class="divider my-4">
              <div class="divider-text">Atau</div>
            </div>

            <div class="d-flex justify-content-center">
              {{-- <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                                <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                                <i class="tf-icons fa-brands fa-google fs-5"></i>
                            </a> --}}

              <a href="https://abuubaidah.com/" class="small">
                {{-- <i class="tf-icons fa-brands fa-twitter fs-5"></i> --}}
                Kembali ke Landing Page
              </a>
            </div>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>
@endsection
