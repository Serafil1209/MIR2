<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireAdmin();

$title = "Управление страницами";
include '../includes/header.php';
?>
<div class="container my-5">
    <h1>Страницы сайта</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Slug</th>
                <th>Название</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php $pages = getAllPages(); ?>
            <?php foreach ($pages as $p): ?>
                <tr>
                    <td><?= e($p['slug']) ?></td>
                    <td><?= e($p['title']) ?></td>
                    <td><a href="page_edit.php?slug=<?= e($p['slug']) ?>" class="btn btn-sm btn-primary">Редактировать</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="page_edit.php?slug=new" class="btn btn-success">Создать новую страницу</a>
</div>
<?php include '../includes/footer.php'; ?>