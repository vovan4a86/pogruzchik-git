import $ from 'jquery';
import Swiper, { Mousewheel, Pagination } from 'swiper';
import { LazyInstance } from './lazyLoading';

let pageSlider = document.querySelector('.page-slider');

export const pageScroller = () => {
  window.addEventListener('DOMContentLoaded', () => {
    let isPageSliderInitialized = pageSlider.classList.contains('swiper-initialized');
    let isPc = window.innerWidth >= 1080;
    let isTablet = window.innerWidth < 1079;

    class PageSlider {
      constructor(pageSlider, isPc, isTablet, pageSlides, speed) {
        this.pageSlider = pageSlider;
        this.isPc = isPc;
        this.isTablet = isTablet;
        this.pageSlides = pageSlides;
        this.speed = speed;
        this.currentSlide = 0;
        this.lastSlideIndex = this.pageSlides.length - 1;
      }

      init() {
        LazyInstance.update();

        let isPc = this.isPc;
        let isTablet = this.isTablet;

        if (isPc && !isPageSliderInitialized) {
          pageSlider = new Swiper('.page-slider', {
            modules: [Mousewheel, Pagination],
            direction: 'vertical',
            spaceBetween: 0,
            slidesPerView: 'auto',
            speed: 800,

            keyboard: {
              enabled: true,
              onlyInViewport: true,
              pageUpDown: true
            },

            mousewheel: {
              sensitivity: 1
            },

            watchOverflow: true,
            init: false,
            allowTouchMove: false,

            on: {
              init: function () {
                const background = this.slides[this.activeIndex].dataset.background;
                background && setHeaderColor(background, this.activeIndex, this.slides.length - 1);
              },
              slideNextTransitionStart: function () {
                const background = this.slides[this.activeIndex].dataset.background;
                background && setHeaderColor(background, this.activeIndex, this.slides.length - 1);
              },
              slidePrevTransitionStart: function () {
                const background = this.slides[this.activeIndex].dataset.background;
                background && setHeaderColor(background, this.activeIndex, this.slides.length - 1);
              }
            }
          });
          pageSlider.init();
        } else if (isTablet && isPageSliderInitialized) {
          pageSlider.destroy(true, true);
        }
      }
    }

    const pageSliderInstance = new PageSlider(
      pageSlider,
      isPc,
      isTablet,
      document.querySelectorAll('.section--slide'),
      800
    );
    pageSliderInstance.init();

    window.addEventListener('resize', () => {
      pageSliderInstance.init();
    });
  });
};

function setHeaderColor(color, currentSlide) {
  const $header = $('.header--home');
  const $headerTop = $('.header--home .header__top');
  const $headerTopHeight = $headerTop.outerHeight();

  switch (color) {
    case 'light':
      setTimeout(() => {
        $header.addClass('header--dark');
      }, 450);
      break;
    case 'dark':
      setTimeout(() => {
        $header.removeClass('header--dark');
      }, 450);
      break;
  }

  if (currentSlide > 0) {
    setTimeout(() => {
      $header.css('transform', `translateY(-${$headerTopHeight}px)`);
    }, 450);
  } else {
    setTimeout(() => {
      $header.css('transform', `translateY(0)`);
    }, 450);
  }
}

pageSlider && pageScroller();
