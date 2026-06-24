// Confirm delete helper (no inline event handlers) to work with strict CSP.

function attachConfirmDelete() {
  const forms = document.querySelectorAll('form.js-confirm-delete');

  forms.forEach((form) => {
    form.addEventListener('submit', (e) => {
      const message = form.getAttribute('data-confirm') || 'Are you sure?';
      // If user cancels, prevent the DELETE request.
      if (!window.confirm(message)) {
        e.preventDefault();
      }
    });
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', attachConfirmDelete);
} else {
  attachConfirmDelete();
}

