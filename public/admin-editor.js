(() => {
  const editor = document.querySelector('.rich-editor');
  const source = document.querySelector('.rich-source');
  const form = document.querySelector('.editor-form');
  const excerpt = document.querySelector('#excerpt');
  const counter = document.querySelector('#excerpt-count');

  if (!editor || !source || !form) return;

  const sync = () => { source.value = editor.innerHTML; };
  editor.addEventListener('input', sync);
  form.addEventListener('submit', sync);
  excerpt?.addEventListener('input', () => { counter.textContent = `${excerpt.value.length} / 320`; });
  if (excerpt && counter) counter.textContent = `${excerpt.value.length} / 320`;

  document.querySelectorAll('.rich-toolbar button[data-command]').forEach(button => {
    button.addEventListener('mousedown', event => event.preventDefault());
    button.addEventListener('click', () => {
      const command = button.dataset.command;
      let value = button.dataset.value || null;
      if (command === 'createLink') {
        value = window.prompt('Enter a web address or email link');
        if (!value) return;
        if (!/^(https?:\/\/|mailto:|tel:|#)/i.test(value)) value = `https://${value}`;
      }
      editor.focus();
      document.execCommand(command, false, value);
      sync();
    });
  });

  document.querySelector('#cover_image')?.addEventListener('change', event => {
    const file = event.currentTarget.files?.[0];
    const label = event.currentTarget.closest('.upload-control');
    const text = label?.querySelector('b');
    if (file && text) text.textContent = file.name;
  });
})();
