@extends('Spider::components.VectorBaseLayout')
@section('body_content')
    @includeIf('user.assets.header')
    @yield('main')
    @includeIf('user.assets.footer')
@endsection
