<?php
declare(strict_types=1);

/** Экранирование HTML */
function e(?string $str): string {
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

/** Обрезка текста */
function truncate(string $text, int $length = 100, string $suffix = '…'): string {
    $text = strip_tags($text);
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr($text, 0, $length) . $suffix;
}

/** Проверка авторизации */
function isAdmin(): bool {
    return isset($_SESSION['admin']) && $_SESSION['admin'] === true;
}

/** Требовать авторизацию */
function requireAdmin(): void {
    if (!isAdmin()) {
        header('Location: /admin/');
        exit;
    }
}

/** CSRF-токен */
function csrfToken(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function checkCsrf(): void {
    $token = $_POST['csrf'] ?? '';
    if (!hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(403);
        die('CSRF token mismatch');
    }
}

/* ==================== PAGES ==================== */

function getPageContent(string $slug): ?array {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = ?");
    $stmt->execute([$slug]);
    return $stmt->fetch() ?: null;
}

function getAllPages(): array {
    global $pdo;
    return $pdo->query("SELECT * FROM pages ORDER BY slug")->fetchAll();
}

function savePage(string $slug, string $title, string $content, string $meta = ''): void {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM pages WHERE slug = ?");
    $stmt->execute([$slug]);
    if ($stmt->fetch()) {
        $sql = "UPDATE pages SET title = ?, content = ?, meta_description = ?, updated_at = NOW() WHERE slug = ?";
        $pdo->prepare($sql)->execute([$title, $content, $meta, $slug]);
    } else {
        $sql = "INSERT INTO pages (slug, title, content, meta_description) VALUES (?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$slug, $title, $content, $meta]);
    }
}

function deletePage(int $id): void {
    global $pdo;
    $pdo->prepare("DELETE FROM pages WHERE id = ?")->execute([$id]);
}

/* ==================== NEWS ==================== */

function getLatestNews(int $limit = 6, int $offset = 0): array {
    global $pdo;
    $sql = "SELECT * FROM news ORDER BY date DESC LIMIT :offset, :limit";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getNewsCount(): int {
    global $pdo;
    return (int)$pdo->query("SELECT COUNT(*) FROM news")->fetchColumn();
}

function getNewsItem(int $id): ?array {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

/** Сохранить новость */
function saveNews(
    ?int $id,
    string $title,
    string $content,
    string $image,
    string $date,
    string $category,
    string $excerpt = ''
): void {
    global $pdo;
    // если excerpt не передан — генерируем из content
    if ($excerpt === '') {
        $excerpt = truncate($content, 200);
    }
    if ($id) {
        $sql = "UPDATE news SET title=?, content=?, excerpt=?, image=?, date=?, category=? WHERE id=?";
        $pdo->prepare($sql)->execute([$title, $content, $excerpt, $image, $date, $category, $id]);
    } else {
        $sql = "INSERT INTO news (title, content, excerpt, image, date, category) VALUES (?, ?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$title, $content, $excerpt, $image, $date, $category]);
    }
}

function deleteNews(int $id): void {
    global $pdo;
    $pdo->prepare("DELETE FROM news WHERE id = ?")->execute([$id]);
}

/* ==================== DOCUMENTS ==================== */

function getAllDocuments(): array {
    global $pdo;
    return $pdo->query("SELECT * FROM documents ORDER BY upload_date DESC")->fetchAll();
}

function addDocument(string $title, string $path, string $category, int $size = 0): void {
    global $pdo;
    $sql = "INSERT INTO documents (title, file_path, category, file_size) VALUES (?, ?, ?, ?)";
    $pdo->prepare($sql)->execute([$title, $path, $category, $size]);
}

function deleteDocument(int $id): void {
    global $pdo;
    $stmt = $pdo->prepare("SELECT file_path FROM documents WHERE id = ?");
    $stmt->execute([$id]);
    if ($file = $stmt->fetchColumn()) {
        $full = $_SERVER['DOCUMENT_ROOT'] . $file;
        if (is_file($full)) @unlink($full);
    }
    $pdo->prepare("DELETE FROM documents WHERE id = ?")->execute([$id]);
}

/* ==================== GALLERY / PROJECTS / SETTINGS ==================== */

function getGalleryImages(int $limit = 10): array {
    global $pdo;
    $sql = "SELECT * FROM gallery ORDER BY sort_order LIMIT :limit";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getProjects(?string $category = null): array {
    global $pdo;
    if ($category) {
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE category = ? ORDER BY sort_order");
        $stmt->execute([$category]);
    } else {
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY sort_order");
    }
    return $stmt->fetchAll();
}

function getSettings(): array {
    global $pdo;
    $rows = $pdo->query("SELECT `key`, `value` FROM settings")->fetchAll();
    $out = [];
    foreach ($rows as $r) $out[$r['key']] = $r['value'];
    return $out;
}

function updateSettings(array $data): void {
    global $pdo;
    foreach ($data as $k => $v) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM settings WHERE `key` = ?");
        $stmt->execute([$k]);
        if ($stmt->fetchColumn()) {
            $pdo->prepare("UPDATE settings SET `value` = ? WHERE `key` = ?")->execute([$v, $k]);
        } else {
            $pdo->prepare("INSERT INTO settings (`key`, `value`) VALUES (?, ?)")->execute([$k, $v]);
        }
    }
}

/* ==================== FEEDBACK ==================== */

function addFeedback(string $name, string $email, string $subject, string $message): void {
    global $pdo;
    $sql = "INSERT INTO feedback (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $pdo->prepare($sql)->execute([$name, $email, $subject, $message]);
}

function getAllFeedback(): array {
    global $pdo;
    return $pdo->query("SELECT * FROM feedback ORDER BY created_at DESC")->fetchAll();
}

function markFeedbackProcessed(int $id): void {
    global $pdo;
    $pdo->prepare("UPDATE feedback SET status='processed' WHERE id=?")->execute([$id]);
}

/* ==================== EVENTS ==================== */

function getUpcomingEvents(int $limit = 3): array {
    global $pdo;
    $sql = "SELECT * FROM events WHERE date_start > NOW() ORDER BY date_start LIMIT :limit";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}