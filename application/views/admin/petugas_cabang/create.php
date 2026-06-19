<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Tambah Petugas Cabang</h4>
        </div>
        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>
        <div class="card-body">
            <form action="<?= base_url('petugas_cabang/store') ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="cabang_id" value="<?= $cabang_id ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"> Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= set_value('nama') ?>">
                        <small class="text-danger"> <?= form_error('nama') ?></small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" autocomplete="off" value="<?= set_value('email') ?>">
                        <small class="text-danger"> <?= form_error('email') ?></small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group input-group-merge">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                autocomplete="new-password"
                                required
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                            <span class="input-group-text cursor-pointer toggle-password"><i class="bx bx-hide"></i></span>
                        </div>
                        <small class="text-danger"><?= form_error('password') ?></small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password Konfirmasi</label>
                        <div class="input-group input-group-merge">
                            <input
                                type="password"
                                id="password_konfirmasi"
                                name="password_konfirmasi"
                                class="form-control"
                                autocomplete="new-password"
                                required
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                            <span class="input-group-text cursor-pointer toggle-password"><i class="bx bx-hide"></i></span>
                        </div>
                        <small class="text-danger"><?= form_error('password_konfirmasi') ?></small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No HP / WhatsApp</label>
                        <input type="text" name="no_hp" class="form-control" value="<?= set_value('no_hp') ?>">
                        <small class="text-danger"> <?= form_error('no_hp') ?></small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select
                            name="is_active"
                            class="form-select">
                            <option value="1">
                                Aktif
                            </option>
                            <option value="0">
                                Nonaktif
                            </option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Foto</label>
                        <input
                            type="file"
                            name="foto"
                            class="form-control">
                        <small class="text-muted">Format: JPG, JPEG, PNG maks file 2MB</small>
                    </div>
                </div>
                <div class="mt-4">
                    <button
                        type="submit"
                        class="btn btn-primary">
                        <i class="bx bx-save"></i>
                        Simpan
                    </button>
                    <a
                        href="<?= base_url('petugas_cabang') ?>"
                        class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>