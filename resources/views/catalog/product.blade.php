@extends('template')
@section('content')
    @include('blocks.bread')
    <!-- aside layout-->
    <div class="layout">
        <div class="layout__container container">
            @include('catalog.blocks.layout_aside')
            <div class="layout__content">
                <main>
                    <section class="section">
                        <div class="section__head">{{ $product->name }}</div>
                        <form class="product" action="#">
                            <input type="hidden" name="product"
                                   value="{{ $product->name }}">
                            <div class="product__top">
                                <button class="product__share share btn-reset" type="button" aria-label="Поделиться">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_641_702)">
                                            <path d="M12.6875 10.375C11.7612 10.375 10.945 10.8307 10.4323 11.5236L5.99969 9.25387C6.07328 9.00303 6.125 8.74306 6.125 8.46875C6.125 8.09669 6.04872 7.74297 5.91694 7.41762L10.5558 4.62612C11.0721 5.232 11.8309 5.625 12.6875 5.625C14.2384 5.625 15.5 4.36341 15.5 2.8125C15.5 1.26159 14.2384 0 12.6875 0C11.1366 0 9.875 1.26159 9.875 2.8125C9.875 3.16991 9.94859 3.50894 10.0707 3.82369L5.41797 6.62337C4.90216 6.0355 4.15428 5.65625 3.3125 5.65625C1.76159 5.65625 0.5 6.91784 0.5 8.46875C0.5 10.0197 1.76159 11.2812 3.3125 11.2812C4.25406 11.2812 5.08409 10.8122 5.59484 10.0998L10.0128 12.3622C9.93147 12.6248 9.875 12.8984 9.875 13.1875C9.875 14.7384 11.1366 16 12.6875 16C14.2384 16 15.5 14.7384 15.5 13.1875C15.5 11.6366 14.2384 10.375 12.6875 10.375Z"
                                                  fill="currentColor"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_641_702">
                                                <rect width="16" height="16" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span>Поделиться</span>
                                </button>
                                <div class="product__code">Код товара: {{ $product->id }}</div>
                            </div>
                            <div class="product__grid">
                                <div class="product__preview">
                                    @if($product->getRecourseDiscountAmount())
                                        <div class="product__preview-top">
                                            <div class="product__badge badge">Лучшая цена</div>
                                            {{--                                            <img class="product__brand lazy" src="/"--}}
                                            {{--                                                 data-src="/static/images/common/brand.png" width="105" height="21"--}}
                                            {{--                                                 alt="">--}}
                                        </div>
                                    @endif
                                    <div class="product__preview-body">
                                        <a href="{{ $image }}" data-fancybox
                                           title="{{ $product->name }}">
                                            <img class="product__view lazy" src="{{ $image }}"
                                                 data-src="{{ $image }}" width="359" height="239"
                                                 alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="product__body">
                                    <div class="p-actions">
                                        <div class="p-actions__row">
                                            <div class="p-actions__col p-actions__col--price">
                                                <div class="p-actions__label">Стоимость ед.</div>
                                                @if($product->price)
                                                    <div class="p-actions__price">{{ $product->price }} руб.</div>
                                                @else
                                                    <div class="p-actions__price">0</div>
                                                @endif
                                            </div>
                                            <div class="p-actions__col p-actions__col--count">
                                                <div class="p-actions__label">Кол-во</div>
                                                <div class="p-actions__count">
                                                    <div class="counter" data-counter="data-counter">
                                                        <button class="counter__btn counter__btn--prev btn-reset"
                                                                type="button" aria-label="Меньше"
                                                                onclick="changeQuantityDown()">
                                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <g clip-path="url(#clip0_657_3899)">
                                                                    <path d="M13.0454 5.73724H0.954545C0.427635 5.73724 0 6.16488 0 6.69179V7.32811C0 7.85503 0.427635 8.28266 0.954545 8.28266H13.0454C13.5723 8.28266 14 7.85503 14 7.32811V6.69179C14 6.16488 13.5723 5.73724 13.0454 5.73724Z"
                                                                          fill="#BDBDBD"/>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_657_3899">
                                                                        <rect width="14" height="14" rx="4"
                                                                              fill="white"/>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                        </button>
                                                        <input class="counter__input" type="number" name="count"
                                                               value="{{ $product->price ? 1 : 0 }}"
                                                               data-count="data-count"/>
                                                        <button class="counter__btn counter__btn--next btn-reset"
                                                                type="button" aria-label="Больше"
                                                                onclick="changeQuantityUp()">
                                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <g clip-path="url(#clip0_657_3897)">
                                                                    <path d="M12.75 5.75H8.5C8.36194 5.75 8.25 5.63806 8.25 5.5V1.25C8.25 0.559692 7.69031 0 7 0C6.30969 0 5.75 0.559692 5.75 1.25V5.5C5.75 5.63806 5.63806 5.75 5.5 5.75H1.25C0.559692 5.75 0 6.30969 0 7C0 7.69031 0.559692 8.25 1.25 8.25H5.5C5.63806 8.25 5.75 8.36194 5.75 8.5V12.75C5.75 13.4403 6.30969 14 7 14C7.69031 14 8.25 13.4403 8.25 12.75V8.5C8.25 8.36194 8.36194 8.25 8.5 8.25H12.75C13.4403 8.25 14 7.69031 14 7C14 6.30969 13.4403 5.75 12.75 5.75Z"
                                                                          fill="#BDBDBD"/>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_657_3897">
                                                                        <rect width="14" height="14" rx="4"
                                                                              fill="white"/>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-actions__col p-actions__col--total">

                                                <div class="p-actions__total">Итого:&nbsp;
                                                    @if($product->price)
                                                        <span>за 1 {{ $product->getRecourseMeasure() }}</span>
                                                    @endif
                                                </div>
                                                @if($product->price)
                                                    <div class="p-actions__summary">{{ $product->price }} ₽</div>
                                                @else
                                                    <div class="p-actions__summary">0 ₽</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="p-actions__action">
                                            <button class="p-actions__btn btn-reset" aria-label="Добавить в заказ"
                                                    data-count="{{ $product->price ? 1 : 0 }}"
                                                    onclick="addToCart(this, {{ $product->id }})">
                                                <span>Добавить в заказ</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="p-infos" x-data="{ open: false }">
                                        @if($deliv = Settings::get('prod_delivery_info'))
                                            <div class="p-infos__item">
                                                <div class="p-infos__head"
                                                     :class="open == 'Информация о доставке' &amp;&amp; 'is-active'"
                                                     @click="open == 'Информация о доставке' ? open = false : open = 'Информация о доставке'">
                                                    <div class="p-infos__title">
                                                        <div class="p-infos__icon lazy"
                                                             data-bg="/static/images/common/ico_delivery.svg"></div>
                                                        <div class="p-infos__label">Информация о доставке</div>
                                                    </div>
                                                    <div class="p-infos__trigger lazy"
                                                         data-bg="/static/images/common/ico_dropdown.svg"></div>
                                                </div>
                                                <div class="p-infos__body" x-show="open == 'Информация о доставке'"
                                                     x-transition.duration.250ms x-cloak>
                                                    @foreach($deliv as $item)
                                                        <p>{{ $item }}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        @if($pay = Settings::get('prod_pay_info'))
                                            <div class="p-infos__item">
                                                <div class="p-infos__head"
                                                     :class="open == 'Варианты оплаты' &amp;&amp; 'is-active'"
                                                     @click="open == 'Варианты оплаты' ? open = false : open = 'Варианты оплаты'">
                                                    <div class="p-infos__title">
                                                        <div class="p-infos__icon lazy"
                                                             data-bg="/static/images/common/ico_cash.svg"></div>
                                                        <div class="p-infos__label">Варианты оплаты</div>
                                                    </div>
                                                    <div class="p-infos__trigger lazy"
                                                         data-bg="/static/images/common/ico_dropdown.svg"></div>
                                                </div>
                                                <div class="p-infos__body" x-show="open == 'Варианты оплаты'"
                                                     x-transition.duration.250ms x-cloak>
                                                    @foreach($pay as $item)
                                                        <p>{{ $item }}</p>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @include('blocks.send_detail_count')

                            <div class="product__content" x-data="{ view: 'Описание' }">
                                <div class="product__nav">
                                    <div class="tabs">
                                        <div class="tabs__item" :class="view == 'Описание' &amp;&amp; 'is-active'"
                                             @click="view = 'Описание'">Описание
                                        </div>
                                        <div class="tabs__item"
                                             :class="view == 'Характеристики' &amp;&amp; 'is-active'"
                                             @click="view = 'Характеристики'">Характеристики
                                        </div>
                                    </div>
                                </div>
                                <div class="product__views">
                                    <div class="product__content" x-show="view == 'Описание'"
                                         x-transition.duration.250ms x-cloak>
                                        <div class="product__subtitle">{{ $product->name }}</div>
                                        <div class="product__grid-view">
                                            <div class="product__grid-body">
                                                {!! $product->description !!}
                                            </div>
                                            <div class="product__grid-aside">
                                                @if(count($product->docs))
                                                    <div class="docs">
                                                        <div class="docs__title">Документы</div>
                                                        <div class="docs__list">
                                                            @foreach($product->docs as $item)
                                                                <a class="docs__item"
                                                                   href="{{ \Fanky\Admin\Models\ProductDoc::UPLOAD_URL . $item->file }}"
                                                                   title="{{ $item->name }}"
                                                                   download>
                                                            <span class="docs__icon lazy"
                                                                  data-bg="/static/images/common/ico_doc.svg"></span>
                                                                    <span class="docs__body">
																	<span class="docs__subtitle">{{ $item->name }}</span>
																	<span class="docs__size">{{ $item->getExtension() }}, {{ $item->getFileSizeAttribute() }}</span>
																</span>
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                @if(count($product->certificates))
                                                    <div class="docs">
                                                        <div class="docs__title">Сертификаты</div>
                                                        <div class="docs__list">
                                                            @foreach($product->certificates as $item)
                                                                <a class="docs__item"
                                                                   href="{{ \Fanky\Admin\Models\ProductCertificate::UPLOAD_URL . $item->image }}"
                                                                   title="Сертификат {{ $product->name }}"
                                                                   download>
                                                            <span class="docs__icon lazy"
                                                                  data-bg="/static/images/common/ico_doc.svg"></span>
                                                                    <span class="docs__body">
																	<span class="docs__subtitle">Сертификат {{ $loop->iteration }}</span>
																</span>
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="b-alert">{{ Settings::get('prod_warn') ?: '' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product__content" x-show="view == 'Характеристики'"
                                         x-transition.duration.250ms x-cloak>
                                        <div class="product__heading">Характеристики</div>
                                        @if(count($chars))
                                            <div class="b-context" x-data="{ contextIsOpen: false }">
                                                <div class="b-context__list">
                                                    @foreach($chars as $char)
                                                        <dl>
                                                            <dt>{{ trim($char->name) }}</dt>
                                                            <dd>{{ trim($char->value) }}</dd>
                                                        </dl>
                                                        @if($loop->iteration > 5)
                                                            <dl x-show="contextIsOpen" x-transition.duration.250ms
                                                                x-cloak>
                                                                <dt>{{ trim($char->name) }}</dt>
                                                                <dd>{{ trim($char->value) }}</dd>
                                                            </dl>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                @if(count($chars) > 5)
                                                    <div class="b-context__action"
                                                         @click="contextIsOpen = !contextIsOpen">
                                                        <span x-show="!contextIsOpen">Показать все характеристики</span>
                                                        <span x-show="contextIsOpen">Скрыть характеристики</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="b-context__list">
                                                Не указаны
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @include('blocks.send_detail_count')
                            <div class="section">
                                <div class="section__block">
                                    <div class="section__row">
                                        <div class="section__content">
                                            <div class="text-block">
                                                @if($category->text)
                                                    <div class="section__subtitle">{{ $category->name }}</div>
                                                    {!! $category->text !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="section__aside">
                                            <a class="b-aside" href="javascript:void(0)" title="Оптовый прайс-лист">
                                                <div class="b-aside__currency">₽</div>
                                                <div class="b-aside__label">Оптовый прайс-лист</div>
                                                <div class="b-aside__text">
                                                    Отправьте заявку на получение прайс-листа "{{ $root->name }}"
                                                    - получите выгодные цены сейчас
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </main>
            </div>
        </div>

        @include('blocks.similar')

        <div class="s-calc lazy"
             data-bg="{{ Settings::fileSrc(Settings::get('complex_banner')['complex_banner_img']) ?: '/static/images/common/calc-bg.jpg' }}">
            <div class="s-calc__container container">
                <div class="s-calc__title">{{ Settings::get('complex_banner')['complex_banner_title'] ?: 'Комплексное снабжение строительных объектов' }}</div>
                <div class="s-calc__text">{{ Settings::get('complex_banner')['complex_banner_text'] ?: 'Подбор аналогов с полным соответствием характеристик товаров по проекту для
                    экономии бюджета' }}
                </div>
                <div class="s-calc__action">
                    <button class="btn btn--primary btn-reset" type="button" data-popup data-src="#calc"
                            aria-label="Сделать расчет">
                        <span>Сделать расчет</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
