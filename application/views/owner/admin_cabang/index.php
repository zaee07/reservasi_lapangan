<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Admin Cabang</h4>
        <a
            href="<?= base_url('admin_cabang/create') ?>"
            class="btn btn-primary">
            <i class="bx bx-plus"></i>
            Tambah Admin
        </a>
    </div>
    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Cabang</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admin as $a) : ?>
                        <tr>
                            <td>
                                <?php if ($a->foto) : ?>
                                    <img
                                        src="<?= base_url('uploads/user/' . $a->foto) ?>"
                                        width="45"
                                        class="rounded-circle">
                                <?php endif; ?>
                            </td>
                            <td><?= $a->nama ?></td>
                            <td><?= $a->email ?></td>
                            <td><?= $a->nama_cabang ?></td>
                            <td><?= $a->no_hp ?></td>
                            <td>
                                <?php if ($a->is_active == 1) : ?>
                                    <span class="badge bg-label-success">
                                        Aktif
                                    </span>
                                <?php else : ?>
                                    <span class="badge bg-label-danger">
                                        Nonaktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a
                                    href="<?= base_url('admin_cabang/edit/' . $a->id) ?>"
                                    class="btn btn-sm btn-info">
                                    Edit
                                </a>
                                <a
                                    href="<?= base_url('admin_cabang/password/' . $a->id) ?>"
                                    class="btn btn-sm btn-warning">
                                    Ubah Password
                                </a>
                                <a
                                    href="<?= base_url('admin_cabang/delete/' . $a->id) ?>"
                                    onclick="return confirm('Yakin hapus data?')"
                                    class="btn btn-sm btn-danger">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>