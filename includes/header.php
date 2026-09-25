<?php
/**
 * includes/header.php — шапка сайта.
 * Ожидает переменные:
 *   $title        — заголовок страницы
 *   $currentPage  — текущий раздел для подсветки меню
 *   $settings     — настройки сайта (загружаются автоматически)
 */
if (!isset($settings)) {
    $settings = function_exists('getSettings') ? getSettings() : [];
}
$currentPage = $currentPage ?? '';

// Пункт 3 Требований (приказ Рособрнадзора № 1493): доступ к разделу
// «Сведения об образовательной организации» — с главной страницы и из основного меню.
$svedMenu = [
    ['osnovnye-svedeniya', 'Основные сведения'],
    ['struktura', 'Структура и органы управления'],
    ['documenty', 'Документы'],
    ['obrazovanie', 'Образование'],
    ['obrazovatelnye-standarty', 'Образовательные стандарты и требования'],
    ['rukovodstvo', 'Руководство'],
    ['pedagogicheskiy-sostav', 'Педагогический состав'],
    ['materialno-tehnicheskoe-obespechenie', 'Материально-техническое обеспечение. Доступная среда'],
    ['platnye-obrazovatelnye-uslugi', 'Платные образовательные услуги'],
    ['finansovo-hozyaystvennaya-deyatelnost', 'Финансово-хозяйственная деятельность'],
    ['vakantnye-mesta', 'Вакантные места для приема (перевода)'],
    ['stipendienyi', 'Стипендии и меры поддержки обучающихся'],
    ['mezhdunarodnoe-sotrudnichestvo', 'Международное сотрудничество'],
    ['organizaciya-pitaniya', 'Организация питания'],
];
?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'ММЦ «МИР»') ?> — <?= e($settings['site_title'] ?? 'ММЦ «МИР»') ?></title>
    <meta name="description" content="<?= e($settings['site_description'] ?? 'Многофункциональный молодёжный центр «МИР». Официальный сайт образовательной организации.') ?>">
    <link rel="canonical" href="<?= e(SITE_URL . ($_SERVER['REQUEST_URI'] ?? '/')) ?>">
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <?php if (!empty($extraCss)): foreach ((array)$extraCss as $css): ?>
        <link rel="stylesheet" href="<?= e($css) ?>">
    <?php endforeach; endif; ?>
</head>
<body class="<?= !empty($_COOKIE['sv_large_font']) ? 'font-large ' : '' ?><?= !empty($_COOKIE['sv_high_contrast']) ? 'high-contrast' : '' ?>">

<a class="skip-link" href="#main">Перейти к основному содержанию</a>

<header class="site-header">
    <div class="container site-header__inner">
        <a href="/" class="site-logo">
            <img src="/assets/img/logo.png" alt="ММЦ «МИР»" width="48" height="48" onerror="this.style.display='none'">
            <span class="site-logo__text">
                <span class="site-logo__title"><?= e($settings['site_title'] ?? 'ММЦ «МИР»') ?></span>
                <span class="site-logo__subtitle"><?= e($settings['site_subtitle'] ?? 'Молодёжный центр') ?></span>
            </span>
        </a>

        <nav class="main-nav" id="mainNav" aria-label="Основное меню сайта">
            <a href="/" class="main-nav__link <?= $currentPage === 'index' ? 'active' : '' ?>">Главная</a>
            <a href="/about.php" class="main-nav__link <?= $currentPage === 'about' ? 'active' : '' ?>">О Центре</a>
            <a href="/activities.php" class="main-nav__link <?= $currentPage === 'activities' ? 'active' : '' ?>">Деятельность</a>
            <a href="/education.php" class="main-nav__link <?= $currentPage === 'education' ? 'active' : '' ?>">Образование</a>
            <a href="/projects.php" class="main-nav__link <?= $currentPage === 'projects' ? 'active' : '' ?>">Проекты</a>
            <a href="/news.php" class="main-nav__link <?= $currentPage === 'news' ? 'active' : '' ?>">Новости</a>

            <details class="main-nav__dropdown <?= $currentPage === 'svedeniya' ? 'open' : '' ?>"
                     <?= $currentPage === 'svedeniya' ? 'open' : '' ?>>
                <summary class="main-nav__link main-nav__link--parent <?= $currentPage === 'svedeniya' ? 'active' : '' ?>">Сведения об образовательной организации</summary>
                <ul class="main-nav__submenu">
                    <li><a href="/svedeniya/">Главная страница раздела</a></li>
                    <?php foreach ($svedMenu as [$slug, $label]): ?>
                        <li><a href="/svedeniya/?sub=<?= e($slug) ?>"><?= e($label) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </details>

            <a href="/contacts.php" class="main-nav__link <?= $currentPage === 'contacts' ? 'active' : '' ?>">Контакты</a>
        </nav>

        <div class="header-actions">
            <button class="btn-icon" id="mobileMenuToggle" aria-label="Открыть меню" aria-expanded="false">☰</button>
        </div>
    </div>
</header>

<main id="main">
