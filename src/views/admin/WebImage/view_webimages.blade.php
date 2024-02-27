@php
    $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard', 'link' => url('admin')], ['title' => 'Pages', 'link' => url('admin/page')], ['title' => 'Create Page']];
@endphp
@extends('Spider::admin.assets.layout')
@prepend('css')
@endprepend
@section('main')
    <main>
        <x-Spider::admin.breadcrumb :path="$path"></x-Spider::admin.breadcrumb>
        <x-Spider::admin.table>
            @slot('thead')
                <thead>
                    <tr>
                        <th class="min">Sr.</th>
                        <th>Webimage Slug</th>
                        <th>Webimage Alt</th>
                        <th>Preview</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            @endslot
            @slot('tbody')
                <tbody>
                    @foreach ($webImages as $i => $webImage)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $webImage['webimage_slug'] }}</td>
                            <td>{{ $webImage['webimage_alt'] }}</td>
                            <td>Preview</td>
                            </td>
                            <td class="actions">
                                <span class="toggle_btn"
                                    data-api="{{ url('api/admin/webimage/' . $webImage['id'] . '/toggle') }}">
                                    <i class="icon text error bg-error fa-solid fa-eye-slash"
                                        title="Page is disabled. Click to active"></i>
                                    <i class="icon text success bg-success fa-solid fa-eye"
                                        title="Page is active. Click to disable"></i>
                                </span>
                                <i class="icon text error bg-error fa-solid fa-trash vu-btn-menu delete_btn" title="Delete Page"
                                    data-api="{{ url('api/admin/webimage/' . $webImage['id'] . '/delete') }}">
                                    <div class="vu-menu">
                                        <div class="vu-menu-item delete_btn"
                                            data-api="{{ url('api/admin/webimage/' . $webImage['id'] . '/delete') }}">Delete
                                        </div>
                                        <div class="vu-menu-item delete_btn"
                                            data-api="{{ url('api/admin/webimage/' . $webImage['id'] . '/delete?force=1') }}"
                                            data-force="true">Force Delete</div>
                                    </div>
                                </i>
                                <a href="{{ url('admin/webimage/' . $webImage['id'] . '/update') }}">
                                    <i class="icon text prime bg-prime fa-solid fa-square-pen" title="Edit Page"></i>
                                </a>
                                <i class="icon fa-solid fa-ellipsis-vertical menu_btn" title="Show options"></i>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @endslot
        </x-admin.table>
    </main>
@endsection
@prepend('js')
@endprepend
