<div class="card border-0 shadow-sm">
    <div class="card-body text-center p-4">
        <div class="display-2 text-success mb-3">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <h4 class="fw-bold">Pembayaran Berhasil</h4>
        <p class="text-muted mb-4">
            Terima kasih, pembayaran berhasil diterima.
            Booking Anda telah dikonfirmasi.
        </p>
        <?= badge_status_booking($booking->status_booking) ?>
        <hr>
        <div class="text-center">
            <small class="text-muted">Total Pembayaran</small>
            <h2 class="fw-bold text-success mb-0">Rp <?= number_format($booking->total_bayar, 0, ',', '.') ?></h2>
        </div>
        <hr>
        <div class="alert alert-success py-2 small">
            <i class="bi bi-info-circle-fill me-2"></i>
            Simpan QR Booking dan tunjukkan kepada petugas saat check-in.
        </div>
        <div class="d-grid gap-2 mt-4">
            <a href="<?= base_url('riwayat_booking/detail/' . $booking->id) ?>" class="btn btn-primary btn-lg">
                <i class="bi bi-ticket-perforated me-2"></i>
                Lihat Detail Booking
            </a>
            <a href="<?= base_url('home') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-house me-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>