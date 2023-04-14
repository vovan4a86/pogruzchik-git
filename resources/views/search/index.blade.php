@extends('template')
@section('content')
    @include('blocks.bread')
    <title>{{ $title }}</title>
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
                        <div class="section__lead">{{ $title }}</div>
                        @if(count($items))
                            <div class="b-cards">
                                <div class="b-cards__grid">
                                    @foreach($items as $item)
                                        @include('catalog.product_item', compact($item))
                                    @endforeach
                                </div>
                            </div>
                            <div class="section__pagination">
                                @include('catalog.section_pagination', ['paginator' => $items])
                            </div>
                        @endif
                    </section>
                </main>
            </div>
        </div>
    </div>
@endsection
