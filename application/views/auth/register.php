<div class="text-center mb-4">
    <h4 class="fw-bold mb-2">Registrasi</h4>
    <p class="text-muted">Buat akun baru</p>
</div>

<form action="<?= base_url('auth/register_action') ?>" method="POST">
    <div class="mb-3">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" name="nama" id="nama" value="<?= set_value('nama') ?>" required>
        <?= form_error('nama', '<small class="text-danger">', '</small>') ?>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email" value="<?= set_value('email') ?>" required>
        <?= form_error('email', '<small class="text-danger">', '</small>') ?>
    </div>
    <div class="mb-3">
        <label for="no_hp" class="form-label">no_hp</label>
        <input type="tel" class="form-control" name="no_hp" id="no_hp" value="<?= set_value('no_hp') ?>" maxlength="15" required>
        <?= form_error('no_hp', '<small class="text-danger">', '</small>') ?>
    </div>
    <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
            <label class="form-label" for="password">Password</label>
        </div>
        <div class="input-group input-group-merge">
            <input
                type="password"
                id="password"
                class="form-control"
                name="password"
                required
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="password" />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            <?= form_error('password', '<small class="text-danger">', '</small>') ?>
        </div>
    </div>
    <div class="mb-3 form-password-toggle">
        <div class="d-flex justify-content-between">
            <label class="form-label" for="password_konfirmasi">Konfirmasi Password</label>
        </div>
        <div class="input-group input-group-merge">
            <input
                type="password"
                id="password_konfirmasi"
                name="password_konfirmasi"
                class="form-control"
                required
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="password_konfirmasi" />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            <?= form_error('password_konfirmasi', '<small class="text-danger">', '</small>') ?>
        </div>
    </div>
    <button type="submit" class="btn btn-success w-100">Daftar</button>
</form>

<div class="text-center mt-3">
    <a href="<?= base_url('auth') ?>">Sudah punya akun? Login</a>
</div>