<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Detail Riwayat</h4>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-4"><?= $booking->invoice_no ?></h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Booking</small>
                    <div class="fw-bold"><?= $booking->kode_booking ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Cabang</small>
                    <div class="fw-bold"><?= $booking->nama_cabang ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Lapangan</small>
                    <div class="fw-bold"><?= $booking->nama_lapangan ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Pemesan</small>
                    <div class="fw-bold"><?= $booking->nama_pemesan ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">No HP</small>
                    <div class="fw-bold"><?= $booking->no_hp_pemesan ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Metode Bayar</small>
                    <div class="fw-bold"><?= strtoupper($booking->metode_bayar) ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Status Pembayaran</small>
                    <div><?= badge_status_pembayaran($booking->status_pembayaran) ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Tanggal Main</small>
                    <div class="fw-bold"><?= date('d/m/Y', strtotime($booking->tanggal_main)) ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <small class="text-muted">Jam Main</small>
                    <div class="fw-bold">
                        <?= substr($booking->jam_mulai, 0, 5) ?> - <?= substr($booking->jam_selesai, 0, 5) ?>
                    </div>
                </div>
            </div>
            <?php if (!empty($booking->qr_booking) && $booking->status_booking !== STATUS_BOOKING_COMPLETED) : ?>
                <div class="col-md-4">
                    <div class="card mb-2">
                        <div class="card-header">QR Booking</div>
                        <div class="card-body text-center">
                            <img src="<?= base_url('uploads/qrcode/' . $booking->qr_booking) ?>" class="img-fluid" style="max-width:220px">
                        </div>
                    </div>
                </div>
                <div class="col-8">
                <?php endif; ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">Timeline Riwayat</div>
                        <?php foreach ($riwayat_bayar as $r) : ?>
                            <div class="border-start border-3 ps-3 mb-3">
                                <div class="fw-bold"><?= badge_status_pembayaran($r->status_pembayaran) ?></div>
                                <small class="text-muted"><?= $r->created_at ?></small>
                                <div><?= $r->keterangan ?></div>
                            </div>
                        <?php endforeach; ?>
                        <div class="card-body">
                            <?php foreach ($riwayat as $r) : ?>
                                <div class="border-start border-3 ps-3 mb-3">
                                    <div class="fw-bold"><?= $r->status_booking ?: $r->status_pembayaran ?></div>
                                    <small class="text-muted"><?= $r->created_at ?></small>
                                    <div><?= $r->keterangan ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </div>