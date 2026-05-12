<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="<?= base_url('dashboard') ?>" class="text-muted fw-light">Dashboard</a> /
        </span>
        Ubah Password
    </h4>

    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Ubah Password</h5>
                    <small class="text-muted float-end">change password</small>
                </div>

                <div class="card-body">
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('auth/ubah_password') ?>">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="password_lama">
                                Password Lama
                            </label>
                            <div class="col-sm-9">
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password_lama"
                                    name="password_lama"
                                    placeholder="Masukkan password lama"
                                    required>
                                <?= form_error('password_lama', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="password_baru">
                                Password Baru
                            </label>
                            <div class="col-sm-9">
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password_baru"
                                    name="password_baru"
                                    placeholder="Minimal 6 karakter"
                                    required>
                                <?= form_error('password_baru', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="konfirmasi_password">
                                Konfirmasi Password
                            </label>
                            <div class="col-sm-9">
                                <input
                                    type="password"
                                    class="form-control"
                                    id="konfirmasi_password"
                                    name="konfirmasi_password"
                                    placeholder="Ulangi password baru"
                                    required>
                                <?= form_error('konfirmasi_password', '<small class="text-danger">', '</small>') ?>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save"></i> Simpan Password
                                </button>
                                <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-secondary ms-2">
                                    Batal
                                </a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>