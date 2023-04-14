import $ from 'jquery';
import { isLocalStorageEnabled } from '../functions/isLocalStorageEnabled';

export const cookies = () => {
  const cookieBlock = $('.cookies');

  localStorage.getItem('levering-cookies') ? cookieBlock.remove() : showCookieDialog();

  function showCookieDialog() {
    setTimeout(() => {
      cookieBlock.addClass('is-active');
    }, 3000);
  }

  cookieBlock.on('click', function (event) {
    const target = event.target;

    target.closest('.cookies__btn') && cookieBlock.fadeOut(250);

    isLocalStorageEnabled() && localStorage.setItem('levering-cookies', 'confirmed');
  });
};

cookies();
