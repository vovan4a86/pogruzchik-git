import Swiper, { Pagination, EffectFade, Autoplay, Navigation, FreeMode, Thumbs } from 'swiper';
import { LazyInstance } from './lazyLoading';

export const mainSlider = ({ slider, pagination, speed, delay }) => {
  new Swiper(slider, {
    modules: [Pagination, EffectFade, Autoplay],
    fadeEffect: { crossFade: true },
    effect: 'fade',
    autoplay: {
      delay: delay || 3000,
      disableOnInteraction: false
    },
    pagination: {
      el: pagination,
      clickable: true
    },
    speed: speed
  });
};

export const sectionSlider = ({ slider, navigationPrev, navigationNext, speed, delay, gap }) => {
  new Swiper(slider, {
    modules: [Navigation],
    slidesPerView: 1.3,
    centeredSlides: false,
    spaceBetween: 10,
    autoplay: {
      delay: delay || 3000,
      disableOnInteraction: false
    },
    navigation: {
      nextEl: navigationNext,
      prevEl: navigationPrev
    },
    speed: speed || 600,
    breakpoints: {
      600: {
        slidesPerView: 1.3,
        spaceBetween: 20,
        centeredSlides: false
      },
      810: {
        slidesPerView: 3.2,
        spaceBetween: 20,
        centeredSlides: false
      },
      1080: {
        slidesPerView: 3.2,
        spaceBetween: 20,
        centeredSlides: false
      },
      1440: {
        slidesPerView: 4,
        spaceBetween: 30,
        centeredSlides: false
      }
    },
    observer: true,
    observeParents: true,
    on: {
      init: function () {
        LazyInstance.update();
      }
    }
  });
};

export const productSlider = ({ thumbs, prodSlider }) => {
  const thumbSlider = new Swiper(thumbs, {
    modules: [FreeMode],
    spaceBetween: 10,
    slidesPerView: 3,
    freeMode: true,
    watchSlidesProgress: true,
    speed: 850
  });

  new Swiper(prodSlider, {
    modules: [Pagination, Thumbs],
    thumbs: {
      swiper: thumbSlider
    },
    speed: 850
  });
};

productSlider({
  thumbs: '[data-product-slider-thumbs]',
  prodSlider: '[data-product-slider]'
});

mainSlider({
  slider: '[data-hero-slider]',
  pagination: '[data-hero-pagination]',
  speed: 850,
  delay: 4000
});

sectionSlider({
  slider: '[data-sert-slider]',
  navigationPrev: '[data-sert-prev]',
  navigationNext: '[data-sert-next]'
});

sectionSlider({
  slider: '[data-related-slider]',
  navigationPrev: '[data-related-prev]',
  navigationNext: '[data-related-next]'
});
