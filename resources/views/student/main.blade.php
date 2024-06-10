@extends('layouts.main')

@section('contents')
  <div class="layout-container">
    @if (Auth::user()->roles->count() > 0)
      @include('admin.sidebar')
    @else
      @include('student.sidebar')
    @endif

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
