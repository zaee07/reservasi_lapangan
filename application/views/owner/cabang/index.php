<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Data Cabang</h4>

        <a href="<?= base_url('cabang/create') ?>" class="btn btn-primary">
            <i class="bx bx-plus"></i> Tambah Cabang
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
                        <th>Logo</th>
                        <th>Kode</th>
                        <th>Nama Cabang</th>
                        <th>No WA</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($cabang as $c) : ?>

                        <tr>

                            <td>
                                <?php if ($c->logo) : ?>
                                    <img
                                        src="<?= base_url('uploads/logo/' . $c->logo) ?>"
                                        width="50">
                                <?php endif; ?>
                            </td>

                            <td><?= $c->kode_cabang ?></td>

                            <td><?= $c->nama_cabang ?></td>

                            <td><?= $c->no_wa ?></td>

                            <td>
                                <?php if ($c->status == 'aktif') : ?>

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
                                    href="<?= base_url('cabang/edit/' . $c->id) ?>"
                                    class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <a
                                    href="<?= base_url('cabang/delete/' . $c->id) ?>"
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