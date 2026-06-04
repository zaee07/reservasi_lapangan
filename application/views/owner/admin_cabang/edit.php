<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Admin Cabang</h4>
        </div>
        <div class="card-body">
            <form
                action="<?= base_url('admin_cabang/update/' . $admin->id) ?>"
                method="POST"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            value="<?= $admin->nama ?>">
                        <small class="text-danger"><?= form_error('nama') ?></small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            class="form-control"
                            value="<?= $admin->email ?>"
                            disabled>
                        <small class="text-muted">Email tidak dapat diubah</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No HP / WhatsApp</label>
                        <input
                            type="text"
                            name="no_hp"
                            class="form-control"
                            value="<?= $admin->no_hp ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cabang</label>
                        <select
                            name="cabang_id"
                            class="form-select">
                            <?php foreach ($cabang as $c) : ?>
                                <option
                                    value="<?= $c->id ?>"
                                    <?= $admin->cabang_id == $c->id ? 'selected' : '' ?>>
                                    <?= $c->nama_cabang ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select
                            name="is_active"
                            class="form-select">
                            <option
                                value="1"
                                <?= $admin->is_active == 1 ? 'selected' : '' ?>>
                                Aktif
                            </option>
                            <option
                                value="0"
                                <?= $admin->is_active == 0 ? 'selected' : '' ?>>
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
                    </div>
                    <?php if ($admin->foto) : ?>
                        <div class="col-md-12 mb-3">
                            <img
                                src="<?= base_url('uploads/user/' . $admin->foto) ?>"
                                width="120"
                                class="rounded">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mt-4">
                    <button
                        type="submit"
                        class="btn btn-primary">
                        <i class="bx bx-save"></i>
                        Update
                    </button>
                    <a
                        href="<?= base_url('admin_cabang') ?>"
                        class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>