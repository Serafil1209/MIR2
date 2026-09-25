<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$settings = getSettings();
$news = getLatestNews(3);
$projects = getProjects();
$gallery = getGalleryImages(5);
$title = "Главная";
include 'includes/header.php';
?>

<!-- Hero -->
<section class="hero">
    <div class="container hero__inner">
        <div class="hero__content animate">
            <h1 class="hero__title">
                <?= e($settings['hero_title'] ?? 'Создавай будущее вместе с нами!') ?>
            </h1>
            <p class="hero__subtitle">
                <?= e($settings['hero_subtitle'] ?? '') ?>
            </p>
            <div class="hero__actions">
                <a href="<?= e($settings['hero_button_link'] ?? '/about.php') ?>" class="btn btn-primary btn-lg">
                    <?= e($settings['hero_button_text'] ?? 'Узнать больше') ?> →
                </a>
                <a href="/contacts.php" class="btn btn-outline btn-lg">Связаться</a>
            </div>
            <div class="hero__stats">
                <div class="hero__stat">
                    <span class="hero__stat-num"><?= e($settings['stat_participants'] ?? '5000+') ?></span>
                    <span class="hero__stat-label">Участников</span>
                </div>
                <div class="hero__stat">
                    <span class="hero__stat-num"><?= e($settings['stat_projects'] ?? '25') ?></span>
                    <span class="hero__stat-label">Проектов</span>
                </div>
                <div class="hero__stat">
                    <span class="hero__stat-num"><?= e($settings['stat_events'] ?? '300+') ?></span>
                    <span class="hero__stat-label">Мероприятий в год</span>
                </div>
            </div>
        </div>
        <div class="hero__visual animate">
            <img src="/assets/img/hero.jpg" alt="ММЦ «МИР»" onerror="this.src='/assets/img/placeholder.jpg'">
        </div>
    </div>
</section>

<!-- Быстрые ссылки -->
<section class="section">
    <div class="container">
        <div class="quick-links">
            <a href="/education.php" class="quick-link">
                <span class="quick-link__icon">📚</span>
                <span>Образование</span>
            </a>
            <a href="/activities.php" class="quick-link">
                <span class="quick-link__icon">🎨</span>
                <span>Деятельность</span>
            </a>
            <a href="/projects.php" class="quick-link">
                <span class="quick-link__icon">🚀</span>
                <span>Проекты</span>
            </a>
            <a href="/contacts.php" class="quick-link">
                <span class="quick-link__icon">📞</span>
                <span>Контакты</span>
            </a>
        </div>
    </div>
</section>

<!-- Новости -->
<section class="section section-alt">
    <div class="container">
        <h2 class="section-title">Новости и анонсы</h2>
        <div class="grid grid-3">
            <?php foreach ($news as $item): ?>
                <article class="card">
                    <img class="card__img" src="<?= e($item['image'] ?: '/assets/img/placeholder.jpg') ?>" alt="<?= e($item['title']) ?>">
                    <div class="card__body">
                        <div class="card__date"><?= date('d.m.Y', strtotime($item['date'])) ?></div>
                        <h3 class="card__title"><?= e($item['title']) ?></h3>
                        <p class="card__text"><?= e(truncate($item['excerpt'] ?? $item['content'], 120)) ?></p>
                        <a href="/news.php?id=<?= $item['id'] ?>" class="btn btn-outline btn-sm">Читать →</a>
                    </div>
                </article>
            <?php endforeach; ?>
            <?php if (empty($news)): ?>
                <p>Новостей пока нет.</p>
            <?php endif; ?>
        </div>
        <div style="text-align:center; margin-top: 40px;">
            <a href="/news.php" class="btn btn-primary">Все новости →</a>
        </div>
    </div>
</section>

<!-- Проекты -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Проекты и мероприятия</h2>
        <div class="grid grid-3">
            <?php foreach ($projects as $p): ?>
                <article class="card">
                    <img class="card__img" src="<?= e($p['image'] ?: '/assets/img/placeholder.jpg') ?>" alt="<?= e($p['title']) ?>">
                    <div class="card__body">
                        <h3 class="card__title"><?= e($p['title']) ?></h3>
                        <p class="card__text"><?= e(truncate($p['description'], 100)) ?></p>
                        <?php if ($p['url']): ?>
                            <a href="<?= e($p['url']) ?>" class="btn btn-primary btn-sm">Подробнее →</a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Галерея -->
<?php if ($gallery): ?>
<section class="section section-alt">
    <div class="container">
        <h2 class="section-title">Фотогалерея</h2>
        <div class="grid grid-3">
            <?php foreach ($gallery as $img): ?>
                <div class="card">
                    <img class="card__img" src="<?= e($img['image_path']) ?>" alt="<?= e($img['title']) ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>