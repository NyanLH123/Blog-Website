<div class="hero-section">
    <h1>Latest Updates</h1>
</div>

<div class="grid">
    <?php foreach($posts as $p): ?>
        <?php 
            $liked = isset($likedPosts[$p['id']]); 
            include __DIR__ . '/../partial/_post_card.php'; 
        ?>
    <?php endforeach; ?>
</div>