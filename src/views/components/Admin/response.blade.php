@once
    @prepend('css')
        <style>
            .vu-response {
                border-radius: 6px;
                font-weight: 600;
                font-size: 1.2em;
                margin-bottom: 20px;
            }
        </style>
    @endprepend
@endonce
@if (Session::has('result'))
    @php
        $icon = [
            'success' => 'fa-check',
            'error' => 'fa-bug',
            'warn' => 'fa-triangle-exclamation',
            'info' => 'fa-info',
        ];
        $type = Session::get('result')['success'] ? 'success' : 'error';
    @endphp
    <div class="vu-response {{ $type }} bdr-{{ $type }} bg-{{ $type }}">
        <i class="text rflex aic bg-{{ $type }}"><i class="fa-solid {{ $icon[$type] }} icon"></i>
            {{  Session::get('result')['msg'] }}</i>
    </div>
@endif
