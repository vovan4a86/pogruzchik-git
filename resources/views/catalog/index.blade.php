@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <section class="section">
            <div class="section__container container">
                <button class="request-btn btn-reset" type="button" data-popup="data-popup" data-src="#request"
                        aria-label="Запрос менеджеру">
                    <span class="request-btn__icon lazy" data-bg="/static/images/common/ico_request.svg"></span>
                    <span class="request-btn__label">Запрос менеджеру</span>
                </button>
                <div class="section__title">Каталог</div>
                <div class="section__grid">
                    @foreach($categories as $item)
                        @php
                            if($item->size_cat) {
                                [$w, $h] = array_map('trim', explode(',', $item->size_cat));
                            } else {
                                $w = $h = 120;
                            }
                        @endphp
                        <div class="section__item">
                            <div class="catalog-item">
                                <a class="catalog-item__title" href="{{ $item->url }}">{{ $item->title }}</a>
                                <img class="catalog-item__pic lazy" src="/"
                                     data-src="{{ $item->thumb(2) }}"
                                     width="{{ $w }}" height="{{ $h ?: 120 }}" alt="{{ $item->name }}">
                                @if($item->children)
                                    <ul class="catalog-item__list list-reset">
                                        @foreach($item->children as $child)
                                            @if($loop->iteration < 8)
                                                <li>
                                                    <a href="{{ $child->url }}">{{ $child->title }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    @if(count($item->children) >= 8)
                                        <div class="catalog-item__action">
                                            <a class="catalog-item__link" href="{{ $item->url }}"
                                               title="{{ $item->name }}">
                                                <span>Все подкатегории</span>
                                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3.4375 11H18.5625" stroke="currentColor"
                                                          stroke-width="1.5"
                                                          stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M12.375 4.8125L18.5625 11L12.375 17.1875"
                                                          stroke="currentColor"
                                                          stroke-width="1.5" stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="section__block">
                    <div class="section__subtitle">{{ $h1 }}</div>
                    {!! $text !!}
                    <div class="block-request">
                        <button class="block-request__request btn-reset" type="button" data-popup="data-popup" data-src="#request"
                                aria-label="Получить расчёт цены">
                            <span>Получить расчёт цены</span>
                        </button>
                        <div class="block-request__body">Получите детальный расчет цены на ваш строительный объект.
                           Детальную информацию можно получить в отделе продаж.
                        </div>
                    </div>

                </div>
            </div>
        </section>
        @include('blocks.send_request_consultation')
    </main>
@endsection
