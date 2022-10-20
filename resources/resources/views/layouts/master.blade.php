@extends('layouts.UserLayouts')

@section('content')
    <!-- Main sidebar -->
    @include('mail::include.sidebar')
    <!-- /main sidebar -->


    <!-- Main content -->
    <div class="content-wrapper">

    @yield('contetn-warpper')

    </div>
    <!-- /main content -->
@endsection
