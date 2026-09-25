<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireAdmin();

$slug = $_GET['slug'] ?? '';
if ($slug === 'new') {
    $title = 'Новая страница';
    $content = '';
    $slug = '';
} else {
    $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = ?");
    $stmt->execute([$slug]);
    $page = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$page) {
        $title = 'Новая страница';
        $content = '';
        $slug = '';
    } else {
        $title = $page['title'];
        $content = $page['content'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();
    $new_slug = $_POST['slug'] ?: $slug;
    $new_title = $_POST['title'];
    $new_content = $_POST['content'];
    savePage($new_slug, $new_title, $new_content);
    $_SESSION['msg'] = 'Страница сохранена';
    header('Location: pages.php');
    exit;
}

$page_title = "Редактирование страницы";
include '../includes/header.php';
?>
<div class="container my-5">
    <h1><?= $slug ? 'Редактирование: ' . e($title) : 'Новая страница' ?></h1>
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-success"><?= e($_SESSION['msg']); unset($_SESSION['msg']); ?></div>
    <?php endif; ?>
    <form method="post">
                <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">
        <div class="mb-3">
            <label for="slug" class="form-label">Slug (уникальный идентификатор)</label>
            <input type="text" class="form-control" id="slug" name="slug" value="<?= e($slug) ?>" required>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= e($title) ?>" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Содержание</label>
            <textarea class="form-control" id="editor" name="content" rows="10"><?= e($content) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="pages.php" class="btn btn-secondary">Отмена</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $('#editor').summernote({height: 400});
</script>
<?php include '../includes/footer.php'; ?>