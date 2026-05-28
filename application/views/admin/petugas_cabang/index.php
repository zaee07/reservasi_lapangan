<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="fw-bold">Petugas Cabang</h4>

        <a
            href="<?= base_url('petugas_cabang/create') ?>"
            class="btn btn-primary">
            <i class="bx bx-plus"></i>
            Tambah Petugas
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

                    <?php foreach ($petugas as $p) : ?>

                        <tr>

                            <td>

                                <?php if ($p->foto) : ?>

                                    <img
                                        src="<?= base_url('uploads/user/' . $p->foto) ?>"
                                        width="45"
                                        class="rounded-circle">

                                <?php endif; ?>

                            </td>

                            <td><?= $p->nama ?></td>

                            <td><?= $p->email ?></td>

                            <td><?= $p->nama_cabang ?></td>

                            <td><?= $p->no_hp ?></td>

                            <td>

                                <?php if ($p->is_active == 1) : ?>

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
                                    href="<?= base_url('petugas_cabang/edit/' . $p->id) ?>"
                                    class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <a
                                    href="<?= base_url('petugas_cabang/delete/' . $p->id) ?>"
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