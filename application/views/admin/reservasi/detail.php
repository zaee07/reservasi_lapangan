<div class="card">
    <div class="card-body">
        <h5 class="mb-4"><?= $booking->kode_booking ?></h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <small class="text-muted">Cabang</small>
                <div class="fw-bold"><?= $booking->nama_cabang ?></div>
            </div>
            <div class="col-md-6 mb-3">
                <small class="text-muted">Lapangan</small>
                <div class="fw-bold"><?= $booking->nama_lapangan ?></div>
            </div>
            <div class="col-md-6 mb-3">
                <small class="text-muted">Pemesan</small>
                <div class="fw-bold"><?= $booking->nama_pemesan ?></div>
            </div>
            <div class="col-md-6 mb-3">
                <small class="text-muted">No HP</small>
                <div class="fw-bold"><?= $booking->no_hp_pemesan ?></div>
            </div>
            <div class="col-md-6 mb-3">
                <small class="text-muted">Status Booking</small>
                <div><?= badge_status_booking($booking->status_booking) ?></div>
            </div>
            <div class="col-md-6 mb-3">
                <small class="text-muted">Status Pembayaran</small>
                <div><?= badge_status_pembayaran($booking->status_pembayaran) ?></div>
            </div>
        </div>
        <hr>
        <h6>Slot Booking</h6>
        <?php foreach ($slots as $slot) : ?>
            <div class="border rounded p-2 mb-2">
                <?= substr($slot->jam_mulai, 0, 5) ?>-<?= substr($slot->jam_selesai, 0, 5) ?>
            </div>
        <?php endforeach; ?>
        <?php if (
            $booking->status_booking
            ==
            STATUS_BOOKING_PENDING
        ) : ?>

            <a
                href="<?= base_url(
                            'admin/reservasi/confirm/' .
                                $booking->id
                        ) ?>"
                onclick="return confirm(
            'Konfirmasi booking ini?'
        )"
                class="btn btn-success">
                Confirm Booking
            </a>

        <?php endif; ?>
    </div>
</div>