@prepend('css')
    <link rel="stylesheet" href="{{ url('vector/spider/css/admin/table.css') }}">
@endprepend
<section class="panel table_panel">
    <table class="vu-table">
        {{ $thead ?? '' }}
        {{ $tbody ?? '' }}
        @isset($tfoot)
            {{ $tfoot }}
        @else
            <tfoot></tfoot>
        @endisset
    </table>
</section>
@prepend('js')
    <script src="{{ url('vector/spider/js/form.js') }}"></script>
@endprepend
