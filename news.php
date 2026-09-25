<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireAdmin();

// Обработка действий
$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Удаление
if ($action === 'delete' && $id) {
    deleteNews($id);
    header('Location: news.php');
    exit;
}

// Сохранение (добавление/обновление)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $date = $_POST['date'];
    $category = $_POST['category'] ?? '';
    $image = $_POST['image'] ?? '';
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    saveNews($id, $title, $content, $image, $date, $category);
    header('Location: news.php');
    exit;
}

$title_page = "Управление новостями";
include '../includes/header.php';
?>
<div class="container my-5">
    <h1>Новости</h1>
    <a href="news.php?action=add" class="btn btn-success mb-3">Добавить новость</a>

    <?php if ($action === 'add' || ($action === 'edit' && $id)): ?>
        <?php
        $news_item = null;
        if ($action === 'edit' && $id) {
            $news_item = getNewsItem($id);
            if (!$news_item) {
                echo '<div class="alert alert-danger">Новость не найдена</div>';
                include '../includes/footer.php';
                exit;
            }
        }
        ?>
        <h2><?= $action === 'add' ? 'Новая новость' : 'Редактирование' ?></h2>
        <form method="post">
            <input type="hidden" name="id" value="<?= $news_item['id'] ?? 0 ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Заголовок</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= e($news_item['title'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Содержание</label>
                <textarea class="form-control" id="editor" name="content" rows="10"><?= e($news_item['content'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Дата</label>
                <input type="date" class="form-control" id="date" name="date" value="<?= e($news_item['date'] ?? date('Y-m-d')) ?>" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Категория</label>
                <input type="text" class="form-control" id="category" name="category" value="<?= e($news_item['category'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Путь к изображению</label>
                <input type="text" class="form-control" id="image" name="image" value="<?= e($news_item['image'] ?? '') ?>" placeholder="/uploads/news/photo.jpg">
            </div>
            <button type="submit" name="save" class="btn btn-primary">Сохранить</button>
            <a href="news.php" class="btn btn-secondary">Отмена</a>
        </form>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
        <script>$('#editor').summernote({height: 300});</script>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Заголовок</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM news ORDER BY date DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= e($row['title']) ?></td>
                        <td><?= date('d.m.Y', strtotime($row['date'])) ?></td>
                        <td>
                            <a href="news.php?action=edit&id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Редактировать</a>
                            <a href="news.php?action=delete&id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">Удалить</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>