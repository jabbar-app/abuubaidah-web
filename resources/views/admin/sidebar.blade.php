<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="/" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="{{ asset('assets/img/mahad/abuubaidah.svg') }}" alt="Abu Ubaidah" width="50%">
      </span>
      <span class="app-brand-text demo menu-text fw-bold">Abu Ubaidah</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
      <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <li class="menu-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-id"></i>
        <div data-i18n="Dashboard">Dashboard</div>
      </a>
    </li>
    <!-- Apps & Pages -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text" data-i18n="Manajemen Data">Manajemen Data</span>
    </li>
    @if (Auth::user()->hasRole('Super Admin'))
      <li class="menu-item {{ Request::is('programs*') ? 'active' : '' }}">
        <a href="{{ route('programs.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-book"></i>
          <div data-i18n="Data Program">Data Program</div>
        </a>
      </li>
      <li class="menu-item {{ Request::is('users*') ? 'active' : '' }}">
        <a href="{{ route('users.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-user"></i>
          <div data-i18n="Data User">Data User</div>
        </a>
      </li>
      <li class="menu-item {{ Request::is('announcements*') ? 'active' : '' }}">
        <a href="{{ route('announcements.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-book"></i>
          <div data-i18n="Data Pengumuman">Data Pengumuman</div>
        </a>
      </li>
      <li class="menu-item {{ Request::is('results*') ? 'active' : '' }}">
        <a href="{{ route('results.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-lamp"></i>
          <div data-i18n="Hasil Ujian">Hasil Ujian</div>
        </a>
      </li>
      <li class="menu-item {{ Request::is('kelas*', 'admin/kelas*') ? 'active' : '' }}">
        <a href="{{ route('admin.kelas.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-book"></i>
          <div data-i18n="Data Kelas">Data Kelas</div>
        </a>
      </li>
    @elseif(Auth::user()->hasRole('Accountant'))
      <li class="menu-item {{ Request::is('payments*') ? 'active' : '' }}">
        <a href="{{ route('payments.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-file-dollar"></i>
          <div data-i18n="Data Transaksi">Data Transaksi</div>
        </a>
      </li>
    @endif
    @if (Auth::user()->hasRole('Super Admin'))
      <li class="menu-item {{ Request::is('payments*') ? 'active' : '' }}">
        <a href="{{ route('payments.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-file-dollar"></i>
          <div data-i18n="Data Transaksi">Data Transaksi</div>
        </a>
      </li>
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Manajemen Program</span>
      </li>
      <li
        class="menu-item {{ Request::is('tahsins*', 'tahfizs*', 'bilhaqs*', 'kibas*', 'lughohs*', 'fais*', 'stebis*') ? 'open' : '' }}">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-brand-tabler"></i>
          <div data-i18n="Edit Program">Edit Program</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ Request::is('tahsins*') ? 'active' : '' }}">
            <a href="{{ route('tahsins.index') }}" class="menu-link">
              <div data-i18n="Tahsin">Tahsin</div>
            </a>
          </li>
          <li class="menu-item {{ Request::is('tahfizs*') ? 'active' : '' }}">
            <a href="{{ route('tahfizs.index') }}" class="menu-link">
              <div data-i18n="Tahfiz">Tahfiz</div>
            </a>
          </li>
          <li class="menu-item {{ Request::is('bilhaqs*') ? 'active' : '' }}">
            <a href="{{ route('bilhaqs.index') }}" class="menu-link">
              <div data-i18n="Bilhaq">Bilhaq</div>
            </a>
          </li>
          <li class="menu-item {{ Request::is('kibas*') ? 'active' : '' }}">
            <a href="{{ route('kibas.index') }}" class="menu-link">
              <div data-i18n="KIBA">KIBA</div>
            </a>
          </li>
          <li class="menu-item {{ Request::is('lughohs*') ? 'active' : '' }}">
            <a href="{{ route('lughohs.index') }}" class="menu-link">
              <div data-i18n="Lughoh">Lughoh</div>
            </a>
          </li>
          <li class="menu-item {{ Request::is('fais*') ? 'active' : '' }}">
            <a href="{{ route('fais.index') }}" class="menu-link">
              <div data-i18n="FAI">FAI</div>
            </a>
          </li>
          <li class="menu-item {{ Request::is('stebis*') ? 'active' : '' }}">
            <a href="{{ route('stebis.index') }}" class="menu-link">
              <div data-i18n="Stebis">Stebis</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item {{ Request::is('helps*') ? 'active' : '' }}">
        <a href="{{ route('helps.index') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-file-description"></i>
          <div data-i18n="Laporan Kendala">Laporan Kendala</div>
        </a>
      </li>
    @endif
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text" data-i18n="Akun">Akun</span>
    </li>
    <li class="menu-item {{ Request::routeIs('profile.edit') ? 'active' : '' }}">
      <a href="#" class="menu-link">
        {{-- <a href="{{ route('profile.edit') }}" class="menu-link"> --}}
        <i class="menu-icon tf-icons ti ti-user"></i>
        <div data-i18n="Edit Profil">Edit Profil</div>
      </a>
    </li>
    <li class="menu-item">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="{{ route('logout') }}" class="menu-link"
          onclick="event.preventDefault(); this.closest('form').submit();">
          <i class="menu-icon tf-icons ti ti-power"></i>
          <div data-i18n="Logout">Logout</div>
        </a>
      </form>
    </li>
  </ul>
</aside>
<!-- / Menu -->
