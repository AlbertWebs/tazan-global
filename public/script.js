(() => {
  const progress = document.querySelector('.scroll-progress');
  const revealItems = document.querySelectorAll('.reveal');
  const parallaxItems = document.querySelectorAll('.parallax');
  const nav = document.querySelector('.navigation');
  const menu = document.querySelector('.menu-toggle');
  let ticking = false;

  const updateScroll = () => {
    const max = document.documentElement.scrollHeight - window.innerHeight;
    progress.style.width = `${max > 0 ? (window.scrollY / max) * 100 : 0}%`;
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      parallaxItems.forEach(item => {
        const rect = item.parentElement.getBoundingClientRect();
        const speed = Number(item.dataset.speed || 0.1);
        item.style.transform = `translate3d(0, ${rect.top * -speed}px, 0) scale(1.08)`;
      });
    }
    ticking = false;
  };
  window.addEventListener('scroll', () => {
    if (!ticking) { window.requestAnimationFrame(updateScroll); ticking = true; }
  }, { passive: true });
  window.addEventListener('resize', updateScroll, { passive: true });
  updateScroll();

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); }
      });
    }, { threshold: 0.12 });
    revealItems.forEach(item => observer.observe(item));
  } else revealItems.forEach(item => item.classList.add('is-visible'));

  menu.addEventListener('click', () => {
    const isOpen = nav.classList.toggle('open');
    menu.setAttribute('aria-expanded', String(isOpen));
    menu.setAttribute('aria-label', isOpen ? 'Close navigation' : 'Open navigation');
  });
  nav.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
    nav.classList.remove('open'); menu.setAttribute('aria-expanded', 'false');
    menu.setAttribute('aria-label', 'Open navigation');
  }));
  document.querySelector('#year').textContent = new Date().getFullYear();
})();
