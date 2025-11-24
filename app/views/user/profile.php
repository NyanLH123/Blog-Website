<div class="profile-nav">
    <a href="<?= BASE_URL ?>/" class="btn-back">← Back to Feed</a>
</div>

<div class="profile-header glass-panel">
    <div class="profile-content">
        <div class="avatar-large">
            <?= strtoupper(substr($profileUser['username'], 0, 1)) ?>
        </div>
        
        <h1><?= htmlspecialchars($profileUser['username']) ?></h1>
        
        <?php if($profileUser['role'] === 'admin'): ?>
            <span class="badge danger" style="margin-bottom: 10px;">Administrator</span>
        <?php endif; ?>

        <div class="profile-stats">
            <div class="stat-item">
                <span class="stat-value"><?= count($posts) ?></span>
                <span class="stat-label">Posts</span>
            </div>
            <div class="stat-item">
                <span class="stat-value"><?= date('M Y', strtotime($profileUser['created_at'])) ?></span>
                <span class="stat-label">Joined</span>
            </div>
        </div>
    </div>
</div>

<h2 style="margin-bottom: 20px;">Posts by <?= htmlspecialchars($profileUser['username']) ?></h2>

<?php if (empty($posts)): ?>
    <div class="glass-panel profile-empty-state">
        <p>This user hasn't posted anything yet.</p>
    </div>
<?php else: ?>
    <div class="grid">
        <?php foreach($posts as $p): ?>
            <?php 
                $liked = isset($likedPosts[$p['id']]); 
                include __DIR__ . '/../partial/_post_card.php'; 
            ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>