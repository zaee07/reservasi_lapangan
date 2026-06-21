<h2>GOR HARMONI</h2>
<hr>
<p>
    <strong>Kode Booking:</strong>
    <?= $booking->kode_booking ?>
</p>
<p>
    <strong>Pemesan:</strong>
    <?= $booking->nama_pemesan ?>
</p>
<p>
    <strong>Lapangan:</strong>
    <?= $booking->nama_lapangan ?>
</p>
<p>
    <strong>Tanggal:</strong>
    <?= $booking->tanggal_main ?>
</p>
<p>
    <strong>Jam:</strong>
    <?= $booking->jam_mulai ?> - <?= $booking->jam_selesai ?>
</p>
<p>
    <strong>Status:</strong>
    <?= ucfirst($booking->status_booking) ?>
</p>
<?php
$path = FCPATH . 'uploads/qrcode/' . $booking->qr_booking;

if (file_exists($path)) {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
}
?>
<?php if (!empty($base64)) : ?>
    <img src="<?= $base64 ?>" width="180">
<?php endif; ?>