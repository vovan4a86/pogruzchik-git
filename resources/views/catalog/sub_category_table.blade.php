@extends('template')
@section('content')
    @include('blocks.bread')
    <!-- aside layout-->
    <div class="layout">
        <div class="layout__container container">
            <div class="layout__request" x-show="!menuIsOpen">
                <button class="request-btn btn-reset" type="button" data-popup="data-popup" data-src="#request"
                        aria-label="Запрос менеджеру">
                    <span class="request-btn__icon lazy" data-bg="/static/images/common/ico_request.svg"></span>
                    <span class="request-btn__label">Запрос менеджеру</span>
                </button>
            </div>
            @include('catalog.blocks.layout_aside')
            <div class="layout__content">
                <main>
                    <section class="section">
                        <div class="section__lead">{{ $category->name }}</div>
                        @if(count($items))
                            <div class="p-table">
                                <div class="p-table__list">
                                    @foreach($items as $id => $value)
                                        @foreach($value as $title => $arr)
                                            <div class="p-table__view">
                                                <div class="p-table__title">
                                                    <a href="{{ $arr['url'] }}">{{ $title }}</a>
                                                </div>
                                                @foreach($arr['value'] as $row)
                                                    <div class="p-table__row">
                                                        @foreach($row as $prod)
                                                            <a class="p-table__item" href="{{ $prod->url }}">
                                                                {{ $prod->name }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @include('blocks.send_detail_count')
                        @if($category->text)
                            <div class="section__subtitle">{{ $category->title }}</div>
                            {!! $category->text !!}
                        @endif
                    </section>
                </main>
            </div>
        </div>
    </div>
@endsection
