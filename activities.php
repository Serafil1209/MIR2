<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$slug = 'activities';
$title = "Деятельность";
$content = getPageContent($slug);

include 'includes/header.php';
?>
<div class="container my-5">
    <h1><?= $title ?></h1>
    <?php if ($content): ?>
        <div><?= $content ?></div>
    <?php else: ?>
        <p>Содержимое страницы не найдено. Заполните его в административной панели.</p>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>