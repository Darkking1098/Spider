@extends('Spider::components.VectorBaseLayout', [
    'title' => $admin['admin_role']['role_title'] . ' Panel',
    'keywords' => 'Admin keywords',
    'description' => 'Admin description',
])
@prepend('css')
    <link rel="stylesheet" href="{{ url('vector/css/admin/style.css') }}">
    <style>
        section.panel {
            padding: 20px;
            box-shadow: 0 0 20px 0 #00000022;
            border-radius: 8px;
            background: white;
        }
    </style>
@endprepend
@push('meta')
    <meta organization="Vector" />
    <meta panel="Spider" />
@endpush
@section('body_content')
    <x-Spider::popup></x-Spider::popup>
    <x-Spider::admin.loader msg="Loading Dashboard..."></x-Spider::admin.loader>
    <div class="vu-layout vu-sidebar-layout">
        @include('Spider::admin.assets.sidebar')
        <div class="main_content">
            @includeIf('Spider::admin.assets.header')
            @yield('main')
            @includeIf('Spider::admin.assets.footer')
        </div>
    </div>
@endsection
