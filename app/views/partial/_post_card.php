<article class="card post-card" data-id="<?= $p['id'] ?>">
    <div class="card-header">
        <div class="avatar"><?= strtoupper(substr($p['username'], 0, 1)) ?></div>
        <div class="meta">
            <a href="<?= BASE_URL ?>/user/<?= htmlspecialchars($p['username']) ?>" class="author">
                <?= htmlspecialchars($p['username']) ?>
            </a>
            <span class="date"><?= date('M j', strtotime($p['created_at'])) ?></span>
        </div>
    </div>
    <h3><a href="<?= BASE_URL ?>/post/<?= $p['id'] ?>-<?= $p['slug'] ?>"><?= htmlspecialchars($p['title']) ?></a></h3>
    <p><?= htmlspecialchars(substr($p['body'], 0, 100)) ?>...</p>
    <div class="card-actions">
        <button class="btn-like <?= (isset($liked) && $liked) ? 'active' : '' ?>" onclick="toggleLike(<?= $p['id'] ?>)">
            ♥ <span class="count"><?= $p['like_count'] ?? 0 ?></span>
        </button>
    </div>
</article>