<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();
    $settings = [
        'site_title' => $_POST['site_title'] ?? 'ММЦ «МИР»',
        'site_email' => $_POST['site_email'] ?? 'info@mmc-mir.ru',
        'site_phone' => $_POST['site_phone'] ?? '+7 (4942) 12-34-56',
        'address' => $_POST['address'] ?? '156000, Костромская область, Костромской район, с. Сандогора, ул. Молодёжная, д. 8',
    ];
    updateSettings($settings);
    $_SESSION['msg'] = 'Настройки сохранены';
    header('Location: settings.php');
    exit;
}

$settings = getSettings();
$title_page = "Настройки сайта";
include '../includes/header.php';
?>
<div class="container my-5">
    <h1>Настройки</h1>
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-success"><?= e($_SESSION['msg']); unset($_SESSION['msg']); ?></div>
    <?php endif; ?>
    <form method="post">
                <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">
        <div class="mb-3">
            <label for="site_title" class="form-label">Название сайта</label>
            <input type="text" class="form-control" id="site_title" name="site_title" value="<?= e($settings['site_title'] ?? 'ММЦ «МИР»') ?>">
        </div>
        <div class="mb-3">
            <label for="site_email" class="form-label">E-mail центра</label>
            <input type="email" class="form-control" id="site_email" name="site_email" value="<?= e($settings['site_email'] ?? 'info@mmc-mir.ru') ?>">
        </div>
        <div class="mb-3">
            <label for="site_phone" class="form-label">Телефон</label>
            <input type="text" class="form-control" id="site_phone" name="site_phone" value="<?= e($settings['site_phone'] ?? '+7 (4942) 12-34-56') ?>">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Адрес</label>
            <input type="text" class="form-control" id="address" name="address" value="<?= e($settings['address'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?>