<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk-Toko Barokah</title>
</head>

<body>
    <h2>Laporan Produk - Toko Barokah</h2>
    <p>DK.Gardu RT 03 - RW 01 Kutamendala</p>
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1;
            foreach ($produk as $p) : ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= $p->nama_produk ?></td>
                    <td>Rp. <?= number_format($p->harga, 0, ',', '.') ?></td>
                    <td><?= $p->stok . ' ' . $p->satuan ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>