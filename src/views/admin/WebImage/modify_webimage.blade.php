@php
    $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard', 'link' => url('admin')], ['title' => 'Pages', 'link' => url('admin/page')], ['title' => 'Create Page']];
@endphp
@extends('Spider::admin.assets.layout')
@prepend('css')
    <style>
        .theme {
            margin-bottom: 20px;
        }

        .theme .theme_name {
            font-size: 0.9em;
        }

        .theme .varients {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(60px, 80px));
        }

        .theme label {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .theme .varients .preview {
            border: 1px dashed;
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 1;
            position: relative;
        }

        .theme .varients .preview img {
            width: 100%;
            height: 100%;
        }

        .theme .varients .preview>:is(a, i) {
            position: absolute;
            right: 0;
            color: inherit;
            display: inline-flex;
            background: white;
            z-index: 1;
            box-shadow: 0 0 7px 0 #00000033;
        }

        .theme .varients .preview a {
            text-decoration: none;
            bottom: 0;
            border-top-left-radius: 5px;
            font-size: 1.2em;
        }

        .theme .varients .preview>i {
            border-bottom-left-radius: 5px;
        }

        .theme .varients .preview i {
            width: 20px;
            font-size: 0.5em;
            aspect-ratio: 1;
            top: 0;
        }

        .theme label span {
            font-size: 0.7em;
            letter-spacing: 1px;
            font-weight: 600;
            text-align: center;
        }

        button[type="button"] {
            font-size: 0.8em;
            margin-bottom: auto;
        }
    </style>
@endprepend
@section('main')
    <main>
        <x-Spider::admin.breadcrumb :path="$path"></x-Spider::admin.breadcrumb>
        <x-Spider::admin.form>
            <section class="panel">
                <h5 class="panel_title">WebImage Basic Info</h5>
                <p class="panel_desc">Just normal things to upload a new Webimage</p>
                <fieldset class="cflex">
                    <fieldset>
                        <div class="field">
                            <label for="page_slug">Webimage Slug</label>
                            <input type="text" name="webimage_slug" id="" required
                                value="{{ $webImage['webimage_slug'] ?? '' }}">
                        </div>
                        <div class="field">
                            <label for="page_slug">Webimage Alt</label>
                            <input type="text" name="webimage_alt" id="" required
                                value="{{ $webImage['webimage_alt'] ?? '' }}">
                        </div>
                    </fieldset>
                    <div class="field">
                        <label for="page_slug">Webimage Caption</label>
                        <textarea name="webimage_caption">{{ $webImage['webimage_alt'] ?? '' }}</textarea>
                    </div>
                </fieldset>
            </section>
            <section class="panel">
                <h5 class="panel_title">Image To Upload</h5>
                <p class="panel_desc">Upload and preview image</p>
                @foreach ($webImage['webimage_srcset'] ?? ['default' => ['default' => '']] as $theme => $varients)
                    <fieldset class="theme cflex" data-theme="{{ $theme }}">
                        <h6 class="theme_name">{{ $theme }} Theme</h6>
                        <fieldset class="varients">
                            @foreach ($varients as $size => $file)
                                <label for="{{ $theme }}_{{ $size }}_img">
                                    <div class="preview">
                                        <a href="{{ url($file ? 'webimage/' . $file : 'images/temp.webp') }}"
                                            target="_blank">
                                            <i class="icon fa-solid fa-eye"></i>
                                        </a>
                                        @if ($size != 'default')
                                            <i class="icon fa-solid fa-xmark" onclick="removeNode(this)"></i>
                                        @endif
                                        <img src="{{ url($file ? 'webimage/' . $file : 'images/temp.webp') }}"
                                            alt="">
                                    </div>
                                    <div class="hidden">
                                        <input type="hidden" name="images[{{ $theme }}][][size]"
                                            value="{{ $size }}">
                                        <input type="file" name="images[{{ $theme }}][][file]" value=""
                                            id="{{ $theme }}_{{ $size }}_img" onchange="display_pic(this)">
                                    </div>
                                    <span>Default</span>
                                </label>
                            @endforeach
                            <button type="button" class="vu-btn" onclick="addField(this)">Add</button>
                        </fieldset>
                    </fieldset>
                @endforeach
                <button type="button" class="vu-btn" onclick="addTheme(this)">Add Theme</button>
            </section>
            <fieldset class="cflex">
                <label for="webimage_status" class="checkbox_field">
                    <input type="checkbox" name="webimage_status" id="webimage_status" value="1"
                        @checked($webPage['webimage_status'] ?? true)>
                    <span>Page is available to use</span>
                </label>
                <label for="can_delete" class="checkbox_field">
                    <input type="checkbox" name="can_delete" id="can_delete" value="1" @checked($webPage['can_delete'] ?? true)>
                    <span>Deletable</span>
                </label>
            </fieldset>
        </x-Spider::admin.form>
        <template id="newTheme">
            <fieldset class="theme cflex" data-theme="{theme}">
                <h6 class="theme_name">{theme} Theme</h6>
                <fieldset class="varients">
                    <label for="{theme}_default_img">
                        <div class="preview">
                            <a href="" target="_blank">
                                <i class="icon fa-solid fa-eye"></i>
                            </a>
                            <img src="{{ url('images/temp.webp') }}" alt="">
                        </div>
                        <div class="hidden">
                            <input type="hidden" name="images[{theme}][][size]" value="default">
                            <input type="file" name="images[{theme}][][file]" value="" id="{theme}_default_img"
                                onchange="display_pic(this)">
                        </div>
                        <span>Default</span>
                    </label>
                    <button type="button" class="vu-btn" onclick="addField(this)">Add</button>
                </fieldset>
            </fieldset>
        </template>
        <template id="newField">
            <label for="{theme}_{size}_img">
                <div class="preview">
                    <a href="" target="_blank">
                        <i class="icon fa-solid fa-eye"></i>
                    </a>
                    <i class="icon fa-solid fa-xmark" onclick="removeNode(this)"></i>
                    <img src="{{ url('images/temp.webp') }}" alt="">
                </div>
                <div class="hidden">
                    <input type="hidden" name="images[{theme}][][size]" value="{size}">
                    <input type="file" name="images[{theme}][][file]" value="" id="{theme}_{size}_img"
                        onchange="display_pic(this)">
                </div>
                <span>{size}</span>
            </label>
        </template>
    </main>
@endsection
@push('js')
    <script>
        function display_pic(node) {
            let vunode = $(node);
            let label = node.closest('label');
            let link = URL.createObjectURL(node.files[0])
            $(label).VU.$('.preview img')[0].src = link;
            $(label).VU.$('.preview a')[0].href = link;
        }

        function passParams(HTML, params) {
            for (const param in params) {
                HTML = HTML.replaceAll(`{${param}}`, params[param])
            }
            return HTML;
        }

        function addTheme(node) {
            let theme = prompt("Enter theme name");
            if (!theme) {
                alert("Invalid Theme name")
                return false;
            }
            let template = $('#newTheme').innerHTML;
            let HTML = passParams(template, {
                theme
            });
            node.insertAdjacentHTML('beforeBegin', HTML);
        }

        function addField(node, size) {
            size = parseInt(size ?? prompt("Enter max size(pixels) :"));
            if (!size || isNaN(size)) {
                alert("Invalid Size")
                return false;
            }
            let theme = $(node.closest('.theme')).VU.get('data-theme');
            let template = $('#newField').innerHTML;
            let HTML = passParams(template, {
                theme,
                size
            });
            node.insertAdjacentHTML('beforeBegin', HTML);
        }

        function removeNode(node) {
            node.closest('label').remove();
        }
    </script>
@endpush
