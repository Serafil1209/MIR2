<?php
/** Обращения граждан (обратная связь) */
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['processed'])) {
    checkCsrf();
    markFeedbackProcessed((int)$_POST['id']);
    header('Location: feedback.php');
    exit;
}

$items = getAllFeedback();
$title = 'Обращения граждан';
include __DIR__ . '/../includes/header.php';
?>
<div class="container section">
    <h1 class="section-title" style="text-align:left">Обращения граждан</h1>
    <?php if (empty($items)): ?><p>Сообщений нет.</p><?php endif; ?>
    <?php foreach ($items as $f): ?>
        <div class="sved-card">
            <h2><?= e($f['subject'] ?: 'Сообщение') ?>
                <small>(<?= e($f['status'] ?? 'new') ?>)</small></h2>
            <p><strong><?= e($f['name']) ?></strong> · <a href="mailto:<?= e($f['email']) ?>"><?= e($f['email']) ?></a>
               · <?= e($f['created_at'] ?? '') ?></p>
            <p><?= nl2br(e($f['message'])) ?></p>
            <?php if (($f['status'] ?? 'new') !== 'processed'): ?>
            <form method="post">
                <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">
                <input type="hidden" name="id" value="<?= (int)$f['id'] ?>">
                <button type="submit" name="processed" class="btn btn-outline btn-sm">Отметить обработанным</button>
            </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
