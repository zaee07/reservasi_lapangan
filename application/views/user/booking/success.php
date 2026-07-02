<div class="card border-0 shadow-sm">
    <div class="card-body text-center p-4">

        <i class="bi bi-check-circle-fill text-success display-3"></i>

        <h4 class="fw-bold mt-3">
            Booking Berhasil
        </h4>

        <p class="text-muted mb-4">
            Silakan selesaikan pembayaran sebelum waktu habis.
        </p>

        <div class="card bg-light border-0 text-start mb-4">
            <div class="card-body">

                <div class="d-flex justify-content-between mb-2">
                    <span>Kode Booking</span>
                    <strong><?= $booking->kode_booking ?></strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Cabang</span>
                    <strong><?= $booking->nama_cabang ?></strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Lapangan</span>
                    <strong><?= $booking->nama_lapangan ?></strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Tanggal</span>
                    <strong><?= $booking->tanggal_main ?></strong>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Jam</span>
                    <strong>
                        <?= substr($booking->jam_mulai, 0, 5) ?>
                        -
                        <?= substr($booking->jam_selesai, 0, 5) ?>
                    </strong>
                </div>

            </div>
        </div>

        <div class="mb-4">

            <small class="text-muted">
                Total Pembayaran
            </small>

            <h2 class="text-primary fw-bold">
                Rp <?= number_format($booking->total_bayar, 0, ',', '.') ?>
            </h2>

        </div>

        <div class="d-grid">
            <a href="<?= base_url('payment/' . $booking->id) ?>"
                class="btn btn-primary btn-lg">
                Lanjut Pembayaran
            </a>
        </div>

    </div>
</div>