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
                <div class="section__title">{{ $category->title }}</div>
                @if($category->children)
                    <div class="section__grid">
                        @foreach($category->children as $child)
                            <div class="section__item">
                                <div class="catalog-item">
                                    <a class="catalog-item__title" href="{{ $child->url }}">{{ $child->title }}</a>
                                    @if($child->image)
                                        <img class="catalog-item__pic lazy" src="/"
                                             data-src="{{ $category->thumb(2) }}" width="152" height="114"
                                             alt="{{ $child->name }}">
                                    @endif
                                    @if($child->children)
                                        <ul class="catalog-item__list list-reset">
                                            @foreach($child->children as $grandchild)
                                                @if($loop->iteration < 8)
                                                    <li>
                                                        <a href="{{ $grandchild->url }}">{{ $grandchild->title }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        @if(count($child->children) >= 8)
                                            <div class="catalog-item__action">
                                                <a class="catalog-item__link" href="{{ $child->url }}"
                                                   title="{{ $child->name }}">
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
                @endif
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
                                <div class="b-aside__text">Отправте заявку на получение прайс-листа "{{ $root->name }}"
                                    - получите выгодные цены сейчас
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('blocks.send_request_consultation')
    </main>
@endsection
