@if($slider = Settings::get('main_slider'))
    <section class="hero section section--slide swiper-slide" data-background="dark">
        <div class="hero__slider swiper" data-hero-slider>
            <div class="hero__wrapper swiper-wrapper">
                @foreach($slider as $slide)
                    <div class="hero__slide swiper-slide">
                        <picture>
                            <source type="image/webp" srcset="/"
                                    data-srcset="{{ Settings::fileSrc(Settings::getAlterImage($slide['main_slider_img'], '--1080.')) }} 1080,
                                    {{ Settings::fileSrc($slide['main_slider_img']) }}"
                                    data-sizes="100w">
                            <img class="hero__bg lazy"
                                 src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                 data-src="{{ Settings::fileSrc(Settings::getAlterImage($slide['main_slider_img'], '--1080.')) }} 1080,
                                 {{ Settings::fileSrc($slide['main_slider_img']) }}"
                                 data-sizes="100w" width="1920" height="1080"
                                 alt="">
                        </picture>
                        <div class="hero__content">
                            <div class="hero__container container">
                                <div class="hero__title">{{ $slide['main_slider_title'] }}</div>
                                <div class="hero__text">{{ $slide['main_slider_text'] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="hero__pagination" data-hero-pagination></div>
            <div class="hero__mouse mouse-scroller">
                <div class="mouse-scroller__icon lazy" data-bg="static/images/common/ico_mouse.svg"></div>
            </div>
        </div>
    </section>
@endif
