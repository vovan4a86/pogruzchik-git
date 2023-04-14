import $ from 'jquery';

export const filterBlockLinks = () => {
  const $link = $('[data-block-link]');
  const cleanPath = window.location.origin + window.location.pathname;

  $link.filter('[href="' + cleanPath + '"]').addClass('is-active');
};

filterBlockLinks();
