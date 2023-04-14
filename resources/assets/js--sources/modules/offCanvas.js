import HcOffCanvasNav from 'hc-offcanvas-nav';

export const offCanvasNav = () => {
  new HcOffCanvasNav('#mobile-nav', {
    customToggle: '.header__burger',
    navTitle: 'Levering',
    levelTitles: true,
    levelTitleAsBack: true,
    labelBack: 'Назад'
  });
};

offCanvasNav();
