<!--
    class=(homepage && "header--home")
    class=(landingPage && "header--landing")
    class=(innerPage && "header--inner")
-->
{{--<header class="header --}}
<header class="header {{ Request::url() == route('main') ? 'header--home' : null }}
{{ isset($innerPage) ? 'header--inner' : null }}
{{ isset($landingPage) ? 'header--landing' : null }}">
    <div class="header__top">
        <div class="header__container container">
            <div class="header__row">
                <div class="header__col">
                    <!-- homepage ? block : link-->
                    <!-- innerPage ? "logo--solid.svg" : "logo.svg"-->
                    @if(Route::is('main'))
                        <div class="header__logo lazy"
                             data-bg="/static/images/common/{{ isset($innerPage) ? 'logo--solid.svg' : 'logo.svg' }}"></div>
                    @else
                        <a class="header__logo lazy" href="{{ route('main') }}"
                           data-bg="/static/images/common/{{ isset($innerPage) ? 'logo--solid.svg' : 'logo.svg' }}"></a>
                    @endif
                    @if(count($topMenu))
                        <nav class="header__nav">
                            <ul class="header__nav-list list-reset">
                                @foreach($topMenu as $item)
                                    <li class="header__nav-item">
                                        <a class="header__nav-link" href="{{ $item->url }}">{{ $item->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    @endif
                </div>
                <div class="header__col">
                    <button class="header__callback btn-reset" type="button" data-popup data-src="#callback"
                            aria-label="Перезвоните мне">Перезвоните мне
                    </button>
                    <div class="header__msg">
                        @if(Settings::get('header_telegram'))
                            <a class="header__msg-icon lazy" href="https://t.me/{{ Settings::get('header_telegram') }}"
                               data-bg="/static/images/common/ico_tg.svg" target="_blank"
                               title="Написать в Telegram"></a>
                        @endif
                        @if(Settings::get('header_whatsapp'))
                            <a class="header__msg-icon lazy"
                               href="https://wa.me/{{ preg_replace('/[^\d+]/', '', Settings::get('header_whatsapp')) }}"
                               data-bg="/static/images/common/ico_wa.svg" target="_blank"
                               title="Написать в Whatsapp"></a>
                        @endif
                    </div>
                    @if(Settings::get('header_phone'))
                        <a class="header__phone"
                           href="tel:{{ preg_replace('/[^\d+]/', '', Settings::get('header_phone')) }}"
                           title="Позвонить нам">{{ Settings::get('header_phone') }}</a>
                    @endif
                    <button class="header__burger btn-reset" type="button" aria-label="Открыть меню">
                        <span class="iconify" data-icon="charm:menu-hamburger" data-width="40"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="header__body">
        <div class="header__container container">
            <div class="header__content">
                <div class="header__catalog">
                    <button class="catalog-btn btn-reset" type="button" aria-label="Открыть каталог"
                            @click="menuIsOpen = !menuIsOpen" :class="menuIsOpen &amp;&amp; 'is-active'">
                        <span class="catalog-btn__icon lazy" data-bg="/static/images/common/ico_catalog.svg"></span>
                        <span class="catalog-btn__label">Каталог</span>
                    </button>
                </div>
                <div class="header__search">
                    <form class="search-field" action="{{ route('search') }}">
                        <!-- innerPage ? "ico_loupe--grey.svg" : "ico_loupe.svg"-->
                        <button class="search-field__btn btn-reset lazy"
                                data-bg="/static/images/common/{{ isset($innerPage) ? 'ico_loupe--grey.svg' : 'ico_loupe.svg' }}"
                                name="submit" aria-label="Найти"></button>
                        <input class="search-field__input input-reset" type="search" name="q"
                               value="{{ Request::get('q') }}"
                               placeholder="Что Вы ищете?" required autocomplete="off">
                    </form>
                </div>
                <!-- innerPage ? "ico_basket--black.svg" : "ico_basket.svg"-->
                <a class="header__basket lazy"
                   data-bg="/static/images/common/{{ isset($innerPage) ? 'ico_basket--black.svg' : 'ico_basket.svg' }}"
                   href="{{ route('cart') }}" title="Перейти в корзину"></a>
            </div>
        </div>
        <div class="header__dropdown">
            <div class="o-nav" x-show="menuIsOpen" @click.away="menuIsOpen = false" x-transition.duration.300ms x-cloak>
                <!-- current — какое меню показано по-умолчанию-->
                <div class="o-nav__container container" x-data="{current: '{{ $catalogMenu->first()->name }}'}">
                    <!-- o-nav__aside-->
                    <div class="o-nav__aside">
                    @foreach($catalogMenu as $item)
                        <!-- o-link-->
                            <div class="o-link" :class="current == '{{ $item->name }}' &amp;&amp; 'is-active'"
                                 @click="current = '{{ $item->name }}'" aria-label="{{ $item->name }}">
                                <div class="o-link__label">{{ $item->name }}</div>
                                <div class="o-link__icon lazy" data-bg="/static/images/common/ico_link.svg"></div>
                            </div>
                        @endforeach
                    </div>
                    <!-- o-nav__body-->
                    <div class="o-nav__body">
                    @foreach($catalogMenu as $item)
                        <!-- o-nav__view-->
                            <div class="o-nav__view" x-show="current == '{{ $item->name }}'">
                                @if($item->children)
                                    <ul class="o-nav__list list-reset">
                                        @foreach($item->children as $child)
                                            <li>
                                                <a href="{{ $child->url }}">{{ $child->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
