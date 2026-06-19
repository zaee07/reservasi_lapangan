<table border="0">
    <tr>
        <td colspan="8"><strong>GOR HARMONI</strong></td>
    </tr>
    <tr>
        <td colspan="8"><strong>LAPORAN BOOKING & PENDAPATAN</strong></td>
    </tr>
    <tr>
        <td colspan="8">Periode :<?= $tanggal_awal ?>s/d<?= $tanggal_akhir ?></td>
    </tr>
</table>
<br>
<table border="1">
    <tr>
        <td>Total Booking</td>
        <td><?= $total_booking ?></td>
    </tr>
    <tr>
        <td>Booking Online</td>
        <td><?= $booking_online ?></td>
    </tr>
    <tr>
        <td>Booking Walk In</td>
        <td><?= $booking_walkin ?></td>
    </tr>
    <tr>
        <td>Total Pendapatan</td>
        <td>
            Rp <?= number_format($total_pendapatan, 0, ',', '.') ?>
        </td>
    </tr>
</table>
<br><br>
<table border="1">
    <thead>
        <tr style="font-weight:bold">
            <th>No</th>
            <th>Kode Booking</th>
            <th>Tanggal Main</th>
            <th>Pemesan</th>
            <th>Lapangan</th>
            <th>Tipe Booking</th>
            <th>Status</th>
            <th>Total Bayar</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($laporan as $row) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->kode_booking ?></td>
                <td><?= $row->tanggal_main ?></td>
                <td><?= $row->nama_pemesan ?></td>
                <td><?= $row->nama_lapangan ?></td>
                <td><?= ucfirst($row->tipe_booking) ?></td>
                <td><?= $row->status_booking ?></td>
                <td><?= $row->total_bayar ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>