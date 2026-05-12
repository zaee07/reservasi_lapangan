<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4 class="fw-bold">Data Lapangan</h4>

        <a
            href="<?= base_url('lapangan/create') ?>"
            class="btn btn-primary">
            <i class="bx bx-plus"></i>
            Tambah Lapangan
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
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Jenis Lantai</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($lapangan as $l) : ?>

                        <tr>

                            <td>

                                <?php if ($l->foto) : ?>

                                    <img
                                        src="<?= base_url('uploads/lapangan/' . $l->foto) ?>"
                                        width="60"
                                        class="rounded">

                                <?php endif; ?>

                            </td>

                            <td><?php // $l->kode_lapangan 
                                ?></td>

                            <td><?= $l->nama_lapangan ?></td>

                            <td><?= ucfirst($l->jenis_lantai) ?></td>

                            <td>

                                <?php if ($l->status == 'aktif') : ?>

                                    <span class="badge bg-label-success">
                                        Aktif
                                    </span>

                                <?php elseif ($l->status == 'maintenance') : ?>

                                    <span class="badge bg-label-warning">
                                        Maintenance
                                    </span>

                                <?php else : ?>

                                    <span class="badge bg-label-danger">
                                        Nonaktif
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>

                                <a
                                    href="<?= base_url('lapangan/edit/' . $l->id) ?>"
                                    class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <a
                                    href="<?= base_url('lapangan/delete/' . $l->id) ?>"
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