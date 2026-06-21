<form method="post">
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="password_lama">Password Lama</label>
        <div class="col-sm-3">
            <div class="input-group input-group-merge">
                <input
                    type="password"
                    id="password_lama"
                    name="password_lama"
                    class="form-control"
                    autocomplete="new-password"
                    required
                    placeholder="Masukkan password lama"
                    aria-describedby="password_lama"
                    required />
                <span class="input-group-text cursor-pointer toggle-password"><i class="bx bx-hide"></i></span>
            </div>
            <?= form_error('password_lama', '<small class="text-danger">', '</small>') ?>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="password_baru">Password Baru</label>
        <div class="col-sm-3">
            <div class="input-group input-group-merge">
                <input
                    type="password"
                    id="password_baru"
                    name="password_baru"
                    class="form-control"
                    autocomplete="new-password"
                    required
                    placeholder="Minimal 6 karakter"
                    aria-describedby="password_baru"
                    required />
                <span class="input-group-text cursor-pointer toggle-password"><i class="bx #bx-eye bx-hide"></i></span>
            </div>
            <?= form_error('password_baru', '<small class="text-danger">', '</small>') ?>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label" for="konfirmasi_password">Konfirmasi Password</label>
        <div class="col-sm-3">
            <div class="input-group input-group-merge">
                <input
                    type="password"
                    id="konfirmasi_password"
                    name="konfirmasi_password"
                    class="form-control"
                    autocomplete="new-password"
                    required
                    placeholder="Minimal 6 karakter"
                    aria-describedby="konfirmasi_password"
                    required />
                <span class="input-group-text cursor-pointer toggle-password"><i class="bx #bx-eye bx-hide"></i></span>
            </div>
            <?= form_error('konfirmasi_password', '<small class="text-danger">', '</small>') ?>
        </div>
    </div>
    <button class="btn btn-primary w-100">Ubah Password</button>
</form>