import $ from 'jquery';

export const filterAsideNav = () => {
  const $link = $('[data-aside-link]');
  const cleanPath = window.location.origin + window.location.pathname;

  $link
    .filter('[href="' + cleanPath + '"]')
    .addClass('is-active')
    .parent()
    .parent()
    .parent()
    .slideDown('fast')
    .parent()
    .addClass('is-active');
};

filterAsideNav();
