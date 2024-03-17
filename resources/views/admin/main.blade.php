@extends('layouts.main')

@section('contents')
  <div class="layout-container">
    @include('admin.sidebar')

    <!-- Layout container -->
    <div class="layout-page">
      @include('admin.navbar')

      <!-- Content wrapper -->
      @yield('content')
      <!-- Content wrapper -->
    </div>
    <!-- / Layout page -->
  </div>
@endsection
