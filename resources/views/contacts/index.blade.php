@extends('template')
@section('content')
    @include('blocks.bread')
    <main>
        <section class="contacts">
            <div class="contacts__container container">
                <div class="contacts__grid">
                    <div class="contacts__about">
                        @if($fields = Settings::get('contacts'))
                            <div class="contacts__title">Контакты</div>
                            <div class="contacts__datalist">
                                <dl>
                                    <dt>Адрес:</dt>
                                    <dd>{!! array_get($fields, 'contacts_address', '')  !!}</dd>
                                </dl>
                                <dl>
                                    <dt>E-mail:</dt>
                                    <dd>
                                        <a href="mailto:{{ array_get($fields, 'contacts_email', '') }}">
                                            {{ array_get($fields, 'contacts_email', '') }}
                                        </a>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Телефон:</dt>
                                    <dd>
                                        <a href="tel:{{ preg_replace('/[^\d+]/', '', array_get($fields, 'contacts_phone', '')) }}">
                                            {{ array_get($fields, 'contacts_phone', '') }}
                                        </a>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Режим работы:</dt>
                                    <dd>{!! array_get($fields, 'contacts_hours', '')  !!}</dd>
                                </dl>
                                @if(array_get($fields, 'contacts_tg') || array_get($fields, 'contacts_wp'))
                                    <dl>
                                        <dt>Пишите нам</dt>
                                        <dd>
                                            @if(array_get($fields, 'contacts_tg'))
                                                <a class="contacts__msg-icon lazy"
                                                   href="https://t.me/{{ array_get($fields, 'contacts_tg', '') }}"
                                                   data-bg="static/images/common/ico_tg.svg" target="_blank"
                                                   title="Написать в Telegram"></a>
                                            @endif
                                            @if(array_get($fields, 'contacts_wp'))
                                                <a class="contacts__msg-icon lazy"
                                                   href="https://wa.me/{{ preg_replace('/[^\d+]/', '', array_get($fields, 'contacts_wp' , '')) }}"
                                                   data-bg="static/images/common/ico_wa.svg" target="_blank"
                                                   title="Написать в Whatsapp"></a>
                                            @endif
                                        </dd>
                                    </dl>
                                @endif
                            </div>
                        @endif
                        <div class="contacts__action">
                            <button class="btn btn--primary btn-reset" type="button" data-popup data-src="#consult"
                                    aria-label="Написать в форме обратной связи">
                                <span>Написать нам</span>
                            </button>
                        </div>
                    </div>
                    @if($lat && $long)
                        <div class="contacts__map" id="map" data-map data-lat="{{ $lat }}" data-long="{{ $long }}"
                             data-hint="{{ Settings::get('contacts')['contacts_address'] }}"></div>
                    @endif
                </div>
                @if($reks)
                <div class="contacts__data" x-data="{ dataIsOpen: false }">
                    <div class="contacts__subtitle">Реквизиты</div>
                    @foreach($reks as $row)
                    <div class="contacts__row" {{ $loop->iteration > 3 ? "x-show=dataIsOpen x-transition.duration.250ms x-cloak" : null }}>
                        @foreach($row as $name => $value)
                        <div class="contacts__column">
                            <div class="contacts__caption">{{ $name['rekvizit_name'] }}</div>
                            <div class="contacts__value">{{ $value{'rekvizit_value'} }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                    @if(count($reks) > 3)
                        <div class="contacts__action" @click="dataIsOpen = !dataIsOpen" aria-label="Развернуть">
                            <span x-show="!dataIsOpen">Развернуть</span>
                            <span x-show="dataIsOpen">Свернуть</span>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </section>
    </main>
@stop
