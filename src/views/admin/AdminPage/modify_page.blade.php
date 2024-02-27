@php
    $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard', 'link' => url('admin')], ['title' => 'Pages', 'link' => url('admin/page')], ['title' => 'Create Page']];
    if (isset($page)) {
        $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard', 'link' => url('admin')], ['title' => 'Pages', 'link' => url('admin/page')], ['title' => 'Page - ' . $page['id'], 'link' => url('admin/page/' . $page['id'])], ['title' => 'Update Page']];
    }
@endphp
@extends('Spider::admin.assets.layout')
@prepend('css')
    <style></style>
@endprepend
@section('main')
    <main>
        <x-Spider::admin.breadcrumb :path="$path"></x-Spider::admin.breadcrumb>
        <x-Spider::admin.form>
            <section class="panel">
                <h5 class="panel_title">Page Basic Info</h5>
                <p class="panel_desc">Just normal things to create a new page</p>
                <fieldset class="cflex">
                    <div class="field">
                        <label for="page_uri">Page URI</label>
                        <input type="text" name="page_uri" id="page_uri" placeholder="Page URI"
                            value="{{ $page['page_uri'] ?? '' }}" required>
                        @error('page_uri')
                            <i class="field_error text error">
                                <i class="fa-solid fa-bug"></i>
                                <span>{{ $message }}</span>
                            </i>
                        @enderror
                    </div>
                    <fieldset>
                        <div class="field">
                            <label for="page_title">Page Title</label>
                            <input type="text" name="page_title" id="page_title" placeholder="Page Title"
                                value="{{ $page['page_title'] ?? '' }}" required>
                            @error('page_title')
                                <i class="field_error text error">
                                    <i class="fa-solid fa-bug"></i>
                                    <span>{{ $message }}</span>
                                </i>
                            @enderror
                        </div>
                        <div class="field">
                            <label for="page_group">Page Group</label>
                            <select name="page_group" id="page_group">
                                @foreach ($groups as $group)
                                    <option value="{{ $group['id'] }}" @selected($group['id'] == ($page['page_group_id'] ?? 0))>
                                        {{ $group['page_group_title'] }}</option>
                                @endforeach
                            </select>
                            @error('page_group')
                                <i class="field_error text error">
                                    <i class="fa-solid fa-bug"></i>
                                    <span>{{ $message }}</span>
                                </i>
                            @enderror
                        </div>
                    </fieldset>
                    <div class="field">
                        <label for="page_uri_desc">Page URI Description</label>
                        <textarea name="page_uri_desc" id="page_uri_desc" placeholder="Page Title">{{ $page['page_uri_desc'] ?? '' }}</textarea>
                        @error('page_uri_desc')
                            <i class="field_error text error">
                                <i class="fa-solid fa-bug"></i>
                                <span>{{ $message }}</span>
                            </i>
                        @enderror
                    </div>
                </fieldset>
            </section>
            <fieldset class="cflex">
                <label for="permission_required" class="checkbox_field">
                    <input type="checkbox" name="permission_required" id="permission_required" value="1"
                        @checked($page['permission_required'] ?? true)>
                    <span>Permission is required to access this page</span>
                </label>
                <label for="can_display" class="checkbox_field">
                    <input type="checkbox" name="can_display" id="can_display" value="1" @checked($page['page_can_display'] ?? false)>
                    <span>Display page in sidebar</span>
                </label>
                <label for="page_status" class="checkbox_field">
                    <input type="checkbox" name="page_status" id="page_status" value="1" @checked($page['page_status'] ?? true)>
                    <span>Page is available to use</span>
                </label>
                <label for="can_delete" class="checkbox_field">
                    <input type="checkbox" name="can_delete" id="can_delete" value="1" @checked($page['can_delete'] ?? true)>
                    <span>Deletable</span>
                </label>
            </fieldset>
        </x-Spider::admin.form>
    </main>
@endsection
@prepend('js')
    <script></script>
@endprepend
