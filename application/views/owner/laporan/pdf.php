<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
        }

        .text-center {
            text-align: center;
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary td {
            border: none;
            padding: 3px;
        }
    </style>
</head>

<body>
    <h2 class="text-center">GOR HARMONI</h2>
    <h3 class="text-center">LAPORAN BOOKING & PENDAPATAN</h3>
    <p class="text-center">Periode :<?= date('d-m-Y', strtotime($tanggal_awal)) ?>s/d<?= date('d-m-Y', strtotime($tanggal_akhir)) ?></p>
    <hr>
    <table class="summary">
        <tr>
            <td width="30%">Total Booking</td>
            <td>:<?= $total_booking ?></td>
        </tr>
        <tr>
            <td>Booking Online</td>
            <td>:<?= $booking_online ?></td>
        </tr>
        <tr>
            <td>Booking Walk In</td>
            <td>:<?= $booking_walkin ?></td>
        </tr>
        <tr>
            <td>Total Pendapatan</td>
            <td>:Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></td>
        </tr>
    </table>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Cabang</th>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Pemesan</th>
                <th>Lapangan</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($laporan as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->nama_cabang ?></td>
                    <td><?= $row->kode_booking ?></td>
                    <td><?= $row->tanggal_main ?></td>
                    <td><?= $row->nama_pemesan ?></td>
                    <td><?= $row->nama_lapangan ?></td>
                    <td><?= ucfirst($row->tipe_booking) ?></td>
                    <td><?= $row->status_booking ?></td>
                    <td>Rp <?= number_format($row->total_bayar, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>