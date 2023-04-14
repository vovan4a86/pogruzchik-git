@if($imgs = Settings::get('our_certificates'))
    <section class="s-sert">
        <div class="s-sert__container container">
            <div class="s-sert__title">Наши сертификаты</div>
            <div class="s-sert__body">
                <div class="s-sert__slider swiper" data-sert-slider>
                    <div class="s-sert__wrapper swiper-wrapper">
                        @foreach($imgs as $img)
                            @php
                              $file = array_get($img, 'our_certificates_img', '');
                            @endphp
                            <a class="s-sert__slide swiper-slide"
                               href="{{ Settings::fileSrc($file) }}"
                               data-fancybox="gallery" data-caption="{{ array_get($img, 'our_certificates_name', '') }}"
                               title="{{ array_get($img, 'our_certificates_name', '') }}">
                                <img class="s-sert__img lazy"
                                     src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                     data-src="{{ Settings::fileSrc(Settings::getAlterImage($file, '-prev.')) }}" width="278" height="380"
                                     alt="{{ array_get($img, 'our_certificates_name', '') }}">
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="slider-nav">
                    <div class="slider-nav__link slider-nav__link--prev lazy"
                         data-bg="static/images/common/ico_left.svg" data-sert-prev></div>
                    <div class="slider-nav__link slider-nav__link--next lazy"
                         data-bg="static/images/common/ico_right.svg" data-sert-next></div>
                </div>
            </div>
        </div>
    </section>
@endif
