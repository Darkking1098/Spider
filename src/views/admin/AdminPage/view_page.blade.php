@php
    $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard', 'link' => url('admin')], ['title' => 'Pages', 'link' => url('admin/page')], ['title' => 'View Page']];
@endphp
@extends('Spider::admin.assets.layout')
@prepend('css')
    <style>
        section.panel {
            margin-bottom: 20px;
        }

        section.panel .page_desc {
            font-size: 0.9em;
            margin-top: 7px;
            font-weight: 600;
        }

        .btn-tert {
            background: rgba(var(--error_rgb, 0.5));
        }

        .btn-sec {
            background: rgba(var(--success_rgb), 0.5);
        }

        .btn-sec.disabled {
            background: rgba(var(--error_rgb), 0.5);
        }

        .btn-sec:not(.disabled) span:last-of-type,
        .btn-sec.disabled span:first-of-type {
            display: none
        }

        .btn-prime {
            background: rgba(var(--info_rgb), 0.5);
        }
    </style>
@endprepend
@section('main')
    <main>
        <x-Spider::admin.breadcrumb :path="$path"></x-Spider::admin.breadcrumb>
        <section class="panel">
            <h5 class="page_info">{{ $page['id'] }}.{{ $page['page_title'] }} <i class="text info"><a href="">#
                        {{ $page['admin_page_group']['page_group_title'] }}</a></i></h5>
            <p class="page_desc">{{ $page['page_uri_desc'] }}</p>
        </section>
        <x-Spider::admin.table>
            @slot('thead')
                <thead>
                    <tr>
                        <th>Attribute</th>
                        <th>Uses</th>
                        <th>Value</th>
                    </tr>
                </thead>
            @endslot
            @slot('tbody')
                <tbody>
                    <tr>
                        <td>Page Title</td>
                        <td>Shows in sidebar</td>
                        <td>{{ $page['page_title'] }}</td>
                    </tr>
                    <tr>
                        <td>Page Group Id</td>
                        <td>Group pages together</td>
                        <td>{{ $page['page_group_id'] }}</td>
                    </tr>
                    <tr>
                        <td>Page URI</td>
                        <td>To control permission</td>
                        <td>{{ $page['page_uri'] }}</td>
                    </tr>
                    <tr>
                        <td>Page Desc</td>
                        <td>To describe about uri</td>
                        <td>{{ $page['page_uri_desc'] }}</td>
                    </tr>
                    <tr>
                        <td>Page Can Display</td>
                        <td>Display in sidebar or not. Dynamic pages must be hidden.</td>
                        <td>{{ $page['page_can_display'] }} <i class="info text">(0-Hide 1-Display)</i></td>
                    </tr>
                    <tr>
                        <td>Page Status</td>
                        <td>To Restrict access for every user</td>
                        <td>{{ $page['page_status'] }} <i class="info text">(0-Restrict 1-Allow)</i></td>
                    </tr>
                    <tr>
                        <td>Permission Requires</td>
                        <td>Some Pages can be used by everyone. So no extra permission.</td>
                        <td>{{ $page['permission_required'] }} <i class="info text">(0-No 1-Yes)</i></td>
                    </tr>
                </tbody>
            @endslot
        </x-Spider::admin.table>
    </main>
@endsection
@prepend('js')
    <script></script>
@endprepend
