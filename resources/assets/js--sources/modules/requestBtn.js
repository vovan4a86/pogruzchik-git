import { setThrottling } from '../functions/throttling';
import $ from 'jquery';

export const requestBtn = () => {
  const $button = $('.request-btn');
  const $headerTopHeight = $('.header__top').outerHeight();

  const manageTrigger = () => {
    if ($button) {
      if (window.scrollY >= 500) {
        $button.css('top', $headerTopHeight + 5 + 'px');

        setTimeout(() => {
          $button.addClass('is-sticky');
        }, 450);
      } else {
        $button.css('top', 10 + 'px');
        $button.removeClass('is-sticky');
      }

      optimizedHandler();
    }
  };

  const optimizedHandler = setThrottling(manageTrigger, 100);

  window.addEventListener('scroll', optimizedHandler);
};

// requestBtn();
