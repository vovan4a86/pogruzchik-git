import { Fancybox } from '@fancyapps/ui';

export const closeBtn =
  '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M25 7 7 25M25 25 7 7"/></svg>';

Fancybox.bind('[data-fancybox]', {
  closeButton: 'outside',
  hideClass: 'fancybox-zoomOut',
  infinite: false
});

Fancybox.bind('[data-popup]', {
  mainClass: 'popup--custom',
  template: { closeButton: closeBtn },
  hideClass: 'fancybox-zoomOut',
  hideScrollbar: false
});

export const showSuccessRequestDialog = () => {
  Fancybox.show([{ src: '#request-done', type: 'inline' }], {
    mainClass: 'popup--custom popup--complete',
    template: { closeButton: closeBtn },
    hideClass: 'fancybox-zoomOut'
  });
};

// в свой модуль форм, импортируешь функцию вызова «спасибо» → вызываешь on success
// import { showSuccessRequestDialog } from 'пудо до компонента'
// вызываешь где нужно
// showSuccessRequestDialog();
