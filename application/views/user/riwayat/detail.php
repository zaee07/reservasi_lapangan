<div class="card-custom border-0 shadow-sm">
    <div class="card-body">
        <div class="text-center mb-3">
            <div class="fw-bold fs-5">
                <?= $booking->kode_booking ?>
            </div>
            <div class="mt-2">
                <?= badge_status_booking(
                    $booking->status_booking
                ) ?>
            </div>
        </div>
        <hr>
        <div class="mb-3">
            <div class="text-muted small">
                Cabang
            </div>
            <div class="fw-semibold">
                <?= $booking->nama_cabang ?>
            </div>
        </div>
        <div class="mb-3">
            <div class="text-muted small">
                Lapangan
            </div>
            <div class="fw-semibold">
                <?= $booking->nama_lapangan ?>
            </div>
        </div>
        <div class="mb-3">
            <div class="text-muted small">
                Tanggal
            </div>
            <div class="fw-semibold">
                <?= $booking->tanggal_main ?>
            </div>
        </div>
        <div class="mb-3">
            <div class="text-muted small">
                Pembayaran
            </div>
            <div class="fw-semibold">
                <?= $pembayaran->invoice_no; ?>
                <?= badge_status_pembayaran($pembayaran->status_pembayaran); ?>
            </div>
        </div>
        <div class="mb-3">
            <div class="text-muted small">
                Slot Booking
            </div>
            <?php foreach ($slots as $slot) : ?>
                <div class="border rounded p-2 mb-2">
                    <?= substr(
                        $slot->jam_mulai,
                        0,
                        5
                    ) ?>
                    -

                    <?= substr(
                        $slot->jam_selesai,
                        0,
                        5
                    ) ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="mb-3">
            <div class="text-muted small">
                Total Bayar
            </div>
            <div class="fw-bold text-primary">
                Rp <?= number_format(
                        $booking->total_bayar,
                        0,
                        ',',
                        '.'
                    ) ?>
            </div>
        </div>
        <?php if (
            $booking->status_booking
            ==
            STATUS_BOOKING_CONFIRMED
            &&
            $pembayaran->status_pembayaran
            ==
            STATUS_PEMBAYARAN_PAID
        ) : ?>
            <div class="text-center mt-4">
                <div class="qr-section">
                    <img src="<?= base_url('uploads/qrcode/' . $booking->qr_booking) ?>" class="img-fluid" style="max-width:250px;">
                </div>
                <div class="mt-2 text-muted">
                    Tunjukkan QR ini saat check-in
                </div>
            </div>
        <?php endif; ?>
        <?php if (
            $booking->status_booking
            ==
            STATUS_BOOKING_PENDING
        ) : ?>
            <div class="d-grid">
                <a
                    href="<?= base_url(
                                'riwayat/cancel/' . $booking->id
                            ) ?>"
                    onclick="return confirm(
                        'Batalkan booking?'
                    )"
                    class="btn btn-danger">
                    Batalkan Booking
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>