<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Petugas Cabang</h4>
        </div>
        <div class="card-body">
            <form
                action="<?= base_url('petugas_cabang/update/' . $petugas->id) ?>"
                method="POST"
                enctype="multipart/form-data">
                <input type="hidden" name="cabang_id" value="<?= $cabang_id ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Nama Lengkap
                        </label>
                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            value="<?= $petugas->nama ?>">
                        <small class="text-danger">
                            <?= form_error('nama') ?>
                        </small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Email
                        </label>
                        <input
                            type="email"
                            class="form-control"
                            value="<?= $petugas->email ?>"
                            disabled>
                        <small class="text-muted">
                            Email tidak dapat diubah
                        </small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            No HP / WhatsApp
                        </label>
                        <input
                            type="text"
                            name="no_hp"
                            class="form-control"
                            value="<?= $petugas->no_hp ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select
                            name="is_active"
                            class="form-select">
                            <option
                                value="1"
                                <?= $petugas->is_active == 1 ? 'selected' : '' ?>>
                                Aktif
                            </option>
                            <option
                                value="0"
                                <?= $petugas->is_active == 0 ? 'selected' : '' ?>>
                                Nonaktif
                            </option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">
                            Foto
                        </label>
                        <input
                            type="file"
                            name="foto"
                            class="form-control">
                        <small class="text-muted">Format: JPG, JPEG, PNG maks file 2MB</small>
                    </div>
                    <?php if ($petugas->foto) : ?>
                        <div class="col-md-12 mb-3">
                            <img
                                src="<?= base_url('uploads/user/' . $petugas->foto) ?>"
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
                        href="<?= base_url('petugas_cabang') ?>"
                        class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>