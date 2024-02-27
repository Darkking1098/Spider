@php
    $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard', 'link' => url('admin')], ['title' => 'Pages', 'link' => url('admin/page')], ['title' => 'Create Page']];
    if (isset($group)) {
        $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard', 'link' => url('admin')], ['title' => 'Groups', 'link' => url('admin/page/group')], ['title' => 'Group - ' . $group['id'], 'link' => url('admin/page/group/' . $group['id'])], ['title' => 'Update Group']];
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
                <h5 class="panel_title">Group Basic Info</h5>
                <p class="panel_desc">Just normal things to create a new group</p>
                <fieldset>
                    <div class="field">
                        <label for="group_title">Group Title</label>
                        <input type="text" name="group_title" id="group_title" placeholder="Group Title"
                            value="{{ $group['page_group_title'] ?? '' }}" required>
                        @error('group_title')
                            <i class="field_error text error">
                                <i class="fa-solid fa-bug"></i>
                                <span>{{ $message }}</span>
                            </i>
                        @enderror
                    </div>
                    <div class="field">
                        <label for="group_index">Group Index</label>
                        <input type="number" name="group_index" id="group_index" required min="1"
                            placeholder="Group Index" value="{{ $group['page_group_index'] ?? '' }}">
                        @error('group_index')
                            <i class="field_error text error">
                                <i class="fa-solid fa-bug"></i>
                                <span>{{ $message }}</span>
                            </i>
                        @enderror
                    </div>
                </fieldset>
            </section>
            <fieldset class="cflex">
                <label for="group_status" class="checkbox_field">
                    <input type="checkbox" name="group_status" id="group_status" value="1" @checked($group['page_group_status'] ?? true)>
                    <span>Group is available to use</span>
                </label>
                <label for="can_delete" class="checkbox_field">
                    <input type="checkbox" name="can_delete" id="can_delete" value="1" @checked($group['can_delete'] ?? true)>
                    <span>Deletable</span>
                </label>
            </fieldset>
        </x-Spider::admin.form>
    </main>
@endsection
@prepend('js')
    <script></script>
@endprepend
