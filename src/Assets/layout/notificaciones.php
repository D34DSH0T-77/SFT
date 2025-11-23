<?php if (!empty($mensaje)): ?>
    <div class="alert alert-<?= htmlspecialchars($mensaje['tipo']) ?> alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($mensaje['texto'] ?? '') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>