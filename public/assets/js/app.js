async function toggleLike(postId) {
    const btn = document.querySelector(`article[data-id="${postId}"] .btn-like`) 
             || document.querySelector('.post-detail .btn-like');
    const countSpan = btn.querySelector('.count');
    const csrfToken = document.getElementById('csrf_token').value;

    // Optimistic UI update
    const wasActive = btn.classList.contains('active');
    let currentCount = parseInt(countSpan.innerText);
    
    btn.classList.toggle('active');
    countSpan.innerText = wasActive ? Math.max(0, currentCount - 1) : currentCount + 1;
    
    // Animation
    btn.animate([
        { transform: 'scale(1)' },
        { transform: 'scale(1.2)' },
        { transform: 'scale(1)' }
    ], { duration: 300 });

    try {
        const response = await fetch(`${window.location.origin}/glass-social/public/post/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ postId: postId, csrf_token: csrfToken })
        });

        const data = await response.json();

        if (data.success) {
            // Sync exact count from server
            countSpan.innerText = data.count;
            if (data.liked) btn.classList.add('active');
            else btn.classList.remove('active');
        } else {
            // Revert on error
            alert(data.message || 'Action failed');
            btn.classList.toggle('active');
            countSpan.innerText = currentCount;
        }
    } catch (error) {
        console.error('Error:', error);
        btn.classList.toggle('active'); // Revert
    }
}