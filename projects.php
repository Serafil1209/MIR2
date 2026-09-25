<?php
/** Публичная страница «Проекты» */
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

$settings = getSettings();
$currentPage = 'projects';
$title = 'Проекты';
$projects = getProjects();

include __DIR__ . '/includes/header.php';
?>
<section class="section">
    <div class="container">
        <h1 class="section-title">Проекты и мероприятия</h1>
        <div class="grid grid-3">
            <?php foreach ($projects as $p): ?>
                <article class="card">
                    <img class="card__img" src="<?= e($p['image'] ?: '/assets/img/placeholder.jpg') ?>" alt="<?= e($p['title']) ?>">
                    <div class="card__body">
                        <?php if (!empty($p['category'])): ?>
                            <div class="card__date"><?= e($p['category']) ?></div>
                        <?php endif; ?>
                        <h2 class="card__title"><?= e($p['title']) ?></h2>
                        <p class="card__text"><?= e(truncate($p['description'] ?? '', 140)) ?></p>
                        <?php if (!empty($p['url'])): ?>
                            <a href="<?= e($p['url']) ?>" class="btn btn-primary btn-sm" rel="noopener">Подробнее →</a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
            <?php if (empty($projects)): ?><p>Проекты пока не добавлены.</p><?php endif; ?>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
