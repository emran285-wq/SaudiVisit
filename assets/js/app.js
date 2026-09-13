const toggle = document.querySelector('.nav-toggle');
const nav = document.querySelector('.site-nav');
if (toggle && nav) {
  toggle.addEventListener('click', () => {
    const open = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!open));
    nav.classList.toggle('open', !open);
  });
}

document.querySelectorAll('.newsletter').forEach((form) => {
  form.addEventListener('submit', () => {
    const button = form.querySelector('button');
    if (button) {
      button.textContent = 'Added ✓';
      button.disabled = true;
    }
  });
});
