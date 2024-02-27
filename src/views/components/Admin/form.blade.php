@once
    @prepend('css')
        <link rel="stylesheet" href="{{url('vector/spider/css/admin/form.css')}}">
    @endprepend
@endonce
<x-admin.response></x-admin.response>
<form action="{{ Request::url() }}" method="post" class="cflex" enctype="multipart/form-data">
    <div class="hidden">@csrf</div>
    {{ $slot }}
    <button type="submit" class="vu-btn">{{ ucfirst($current['page_title']) }}</button>
</form>
@prepend('js')
    <script></script>
@endprepend
