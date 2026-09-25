<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkCsrf();
    if (isset($_POST['delete'])) {
        deleteDocument((int)$_POST['id']);
        header('Location: documents.php');
        exit;
    }
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $title = $_POST['title'];
        $category = $_POST['category'];
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/documents/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $dest = $upload_dir . $filename;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $dest)) {
            addDocument($title, '/uploads/documents/' . $filename, $category);
        }
        header('Location: documents.php');
        exit;
    }
}

$title_page = "Управление документами";
include '../includes/header.php';
?>
<div class="container my-5">
    <h1>Документы</h1>
    <div class="row">
        <div class="col-md-6">
            <h3>Загрузить новый документ</h3>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">
                <div class="mb-3">
                    <label for="title" class="form-label">Название</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Категория</label>
                    <input type="text" class="form-control" id="category" name="category">
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Файл (PDF, DOC, DOCX, JPG, PNG)</label>
                    <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                </div>
                <button type="submit" class="btn btn-primary">Загрузить</button>
            </form>
        </div>
        <div class="col-md-6">
            <h3>Список документов</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Дата</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $docs = getAllDocuments(); ?>
                    <?php foreach ($docs as $doc): ?>
                        <tr>
                            <td><?= e($doc['title']) ?></td>
                            <td><?= e($doc['category']) ?></td>
                            <td><?= date('d.m.Y', strtotime($doc['upload_date'])) ?></td>
                            <td>
                                <a href="<?= e($doc['file_path']) ?>" target="_blank" class="btn btn-sm btn-info">Скачать</a>
                                <form method="post" style="display:inline-block;">
                                    <input type="hidden" name="id" value="<?= $doc['id'] ?>">
                                    <button type="submit" name="delete" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>