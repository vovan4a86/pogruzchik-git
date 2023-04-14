<div class="mob-nav" id="mobile-nav">
    <ul class="mob-nav__list">
        <li class="mob-nav__item" data-nav-highlight>
            <a class="mob-nav__link" href="{{ route('main') }}">Главная</a>
        </li>
        @if($catalogMenu)
            <li class="mob-nav__item">
                <a class="mob-nav__link" href="{{ route('catalog.index') }}">Каталог</a>
                <ul>
                    @foreach($catalogMenu as $item)
                        <li>
                            <a href="{{ $item->url }}">{{ $item->name }}</a>
                            @if($item->children)
                                <ul>
                                    @foreach($item->children as $child)
                                        <li>
                                            <a href="{{ $child->url }}">{{ $child->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ route('catalog.index') }}">Весь каталог</a>
                    </li>
                </ul>
            </li>
        @endif
        @if($mobileMenu)
            @foreach($mobileMenu as $item)
                <li class="mob-nav__item">
                    <a class="mob-nav__link" href="{{ $item->url }}">{{ $item->name }}</a>
                </li>
            @endforeach
        @endif
    </ul>
    <ul class="mob-nav__bottom">
        <li class="mob-nav__icon">
            <a href="javascript:void(0)">
                <span class="iconify" data-icon="ic:baseline-settings-phone" data-width="30"></span>
            </a>
        </li>
        <li class="mob-nav__icon">
            <a href="javascript:void(0)">
                <span class="iconify" data-icon="ic:baseline-telegram" data-width="30"></span>
            </a>
        </li>
        <li class="mob-nav__icon">
            <a href="javascript:void(0)">
                <span class="iconify" data-icon="dashicons:whatsapp" data-width="30"></span>
            </a>
        </li>
    </ul>
</div>