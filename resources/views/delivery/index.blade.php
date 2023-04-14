@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <section class="section">
            <div class="section__container container">
                <div class="section__title">Доставка и оплата</div>
                <div class="b-delivery" x-data="{ view: 'Доставка'}">
                    <div class="b-delivery__nav">
                        <div class="tabs">
                            @if($deliveries)
                                <div class="tabs__item" :class="view == 'Доставка' &amp;&amp; 'is-active'"
                                     @click="view = 'Доставка'">Доставка
                                </div>
                            @endif
                            @if(count($payments))
                                <div class="tabs__item" :class="view == 'Оплата' &amp;&amp; 'is-active'"
                                     @click="view = 'Оплата'">Оплата
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="b-delivery__views">
                        @if($deliveries)
                            <div class="b-delivery__view" x-show="view == 'Доставка'" x-transition.duration.500ms x-cloak>
                            <div class="b-delivery__grid">
                                @foreach($deliveries as $item)
                                <div class="b-delivery__block">
                                    <div class="b-delivery__head">
                                        <div class="b-delivery__title">{{ $item->name }}</div>
                                        <div class="b-delivery__data">
                                            <div class="b-delivery__icon lazy"
                                                 data-bg="{{ \Fanky\Admin\Models\DeliveryItem::UPLOAD_URL . $item->icon }}"></div>
                                            <div class="b-delivery__info">{{ $item->description }}
                                                @if($item->address)
                                                    <div class="b-delivery__address">{{ $item->address }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="b-delivery__subtitle">{{ $item->header_text ?: 'Условия:' }}</div>
                                    {!! $item->text !!}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if(count($payments))
                            <div class="b-delivery__view" x-show="view == 'Оплата'" x-transition.duration.500ms x-cloak>
                                @foreach($payments as $row)
                                    <div class="b-delivery__row">
                                        @foreach($row as $item)
                                            <div class="b-delivery__block">
                                                <div class="b-delivery__title">{{ $item->name }}</div>
                                                <div class="b-delivery__body">{{ $item->description }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
