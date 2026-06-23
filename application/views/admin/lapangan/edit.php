<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h4>Edit Lapangan</h4>
        </div>
        <div class="card-body">
            <form action="<?= base_url('lapangan/update/' . $lapangan->id) ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Kode Lapangan</label>
                    <input
                        type="text"
                        name="kode_lapangan"
                        class="form-control"
                        value="<?php //= $lapangan->kode_lapangan 
                                ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Lapangan</label>
                    <input
                        type="text"
                        name="nama_lapangan"
                        class="form-control"
                        value="<?= $lapangan->nama_lapangan ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Lantai</label>
                    <select
                        name="jenis_lantai"
                        class="form-select">
                        <option value="vinyl" <?= $lapangan->jenis_lantai == 'vinyl' ? 'selected' : '' ?>>
                            Vinyl
                        </option>
                        <option value="karpet" <?= $lapangan->jenis_lantai == 'karpet' ? 'selected' : '' ?>>
                            Karpet
                        </option>
                        <option value="semen" <?= $lapangan->jenis_lantai == 'semen' ? 'selected' : '' ?>>
                            Semen
                        </option>
                        <option value="rumput_sintetis" <?= $lapangan->jenis_lantai == 'rumput_sintetis' ? 'selected' : '' ?>>
                            Rumput Sintetis
                        </option>
                    </select>
                </div>
                <?php
                $hari_aktif = explode(',', $lapangan->hari_operasional);
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <label>Jam Buka</label>
                        <input
                            type="time"
                            name="jam_buka"
                            value="<?= $lapangan->jam_buka ?>"
                            class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Jam Tutup</label>
                        <input
                            type="time"
                            name="jam_tutup"
                            value="<?= $lapangan->jam_tutup ?>"
                            class="form-control">
                    </div>
                </div>
                <hr>
                <label>Hari Operasional</label>
                <div class="row">
                    <?php
                    $hari = [
                        1 => 'Senin',
                        2 => 'Selasa',
                        3 => 'Rabu',
                        4 => 'Kamis',
                        5 => 'Jumat',
                        6 => 'Sabtu',
                        0 => 'Minggu'
                    ];
                    foreach ($hari as $key => $value):
                    ?>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="hari_operasional[]"
                                    value="<?= $key ?>"
                                    <?= in_array($key, $hari_aktif) ? 'checked' : '' ?>>
                                <label class="form-check-label"><?= $value ?></label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <label>Foto 1</label>
                        <input
                            type="file"
                            name="foto_1"
                            class="form-control">
                        <?php if ($lapangan->foto_1): ?>
                            <div class="card">
                                <img
                                    src="<?= base_url('uploads/lapangan/' . $lapangan->foto_1) ?>"
                                    class="card-img-top img-fluid mt-2 rounded"
                                    style="height:180px;object-fit:cover">
                                <div class="card-body p-2">
                                    <a
                                        href="<?= base_url('lapangan/hapus_foto/' . $lapangan->id . '/1') ?>"
                                        class="btn btn-danger btn-sm w-100"
                                        onclick="return confirm('Hapus foto ini?')">
                                        <i class="bx bx-trash"></i>
                                        Hapus
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <label>Foto 2</label>
                        <input
                            type="file"
                            name="foto_2"
                            class="form-control">
                        <?php if ($lapangan->foto_2): ?>
                            <div class="card">
                                <img
                                    src="<?= base_url('uploads/lapangan/' . $lapangan->foto_2) ?>"
                                    class="card-img-top img-fluid mt-2 rounded"
                                    style="height:180px;object-fit:cover">
                                <div class="card-body p-2">
                                    <a
                                        href="<?= base_url('lapangan/hapus_foto/' . $lapangan->id . '/2') ?>"
                                        class="btn btn-danger btn-sm w-100"
                                        onclick="return confirm('Hapus foto ini?')">
                                        <i class="bx bx-trash"></i>
                                        Hapus
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <label>Foto 3</label>
                        <input
                            type="file"
                            name="foto_3"
                            class="form-control">
                        <?php if ($lapangan->foto_3): ?>
                            <div class="card">
                                <img
                                    src="<?= base_url('uploads/lapangan/' . $lapangan->foto_3) ?>"
                                    class="card-img-top img-fluid mt-2 rounded"
                                    style="height:180px;object-fit:cover">
                                <div class="card-body p-2">
                                    <a
                                        href="<?= base_url('lapangan/hapus_foto/' . $lapangan->id . '/13') ?>"
                                        class="btn btn-danger btn-sm w-100"
                                        onclick="return confirm('Hapus foto ini?')">
                                        <i class="bx bx-trash"></i>
                                        Hapus
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="aktif" <?= $lapangan->status == 'aktif' ? 'selected' : '' ?>>
                            Aktif
                        </option>
                        <option value="pemeliharaan" <?= $lapangan->status == 'pemeliharaan' ? 'selected' : '' ?>>
                            Maintenance
                        </option>
                        <option value="nonaktif" <?= $lapangan->status == 'nonaktif' ? 'selected' : '' ?>>
                            Nonaktif
                        </option>
                    </select>
                </div>
                <a href="<?= base_url('lapangan/regenerate_slot/' . $lapangan->id) ?>" class="btn btn-warning" onclick="return confirm('Generate ulang slot 30 hari?')">
                    Regenerate Slot 30 Hari
                </a>
                <button class="btn btn-primary"> Update </button>
                <a href="<?= base_url('lapangan') ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>