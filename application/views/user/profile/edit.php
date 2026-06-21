<form method="post" enctype="multipart/form-data">
    <div class="text-center mb-4">
        <?php if (!empty($user['foto'])) : ?>
            <img
                id="preview-foto"
                src="<?= base_url('uploads/user/' . $user['foto']) ?>"
                class="rounded-circle shadow"
                style="width:120px;height:120px;object-fit:cover;">
        <?php else : ?>
            <img
                id="preview-foto"
                src="<?= base_url('assets/img/avatars/def.png') ?>"
                class="rounded-circle shadow"
                style="width:120px;height:120px;object-fit:cover;">
        <?php endif; ?>
    </div>
    <?php if (!empty($user['foto'])) : ?>
        <a
            href="<?= base_url('profile/hapus_foto') ?>"
            class="btn btn-outline-danger btn-sm mt-2"
            onclick="return confirm('Hapus foto profil?')">
            Hapus Foto
        </a>
    <?php endif; ?>
    <div class="mb-3">
        <label class="form-label">
            Foto Profil
        </label>
        <input
            type="file"
            name="foto"
            id="foto"
            class="form-control"
            accept="image/*">
    </div>
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" value="<?= $user['nama'] ?>">
        <?= form_error('nama', '<small class="text-danger">', '</small>') ?>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>">
        <?= form_error('email', '<small class="text-danger">', '</small>') ?>
    </div>
    <div class="mb-3">
        <label>No HP</label>
        <input type="text" name="no_hp" class="form-control" value="<?= $user['no_hp'] ?>">
        <?= form_error('no_hp', '<small class="text-danger">', '</small>') ?>
    </div>
    <button class="btn btn-primary w-100">Simpan</button>
</form>