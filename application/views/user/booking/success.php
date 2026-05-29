<div class="card shadow-sm">

    <div class="card-body text-center">

        <div class="mb-3">

            <i class="bi bi-check-circle-fill text-success fs-1"></i>

        </div>

        <h5 class="fw-bold">
            Booking Berhasil
        </h5>

        <p class="text-muted">
            Silakan lanjut pembayaran
        </p>

        <hr>

        <div class="text-start">

            <div class="d-flex justify-content-between mb-2">

                <span>Kode Booking</span>

                <strong>
                    <?= $booking->kode_booking ?>
                </strong>

            </div>

            <div class="d-flex justify-content-between mb-2">

                <span>Lapangan</span>

                <strong>
                    <?= $booking->nama_lapangan ?>
                </strong>

            </div>

            <div class="d-flex justify-content-between mb-2">

                <span>Tanggal</span>

                <strong>
                    <?= $booking->tanggal_main ?>
                </strong>

            </div>

            <div class="d-flex justify-content-between mb-2">

                <span>Jam</span>

                <strong>
                    <?= substr($booking->jam_mulai, 0, 5) ?>
                    -
                    <?= substr($booking->jam_selesai, 0, 5) ?>
                </strong>

            </div>

            <div class="d-flex justify-content-between mb-2">

                <span>Total Bayar</span>

                <strong class="text-primary">
                    Rp <?= number_format($booking->total_bayar, 0, ',', '.') ?>
                </strong>

            </div>

        </div>

    </div>

</div>