<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Detail Riwayat</h4>
    </div>
    <div class="row">
        <div class="col-12 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1"><?= $booking->kode_booking ?></h4>
                            <small class="text-muted"><?= ucfirst($booking->tipe_booking) ?></small>
                        </div>
                        <div><?= badge_status_booking($booking->status_booking) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-2">
                <div class="card-header">
                    <h5 class="mb-0">Detail Booking</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Cabang</small>
                            <div><?= $booking->nama_cabang ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Lapangan</small>
                            <div><?= $booking->nama_lapangan ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Pemesan</small>
                            <div><?= $booking->nama_pemesan ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">No HP</small>
                            <div><?= $booking->no_hp_pemesan ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Tanggal Main</small>
                            <div><?= date('d M Y', strtotime($booking->tanggal_main)) ?></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Durasi</small>
                            <div><?= $booking->durasi_menit ?> Menit</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-2">
                <div class="card-header">Pembayaran</div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Invoice</small>
                        <div><?= $booking->invoice_no ?></div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Status</small>
                        <div><?= badge_status_pembayaran($booking->status_pembayaran) ?></div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Total Bayar</small>
                        <h4 class="text-primary mb-0">Rp <?= number_format($booking->total_bayar, 0, ',', '.') ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card mb-2">
                <div class="card-header">Slot Booking
                </div>
                <div class="card-body">
                    <?php foreach ($slots as $slot) : ?>
                        <span class="badge bg-label-primary me-2 mb-2">
                            <?= substr($slot->jam_mulai, 0, 5) ?>
                            -
                            <?= substr($slot->jam_selesai, 0, 5) ?>
                        </span>
                    <?php endforeach; ?>
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