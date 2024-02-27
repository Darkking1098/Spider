@extends('Spider::components.VectorBaseLayout')
@push('css')
    <style>
        main {
            padding: 30px 25px 0;
        }

        form {
            margin: auto 20px;
            width: min(300px, 100%);
        }

        form .form_details {
            margin-bottom: 30px;
        }

        form .img_wrap {
            height: 60px;
            aspect-ratio: 1;
            margin-inline: auto;
            margin-bottom: 20px;
        }

        form #form_title {
            font-size: 1.6rem;
            justify-content: space-between;
            display: flex;
            font-weight: 600;
            color: var(--primary);
        }

        form #form_title span {
            opacity: 0.15;
            animation: blink 4s linear calc(var(--i) * 0.1s) infinite;
        }

        form .field {
            display: flex;
            flex-direction: column;
        }

        form .field label {
            font-size: 0.6em;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        form .field:not(:first-of-type) {
            margin-top: 15px;
        }

        form .field input {
            border-radius: 4px;
            padding: 6px 15px;
            outline: none;
            border: 2px solid var(--gray_400);
            font-size: 1.4rem;
        }

        form .field input:hover {
            border-color: var(--gray_600);
        }

        form .field input:focus {
            border-color: var(--primary);
            font-weight: 600;
        }

        form i.error {
            text-align: right;
            margin-top: 5px;
        }

        form button.vu-btn {
            margin-top: 20px;
            background: var(--secondary);
            color: white;
            margin-left: 0;
            transition: all 0.2s;
        }

        form button.vu-btn:hover {
            background: var(--primary);
        }

        .brand_footer {
            padding: 0 20px 20px;
            text-align: center;
            font-size: 0.7em;
        }

        .brand_footer p {
            margin-top: 5px;
        }

        @keyframes click {

            0%,
            100% {
                transform: unset;
                box-shadow: 2px 2px 0 0 #00000022;
            }

            50% {
                transform: translate(2px, 2px);
                box-shadow: 0px 0px 0 0 #00000022;
            }
        }

        @keyframes blink {

            0%,
            40% {
                opacity: 0.15;
            }

            20% {
                opacity: 1;
            }
        }
    </style>
@endpush
@section('body_content')
    <main class="cflex aic jcc">
        <form action="{{ Request::url() }}" method="post" class="cflex" id="myForm">
            <div class="form_details">
                @csrf
                <div class="img_wrap">
                    <img src="{{ config('vector.app_logo') }}" alt="Vector Logo">
                </div>
                <h4 id="form_title">Admin Verification</h4>
            </div>
            <div class="field">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Username" required>
                @error('username')
                    <i class="text error"><b>{{ $message }}</b></i>
                @enderror
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required>
                @error('password')
                    <i class="text error"><b>{{ $message }}</b></i>
                @enderror
            </div>
            @if (session()->has('result'))
                <i class="text error">
                    <b>{{ session()->get('result')['msg'] }}</b>
                </i>
            @endif
            <button type="submit" class="vu-btn">Validate</button>
        </form>
        <div class="brand_footer jse">
            <h3>Spider</h3>
            <p>Powered By Vector</p>
        </div>
    </main>
@endsection
@push('js')
    <script>
        $('#form_title').VU.VText.split();
        // For Submitting using ajax
        // $("#myForm").VU.ajaxSubmit({
        //     url: "{{ url('api/admin/login') }}",
        //     success: (res) => {
        //         res = JSON.parse(res);
        //     }
        // });
    </script>
@endpush
