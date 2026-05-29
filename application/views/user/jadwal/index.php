<div class="mb-3">
    <form method="GET">
        <div class="row">
            <div class="col-4">
                <input
                    type="date"
                    name="tanggal"
                    class="form-control"
                    value="<?= $tanggal ?>">
            </div>
            <div class="col-4">
                <select class="form-select form-select -sm" aria-label="select-cabang" name="kode_cabang">
                    <?php foreach ($cabang as $c) : ?>
                        <option <?= $kode_cabang == $c->kode_cabang ? 'selected' : '' ?> value="<?= $c->kode_cabang ?>"><?= $c->nama_cabang ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-4 d-grid">
                <button class="btn btn-primary">
                    Filter
                </button>
            </div>
        </div>
    </form>
</div>
<?php if (empty($jadwal)) : ?>
    <div class="alert alert-warning"> Jadwal belum tersedia </div>
<?php endif; ?>

<?php foreach ($jadwal as $nama_cabang => $lapangan) : ?>
    <div class="card border-0 shadow-sm mb-4">
        <div
            class="card-header bg-white">
            <div class="fw-bold fs-6">
                <?= $nama_cabang ?>
            </div>
        </div>
        <div class="card-body">
            <?php foreach ($lapangan as $nama_lapangan => $slots) : ?>
                <div class="mb-4">
                    <div class="fw-semibold mb-2">
                        <?= $nama_lapangan ?>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($slots as $slot) : ?>
                            <div
                                class="border rounded-3 px-3 py-2 bg-white"
                                style="min-width:110px;">
                                <div
                                    class="fw-semibold small mb-1">
                                    <?= substr($slot->jam_mulai, 0, 5) ?>
                                    -
                                    <?= substr($slot->jam_selesai, 0, 5) ?>
                                </div>
                                <div>
                                    <?= badge_status_slot($slot->status_slot) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>