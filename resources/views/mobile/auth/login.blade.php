@extends('mobile.main')

@section('content')
  <div id="content">
    <header class="default heade-sticky d-flex justify-content-center mt-4">
      {{-- <div class="un-title-page go-back">
        <a href="app-pages.html" class="icon">
          <i class="ri-arrow-drop-left-line"></i>
        </a>
        <h1></h1>
      </div>
      <div class="un-block-right">
        <a href="{{ route('mobile.register.show') }}" class="btn nav-link text-primary size-14 weight-500 pe-0">Buat
          Akun</a>
      </div> --}}

      <img src="{{ asset('assets/img/mahad/abuubaidah.svg') }}" alt="Abu Ubaidah" width="15%">
    </header>
    <div class="space-sticky"></div>

    <form action="{{ route('mobile.login') }}" method="POST">
      @csrf
      <section class="account-section p-4 mt-5">
        <div class="display-title text-center mt-4">
          <h1>Assalamu'alaykum! 👋</h1>
          <p>Silakan input email dan password kamu untuk melanjutkan.</p>
        </div>
        {{-- <div class="connect-with-apps">
          <a href="#" class="apple">
            <i class="ri-apple-fill"></i>
          </a>
          <a href="#" class="google">
            <img src="images/icons/google.svg" alt="google">
          </a>
          <a href="#" class="facebook">
            <i class="ri-facebook-circle-fill"></i>
          </a>
        </div>
        <div class="dividar_or">
          <span>or</span>
        </div> --}}
        <div class="content__form margin-t-24">
          <div class="form-group icon-left">
            <label>Email</label>
            <div class="input_group">
              <input type="email" class="form-control" placeholder='e. g. "example@mail.com"' required>
              <div class="icon">
                <i class="ri-mail-open-line"></i>
              </div>
            </div>
          </div>
          <div class="form-group icon-left">
            <label>Password</label>
            <div class="input_group">
              <input type="password" class="form-control" placeholder='e. g. "Pass$99*04"' required>
              <div class="icon">
                <i class="ri-lock-password-line"></i>
              </div>
            </div>
            <a href="page-reset-password.html"
              class="text-primary size-13 margin-t-14 d-block text-decoration-none weight-500">Lupa Password?</a>
          </div>
        </div>
      </section>

      <footer class="footer-account">
        <div class="env-pb">
          <div class="display-actions">
            <a href="{{ route('mobile.login') }}" class="btn btn-sm-arrow bg-primary">
              <p>Masuk بِسْمِ اللَّهِ</p>
              <div class="ico">
                <i class="ri-arrow-drop-right-line"></i>
              </div>
            </a>
          </div>
          <div class="dividar"></div>
          <div class="support">
            <p>Belum punya akun? <a href="{{ route('mobile.register.show') }}">Daftar</a></p>
          </div>
        </div>
      </footer>

    </form>
  </div>
@endsection
