<?php
/**
 * includes/header.php
 * Ожидает переменные:
 *   $title        — заголовок страницы (обязательно)
 *   $currentPage  — текущий slug для подсветки меню (опционально)
 *   $settings     — настройки сайта (загружаются автоматически, если не переданы)
 */

// На всякий случай — если settings не переданы, загрузим
if (!isset($settings)) {
    $settings = function_exists('getSettings') ? getSettings() : [];
}

$currentPage = $currentPage ?? '';
?><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?= e($title ?? 'ММЦ «МИР»') ?> — <?= e($settings['site_title'] ?? 'ММЦ «МИР»') ?></title>

    <meta name="description" content="<?= e($settings['site_description'] ?? 'Многофункциональный Молодёжный Центр «МИР»') ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">

    <!-- Шрифты -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- ✅ ГЛАВНОЕ: подключение стилей -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <?php if (!empty($extraCss)): foreach ((array)$extraCss as $css): ?>
        <link rel="stylesheet" href="<?= e($css) ?>">
    <?php endforeach; endif; ?>
</head>
<body>

<header class="site-header">
    <div class="container site-header__inner">
        <a href="/" class="site-logo">
            <img src="/assets/img/logo.png" alt="ММЦ «МИР»" onerror="this.style.display='none'">
            <div class="site-logo__text">
                <span class="site-logo__title"><?= e($settings['site_title'] ?? 'ММЦ «МИР»') ?></span>
                <span class="site-logo__subtitle"><?= e($settings['site_subtitle'] ?? 'Молодёжный центр') ?></span>
            </div>
        </a>

        <nav class="main-nav" id="mainNav" aria-label="Основная навигация">
            <a href="/" class="main-nav__link <?= $currentPage === 'index' ? 'active' : '' ?>">Главная</a>
            <a href="/about.php" class="main-nav__link <?= $currentPage === 'about' ? 'active' : '' ?>">О Центре</a>
            <a href="/activities.php" class="main-nav__link <?= $currentPage === 'activities' ? 'active' : '' ?>">Деятельность</a>
            <a href="/education.php" class="main-nav__link <?= $currentPage === 'education' ? 'active' : '' ?>">Образование</a>
            <a href="/projects.php" class="main-nav__link <?= $currentPage === 'projects' ? 'active' : '' ?>">Проекты</a>
            <a href="/news.php" class="main-nav__link <?= $currentPage === 'news' ? 'active' : '' ?>">Новости</a>
            <a href="/svedeniya/" class="main-nav__link">Сведения</a>
            <a href="/contacts.php" class="main-nav__link <?= $currentPage === 'contacts' ? 'active' : '' ?>">Контакты</a>
        </nav>

        <div class="header-actions">
            <a href="/admin/" class="btn-icon" title="Админ-панель" aria-label="Админ-панель">⚙</a>
            <button class="btn-icon" id="mobileMenuToggle" aria-label="Меню" style="display:none">☰</button>
        </div>
    </div>
</header>

<main id="main">