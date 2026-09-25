<?php
/**
 * Публичная страница новостей.
 *  /news.php            — список (с пагинацией)
 *  /news.php?id=N       — полная запись
 */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$settings = getSettings();
$currentPage = 'news';

$id = isset($_GET['id']) ? (int)$_GET["id"] : 0;

if ($id > 0) {
    $item = getNewsItem($id);
    if (!$item) {
        http_response_code(404);
        $item = null;
    }
} else {
    $perPage = 9;
    $total   = getNewsCount();
    $pages   = max(1, (int)ceil($total / $perPage));
    $page    = max(1, min($pages, (int)($_GET['page'] ?? 1)));
    $news    = getLatestNews($perPage, ($page - 1) * $perPage);
}

$title = $item ? $item['title'] : 'Новости';
include __DIR__ . '/includes/header.php';
?>
<section class="section">
    <div class="container">

        <?php if (isset($item)): ?>

            <?php if (!$item): ?>
                <h1 class="section-title">Новость не найдена</h1>
                <p><a href="/news.php" class="btn btn-primary">← Ко всем новостям</a></p>
            <?php else: ?>
                <article class="news-full">
                    <h1 class="section-title" style="text-align:left"><?= e($item['title']) ?></h1>
                    <p class="card__date"><?= date('d.m.Y', strtotime($item['date'])) ?>
                        <?php if (!empty($item['category'])): ?> · <?= e($item['category']) ?><?php endif; ?>
                    </p>
                    <?php if (!empty($item['image'])): ?>
                        <img class="news-full__img" src="<?= e($item['image']) ?>" alt="<?= e($item['title']) ?>">
                    <?php endif; ?>
                    <div class="news-full__content"><?= $item['content'] ?></div>
                    <p><a href="/news.php" class="btn btn-outline">← Все новости</a></p>
                </article>
            <?php endif; ?>

        <?php else: ?>
            <h1 class="section-title">Новости и анонсы</h1>
            <div class="grid grid-3">
                <?php foreach ($news as $n): ?>
                    <article class="card">
                        <img class="card__img" src="<?= e($n['image'] ?: '/assets/img/placeholder.jpg') ?>" alt="<?= e($n['title']) ?>">
                        <div class="card__body">
                            <div class="card__date"><?= date('d.m.Y', strtotime($n['date'])) ?></div>
                            <h2 class="card__title"><a href="/news/<?= (int)$n['id'] ?>"><?= e($n['title']) ?></a></h2>
                            <p class="card__text"><?= e(truncate($n['excerpt'] ?? $n['content'], 120)) ?></p>
                            <a href="/news/<?= (int)$n['id'] ?>" class="btn btn-outline btn-sm">Читать →</a>
                        </div>
                    </article>
                <?php endforeach; ?>
                <?php if (empty($news)): ?><p>Новостей пока нет.</p><?php endif; ?>
            </div>

            <?php if ($pages > 1): ?>
                <nav class="pagination" aria-label="Навигация по страницам новостей">
                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <?php if ($i === $page): ?><span class="pagination__current"><?= $i ?></span>
                        <?php else: ?><a class="pagination__link" href="/news.php?page=<?= $i ?>"><?= $i ?></a><?php endif; ?>
                    <?php endfor; ?>
                </nav>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
