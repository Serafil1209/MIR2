<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$settings = getSettings();
$feedback_sent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $captcha = (int)($_POST['captcha'] ?? 0);

    if (!isset($_SESSION['captcha_code']) || $captcha !== (int)$_SESSION['captcha_code']) {
        $error = 'Неверный проверочный код.';
    } elseif ($name === '' || $email === '' || $message === '') {
        $error = 'Все поля обязательны для заполнения.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Введите корректный email.';
    } else {
        // ✅ 4 аргумента: name, email, subject, message
        addFeedback($name, $email, 'Обратная связь с сайта', $message);

        $to      = $settings['site_email'] ?? 'info@mmc-mir.ru';
        $subject = "Обратная связь от $name";
        $body    = "Имя: $name\nE-mail: $email\nСообщение:\n$message";
        $headers = "From: noreply@" . ($_SERVER['HTTP_HOST'] ?? 'localhost') . "\r\n" .
                   "Reply-To: $email\r\n" .
                   "Content-Type: text/plain; charset=UTF-8\r\n";
        @mail($to, $subject, $body, $headers);

        $feedback_sent = true;
        unset($_SESSION['captcha_code']);
    }
}

// Генерация капчи
$num1 = random_int(1, 9);
$num2 = random_int(1, 9);
$_SESSION['captcha_code'] = $num1 + $num2;

$title = "Контакты";
include __DIR__ . '/includes/header.php';
?>
<div class="container my-5">
    <h1>Контакты</h1>
    <div class="row">
        <div class="col-md-6">
            <h3>Наши реквизиты</h3>
            <p><strong>Адрес:</strong> <?= e($settings['site_address'] ?? $settings['address'] ?? '') ?></p>
            <p><strong>Телефон:</strong> <?= e($settings['site_phone'] ?? '') ?></p>
            <p><strong>E-mail:</strong> <?= e($settings['site_email'] ?? '') ?></p>
            <p><strong>Режим работы:</strong> пн-пт 9:00–18:00, сб 10:00–15:00</p>
        </div>
        <div class="col-md-6">
            <h3>Напишите нам</h3>
            <?php if ($feedback_sent): ?>
                <div class="alert alert-success">Ваше сообщение отправлено. Спасибо!</div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= e($error) ?></div>
            <?php endif; ?>
            <form method="post" id="feedback-form">
                <div class="mb-3">
                    <label for="name" class="form-label">Ваше имя</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Сообщение</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="captcha" class="form-label">Сколько будет <?= $num1 ?> + <?= $num2 ?>?</label>
                    <input type="number" class="form-control" id="captcha" name="captcha" required style="max-width:120px;">
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
    </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>