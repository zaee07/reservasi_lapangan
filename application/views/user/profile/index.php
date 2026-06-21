<?php
$inisial = '';
$nama_parts = explode(' ', trim($user['nama']));
foreach ($nama_parts as $part) {
    if (!empty($part)) {
        $inisial .= strtoupper(substr($part, 0, 1));
    }
}
$inisial = substr($inisial, 0, 2);
?>
<div class="card border-0 shadow-sm">
    <div class="card-body text-center">
        <div
            class="mx-auto mb-3 rounded-circle overflow-hidden d-flex align-items-center justify-content-center bg-dark text-white fw-bold"
            style="width:90px;height:90px;font-size:30px;">
            <?php if (!empty($user['foto'])) : ?>
                <img
                    src="<?= base_url('uploads/user/' . $user['foto']) ?>"
                    alt="Foto Profil"
                    class="w-100 h-100"
                    style="object-fit:cover;">
            <?php else : ?>
                <?= $inisial ?>
            <?php endif; ?>
        </div>
        <h5 class="mb-1">
            <?= htmlspecialchars($user['nama']) ?>
        </h5>
        <p class="text-muted mb-1">
            <?= htmlspecialchars($user['email']) ?>
        </p>
        <small class="text-muted">
            <?= htmlspecialchars($user['no_hp']) ?>
        </small>
    </div>
</div>
<div class="list-group mt-3">
    <a href="<?= base_url('profile/edit') ?>"
        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <span>
            <i class="bi bi-person me-2"></i>
            Edit Profil
        </span>
        <i class="bi bi-chevron-right"></i>
    </a>
    <a href="<?= base_url('profile/ubah_password') ?>"
        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
        <span>
            <i class="bi bi-shield-lock me-2"></i>
            Ubah Password
        </span>
        <i class="bi bi-chevron-right"></i>
    </a>
    <a href="<?= base_url('auth/logout') ?>"
        onclick="return confirm('Yakin ingin logout?')"
        class="list-group-item list-group-item-action text-danger d-flex justify-content-between align-items-center">
        <span>
            <i class="bi bi-box-arrow-right me-2"></i>
            Logout
        </span>
        <i class="bi bi-chevron-right"></i>
    </a>
</div>