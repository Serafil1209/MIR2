<?php
/**
 * Вход в административную панель.
 * Пароль задаётся в БД (таблица settings, ключ admin_password)
 * либо константой ADMIN_PASSWORD в includes/config.php.
 */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

if (isAdmin()) {
    header('Location: /admin/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();
    $login    = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    $s = getSettings();
    $hash = $s['admin_password_hash'] ?? (defined('ADMIN_PASSWORD_HASH') ? ADMIN_PASSWORD_HASH : '');

    if ($login !== '' && $hash !== '' && password_verify($password, $hash)) {
        session_regenerate_id(true);
        $_SESSION['admin'] = true;
        $_SESSION['admin_login'] = $login;
        header('Location: /admin/index.php');
        exit;
    }
    $error = 'Неверный логин или пароль.';
}

$page_title = 'Вход в админ-панель';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Вход — ММЦ «МИР»</title>
<meta name="robots" content="noindex, nofollow">
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<main id="main">
<div class="container section" style="max-width:460px">
    <h1 class="section-title" style="text-align:left">Вход в админ-панель</h1>
    <?php if ($error): ?><p class="form-error"><?= e($error) ?></p><?php endif; ?>
    <form method="post" class="sved-form">
        <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">
        <p><label for="login">Логин</label>
           <input type="text" id="login" name="login" required autocomplete="username"></p>
        <p><label for="password">Пароль</label>
           <input type="password" id="password" name="password" required autocomplete="current-password"></p>
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
    <p><a href="/">← На главную</a></p>
</div>
</main>
</body>
</html>
