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
    <!-- Apps & Pages -->
    <li class="menu-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-id"></i>
        <div data-i18n="Dashboard">Dashboard</div>
      </a>
    </li>
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text" data-i18n="Manajemen Data">Manajemen Data</span>
    </li>
    <li class="menu-item {{ Request::routeIs('my.program') ? 'active' : '' }}">
      <a href="{{ route('my.program') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-book"></i>
        <div data-i18n="Data Kelas">Data Kelas</div>
      </a>
    </li>
    @if (!empty($student->nim))
      <li class="menu-item {{ Request::is('kartu-hasil-studi*') ? 'active' : '' }}">
        <a href="{{ route('khs') }}" class="menu-link">
          <i class="menu-icon tf-icons ti ti-notebook"></i>
          <div data-i18n="Kartu Hasil Studi">Kartu Hasil Studi</div>
        </a>
      </li>
    @endif
    <li class="menu-item {{ Request::routeIs('my.transaction') ? 'active' : '' }}">
      <a href="{{ route('my.transaction') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-file-dollar"></i>
        <div data-i18n="Status Transaksi">Status Transaksi</div>
      </a>
    </li>

    <li class="menu-item {{ Request::is('laporan*') ? 'active' : '' }}">
      <a href="{{ route('student.helps.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-file-description"></i>
        <div data-i18n="Laporan Kendala">Laporan Kendala</div>
      </a>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text" data-i18n="Akun">Akun</span>
    </li>
    <li class="menu-item {{ Request::routeIs('profile.edit') ? 'active' : '' }}">
      <a href="{{ route('profile.edit') }}" class="menu-link">
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
