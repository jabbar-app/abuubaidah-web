<div class="card bg-transparent shadow-none my-4 border-0">
  <div class="card-body row p-0 pb-3">
    <div class="col-12 col-md-8 card-separator">
      <h3>Salam, {{ Auth::user()->name }} 👋🏻</h3>
      <div class="col-12">
        <p>Selamat datang di Ma'had Abu Ubaidah Bin Al Jarrah, <br> <em>Lembaga Pendidikan Bahasa Arab & Studi
            Islam!</em></p>
      </div>
      <div class="d-flex justify-content-between flex-wrap gap-3 me-5 mt-4">
        <div class="d-flex align-items-center gap-3 me-4 me-sm-0">
          <span class="bg-label-info p-2 rounded">
            <i class="ti ti-device-laptop ti-xl"></i>
          </span>
          <div class="content-right">
            <p class="mb-0 text-primary">Kelas Terdaftar</p>
            <h4 class="text-primary mb-0">{{ $activeKelasCount }}</h4>
          </div>
        </div>
        <div class="d-flex align-items-center gap-3">
          <span class="bg-label-info p-2 rounded">
            <i class="ti ti-discount-check ti-xl"></i>
          </span>
          <div class="content-right">
            <p class="mb-0 text-primary">Status Akun</p>
            <h4 class="text-primary mb-0">
              @if ($user->status)
                Aktif
              @else
                Ditangguhkan
              @endif
            </h4>
          </div>
        </div>
        <div class="d-flex align-items-center gap-3">
          <span class="bg-label-info p-2 rounded">
            <i class="ti ti-bulb ti-xl"></i>
          </span>
          <div class="content-right">
            <p class="mb-0 text-primary">Kelengkapan Profil</p>
            <h4 class="text-primary mb-0">{{ $profileCompletenessPercentage }}%</h4>
          </div>
        </div>
      </div>
    </div>
    @if (!empty($main))
      <div class="col-12 col-md-4 ps-md-3 ps-lg-4 pt-5 pt-md-0">
        <div class="card bg-primary text-white mb-3">
          <div class="card-header">Pengumuman!</div>
          <div class="card-body">
            <h4 class="card-title text-white">{{ $main->title }}</h4>
            <p class="card-text">{{ $main->description }}</p>
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
<!-- Hour chart End  -->

<div class="alert alert-info alert-dismissible" role="alert">
  <span class="alert-icon text-info me-2">
    <i class="ti ti-bell ti-xs"></i>
  </span>
  Apabila kamu memiliki kendala, silakan klik <a href="{{ route('student.helps.create') }}" class="text-primary" style="font-weight: 600;">di sini untuk buat laporan kendala</a>.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@if (!$payments->isEmpty())
  <div class="alert alert-danger alert-dismissible" role="alert">
    <span class="alert-icon text-danger me-2">
      <i class="ti ti-bell ti-xs"></i>
    </span>
    Kamu memiliki tagihan yang belum dibayar! <a href="/my-transaction" class="text-danger"
      style="font-weight: 600;">Klik disini untuk
      melihat</a>.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif


@if (!empty($announcements))
  @foreach ($announcements as $announce)
    <div class="alert alert-info alert-dismissible" role="alert">
      <span class="alert-icon text-info me-2">
        <i class="ti ti-bell ti-xs"></i>
      </span>
      {{ $announce->title . ' | ' . $announce->description }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endforeach
@endif
