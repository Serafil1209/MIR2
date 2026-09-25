<?php
/**
 * ============================================================
 * Конфигурация сайта ММЦ «МИР»
 * Хостинг: reg.ru (ISPmanager)
 * ============================================================
 */
declare(strict_types=1);

/* ------------------------------------------------------------
 * ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ
 * ------------------------------------------------------------ */

// Хост БД (на reg.ru всегда localhost)
define('DB_HOST', 'localhost');

// Имя базы данных
define('DB_NAME', 'u3656845_mmcmir');

// Имя пользователя БД (создан в ISPmanager)
define('DB_USER', 'u3656845_mmcmir');

// Пароль пользователя БД (из формы создания)
define('DB_PASS', 'tY2-Nu6-4x8-HWP');

// Кодировка соединения
define('DB_CHARSET', 'utf8mb4');

// Адрес сайта (без слэша в конце)
define('SITE_URL', 'https://mmcmir.ru');


/* ------------------------------------------------------------
 * РЕЖИМ ОТЛАДКИ
 * true  — показывать ошибки (для отладки)
 * false — скрывать (для боевого сайта) ← ПОСТАВЬ ПОСЛЕ ЗАПУСКА
 * ------------------------------------------------------------ */
define('DEBUG_MODE', true);


if (DEBUG_MODE) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(E_ALL);
    ini_set('log_errors', '1');
}


/* ------------------------------------------------------------
 * ПОДКЛЮЧЕНИЕ К БД ЧЕРЕЗ PDO
 * ------------------------------------------------------------ */
try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    // Часовой пояс Москва
    $pdo->exec("SET time_zone = '+03:00'");

} catch (PDOException $e) {
    error_log('[DB ERROR] ' . $e->getMessage());

    if (DEBUG_MODE) {
        die('Ошибка БД: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
    } else {
        http_response_code(500);
        die('Сервис временно недоступен.');
    }
}


/* ------------------------------------------------------------
 * СЕССИЯ
 * ------------------------------------------------------------ */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}