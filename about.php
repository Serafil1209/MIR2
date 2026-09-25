<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$slug = 'about';
$page = getPageContent($slug);
$title = $page['title'] ?? 'О Центре';
include 'includes/header.php';
?>
<section class="section">
    <div class="container">
        <h1><?= e($title) ?></h1>
        <?php if ($page): ?>
            <div style="max-width: 900px; font-size: 1.1rem; line-height: 1.8;">
                <?= $page['content'] ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Содержимое страницы не найдено.</div>
        <?php endif; ?>
    </div>
</section>
<?php include 'includes/footer.php'; ?>