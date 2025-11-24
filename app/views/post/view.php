<div class="post-detail glass-panel">
    <header class="post-header">
        <h1><?= htmlspecialchars($post['title']) ?></h1>
        <div class="meta">
            By <a href="<?= BASE_URL ?>/user/<?= htmlspecialchars($post['username']) ?>"><?= htmlspecialchars($post['username']) ?></a> 
            on <?= date('F j, Y', strtotime($post['created_at'])) ?>
        </div>
    </header>
    
    <div class="post-body">
        <?= nl2br(htmlspecialchars($post['body'])) ?>
    </div>

    <div class="post-footer">
        <?php include __DIR__ . '/../partial/_csrf.php'; /* For JS to grab */ ?>
        <button class="btn-like large <?= $isLiked ? 'active' : '' ?>" onclick="toggleLike(<?= $post['id'] ?>)">
            ♥ <span class="count"><?= $likeCount ?></span> Likes
        </button>
    </div>
</div>