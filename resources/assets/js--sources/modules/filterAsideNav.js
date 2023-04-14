import $ from 'jquery';

export const filterAsideNav = () => {
  const $link = $('[data-aside-link]');
  const cleanPath = window.location.origin + window.location.pathname;

  setActive($link, cleanPath);

  // выделение активного пункта категории в левом меню на странице товара
  function isProduct() {
    return window.location.toString().split('/').length >= 7;
  }

  if (isProduct) {
    const url = window.location.toString().split('/').slice(0, -1).join('/');
    const shortedUrl = window.location.toString().split('/').slice(0, -2).join('/');

    setActive($link, url);
    setActive($link, shortedUrl);
  }

  function setActive(nav, path) {
    nav
      .filter('[href="' + path + '"]')
      .addClass('is-active')
      .closest('.aside-nav__body')
      .slideDown('fast')
      .closest('.aside-nav__item')
      .addClass('is-active');
  }
};

filterAsideNav();
