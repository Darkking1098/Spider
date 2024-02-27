@php
    $cont = Vector\Spider\Http\Controllers\AdminControllers\AdminPageController::class;
    $groups = $cont::get_allowedPages();
@endphp
@once
    @prepend('css')
        <style>
            body:has(.vu-sidebar-layout) {
                overflow: hidden;
                min-height: unset;
                height: 100%;
            }

            body:has(.vu-sidebar-layout) main {
                padding: 25px 30px;
            }

            .vu-sidebar-layout {
                flex-grow: 1;
                display: flex;
                overflow: hidden;
                height: 100%;
            }

            .vu-sidebar-layout .vu-sidebar {
                width: 280px;
                display: flex;
                flex-direction: column;
                flex-shrink: 0;
                background: var(--primary);
            }

            .vu-sidebar-layout .vu-sidebar .brand img {
                height: 40px;
                margin: 20px auto;
            }

            .vu-sidebar-layout .main_content {
                flex-grow: 1;
                display: flex;
                flex-direction: column;
                overflow-y: auto;
            }

            .vu-sidebar-layout .main_content header {
                display: none;
            }

            .vu-sidebar {
                background: var(--primary);
            }

            .vu-sidebar .prime_nav {
                overflow-y: auto;
                color: var(--sec_text_light);
            }

            .vu-sidebar .main_nav::-webkit-scrollbar {
                display: none;
            }

            .vu-sidebar nav a {
                display: flex;
                justify-content: space-between;
                transition: all 0.2s;
                padding: 8px 30px;
                color: inherit;
                text-decoration: none;
            }

            .vu-sidebar-layout .vu-sidebar nav :is(li, ul) {
                list-style-type: none;
                transition: all 0.3s;
            }

            .vu-sidebar-layout .vu-sidebar ul li {
                padding-left: 20px;
            }

            .vu-sidebar-layout .vu-sidebar ul a {
                padding-block: 5px;
                font-size: 0.8em;
            }

            .vu-sidebar-layout .vu-sidebar ul li {
                border-bottom: 1px dashed #ffffff33;
            }

            .vu-sidebar .group_head {
                overflow: hidden;
                cursor: pointer;
            }

            .vu-sidebar li>.group_title {
                font-size: 0.85em;
                border-bottom: 1px solid #ffffff44;
            }

            .vu-sidebar nav>li:where(:hover, .active) {
                background: #ffffff39;
            }

            .vu-sidebar nav li:where(.active, :hover)>a {
                color: var(--prime_text_light);
                font-weight: 600;
            }

            .vu-sidebar .sec_nav {
                margin-top: auto;
            }

            .vu-sidebar .sec_nav .logout {
                background: var(--error);
                border-radius: 0;
                font-weight: 600;
                transition: all 0.3s;
            }

            .vu-sidebar .sec_nav .logout a {
                text-align: center;
                font-size: 0.9em;
                justify-content: center;
            }

            .vu-sidebar .sec_nav .logout:hover {
                color: white;
                background: var(--error_dark);
            }

            /* Header goes here */
            .vu-sidebar-layout .main_content header {
                background: var(--primary);
                height: 60px;
                color: var(--prime_text_light);
                flex-shrink: 0;
                padding: 0 20px;
            }

            .vu-sidebar-layout .main_content header .brand {
                height: 100%;
                padding: 10px 20px;
            }

            @media screen and (max-width: 900px) {
                .vu-sidebar-layout .vu-sidebar {
                    position: absolute;
                    height: 100%;
                    right: 0;
                    transform: translateX(100%);
                    transition: all 0.4s;
                    z-index: 99;
                }

                .vu-sidebar-layout .vu-sidebar.active {
                    transform: translateX(0);
                    box-shadow: 0 0 80px 0 #00000088;
                }

                .vu-sidebar-layout .main_content header {
                    display: flex;
                    align-items: center;
                }
            }
        </style>
    @endprepend
@endonce
<div class="vu-sidebar">
    <a href="{{ url('') }}" class="brand">
        <img src="{{ config('app.app_logo_white') }}" alt="">
    </a>
    <nav class="prime_nav">
        <li @class(['group_head', 'active' => $current['page_uri'] == 'admin'])>
            <a href="{{ url('admin') }}" class="group_title">Dashboard</a>
        </li>
        @foreach ($groups as $group)
            @if (count($group['admin_pages']) > 0)
                <li @class([
                    'group_head',
                    'active' => $group['id'] == ($current['admin_page_group']['id'] ?? ''),
                ])>
                    <a class="group_title rflex jcsb aic">
                        {{ $group['page_group_title'] }}
                        <i class="fa-regular fa-angle-down"></i>
                    </a>
                    <ul>
                        @foreach ($group['admin_pages'] as $pg)
                            <li @class([
                                'active' => $pg['page_uri'] == $current['page_uri'],
                            ])>
                                <a href="{{ url($pg['page_uri']) }}"
                                    data-loadMsg="Loading document for {{ $pg['page_title'] }}">
                                    {{ $pg['page_title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
        @endforeach
    </nav>
    <nav class="sec_nav">
        <li class="logout"><a href="{{ url('admin/logout') }}">Logout</a></li>
    </nav>
</div>
@prepend('js')
    <script>
        $(".group_head:has(ul)").VU.perform((n, i, no) => {
            let inner = n.$('ul')[0];
            n.set("data-height", inner.offsetHeight + "px");
            n.$(".group_title")[0].addEventListener("click", () => {
                no.VU.perform((x) => {
                    if (n != x) {
                        x.removeClass("active")
                        x.$('ul')[0].VU.addCSS("height", "0px");
                    }
                })
                inner.VU.addCSS("height", n.hasClass("active") ? "0px" : n.get("data-height"));
                n.toggleClass("active");
            })
            inner.VU.addCSS("height", n.hasClass("active") ? n.get("data-height") : "0px");
        })
    </script>
@endprepend
