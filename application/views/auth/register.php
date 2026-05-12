<div class="text-center mb-4">
    <h4 class="fw-bold mb-2">Registrasi</h4>
    <p class="text-muted">Buat akun baru</p>
</div>

<form action="<?= base_url('auth/register_action') ?>" method="POST">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" id="username" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password" required>
    </div>
    <button type="submit" class="btn btn-success w-100">Daftar</button>
</form>

<div class="text-center mt-3">
    <a href="<?= base_url('auth') ?>">Sudah punya akun? Login</a>
</div>