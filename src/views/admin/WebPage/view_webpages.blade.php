@php
    $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard', 'link' => url('admin')], ['title' => 'All WebPages']];
@endphp
@extends('Spider::admin.assets.layout')
@section('main')
    <main>
        <x-Spider::admin.breadcrumb :path="$path"></x-Spider::admin.breadcrumb>
        <x-Spider::admin.table>
            @slot('thead')
                <thead>
                    <tr>
                        <th class="min">Sr.</th>
                        <th>Page Title</th>
                        <th>Page Slug</th>
                        <th>Page Loaded</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            @endslot
            @slot('tbody')
                <tbody>
                    @foreach ($webPages as $i => $page)
                        <tr @class(['disabled' => !$page['webpage_status']])>
                            <th class="min">{{ $i + 1 }}</th>
                            <td>{{ $page['webpage_title'] }}</td>
                            <td><a href="{{ url($page['webpage_slug']) }}">
                                    {{ $page['webpage_slug'] }}</a>
                            </td>
                            <td>{{ $page['load_count'] }}</td>
                            <td class="actions">
                                <span class="toggle_btn" data-api="{{ url('api/admin/webpage/' . $page['id'] . '/toggle') }}">
                                    <i class="icon text error bg-error fa-solid fa-eye-slash"
                                        title="Page is disabled. Click to active"></i>
                                    <i class="icon text success bg-success fa-solid fa-eye"
                                        title="Page is active. Click to disable"></i>
                                </span>
                                <i class="icon text error bg-error fa-solid fa-trash vu-btn-menu delete_btn" title="Delete Page"
                                    data-api="{{ url('api/admin/webpage/' . $page['id'] . '/delete') }}">
                                    <div class="vu-menu">
                                        <div class="vu-menu-item delete_btn"
                                            data-api="{{ url('api/admin/webpage/' . $page['id'] . '/delete') }}">Delete</div>
                                        <div class="vu-menu-item delete_btn"
                                            data-api="{{ url('api/admin/webpage/' . $page['id'] . '/delete?force=1') }}"
                                            data-force="true">Force Delete</div>
                                    </div>
                                </i>
                                <a href="{{ url('admin/webpage/' . $page['id'] . '/update') }}">
                                    <i class="icon text prime bg-prime fa-solid fa-square-pen" title="Edit Page"></i>
                                </a>
                                <i class="icon fa-solid fa-ellipsis-vertical menu_btn" title="Show options"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endslot
        </x-Spider::admin.table>
    </main>
@endsection
