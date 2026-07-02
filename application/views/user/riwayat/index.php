<?php if (empty($riwayat)) : ?>
    <div class="alert alert-warning">Belum ada booking</div>
<?php endif; ?>

<?php foreach ($riwayat as $r) : ?>
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="fw-bold"><?= $r->kode_booking ?></div>
                    <small class="text-muted"><?= $r->nama_cabang ?></small>
                </div>
                <div>
                    <?= badge_status_booking($r->status_booking) ?>
                </div>
            </div>
            <hr>
            <div class="mb-2">
                <div class="fw-semibold"><?= $r->nama_lapangan ?>
                </div>
                <small class="text-muted">
                    <?= date('d M Y', strtotime($r->tanggal_main)) ?>
                    •
                    <?= substr($r->jam_mulai, 0, 5) ?>
                    -
                    <?= substr($r->jam_selesai, 0, 5) ?>
                </small>
            </div>
            <div class="mb-2">
                <small class="text-muted">Invoice</small>
                <div class="fw-semibold"><?= $r->invoice_no ?: '-' ?></div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-primary fw-bold">
                        Rp <?= number_format($r->total_bayar, 0, ',', '.') ?>
                    </div>
                    <div class="mt-1"><?= badge_status_pembayaran($r->status_pembayaran) ?></div>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('riwayat_booking/detail/' . $r->id) ?>" class="btn btn-sm btn-outline-primary"> Detail</a>
                    <?php if ($r->status_booking == STATUS_BOOKING_PENDING) : ?>
                        <a href="<?= base_url('riwayat_booking/cancel/' . $r->id) ?>"
                            onclick="return confirm('Batalkan booking?')"
                            class="btn btn-sm btn-outline-danger">
                            Batalkan
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>