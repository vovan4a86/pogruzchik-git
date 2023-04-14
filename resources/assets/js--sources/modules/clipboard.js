import ClipboardJS from 'clipboard';

const clipboard = new ClipboardJS('[data-share-link]');

clipboard.on('success', function (e) {
  copyContent(e.text, e).then(() => changeCopyLabel(e));

  async function copyContent(text) {
    try {
      await navigator.clipboard.writeText(text);
    } catch (err) {
      console.error('Failed to copy: ', err);
    }
  }

  function changeCopyLabel(e) {
    const label = e.trigger.querySelector('.share-list__label');
    label.textContent = 'Ссылка скопирована';

    setTimeout(() => {
      label.textContent = 'Скопировать ссылку';
    }, 1800);
  }
});

clipboard.on('error', function (e) {
  console.error('Action:', e.action);
  console.error('Trigger:', e.trigger);
});
