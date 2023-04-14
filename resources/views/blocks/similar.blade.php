@if(count($similar))
    <section class="s-related">
        <div class="s-related__container container">
            <div class="s-related__title">Похожие товары</div>
            <div class="related-nav">
                <div class="related-nav__link related-nav__link--prev lazy" data-bg="/static/images/common/ico_l.svg"
                     data-related-prev></div>
                <div class="related-nav__link related-nav__link--next lazy" data-bg="/static/images/common/ico_r.svg"
                     data-related-next></div>
            </div>
            <div class="s-related__slider swiper" data-related-slider>
                <div class="s-related__wrapper swiper-wrapper">
                    @foreach($similar as $item)
                        <div class="s-related__item swiper-slide">
                            @include('catalog.product_item', compact('item'))
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
