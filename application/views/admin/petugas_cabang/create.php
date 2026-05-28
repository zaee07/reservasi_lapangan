<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Tambah Petugas Cabang</h4>
        </div>
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
                        <input type="email" name="email" class="form-control" value="<?= set_value('email') ?>">
                        <small class="text-danger"> <?= form_error('email') ?></small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control">
                        <small class="text-danger"><?= form_error('password') ?></small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No HP / WhatsApp</label>
                        <input type="text" name="no_hp" class="form-control" value="<?= set_value('no_hp') ?>">
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
                        <small class="text-muted">Format: JPG, JPEG, PNG</small>
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
                        href="<?= base_url('admin_cabang') ?>"
                        class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>