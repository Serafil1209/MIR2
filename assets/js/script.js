/* ММЦ «МИР» — интерактив: мобильное меню, панель доступности (слабовидящие), формы */
(function () {
    'use strict';

    /* ---------- Мобильное меню ---------- */
    var toggle = document.getElementById('mobileMenuToggle');
    var nav = document.getElementById('mainNav');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            var open = nav.classList.toggle('open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    /* ---------- Панель доступности (версия для слабовидящих) ---------- */
    var body = document.body;

    function setCookie(name, value, days) {
        var d = new Date();
        d.setTime(d.getTime() + days * 864e5);
        document.cookie = name + '=' + encodeURIComponent(value) +
            '; expires=' + d.toUTCString() + '; path=/; SameSite=Lax';
    }

    // Восстановление настроек из cookie (чтобы работать без JS и между страницами)
    function getCookie(name) {
        var m = document.cookie.match(new RegExp('(?:^|; )' + name + '=([^;]*)'));
        return m ? decodeURIComponent(m[1]) : '';
    }

    if (getCookie('sv_large_font')) body.classList.add('font-large');
    if (getCookie('sv_high_contrast')) body.classList.add('high-contrast');
    if (getCookie('sv_images_off')) body.classList.add('images-off');

    var fontStep = parseInt(getCookie('sv_font_step') || '0', 10);
    applyFontStep(fontStep);

    function applyFontStep(step) {
        step = Math.max(-1, Math.min(3, step));
        var scale = [0.9, 1, 1.15, 1.3, 1.45][step + 1];
        document.documentElement.style.setProperty('--font-scale', scale);
        return step;
    }

    var toolbar = document.querySelector('.accessibility-toolbar');
    if (toolbar) {
        toolbar.addEventListener('click', function (ev) {
            var btn = ev.target.closest('[data-sv]');
            if (!btn) return;
            var action = btn.getAttribute('data-sv');

            if (action === 'contrast') {
                var on = body.classList.toggle('high-contrast');
                setCookie('sv_high_contrast', on ? '1' : '', on ? 365 : -1);
                btn.setAttribute('aria-pressed', on ? 'true' : 'false');
            } else if (action === 'fontplus') {
                fontStep = applyFontStep(fontStep + 1);
                setCookie('sv_font_step', String(fontStep), 365);
                body.classList.add('font-large');
                setCookie('sv_large_font', '1', 365);
            } else if (action === 'fontminus') {
                fontStep = applyFontStep(fontStep - 1);
                setCookie('sv_font_step', String(fontStep), 365);
                if (fontStep <= 0) {
                    body.classList.remove('font-large');
                    setCookie('sv_large_font', '', -1);
                }
            } else if (action === 'imagesoff') {
                var off = body.classList.toggle('images-off');
                setCookie('sv_images_off', off ? '1' : '', off ? 365 : -1);
                btn.setAttribute('aria-pressed', off ? 'true' : 'false');
            } else if (action === 'reset') {
                body.classList.remove('high-contrast', 'font-large', 'images-off');
                applyFontStep(0);
                setCookie('sv_high_contrast', '', -1);
                setCookie('sv_large_font', '', -1);
                setCookie('sv_images_off', '', -1);
                setCookie('sv_font_step', '0', 365);
                toolbar.querySelectorAll('[aria-pressed]').forEach(function (b) {
                    b.setAttribute('aria-pressed', 'false');
                });
            }
        });
    }

    /* ---------- Подсветка активного пункта раздела «Сведения» ---------- */
    document.querySelectorAll('.sved-nav__list a').forEach(function (a) {
        if (a.href === window.location.href) a.classList.add('active');
    });

    /* ---------- Плавная прокрутка к якорям компонентов ОП/педсостава ---------- */
    document.querySelectorAll('a[href*="#"]').forEach(function (a) {
        a.addEventListener('click', function () {
            var id = (a.getAttribute('href') || '').split('#')[1];
            if (!id) return;
            var el = document.getElementById(id);
            if (el) {
                setTimeout(function () { el.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 30);
            }
        });
    });
})();
