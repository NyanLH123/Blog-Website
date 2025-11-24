<?php 
$flash = \Core\Session::getFlash(); 
if ($flash): ?>
    <div class="flash-msg flash-<?= $flash['type'] ?>">
        <?= htmlspecialchars($flash['message']) ?>
    </div>
<?php endif; ?>