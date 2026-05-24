<div class="mb-3">

    <form method="GET">

        <div class="row">

            <div class="col-8">

                <input
                    type="date"
                    name="tanggal"
                    class="form-control"
                    value="<?= $tanggal ?>">

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

    <div class="alert alert-warning">
        Jadwal belum tersedia
    </div>

<?php endif; ?>

<?php

$current_lapangan = '';

foreach ($jadwal as $j) :

    if ($current_lapangan != $j->nama_lapangan) :

        $current_lapangan = $j->nama_lapangan;
?>

        <div class="card mb-3 shadow-sm">

            <div class="card-header">

                <div class="fw-bold">
                    <?= $j->nama_lapangan ?>
                </div>

                <small class="text-muted">
                    <?= $j->nama_cabang ?>
                </small>

            </div>

            <div class="card-body">

            <?php endif; ?>

            <div
                class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">

                <div>

                    <div class="fw-semibold">

                        <?= substr($j->jam_mulai, 0, 5) ?>
                        -
                        <?= substr($j->jam_selesai, 0, 5) ?>

                    </div>

                </div>

                <div>

                    <?php if ($j->status_slot == 'available') : ?>

                        <span class="badge bg-success">
                            Tersedia
                        </span>

                    <?php elseif ($j->status == 'booked') : ?>

                        <span class="badge bg-primary">
                            Dipesan
                        </span>

                    <?php elseif ($j->status == 'in_use') : ?>

                        <span class="badge bg-warning text-dark">
                            Maintenance
                        </span>

                    <?php elseif ($j->status == 'closed') : ?>

                        <span class="badge bg-warning text-dark">
                            Tutup
                        </span>

                    <?php else : ?>

                        <span class="badge bg-danger">
                            Tutup
                        </span>

                    <?php endif; ?>

                </div>

            </div>

            <?php

            $next = next($jadwal);

            if (
                !$next ||
                $next->nama_lapangan != $current_lapangan
            ) :
            ?>

            </div>

        </div>

    <?php endif; ?>

<?php endforeach; ?>