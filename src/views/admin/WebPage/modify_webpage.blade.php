@php
    $path = [
        ['title' => $admin['admin_role']['role_title'] . ' Dashboard', 'link' => url('admin')],
        ['title' => 'WebPages', 'link' => url('admin/page')],
        ['title' => 'Create Page'],
    ];
    if (isset($webPage)) {
        $path = [
            ['title' => $admin['admin_role']['role_title'] . ' Dashboard', 'link' => url('admin')],
            ['title' => 'WebPages', 'link' => url('admin/page')],
            ['title' => 'WebPage - ' . $webPage['id'], 'link' => url('admin/page/' . $webPage['id'])],
            ['title' => 'Update Page'],
        ];
    }
@endphp
@extends('Spider::admin.assets.layout')
@section('main')
    <main>
        <x-Spider::admin.breadcrumb :path="$path"></x-Spider::admin.breadcrumb>
        <x-Spider::admin.form>
            @include('Spider::admin.WebPage.modify_webpage_component', ['webPage' => $webPage ?? []])
        </x-Spider::admin.form>
    </main>
@endsection
