@if($paginator instanceof \Illuminate\Pagination\LengthAwarePaginator
    && $paginator->hasPages()
    && $paginator->lastPage() > 1)
    <? /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */ ?>

    <?php
    // config
    $link_limit = 5; // maximum number of links (a little bit inaccurate, but will be ok for now)
    $half_total_links = floor($link_limit / 2);
    $from = $paginator->currentPage() - $half_total_links;
    $to = $paginator->currentPage() + $half_total_links;
    if ($paginator->currentPage() < $half_total_links) {
        $to += $half_total_links - $paginator->currentPage();
    }
    if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
        $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
    }
    ?>

    @if ($paginator->lastPage() > 1)
        <div class="pagination">
            <div class="pagination__row">
                @if ($paginator->currentPage() > 1)
                    <a class="pagination__link pagination__link--prev" href="{{ $paginator->previousPageUrl() }}"
                       onclick="ajaxRequest(this, event)">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 3L5 8L10 13" stroke="currentColor" stroke-width="2"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                @else
                    <span class="pagination__link pagination__link--prev">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 3L5 8L10 13" stroke="currentColor" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                @endif
                @if($from > 1)
                    <a class="pagination__link" href="{{ $paginator->url(1) }}"
                       data-pagination-link onclick="ajaxRequest(this, event)">1</a>
                @endif

                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    @if ($from < $i && $i < $to)
                        @if ($i == $paginator->currentPage())
                            <a class="pagination__link pagination__link--is-current"
                               href="{{ $paginator->url($i) }}"
                               data-pagination-link onclick="ajaxRequest(this, event)">{{ $i }}</a>
                        @else
                            <a class="pagination__link" href="{{ $paginator->url($i) }}"
                               data-pagination-link onclick="ajaxRequest(this, event)">{{ $i }}</a>
                        @endif
                    @endif
                @endfor

                @if($paginator->lastPage() > 3)
                    <div class="pagination__link pagination__link--divider" data-pagination-link>
                        <svg width="19" height="4" viewBox="0 0 19 4" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.60067 3.37267C10.4793 3.37267 11.1916 2.6604 11.1916 1.78177C11.1916 0.903131 10.4793 0.190857 9.60067 0.190857C8.72204 0.190857 8.00977 0.903131 8.00977 1.78177C8.00977 2.6604 8.72204 3.37267 9.60067 3.37267Z"
                                  fill="currentColor"/>
                            <path d="M2.32724 3.37267C3.20587 3.37267 3.91815 2.6604 3.91815 1.78177C3.91815 0.903131 3.20587 0.190857 2.32724 0.190857C1.4486 0.190857 0.736328 0.903131 0.736328 1.78177C0.736328 2.6604 1.4486 3.37267 2.32724 3.37267Z"
                                  fill="currentColor"/>
                            <path d="M16.8722 3.37267C17.7508 3.37267 18.4631 2.6604 18.4631 1.78177C18.4631 0.903131 17.7508 0.190857 16.8722 0.190857C15.9935 0.190857 15.2812 0.903131 15.2812 1.78177C15.2812 2.6604 15.9935 3.37267 16.8722 3.37267Z"
                                  fill="currentColor"/>
                        </svg>
                    </div>
                @endif

                @if($to < $paginator->lastPage())
                    <a class="pagination__link pagination__link--all"
                       href="{{ $paginator->url($paginator->lastPage()) }}"
                       data-pagination-link onclick="ajaxRequest(this, event)">{{ $paginator->lastPage() }}</a>
                @endif
                @if ($paginator->currentPage() < $paginator->lastPage())
                    <a class="pagination__link pagination__link--next" href="{{ $paginator->nextPageUrl() }}"
                       onclick="ajaxRequest(this, event)">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 3L5 8L10 13" stroke="currentColor" stroke-width="2"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                @else
                    <span class="pagination__link pagination__link--next">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 3L5 8L10 13" stroke="currentColor" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                @endif
            </div>
        </div>
    @endif
@endif
