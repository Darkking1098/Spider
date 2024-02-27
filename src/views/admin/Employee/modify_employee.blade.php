@php
    $path = [['title' => $admin['admin_role']['role_title'] . ' Dashboard']];
@endphp
@extends('Spider::admin.assets.layout')
@prepend('css')
    <style>
        section.bg_banner {
            padding: 0;
            position: relative;
            margin-bottom: 100px;
            border-radius: 7px;
            filter: drop-shadow(0 0 10px #00000033);
        }

        .bg_banner .banner {
            height: 200px;
            border-radius: inherit;
            position: relative;
        }

        .bg_banner .banner button {
            position: absolute;
            right: 0;
            bottom: 0;
            margin: 20px;
            font-size: 0.8em;
            padding: 6px 15px;
        }

        .bg_banner .banner img {
            height: 100%;
            border-radius: inherit;
        }

        .bg_banner .profile_pic {
            position: absolute;
            top: 0;
            height: 100%;
            left: 50%;
            aspect-ratio: 1;
            transform: translate(-50%, 30%);
            border: 6px solid white;
            border-radius: 50%;
        }

        .bg_banner .profile_pic img {
            border-radius: inherit;
        }

        .bg_banner .profile_pic i {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(140%, 140%);
            background: white;
            border-radius: 50%;
            font-size: 0.8em;
        }
    </style>
@endprepend
@section('main')
    <main>
        <x-Spider::admin.breadcrumb :path="$path"></x-Spider::admin.breadcrumb>
        <x-Spider::admin.form>
            <section class="bg_banner">
                <div class="banner img_wrap">
                    <img src="{{ url('images/user_bg.jpg') }}" alt="">
                    <button type="button" class="vu-btn">Update</button>
                </div>
                <div class="profile_pic img_wrap">
                    <img src="{{ url('images/profile/profile 1.jpg') }}" alt="">
                    <i class="fa-solid fa-camera icon"></i>
                </div>
            </section>
            <section class="panel">
                <h5 class="panel_title">Employee Basic Info</h5>
                <p class="panel_desc">Just normal things to add new employee</p>
                <fieldset class="cflex">
                    <fieldset>
                        <div class="field">
                            <label for="">Employee Name</label>
                            <input type="text" name="" id="">
                        </div>
                        <div class="field">
                            <label for="">Employee Username</label>
                            <input type="text" name="" id="">
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="field cflex">
                            <label for="">Employee D.O.B.</label>
                            <input type="date" name="emp_dob" placeholder="Employee DOB">
                        </div>
                        <div class="field">
                            <label for="">Employee Gender</label>
                            <select name="" id="">
                                <option value="">Male</option>
                                <option value="">Female</option>
                                <option value="">Transgender</option>
                            </select>
                        </div>
                    </fieldset>
                </fieldset>
            </section>
            <section class="panel">
                <h5 class="panel_title">Employee Contact Info</h5>
                <p class="panel_desc">Employee mobile number and email</p>
                <fieldset class="cflex">
                    <fieldset>
                        <div class="field">
                            <label for="">Employee Personal Contact</label>
                            <input type="text" name="" id="">
                        </div>
                        <div class="field">
                            <label for="">Employee Personal E-mail</label>
                            <input type="text" name="" id="">
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="field">
                            <label for="">Employee Company Contact</label>
                            <input type="text" name="" id="">
                        </div>
                        <div class="field">
                            <label for="">Employee Company E-mail</label>
                            <input type="text" name="" id="">
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="field">
                            <label for="">Employee Family Contact</label>
                            <input type="text" name="" id="">
                        </div>
                        <div class="field">
                            <label for="">Employee Family E-mail</label>
                            <input type="text" name="" id="">
                        </div>
                    </fieldset>
                </fieldset>
            </section>
            <section class="panel">
                <h5 class="panel_title">Employee Salary</h5>
                <p class="panel_desc">It's all about money</p>
                <fieldset class="cflex">
                    <fieldset>
                        <div class="field">
                            <label for="">Employee Joing Date</label>
                            <input type="text" name="" id="">
                        </div>
                        <div class="field">
                            <label for="">Employee Salary</label>
                            <input type="text" name="" id="">
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="field">
                            <label for="">Employee Job Role</label>
                            <select name="" id="">
                                @foreach ($roles as $role)
                                    <option value="{{ $role['id'] }}">
                                        {{ $role['role_title'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label for="">Employee Team</label>
                            <select name="" id="" readonly></select>
                        </div>
                    </fieldset>
                </fieldset>
            </section>
            <section class="panel">
                <h5 class="panel_title">Employee Password</h5>
                <p class="panel_desc">Can only be changed by developer and employee itself.</p>
                <fieldset>
                    <div class="field">
                        <label for="">Employee Password</label>
                        <input type="text" name="" id="">
                    </div>
                </fieldset>
            </section>
            <fieldset class="cflex">
                <label for="page_status" class="checkbox_field">
                    <input type="checkbox" name="page_status" id="page_status" value="1"
                        @checked($empoyee['emp_status'] ?? true)>
                    <span>Page is available to use</span>
                </label>
                <label for="join_team" class="checkbox_field">
                    <input type="checkbox" name="join_team" id="join_team" value="1" @checked($empoyee['join_team'] ?? true)>
                    <span>Can join team</span>
                </label>
                <label for="can_delete" class="checkbox_field">
                    <input type="checkbox" name="can_delete" id="can_delete" value="1"
                        @checked($empoyee['can_delete'] ?? true)>
                    <span>Deletable</span>
                </label>
            </fieldset>
        </x-Spider::admin.form>
    </main>
@endsection
@prepend('js')
@endprepend
