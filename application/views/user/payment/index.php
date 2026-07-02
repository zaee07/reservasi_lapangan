<div class="card-custom border-0 shadow-sm">
    <div class="card-body">

        <div class="text-center mb-3">
            <div class="fw-bold fs-5">
                Pembayaran Qris <?= $booking->kode_booking ?>
            </div>
            <div class="mt-2">
                <?= badge_status_booking($booking->status_booking) ?>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-header">
                <h4>Pembayaran QRIS</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>

                        <td width="180">Invoice</td>

                        <td><?= $pembayaran->invoice_no ?></td>

                    </tr>

                    <tr>

                        <td>Kode Booking</td>

                        <td><?= $booking->kode_booking ?></td>

                    </tr>

                    <tr>

                        <td>Nama</td>

                        <td><?= $booking->nama_pemesan ?></td>

                    </tr>

                    <tr>

                        <td>Cabang</td>

                        <td><?= $booking->nama_cabang ?></td>

                    </tr>

                    <tr>

                        <td>Lapangan</td>

                        <td><?= $booking->nama_lapangan ?></td>

                    </tr>

                    <tr>

                        <td>Tanggal</td>

                        <td><?= $booking->tanggal_main ?></td>

                    </tr>

                    <tr>

                        <td>Jam</td>

                        <td>

                            <?= substr($booking->jam_mulai, 0, 5) ?>

                            -

                            <?= substr($booking->jam_selesai, 0, 5) ?>

                        </td>

                    </tr>

                    <tr>

                        <td>Total</td>

                        <td>

                            <h4 class="text-primary">

                                Rp <?= number_format($booking->total_bayar, 0, ',', '.') ?>

                            </h4>

                        </td>

                    </tr>

                </table>

                <hr>

                <div class="text-center">

                    <?php if ($pembayaran->qr_image): ?>

                        <img
                            src="<?= base_url('uploads/payment/' . $pembayaran->qr_image) ?>"
                            class="img-fluid rounded border"
                            style="max-width:300px">

                    <?php else: ?>

                        <div class="alert alert-warning">
                            QRIS belum tersedia.
                        </div>

                    <?php endif; ?>
                </div>

                <hr>

                <div class="row text-center">

                    <div class="col-md-6">

                        <h6>Status</h6>

                        <?= badge_status_pembayaran($pembayaran->status_pembayaran) ?>

                    </div>

                    <div class="col-md-6">

                        <h6>Sisa Waktu</h6>

                        <h4 id="countdown"></h4>

                    </div>

                </div>

                <hr>

                <div class="d-grid gap-2">
                    <button
                        class="btn btn-success"
                        onclick="checkPaymentStatus()">
                        Cek Sekarang
                    </button>
                </div>

            </div>

        </div>

    </div>

</div>

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
            // paymentInterval tetap berjalan
            // menunggu server mengubah status booking menjadi expired
            // clearInterval(paymentInterval);
            // window.location ="<?= base_url('member/riwayat/detail/' . $booking->id) ?>";

            return;
        }

        let minute = Math.floor(diff / 60000);
        let second = Math.floor((diff % 60000) / 1000);

        $("#countdown").text(
            String(minute).padStart(2, '0') +
            ":" +
            String(second).padStart(2, '0')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Check Payment Gateway
    |--------------------------------------------------------------------------
    */
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