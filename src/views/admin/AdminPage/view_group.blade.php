@php
    $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard', 'link' => url('admin')], ['title' => 'Groups', 'link' => url('admin/page/group')], ['title' => 'View Group']];
@endphp
@extends('Spider::admin.assets.layout')
@prepend('css')
    <style></style>
@endprepend
@section('main')
    <main>
        <x-Spider::admin.breadcrumb :path="$path"></x-Spider::admin.breadcrumb>
    </main>
@endsection
@prepend('js')
    <script></script>
@endprepend
