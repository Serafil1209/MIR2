// ===== Мобильное меню =====
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('mobileMenuToggle');
    const nav = document.getElementById('mainNav');
    if (!toggle || !nav) return;

    const mq = window.matchMedia('(max-width: 900px)');
    const update = () => {
        toggle.style.display = mq.matches ? 'flex' : 'none';
        if (!mq.matches) nav.classList.remove('open');
    };
    update();
    mq.addEventListener('change', update);

    toggle.addEventListener('click', () => nav.classList.toggle('open'));
});