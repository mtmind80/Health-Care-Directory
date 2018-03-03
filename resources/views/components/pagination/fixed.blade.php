{{-- required CSS --}}
<style scoped>
    body.xs .list-items .pagination-container.fixed-pagination .pagination-info span {
        margin-top: 0px;
    }
    .list-items .pagination-container.fixed-pagination .pagination-info span.item-label {
        text-align: left;
    }
    body.xs .list-items .pagination-container.fixed-pagination .pagination-info span.item-label {
        text-align: center;
    }
    .list-items .pagination-container.fixed-pagination .pagination-info span.item-label,
    .list-items .pagination-container.fixed-pagination .pagination-pages span.item-label,
    .list-items .pagination-container.fixed-pagination .pagination-goto span.item-label,
    .list-items .pagination-container.fixed-pagination .pagination-handlers span.item-label{
        display: block;
        font-weight: bold;
        margin-top: 0px;
        margin-bottom: 3px;
    }
    .list-items .pagination-container.fixed-pagination .pagination-info,
    .list-items .pagination-container.fixed-pagination .pagination-pages,
    .list-items .pagination-container.fixed-pagination .pagination-goto,
    .list-items .pagination-container.fixed-pagination .pagination-handlers {
        margin: 15px 0;
    }
    .list-items .pagination-container.fixed-pagination .pagination-handlers .pagination {
        margin: 1px 0;
    }
    body:not(.xs) .list-items .pagination-container.fixed-pagination .pagination-handlers ul.pagination {
        margin-top: 2px;
    }
    body.sm .list-items .pagination-container.fixed-pagination .pagination-goto {
        text-align: right;
    }
    body.sm .list-items .pagination-container.fixed-pagination .pagination-handlers {
        float: none !important;
        text-align: center !important;
    }
</style>
<div class="row pagination-container clearfix text-center fixed-pagination">
    <div class="col-xs-12 col-sm-4 col-md-3">
        <div class="pull-left pagination-info">
            @if (!$paginator->total())
                <span>There is no item to show.</span>
            @else
                <span class="item-label">Showing:</span>
                @if ($paginator->perPage() > $paginator->total())
                    <span>{!! $paginator->total() !!} {{ $paginator->total() == 1 ? 'item' : 'items' }}</span>
                @else
                    <span>{{ $paginator->perPage() }} de {!! $paginator->total() !!} {{ $paginator->total() == 1 ? 'item': 'items' }}</span>
                @endif
            @endif
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-2 pagination-pages">
        <span class="item-label">Items per page:</span>
        <select id="pageItems" class="form-control">
            <option value="{{ route($route, array_merge(Request::query(), ['page' => 0, 'perPage' => 10])) }}"{{ Request::input('perPage') == 10 ? ' selected' : '' }}>10</option>
            <option value="{{ route($route, array_merge(Request::query(), ['page' => 0, 'perPage' => 20])) }}"{{ Request::input('perPage') == 20 ? ' selected' : '' }}>20</option>
            <option value="{{ route($route, array_merge(Request::query(), ['page' => 0, 'perPage' => $paginator->total()])) }}"{{ Request::input('perPage') == $paginator->total() ? ' selected' : '' }}>All</option>
        </select>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-2 pagination-goto">
        <span class="item-label">Go to page:</span>
        <select id="gotoPage" class="form-control">
            <option value="0" selected></option>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <option value="{{ route($route, array_merge(Request::query(), ['page' => $i])) }}">{{ $i }}</option>
            @endfor
        </select>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-5 pull-right pagination-handlers text-right">
        <span class="item-label">Pagination:</span>
        @if ($paginator->lastPage() > 1)
            <ul class="pagination">
                @if ($paginator->currentPage() > 1)
                    <li>
                        <a href="{{ $paginator->url(1) . $query }}" data-toggle="tooltip" title="first page"><i class="fa fa-angle-double-left"></i></a>
                    </li>
                @endif
                @if (($paginator->currentPage()-5) > 2)
                    <li>
                        <a href="{{ $paginator->url($paginator->currentPage() - 5) . $query }}" data-toggle="tooltip" title="jump 5 pages down">-5</a>
                    </li>
                @endif
                @if ($paginator->currentPage() > 2)
                    <li>
                        <a href="{{ $paginator->url($paginator->currentPage() - 1) . $query }}" data-toggle="tooltip" title="previous page"><i class="fa fa-angle-left"></i></a>
                    </li>
                @endif
                <li class="active">
                    <a href="javascript:;" data-toggle="tooltip" title="current page">{{ $paginator->currentPage() }}</a>
                </li>
                @if (($paginator->currentPage() + 1) < $paginator->lastPage())
                    <li>
                        <a href="{{ $paginator->url($paginator->currentPage() + 1) . $query }}" data-toggle="tooltip" title="next page"><i class="fa fa-angle-right"></i></a>
                    </li>
                @endif
                @if (($paginator->currentPage() + 5) < $paginator->lastPage())
                    <li>
                        <a href="{{ $paginator->url($paginator->currentPage() + 5) . $query }}" data-toggle="tooltip" title="jump 5 pages up">+5</a>
                    </li>
                @endif
                @if ($paginator->currentPage() < $paginator->lastPage())
                    <li>
                        <a href="{{ $paginator->url($paginator->lastPage()) . $query }}" data-toggle="tooltip" title="last page"><i class="fa fa-angle-double-right"></i></a>
                    </li>
                @endif
            </ul>
        @endif
    </div>
</div>





