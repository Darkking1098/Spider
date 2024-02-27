@php
    $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard', 'link' => url('admin')], ['title' => 'All Groups']];
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
                        <th>Group Title</th>
                        <th>Group Index</th>
                        <th>Group Pages</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            @endslot
            @slot('tbody')
                <tbody>
                    @foreach ($groups as $i => $group)
                        <tr @class(['disabled' => !$group['page_group_status']])>
                            <th class="min">{{ $i + 1 }}</th>
                            <td>{{ $group['page_group_title'] }}</td>
                            <td>{{ $group['page_group_index'] }}</td>
                            <td><a href="{{ url('admin/page?group=' . $group['id']) }}">{{ $group['admin_pages_count'] }}
                                    Pages</a>
                            </td>
                            <td class="actions">
                                <span class="toggle_btn" data-api="{{ url('api/admin/page/group/' . $group['id'] . '/toggle') }}">
                                    <i class="icon text error bg-error fa-solid fa-eye-slash"
                                        title="Page is disabled. Click to active"></i>
                                    <i class="icon text success bg-success fa-solid fa-eye"
                                        title="Page is active. Click to disable"></i>
                                </span>
                                <i class="icon text error bg-error fa-solid fa-trash vu-btn-menu delete_btn" title="Delete Page"
                                    data-api="{{ url('api/admin/page/group/' . $group['id'] . '/delete') }}">
                                    <div class="vu-menu">
                                        <div class="vu-menu-item delete_btn"
                                            data-api="{{ url('api/admin/page/group/' . $group['id'] . '/delete') }}">Delete
                                        </div>
                                        <div class="vu-menu-item delete_btn"
                                            data-api="{{ url('api/admin/page/group/' . $group['id'] . '/delete?force=1') }}"
                                            data-force="true">Force Delete</div>
                                    </div>
                                </i>
                                <a href="{{ url('admin/page/group/' . $group['id'] . '/update') }}">
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
