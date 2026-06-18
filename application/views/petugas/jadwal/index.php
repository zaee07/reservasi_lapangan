<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Jadwal Slot</h4>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input type="date" name="tanggal" class="form-control" value="<?= $tanggal ?>">
                    </div>
                    <div class="col-md-4">
                        <select name="lapangan" class="form-select">
                            <option value="">-- Pilih Lapangan --</option>
                            <?php foreach ($lapangan as $l) : ?>
                                <option value="<?= $l->id ?>">
                                    <?= $l->nama_lapangan ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jadwal as $j) : ?>
                        <tr>
                            <td><?= $j->nama_lapangan ?></td>
                            <td><?= $j->tanggal ?></td>
                            <td>
                                <?= substr($j->jam_mulai, 0, 5) ?>
                                -
                                <?= substr($j->jam_selesai, 0, 5) ?>
                            </td>
                            <td><?= badge_status_slot($j->status_slot) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>