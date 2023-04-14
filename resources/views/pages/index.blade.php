@extends('template')
@section('content')
    <!-- homepage layout-->
    <main class="page-slider swiper">
        <div class="page-slider__wrapper swiper-wrapper">
            @include('pages.index.slider')
            @if(count($categories))
                <section class="s-catalog section section--slide swiper-slide" data-background="light">
                    <div class="s-catalog__container container">
                        <div class="s-catalog__title">Каталог продукции</div>
                        <div class="s-catalog__grid">
                            @foreach($categories as $item)
                                @php
                                    if($item->size_main) {
                                        [$w, $h] = array_map('trim', explode(',', $item->size_main));
                                    } else {
                                        $w = $h = 200;
                                    }
                                @endphp
                                <div class="s-catalog__col {{ $loop->iteration <= 3 ? 's-catalog__col--wide' : null }}">
                                    <a class="catalog-card {{ $loop->iteration <= 3 ? 'catalog-card--wide' : null }}" href="{{ $item->url }}" title="{{ $item->name }}">
                                        <span class="catalog-card__title">{{ $item->title }}</span>
                                        <img class="catalog-card__pic lazy" src="/" data-src="{{ $item->thumb(2) }}"
                                             width="{{ $w }}" height="{{ $h ?: 200 }}" alt="{{ $item->title }}"/>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
            @if($fields = Settings::get('main_call'))
                <section class="s-callback section lazy section--slide swiper-slide"
                         data-bg="static/images/common/s-callback-bg.jpg" data-background="light">
                    <div class="s-callback__container container">
                        <div class="s-callback__grid">
                            <div class="s-callback__col s-callback__col--picture">
                                <div class="s-callback__decor lazy" data-bg="static/images/common/man.png"></div>
                            </div>
                            <div class="s-callback__col">
                                <div class="s-callback__title">{{ array_get($fields, 'main_call_title', '') }}</div>
                                <div class="s-callback__subtitle">{{ array_get($fields, 'main_call_subtitle', '') }}</div>
                                <div class="s-callback__text">{{ array_get($fields, 'main_call_text', '') }}</div>
                                <div class="s-callback__action">
                                    <button class="btn btn--primary btn-reset" type="button" data-popup
                                            data-src="#request" aria-label="Отправить заявку">
                                        <span>Отправить заявку</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
            @if($fields = Settings::get('main_about'))
                <section class="s-about section section--slide swiper-slide" data-background="light">
                    <div class="s-about__grid">
                        <div class="s-about__col"></div>
                        <div class="s-about__col s-about__col--decor lazy"
                             data-bg="{{ Settings::fileSrc(array_get($fields, 'main_about_img', '/static/images/common/s-about-bg.jpg')) }}"></div>
                        <div class="s-about__body">
                            <div class="s-about__title">{{ array_get($fields, 'main_about_title', '') }}</div>
                            <div class="s-about__subtitle">{{ array_get($fields, 'main_about_subtitle', '') }}</div>
                            <div class="s-about__content">
                                {!! array_get($fields, 'main_about_text', '') !!}
                            </div>
                            <div class="s-about__action">
                                <a class="btn btn--white" href="{{ route('about') }}" title="Подробнее о компании">
                                    <span>Подробнее о компании</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
            @if($fields = Settings::get('main_geo'))
                <section class="s-delivery section section--slide swiper-slide" data-background="dark">
                    <div class="s-delivery__container container">
                        <div class="s-delivery__title">География доставки</div>
                        <ul class="s-delivery__list list-reset">
                            @foreach($fields as $field)
                                <li class="s-delivery__list-item">{{ $field }}</li>
                            @endforeach
                        </ul>
                        <div class="s-delivery__action">
                            <a class="btn btn--primary" href="{{ route('contacts') }}" title="Контакты">
                                <span>Контакты</span>
                            </a>
                        </div>
                    </div>
                    <div class="s-delivery__map-block">
                        <img class="s-delivery__map lazy" src="/" data-src="static/images/common/map.svg" width="1091"
                             height="677" alt="">
                        <div class="s-delivery__office">
                            <img class="lazy" src="/" data-src="static/images/common/office.jpg" width="300"
                                 height="180"
                                 alt="">
                        </div>
                    </div>
                </section>
            @endif

            @include('blocks.footer')
        </div>
    </main>
@stop
