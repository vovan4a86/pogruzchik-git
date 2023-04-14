@php $landingPage = true @endphp
@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <section class="about-hero">
            @if($img = Settings::get('about_img'))
                <picture>
                    <source type="image/webp" srcset="/"
                            data-srcset="{{ Settings::fileSrc(Settings::getAlterImage($img, '--1080.'))}}  1080,
                         {{ Settings::fileSrc($img) }}" data-sizes="100">
                    <img class="about-hero__bg lazy"
                         src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                         data-src="{{ Settings::fileSrc(Settings::getAlterImage($img, '--1080.')) }} 1080,
                      {{ Settings::fileSrc($img) }}"
                         data-sizes="100w" width="1920" height="1080"
                         alt="">
                </picture>
            @endif
            @if($fields = Settings::get('about_main'))
                <div class="about-hero__container container">
                    <div class="about-hero__grid">
                        <div class="about-hero__body">
                            <div class="about-hero__title">{{ array_get($fields, 'about_main_title', '') }}</div>
                            <div class="about-hero__text">{{ array_get($fields, 'about_main_subtitle', '') }}</div>
                            <div class="about-hero__feature">{{ array_get($fields, 'about_main_s_text', '') }}</div>
                        </div>
                        <div class="about-hero__points">
                            {!! array_get($fields, 'about_main_text', '') !!}
                        </div>
                    </div>
                </div>
            @endif
        </section>
        <section class="about-features">
            <div class="about-features__container container">
                <div class="about-features__grid">
                    <div class="about-features__col">
                        <div class="about-features__title">{{ Settings::get('about_second_top_title') ?: '' }}</div>
                    </div>
                    <div class="about-features__body">
                        @if($fields = Settings::get('about_second_top_text'))
                            @foreach($fields as $field)
                                <div class="about-features__text">{{ $field }}</div>
                            @endforeach
                        @endif
                        @if($feats = Settings::get('about_second_top_feats'))
                            <div class="b-points">
                                @foreach($feats as $feat)
                                    <div class="b-points__point">
                                        <div class="b-points__stat">{{ array_get($feat, 'about_second_top_feats_num', '') }}</div>
                                        <div class="b-points__value">{!! array_get($feat, 'about_second_top_feats_text', '') !!}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="about-features__content">
                    @if(Settings::get('about_second_bottom_title'))
                        <div class="about-features__title">{{ Settings::get('about_second_bottom_title') ?: '' }}</div>
                    @endif
                    @if($fields = Settings::get('about_second_bottom_text'))
                        @foreach($fields as $field)
                            <div class="about-features__text">{{ $field }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
        <section class="about-supply">
            <div class="about-supply__container container">
                <div class="about-supply__title">{{ Settings::get('about_third_title') ?: '' }}</div>
                @if($fields = Settings::get('about_third_text'))
                    <div class="about-supply__grid">
                        @foreach($fields as $field)
                            <div class="about-supply__col">
                                <div class="about-supply__item">
                                    {!! array_get($field, 'about_third_text_item', '') !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
        <section class="s-features">
            <div class="s-features__container container">
                <div class="s-features__body">
                    <div class="s-features__item">
                        <div class="s-features__title">Комплексное снабжение строительных компаний</div>
                        @if($fields = Settings::get('about_groups'))
                            <div class="s-features__subtitle">Основные группы:</div>
                            <div class="s-features__links">
                                @foreach($fields as $field)
                                    @php
                                        $isSize = stripos(array_get($field, 'about_groups_size'), ',');
                                        if($isSize) [$width, $height] = explode(',', array_get($field, 'about_groups_size'));
                                        else [$width, $height] = [80, 100];
                                    @endphp
                                    <a class="s-features__link {{ $loop->iteration > 4 ? 's-features__link--wide' : '' }}"
                                       href="{{ array_get($field, 'about_groups_link', '') }}"
                                       title="{{ array_get($field, 'about_groups_title', '') }}">
                                        <span class="s-features__label">{{ array_get($field, 'about_groups_title', '') }}</span>
                                        <img class="s-features__pic lazy" src="/"
                                             data-src="{{ Settings::fileSrc(array_get($field, 'about_groups_img', '')) }}"
                                             width="{{ trim($width) }}" height="{{ trim($height) }}" alt="">
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="s-features__item">
                        <div class="s-features__grid">
                            @if($fields = Settings::get('about_conc_feats'))
                                <div class="s-features__col">
                                    <div class="s-features__title">Конкурентные преимущества</div>
                                    <div class="b-features">
                                        @foreach($fields as $field)
                                            @php
                                              $img = array_get($field, 'about_conc_feats_ico', '/static/images/common/ico_team.svg');
                                            @endphp
                                            <div class="b-features__item">
                                                <div class="b-features__icon lazy"
                                                     data-bg="{{ Settings::fileSrc($img) }}"></div>
                                                <div class="b-features__label">{{ array_get($field, 'about_conc_feats_text', '') }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if($img = Settings::get('about_conc_feats_img'))
                                <div class="s-features__col s-features__col--bg lazy"
                                     data-bg="{{ $img ? Settings::fileSrc($img) : '/static/images/common/s-features-bg.jpg' }}"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('about.certificates')
        @include('blocks.send_request')
    </main>

@stop
