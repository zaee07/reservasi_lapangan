<div class="card">
    <div class="card-body">
        <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="date" name="tanggal" class="form-control" value="<?= $tanggal ?>">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">Semua Status </option>
                        <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>> Pending </option>
                        <option value="paid" <?= $status == 'paid' ? 'selected' : '' ?>> Paid </option>
                        <option value="expired" <?= $status == 'expired' ? 'selected' : '' ?>> Expired </option>
                        <option value="failed" <?= $status == 'failed' ? 'selected' : '' ?>> Failed </option>
                    </select>
                </div>
                <div class="col-md-4 d-grid">
                    <button class="btn btn-primary">
                        Filter
                    </button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Booking</th>
                        <th>Pemesan</th>
                        <th>Lapangan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pembayaran)) : ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada pembayaran</td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($pembayaran as $p) : ?>
                        <tr>
                            <td><?= $p->invoice_no ?></td>
                            <td><?= $p->kode_booking ?></td>
                            <td><?= $p->nama_pemesan ?></td>
                            <td><?= $p->nama_lapangan ?></td>
                            <td>Rp <?= number_format($p->total_bayar, 0, ',', '.') ?></td>
                            <td><?= badge_status_pembayaran($p->status_pembayaran) ?></td>
                            <td>
                                <a href="<?= base_url('admin/transaksi/detail/' . $p->id) ?>" class="btn btn-sm btn-primary">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>