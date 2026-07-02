<div class="text-center mb-4">
    <h5 class="fw-bold">Pembayaran QRIS</h5>
    <?= badge_status_pembayaran($pembayaran->status_pembayaran) ?>
    <h2 id="countdown" class="fw-bold text-danger mt-3"></h2>
    <small class="text-muted">Sisa waktu pembayaran</small>
</div>
<div class="card border-0 bg-light mb-4">
    <div class="card-body text-center">
        <img
            src="<?= base_url('uploads/payment/' . $pembayaran->qr_image) ?>"
            class="img-fluid rounded border p-2 bg-white"
            style="max-width:260px">
        <p class="mt-3 text-muted mb-0">
            Scan menggunakan aplikasi
            QRIS / Mobile Banking / E-Wallet
        </p>
    </div>
</div>
<div class="card border-0">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <span>Invoice</span>
            <strong><?= $pembayaran->invoice_no ?></strong>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span>Kode Booking</span>
            <strong><?= $booking->kode_booking ?></strong>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span><i class="bi bi-building me-1"></i>Cabang</span>
            <strong><?= $booking->nama_cabang ?></strong>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span><i class="bi bi-grid me-1"></i>Lapangan</span>
            <strong><?= $booking->nama_lapangan ?></strong>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span><i class="bi bi-calendar3 me-1"></i>Tanggal</span>
            <strong><?= $booking->tanggal_main ?></strong>
        </div>
        <div class="d-flex justify-content-between">
            <span><i class="bi bi-clock me-1"></i>Jam</span>
            <strong>
                <?= substr($booking->jam_mulai, 0, 5) ?>
                -
                <?= substr($booking->jam_selesai, 0, 5) ?>
            </strong>
        </div>
        <hr>
        <div class="text-center">
            <small class="text-muted">
                Total Pembayaran
            </small>
            <h2 class="text-primary fw-bold">
                Rp <?= number_format($booking->total_bayar, 0, ',', '.') ?>
            </h2>
        </div>
    </div>
</div>
<div class="d-grid mt-4">
    <button
        onclick="checkPaymentStatus()"
        class="btn btn-success">
        <i class="bi bi-arrow-repeat me-2"></i>
        Cek Pembayaran
    </button>
</div>
<script>
    const expiredAt = <?= strtotime($booking->expired_at) * 1000 ?>;
    let countdownInterval = null;
    let paymentInterval = null;

    function updateCountdown() {
        let diff = expiredAt - Date.now();
        if (diff <= 0) {
            $("#countdown").text("00:00");
            clearInterval(countdownInterval);
            return;
        }

        let minute = Math.floor(diff / 60000);
        let second = Math.floor((diff % 60000) / 1000);

        $("#countdown").text(String(minute).padStart(2, '0') + ":" + String(second).padStart(2, '0'));
    }

    function checkPaymentStatus() {
        $.get(
            "<?= base_url('payment/ajax_status/' . $pembayaran->invoice_no) ?>",
            function(res) {
                switch (res.status) {
                    case "paid":
                        clearInterval(countdownInterval);
                        clearInterval(paymentInterval);
                        window.location = "<?= base_url('payment/success/' . $pembayaran->invoice_no) ?>";
                        break;
                    case "expired":
                        clearInterval(countdownInterval);
                        clearInterval(paymentInterval);
                        window.location = "<?= base_url('member/riwayat/detail/' . $booking->id) ?>";
                        break;
                    case "unpaid":
                        // masih menunggu pembayaran
                        break;
                    default:
                        console.log(res);
                        break;
                }
            },
            "json"
        );
    }
    updateCountdown();

    countdownInterval = setInterval(updateCountdown, 1000);
    paymentInterval = setInterval(checkPaymentStatus, 5000);
</script>