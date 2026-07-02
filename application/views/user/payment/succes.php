<div class="container py-5">
    <div class="card shadow">
        <div class="card-body text-center">
            <div class="display-3 text-success">
                <i class="bx bx-check-circle"></i>
            </div>
            <h2 class="mt-3">Pembayaran Berhasil</h2>
            <p>Terima kasih.Booking Anda telah dikonfirmasi.</p>
            <hr>
            <table class="table">
                <tr>
                    <th>Invoice</th>
                    <td><?= $payment->invoice_no ?></td>
                </tr>
                <tr>
                    <th>Kode Booking</th>
                    <td><?= $booking->kode_booking ?></td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td><?= $booking->tanggal_main ?></td>
                </tr>
                <tr>
                    <th>Jam</th>
                    <td><?= substr($booking->jam_mulai, 0, 5) ?>-<?= substr($booking->jam_selesai, 0, 5) ?></td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td>Rp<?= number_format($booking->total_bayar, 0, ',', '.') ?></td>
                </tr>
            </table>
            <a href="<?= base_url('riwayat_booking/detail/' . $booking->id) ?>" class="btn btn-primary">
                Lihat Booking
            </a>
        </div>
    </div>
</div>