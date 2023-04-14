import $ from 'jquery';

export const asideNav = () => {
  $('[data-aside-head]').on('click', function () {
    if ($(this).siblings('[data-aside-body]').is(':visible')) {
      $(this).parent().removeClass('is-active');
      $(this).siblings('[data-aside-body]').slideUp();
    } else {
      closeOpenedMenu();

      $(this).parent().addClass('is-active');
      $(this).siblings('[data-aside-body]').slideDown();
    }
  });

  function closeOpenedMenu() {
    $('.aside-nav__item').each(function () {
      $(this).removeClass('is-active');
    });

    $('.aside-nav__body').each(function () {
      $(this).slideUp();
    });
  }
};

asideNav();
