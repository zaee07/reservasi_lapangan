<div class="text-center mb-4">
    <h4 class="fw-bold mb-2">Login</h4>
    <p class="text-muted">Masuk ke akun Anda</p>
</div>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error') ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('auth/login') ?>" method="POST">
    <div class="mb-3">
        <label for="email" class="form-label">email</label>
        <input type="text" class="form-control" name="email" id="email" required>
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
        </div>
    </div>
    <button type="submit" class="btn btn-primary w-100">Login</button>
</form>
<p class="text-center mt-3">
    <span>Belum punya akun?</span>
    <a href="<?= base_url('register') ?>">
        <span>Registrasi</span>
    </a>
</p>