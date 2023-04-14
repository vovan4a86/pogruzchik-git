@if(isset($bread) && count($bread))
    <!-- inner page layout-->
    <!-- landingPage && "breadcrumbs--landing"
         innerPage && "breadcrumbs--inner" -->
    <nav class="breadcrumbs {{ isset($innerPage) ? 'breadcrumbs--inner' : null }}
                            {{ isset($landingPage) ? 'breadcrumbs--landing' : null }} "
         :class="menuIsOpen &amp;&amp; 'is-hidden'">
        <div class="breadcrumbs__container container">
            <ul class="breadcrumbs__list list-reset" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li class="breadcrumbs__item" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <!-- оставь заглушку у последней ссылки-->
                    <a class="breadcrumbs__link" href="{{ route('main') }}" itemprop="item">
                        <span itemprop="name">Главная</span>
                        <meta itemprop="position" content="1">
                    </a>
                </li>
                @foreach($bread as $item)
                    <li class="breadcrumbs__item" itemprop="itemListElement" itemscope
                        itemtype="https://schema.org/ListItem">
                        <a class="breadcrumbs__link" href="{!! $loop->last ? 'javascript:void(0)': $item['url'] !!}"
                           itemprop="item">
                            <span itemprop="name">{{ $item['name'] }}</span>
                            <meta itemprop="position" content="{{ $loop->index + 1 }}">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
@endif
