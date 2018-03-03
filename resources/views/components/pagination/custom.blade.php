{{-- */ $links = !empty($links) ? $links : 7; /* --}}
{{-- */ $query = !empty($query) ? '&'.$query : ''; /* --}}
{{-- */ $params = !empty($params) ? $params : null; /* --}}
@if ($paginator->lastPage() > 1)
    <ul{!! !empty($params['ul-class']) ? ($params['ul-class'] != 'none' ?  ' class="'.$params['ul-class'].'"' : '')  : ' class="pagination custom-pagination"' !!}>
        <li class="{!! !empty($params['li-class']) ?  $params['li-class'] : '' !!}{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{ $paginator->url(1) . $query }}">«</a>
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <?php
            $halfTotalLinks = floor($links / 2);
            $from = $paginator->currentPage() - $halfTotalLinks;
            $to = $paginator->currentPage() + $halfTotalLinks;
            if ($paginator->currentPage() < $halfTotalLinks) {
                $to += $halfTotalLinks - $paginator->currentPage();
            }
            if ($paginator->lastPage() - $paginator->currentPage() < $halfTotalLinks) {
                $from -= $halfTotalLinks - ($paginator->lastPage() - $paginator->currentPage()) - 1;
            }
            ?>
            @if ($from < $i && $i < $to)
                <li class="{!! !empty($params['li-class']) ?  $params['li-class'] : '' !!}{{ ($paginator->currentPage() == $i) ? ' active selected' : '' }}">
                    <a href="{{ $paginator->url($i) . $query }}">{{ $i }}</a>
                </li>
            @endif
        @endfor
        <li class="{!! !empty($params['li-class']) ?  $params['li-class'] : '' !!}{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
            <a href="{{ $paginator->url($paginator->lastPage()) . $query }}">»</a>
        </li>
    </ul>
@endif