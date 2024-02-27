@php
    $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard']];
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
                        <th>Role</th>
                        <th>Role Desc</th>
                        <th>Holders</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            @endslot
            @slot('tbody')
                <tbody>
                    @foreach ($roles as $i => $role)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{$role['role_title']}}</td>
                            <td>{{$role['role_desc']}}</td>
                            <td>{{$role['employees_count']}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            @endslot
        </x-Spider::admin.table>
    </main>
@endsection
@prepend('js')
@endprepend
