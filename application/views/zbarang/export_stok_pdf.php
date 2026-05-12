<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produk</title>
</head>

<body>
    <h2>Laporan Stok Produk Menipis - Toko Barokah</h2>
    <p>DK.Gardu RT 03 - RW 01 Kutamendala</p>
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produk as $p) : ?>
                <tr>
                    <td><?= $p->id ?></td>
                    <td><?= $p->nama_produk ?></td>
                    <td><?= $p->stok . ' ' . $p->satuan ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>