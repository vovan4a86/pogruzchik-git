@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <section class="complex-hero">
            <div class="complex-hero__container container">
                <div class="complex-hero__body">
                    <div class="complex-hero__title">{{ Settings::get('complex_first')['complex_first_title'] }}</div>
                    <div class="complex-hero__text">{!! Settings::get('complex_first')['complex_first_text'] !!}</div>
                    @if($feats = Settings::get('complex_feats'))
                        <div class="complex-hero__points">
                            <div class="b-points b-points--white">
                                @foreach($feats as $feat)
                                    <div class="b-points__point">
                                        <div class="b-points__stat">{{ array_get($feat, 'complex_feats_num', '') }}</div>
                                        <div class="b-points__value">{!! array_get($feat, 'complex_feats_text', '') !!}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if( Settings::get('complex_first')['complex_first_img'] )
                <img class="complex-hero__pic lazy" src="/"
                     data-src="{{ Settings::fileSrc(Settings::get('complex_first')['complex_first_img']) }}" width="594"
                     height="930" alt="">
            @endif
        </section>
        <div class="b-clients">
            <div class="b-clients__container container">
                <div class="b-clients__list">
                    <div class="b-clients__item">
                        <div class="b-clients__icon lazy" data-bg="static/images/common/ico_business.svg"></div>
                        <div class="b-clients__body">
                            <div class="b-clients__title">Компаниям:</div>
                            <div class="b-clients__text">{!! Settings::get('complex_company') ?: ''  !!}</div>
                        </div>
                    </div>
                    <div class="b-clients__item">
                        <div class="b-clients__icon lazy" data-bg="static/images/common/ico_user.svg"></div>
                        <div class="b-clients__body">
                            <div class="b-clients__title">Частным клиентам:</div>
                            <div class="b-clients__text">{!! Settings::get('complex_client') ?: ''  !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(count($items))
            <section class="s-objects">
                <div class="s-objects__container container">
                    <div class="s-objects__title">Объекты, на которые мы поставляли материалы</div>
                    <div class="s-objects__grid">
                        @each('complex.list_item', $items, 'item')
                    </div>
                    @include('paginations.links_limit', ['paginator' => $items])
                </div>
            </section>
        @endif

        @include('about.certificates')
        @include('blocks.send_request')
    </main>
@endsection
