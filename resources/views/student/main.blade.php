@extends('layouts.main')

@section('contents')
  <div class="layout-container">
    @include('student.sidebar')

    <!-- Layout container -->
    <div class="layout-page">
      @include('student.navbar')

      <!-- Content wrapper -->
      @yield('content')
      <!-- Content wrapper -->
    </div>
    <!-- / Layout page -->
  </div>
@endsection
