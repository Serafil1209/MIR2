</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <h4 class="footer-title"><?= e($settings['site_title'] ?? 'ММЦ «МИР»') ?></h4>
                <p style="color: rgba(255,255,255,0.7); margin-bottom: 16px;">
                    <?= e($settings['site_subtitle'] ?? 'Многофункциональный Молодёжный Центр') ?>
                </p>
                <p style="color: rgba(255,255,255,0.5); font-size: 0.9rem;">
                    <?= e($settings['site_address'] ?? '') ?>
                </p>
            </div>
            <div>
                <h4 class="footer-title">Контакты</h4>
                <p><a href="tel:<?= e($settings['site_phone'] ?? '') ?>"><?= e($settings['site_phone'] ?? '') ?></a></p>
                <p><a href="mailto:<?= e($settings['site_email'] ?? '') ?>"><?= e($settings['site_email'] ?? '') ?></a></p>
                <p><a href="/contacts.php">Форма обратной связи</a></p>
            </div>
            <div>
                <h4 class="footer-title">Разделы</h4>
                <p><a href="/about.php">О Центре</a></p>
                <p><a href="/news.php">Новости</a></p>
                <p><a href="/svedeniya/">Сведения об ОО</a></p>
                <p><a href="/admin/">Админ-панель</a></p>
            </div>
        </div>
        <div class="footer-bottom">
            © <?= date('Y') ?> <?= e($settings['site_title'] ?? 'ММЦ «МИР»') ?>. Все права защищены.
            <?php if (!empty($settings['site_inn'])): ?>
                | <?= e($settings['site_inn']) ?>
            <?php endif; ?>
        </div>
    </div>
</footer>

<!-- Панель доступности для слабовидящих -->
<div class="accessibility-toolbar" role="toolbar" aria-label="Настройки доступности">
    <button class="icon-btn" id="toggle-contrast" title="Версия для слабовидящих" aria-label="Версия для слабовидящих">◐</button>
    <button class="icon-btn" id="toggle-font" title="Крупный шрифт" aria-label="Крупный шрифт">А+</button>
</div>

<script src="/assets/js/script.js"></script>
</body>
</html>
<script src="/assets/js/script.js"></script>
</body>
</html>