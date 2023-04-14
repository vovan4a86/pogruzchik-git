import hcSticky from 'hc-sticky';
import { setThrottling } from '../functions/throttling';
import $ from 'jquery';

export const stickyHeader = ({ headerSelector }) => {
  new hcSticky(headerSelector);

  const $header = $(headerSelector);
  const $headerTopHeight = $('.header__top').outerHeight();

  const manageTrigger = () => {
    if ($header) {
      if (window.scrollY >= 50) {
        headerSelector === '.header--landing' && $header.addClass('header--dark');
        $header.css('transform', `translateY(-${$headerTopHeight}px)`);
        $header.addClass('sticky');
      } else {
        headerSelector === '.header--landing' && $header.removeClass('header--dark');
        $header.css('transform', `translateY(0)`);
        $header.removeClass('sticky');
      }

      optimizedHandler();
    }
  };

  const optimizedHandler = setThrottling(manageTrigger, 100);

  window.addEventListener('scroll', optimizedHandler);
};

stickyHeader({
  headerSelector: '.header--inner'
});

stickyHeader({
  headerSelector: '.header--landing'
});
