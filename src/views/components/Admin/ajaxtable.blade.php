@prepend('css')
    <link rel="stylesheet" href="{{ url('vector/spider/css/admin/table.css') }}">
@endprepend
<section class="table_panel">
    <table class="vu-table">
        {{ $thead ?? '' }}
        {{ $tbody ?? '' }}
        <tfoot>
            <tr>
                <td colspan="100">
                    <div class="rflex jcsb">
                        <div class="counter">
                            <span class="start">3</span>-<span class="end">9</span> of <span class="total">15</span>
                        </div>
                        <form action="{{ url('api/' . $current['page_uri']) }}" method="post">
                            <label>Rows per page</label> <select name="" id="">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </form>
                        <div class="vu-pagination"><i class="icon fa-solid fa-chevron-left"></i><b><span
                                    class="current_page">3</span>/<span class="total_pages">10</span></b><i
                                class="icon fa-solid fa-chevron-right"></i>
                        </div>
                    </div>
                </td>
            </tr>
        </tfoot>
        {{ $tfoot ?? '' }}
    </table>
</section>
@prepend('js')
    <script src="{{ url('vector/spider/js/form.js') }}"></script>
@endprepend
