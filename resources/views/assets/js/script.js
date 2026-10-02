const glow = document.getElementById('glow');

window.addEventListener('pointermove', (event) => {
  glow.style.left = `${event.clientX}px`;
  glow.style.top = `${event.clientY}px`;
});

window.addEventListener('load', () => {
  document.body.animate(
    [{ opacity: 0 }, { opacity: 1 }],
    { duration: 450, easing: 'ease-out' }
  );
});
