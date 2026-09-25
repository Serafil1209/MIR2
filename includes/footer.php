<?php
/**
 * includes/footer.php — подвал сайта + панель доступности (версия для слабовидящих).
 * Закрытие <main>, открытого в header.php.
 */
?>
</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <h2 class="footer-title"><?= e($settings['site_title'] ?? 'ММЦ «МИР»') ?></h2>
                <p><?= e($settings['site_full_name'] ?? 'Муниципальное бюджетное учреждение дополнительного образования «Многофункциональный молодёжный центр „МИР“»') ?></p>
                <p><?= e($settings['site_address'] ?? '156013, Костромская область, Костромской район, с. Сандогора, ул. Молодёжная, д. 8') ?></p>
            </div>
            <div>
                <h2 class="footer-title">Контакты</h2>
                <p><a href="tel:<?= preg_replace('/[^0-9+]/', '', e($settings['site_phone'] ?? '+74942392114')) ?>"><?= e($settings['site_phone'] ?? '+7 (4942) 39-21-14') ?></a></p>
                <p><a href="mailto:<?= e($settings['site_email'] ?? 'mmc-mir@44region.ru') ?>"><?= e($settings['site_email'] ?? 'mmc-mir@44region.ru') ?></a></p>
                <p>Режим работы: пн–пт 9:00–20:00, сб 10:00–18:00, вс — выходной</p>
                <p><a href="/contacts.php">Форма обратной связи</a></p>
            </div>
            <div>
                <h2 class="footer-title">Сведения об образовательной организации</h2>
                <nav aria-label="Дополнительная навигация по разделу «Сведения»">
                    <p><a href="/svedeniya/">Главная страница раздела</a></p>
                    <p><a href="/svedeniya/?sub=osnovnye-svedeniya">Основные сведения</a></p>
                    <p><a href="/svedeniya/?sub=documenty">Документы</a></p>
                    <p><a href="/svedeniya/?sub=obrazovanie">Образование</a></p>
                    <p><a href="/svedeniya/?sub=pedagogicheskiy-sostav">Педагогический состав</a></p>
                    <p><a href="/svedeniya/?sub=finansovo-hozyaystvennaya-deyatelnost">Финансово-хозяйственная деятельность</a></p>
                </nav>
            </div>
            <div>
                <h2 class="footer-title">Разделы сайта</h2>
                <p><a href="/about.php">О Центре</a></p>
                <p><a href="/activities.php">Деятельность</a></p>
                <p><a href="/projects.php">Проекты</a></p>
                <p><a href="/news.php">Новости</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            © <?= date('Y') ?> <?= e($settings['site_title'] ?? 'ММЦ «МИР»') ?>. Все права защищены.
            <?php if (!empty($settings['site_inn'])): ?> | ИНН <?= e($settings['site_inn']) ?><?php endif; ?>
            <?php if (!empty($settings['site_ogrn'])): ?> | ОГРН <?= e($settings['site_ogrn']) ?><?php endif; ?>
        </div>
    </div>
</footer>

<!-- Версия сайта для слабовидящих (ст. 29 ФЗ № 273-ФЗ, требования к доступности) -->
<div class="accessibility-toolbar" role="toolbar" aria-label="Настройки доступности сайта">
    <span class="accessibility-toolbar__label">Версия для слабовидящих:</span>
    <button type="button" class="icon-btn" data-sv="contrast" title="Высококонтрастная чёрно-белая схема" aria-pressed="false">◐ Контраст</button>
    <button type="button" class="icon-btn" data-sv="fontplus" title="Увеличить шрифт" aria-label="Увеличить шрифт">А+</button>
    <button type="button" class="icon-btn" data-sv="fontminus" title="Уменьшить шрифт" aria-label="Уменьшить шрифт">А−</button>
    <button type="button" class="icon-btn" data-sv="imagesoff" title="Отключить изображения" aria-pressed="false">Изобр.</button>
    <button type="button" class="icon-btn" data-sv="reset" title="Сбросить настройки">✕ Сброс</button>
</div>

<script src="/assets/js/script.js"></script>
</body>
</html>
