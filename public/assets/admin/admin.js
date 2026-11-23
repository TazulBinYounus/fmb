/* FMB admin panel behaviour (no build step; jQuery + Bootstrap 4 already loaded) */
(function () {
  'use strict';

  // Mobile sidebar toggle
  document.addEventListener('click', function (e) {
    var toggle = e.target.closest('[data-adm-toggle]');
    var sidebar = document.querySelector('.adm-sidebar');
    if (toggle && sidebar) { sidebar.classList.toggle('open'); return; }
    if (sidebar && sidebar.classList.contains('open') && !e.target.closest('.adm-sidebar')) sidebar.classList.remove('open');
  });

  // Delete / destructive confirmations: <form data-confirm="Delete this project?">
  document.addEventListener('submit', function (e) {
    var form = e.target;
    var message = form.getAttribute('data-confirm');
    if (message && !window.confirm(message)) { e.preventDefault(); return; }

    // Loading state: disable the submit button and show a spinner (prevents double submits)
    var btn = e.submitter || form.querySelector('[type=submit]');
    if (btn && !form.hasAttribute('data-no-loading')) {
      setTimeout(function () { btn.classList.add('is-loading'); btn.disabled = true; }, 0);
    }
  });

  // Image preview for file inputs: <input type="file" data-preview="#imgId">
  document.addEventListener('change', function (e) {
    var input = e.target;
    if (input.type !== 'file') return;
    var label = input.nextElementSibling;
    if (label && label.classList.contains('custom-file-label')) {
      label.textContent = input.files.length > 1 ? input.files.length + ' files selected' : (input.files[0] ? input.files[0].name : 'Choose file');
    }
    var target = input.getAttribute('data-preview') && document.querySelector(input.getAttribute('data-preview'));
    if (target && input.files[0] && input.files[0].type.indexOf('image/') === 0) {
      target.src = URL.createObjectURL(input.files[0]);
      target.classList.remove('d-none');
    }
  });

  // Slug field follows the name until edited manually: <input data-slug-source="#name">
  document.querySelectorAll('[data-slug-source]').forEach(function (slug) {
    var source = document.querySelector(slug.getAttribute('data-slug-source'));
    if (!source) return;
    var touched = slug.value.length > 0;
    slug.addEventListener('input', function () { touched = slug.value.length > 0; });
    source.addEventListener('input', function () {
      if (touched) return;
      slug.value = source.value.toLowerCase().normalize('NFKD').replace(/[̀-ͯ]/g, '')
        .replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '').slice(0, 80);
    });
  });

  // Repeater rows: <div data-repeater><template>…</template><div data-repeater-list>…</div><button data-repeater-add>
  document.addEventListener('click', function (e) {
    var add = e.target.closest('[data-repeater-add]');
    if (add) {
      var repeater = add.closest('[data-repeater]');
      var tpl = repeater.querySelector('template');
      var list = repeater.querySelector('[data-repeater-list]');
      var index = Date.now();
      list.insertAdjacentHTML('beforeend', tpl.innerHTML.replace(/__INDEX__/g, index));
      var first = list.lastElementChild.querySelector('input,textarea');
      if (first) first.focus();
      return;
    }
    var remove = e.target.closest('[data-repeater-remove]');
    if (remove) remove.closest('.adm-repeater-row').remove();
  });

  // Minimal rich-text editor: <textarea data-editor> becomes a contenteditable area with a toolbar.
  document.querySelectorAll('textarea[data-editor]').forEach(function (textarea) {
    var wrap = document.createElement('div');
    wrap.className = 'adm-editor';
    wrap.innerHTML =
      '<div class="adm-editor-toolbar">' +
      '<button type="button" data-cmd="bold" title="Bold"><i class="fa fa-bold"></i></button>' +
      '<button type="button" data-cmd="italic" title="Italic"><i class="fa fa-italic"></i></button>' +
      '<button type="button" data-cmd="formatBlock" data-val="h3" title="Heading">H</button>' +
      '<button type="button" data-cmd="formatBlock" data-val="p" title="Paragraph">P</button>' +
      '<button type="button" data-cmd="insertUnorderedList" title="Bullet list"><i class="fa fa-list-ul"></i></button>' +
      '<button type="button" data-cmd="insertOrderedList" title="Numbered list"><i class="fa fa-list-ol"></i></button>' +
      '<button type="button" data-cmd="createLink" title="Link"><i class="fa fa-link"></i></button>' +
      '<button type="button" data-cmd="unlink" title="Remove link"><i class="fa fa-unlink"></i></button>' +
      '<button type="button" data-cmd="removeFormat" title="Clear formatting"><i class="fa fa-eraser"></i></button>' +
      '<button type="button" data-cmd="source" title="Edit HTML" class="ml-auto"><i class="fa fa-code"></i></button>' +
      '</div><div class="adm-editor-area" contenteditable="true"></div>';
    textarea.parentNode.insertBefore(wrap, textarea);
    var area = wrap.querySelector('.adm-editor-area');
    area.innerHTML = textarea.value;
    textarea.style.display = 'none';
    var sourceMode = false;

    wrap.querySelector('.adm-editor-toolbar').addEventListener('click', function (e) {
      var b = e.target.closest('button');
      if (!b) return;
      var cmd = b.getAttribute('data-cmd');
      if (cmd === 'source') {
        sourceMode = !sourceMode;
        if (sourceMode) { textarea.value = area.innerHTML; textarea.style.display = ''; textarea.rows = 12; area.style.display = 'none'; }
        else { area.innerHTML = textarea.value; textarea.style.display = 'none'; area.style.display = ''; }
        return;
      }
      area.focus();
      if (cmd === 'createLink') {
        var url = window.prompt('Link URL (https://…)');
        if (url) document.execCommand('createLink', false, url);
        return;
      }
      document.execCommand(cmd, false, b.getAttribute('data-val') || null);
    });

    textarea.form && textarea.form.addEventListener('submit', function () {
      if (!sourceMode) textarea.value = area.innerHTML;
    });
  });

  // Copy-to-clipboard buttons: <button data-copy="https://…">
  document.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-copy]');
    if (!btn) return;
    var text = btn.getAttribute('data-copy');
    var done = function () { btn.innerHTML = '<i class="fa fa-check"></i>'; setTimeout(function () { btn.innerHTML = '<i class="fa fa-link"></i>'; }, 1500); };
    if (navigator.clipboard && window.isSecureContext) { navigator.clipboard.writeText(text).then(done); }
    else { window.prompt('Copy this link:', text); }
  });

  // Auto-hide success alerts
  setTimeout(function () {
    document.querySelectorAll('.alert-success[data-autohide]').forEach(function (a) { a.style.transition = 'opacity .4s'; a.style.opacity = '0'; setTimeout(function () { a.remove(); }, 400); });
  }, 4000);
})();
