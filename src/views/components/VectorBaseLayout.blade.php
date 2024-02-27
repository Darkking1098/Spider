@extends('Spider::components.BaseLayout')

@section('styles')
    <!-- Icon Stylesheets -->
    <link rel="stylesheet" href="{{ url('vector/spider/icon/css/all.min.css') }}">
    <!-- Vector Stylesheets -->
    <link rel="stylesheet" href="{{ url('vector/spider/css/style.php') }}">
    @stack('css')
@endsection

@section('body')
    <body>
        @yield('body_content')
        @stack('other')
        <!-- Main Scripts -->
        <script src="{{ url('vector/spider/js/vector.js') }}"></script>
        <!-- Other Scripts -->
        @stack('js')
    </body>
@endsection
