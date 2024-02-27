@php
    $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard']];
@endphp
@extends('Spider::admin.assets.layout')
@prepend('css')
@endprepend
@section('main')
    <main>
        <x-Spider::admin.breadcrumb :path="$path"></x-Spider::admin.breadcrumb>
    </main>
@endsection
@prepend('js')
@endprepend
