<h2>Admin Dashboard</h2>
<div class="glass-panel table-container">
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['username']) ?></td>
                <td><?= htmlspecialchars($u['email']) ?></td>
                <td><?= $u['blocked'] ? '<span class="badge danger">Blocked</span>' : '<span class="badge success">Active</span>' ?></td>
                <td>
                    <?php if($u['role'] !== 'admin'): ?>
                    <form action="<?= BASE_URL ?>/admin/block" method="POST">
                        <?php include __DIR__ . '/../partial/_csrf.php'; ?>
                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                        <input type="hidden" name="action" value="<?= $u['blocked'] ? 'unblock' : 'block' ?>">
                        <button type="submit" class="btn-sm <?= $u['blocked'] ? 'btn-primary' : 'btn-danger' ?>">
                            <?= $u['blocked'] ? 'Unblock' : 'Block' ?>
                        </button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>