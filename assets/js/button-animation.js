document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.wp-block-button__link').forEach(button => {
    button.addEventListener('mouseenter', () => {
      button.classList.remove('is-animated'); // reset
      void button.offsetWidth; // force reflow
      button.classList.add('is-animated'); // reapply
    });
  });
});