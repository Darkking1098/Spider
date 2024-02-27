@php
    $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard', 'link' => url('admin')], ['title' => 'All Pages']];
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
                        <th>Page Group</th>
                        <th>Page URI</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            @endslot
            @slot('tbody')
                <tbody>
                    @foreach ($pages as $i => $page)
                        <tr @class(['disabled' => !$page['page_status']]) data-group="{{ $page['admin_page_group']['id'] }}">
                            <th class="min">{{ $i + 1 }}</th>
                            <td><a href="{{ url('admin/page/' . $page['id']) }}">{{ $page['page_title'] }}</a></td>
                            <td>
                                <a href="{{ url('admin/page/group/' . $page['admin_page_group']['id']) }}">
                                    {{ $page['admin_page_group']['page_group_title'] }}
                                </a>
                            </td>
                            <td>{{ $page['page_uri'] }}</td>
                            <td class="actions">
                                <span class="toggle_btn" data-api="{{ url('api/admin/page/' . $page['id'] . '/toggle') }}">
                                    <i class="icon text error bg-error fa-solid fa-eye-slash"
                                        title="Page is disabled. Click to active"></i>
                                    <i class="icon text success bg-success fa-solid fa-eye"
                                        title="Page is active. Click to disable"></i>
                                </span>
                                <i class="icon text error bg-error fa-solid fa-trash vu-btn-menu delete_btn" title="Delete Page"
                                    data-api="{{ url('api/admin/page/' . $page['id'] . '/delete') }}">
                                    <div class="vu-menu">
                                        <div class="vu-menu-item delete_btn"
                                            data-api="{{ url('api/admin/page/' . $page['id'] . '/delete') }}">Delete</div>
                                        <div class="vu-menu-item delete_btn"
                                            data-api="{{ url('api/admin/page/' . $page['id'] . '/delete?force=1') }}"
                                            data-force="true">Force Delete</div>
                                    </div>
                                </i>
                                <a href="{{ url('admin/page/' . $page['id'] . '/update') }}">
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
@prepend('js')
    <script>
        let url = new URLSearchParams(location.search);
        if (url.has('group')) {
            let g = url.get('group');
            $('tbody tr').VU.perform((x) => {
                if (x.get('data-group') != g) x.addClass('hide');
            })
        }
    </script>
@endprepend
