@php
    $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard']];
@endphp
@extends('Spider::admin.assets.layout')
@prepend('css')
    <style>
        .permissions:not(:last-of-type) {
            margin-bottom: 20px;
        }

        .permission {
            font-size: 0.7em;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .permission span {
            display: inline-block;
            margin-left: 7px;
        }
    </style>
@endprepend
@section('main')
    <main>
        <x-Spider::admin.breadcrumb :path="$path"></x-Spider::admin.breadcrumb>
        <x-Spider::admin.form>
            <section class="panel">
                <fieldset class="cflex">
                    <div class="field">
                        <label for="role_title">Role Title</label>
                        <input type="text" name="role_title" id="role_title" value="{{ $role['role_title'] ?? '' }}">
                    </div>
                    <div class="field">
                        <label for="role_desc">Role Description</label>
                        <textarea name="role_desc" id="role_desc">{{ $role['role_desc'] ?? '' }}</textarea>
                    </div>
                </fieldset>
            </section>
            <section class="panel">
                <fieldset class="cflex">
                    @foreach ($groups as $i => $group)
                        @if (count($group['admin_pages']))
                            <fieldset class="permissions">
                                @foreach ($group['admin_pages'] as $j => $page)
                                    <label class="permission" for="per{{ $i }}_{{ $j }}">
                                        <input type="checkbox" name="role_permissions[]"
                                            id="per{{ $i }}_{{ $j }}" value="{{ $page['id'] }}"
                                            @checked(in_array($page['id'], $role['role_permissions'] ?? []) || ($role['role_permissions'] ?? ['x'])[0] == '*')>
                                        <span>{{ $page['page_title'] }}</span>
                                    </label>
                                @endforeach
                            </fieldset>
                        @endif
                    @endforeach
                </fieldset>
            </section>
            <fieldset class="cflex">
                <label for="role_sensitive" class="checkbox_field">
                    <input type="checkbox" name="role_sensitive" id="role_sensitive" value="1"
                        @checked($role['role_sensitive'] ?? false)>
                    <span>Sensitive role</span>
                </label>
                <label for="can_delete" class="checkbox_field">
                    <input type="checkbox" name="can_delete" id="can_delete" value="1" @checked($role['can_delete'] ?? true)>
                    <span>Deletable</span>
                </label>
            </fieldset>
        </x-Spider::admin.form>
    </main>
@endsection
@prepend('js')
@endprepend
