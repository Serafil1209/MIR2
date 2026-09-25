<?php
/** Главная страница админ-панели */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

$settings = getSettings();
$title = 'Админ-панель';
include __DIR__ . '/../includes/header.php';
?>
<div class="container section">
    <h1 class="section-title" style="text-align:left">Админ-панель ММЦ «МИР»</h1>
    <p>Вы вошли как: <?= e($_SESSION['admin_login'] ?? 'admin') ?>
       · <a href="/admin/logout.php">Выйти</a></p>
    <ul class="sved-subdivisions">
        <li><a class="sved-subdivisions__link" href="/admin/news.php">Новости</a></li>
        <li><a class="sved-subdivisions__link" href="/admin/pages.php">Страницы сайта</a></li>
        <li><a class="sved-subdivisions__link" href="/admin/documents.php">Документы (файлы раздела «Сведения» и др.)</a></li>
        <li><a class="sved-subdivisions__link" href="/admin/settings.php">Настройки сайта</a></li>
        <li><a class="sved-subdivisions__link" href="/admin/feedback.php">Обращения граждан</a></li>
        <li><a class="sved-subdivisions__link" href="/svedeniya/">Открыть раздел «Сведения об образовательной организации» →</a></li>
    </ul>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
