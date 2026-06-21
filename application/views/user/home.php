<div class="mb-3">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h5 class="mb-1 fw-bold">Hi, <?= $user['nama'] ?> 👋</h5>
            <small class="text-muted">Selamat datang kembali!</small>
        </div>
        <a href="javascript:void(0)" class="text-primary fs-5">
            <i class="bi bi-bell"></i>
        </a>
    </div>
</div>
<div class="card card-custom mb-4 overflow-hidden"
    style="background: linear-gradient(135deg,#0d6efd,#3b82f6);color:#fff;">
    <div class="card-body p-3">
        <div class="row align-items-center">
            <div class="col-7">
                <h5 class="fw-bold  mb-2">Main Seru, Harga Hemat!</h5>
                <p class="mb-2 small">Diskon 20% setiap hari hanya untuk member</p>
                <a href="<?= base_url('jadwal_lapangan') ?>"
                    class="btn btn-light rounded-pill px-4 py-2 fw-semibold shadow-sm">
                    <i class="bi bi-calendar-check me-1"></i>
                    Mulai Booking
                </a>
            </div>
            <div class="col-5 text-end">
                <img src="<?= base_url('assets/img/badminton-banner.png') ?>" class="img-fluid" style="max-height:90px;">
            </div>
        </div>
    </div>
</div>
<div class="mb-4">
    <h6 class="fw-bold mb-3">Quick Action</h6>
    <div class="row g-3">
        <div class="col-6">
            <a href="<?= base_url('booking') ?>" class="text-decoration-none">
                <div class="card card-custom text-center h-100">
                    <div class="card-body py-3">
                        <div class="mb-2">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width:44px;height:44px;background:rgba(13,110,253,.12);color:#0d6efd;">
                                <i class="bi bi-calendar-check fs-5"></i>
                            </span>
                        </div>
                        <div class="fw-semibold text-dark">Booking</div>
                        <small class="text-muted">Pilih Jadwal Main</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6">
            <a href="<?= base_url('riwayat_booking') ?>"
                class="text-decoration-none">
                <div class="card card-custom text-center h-100">
                    <div class="card-body py-3">
                        <div class="mb-2">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width:44px;height:44px;background:rgba(13,110,253,.12);color:#0d6efd;">
                                <i class="bi bi-receipt-cutoff fs-5"></i>
                            </span>
                        </div>
                        <div class="fw-semibold text-dark">Booking Saya</div>
                        <small class="text-muted">Lihat Booking</small>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="row g-3 mb-4">
    <div class="col-6">
        <div class="card card-custom">
            <div class="card-body py-3">
                <small class="text-muted">Booking Aktif</small>
                <h4 class="fw-bold mb-0"><?= $booking_aktif ?></h4>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card card-custom">
            <div class="card-body py-3">
                <small class="text-muted">Pending Bayar</small>
                <h4 class="fw-bold text-warning mb-0"><?= $booking_pending ?></h4>
            </div>
        </div>
    </div>
</div>
<div class="card card-custom mb-4 border-0"
    style="background:#eff6ff;">
    <div class="card-body p-3">
        <div class="d-flex">
            <div class="me-2 text-primary">
                <i class="bi bi-info-circle-fill"></i>
            </div>
            <div>
                <div class="fw-semibold mb-1">Informasi Booking</div>
                <small class="text-muted d-block">Booking yang sudah dibayar tidak dapat dibatalkan.</small>
                <small class="text-muted d-block">Datang minimal 10 menit sebelum jadwal bermain.</small>
            </div>
        </div>
    </div>
</div>
<?php if ($booking_terdekat) : ?>
    <div class="card card-custom mb-4">
        <div class="card-body">
            <small class="text-muted"> Booking Terdekat </small>
            <h6 class="fw-bold mt-2"> <?= $booking_terdekat->nama_lapangan ?> </h6>
            <div> <?= date('d M Y', strtotime($booking_terdekat->tanggal_main)) ?> </div>
            <div>
                <?= substr($booking_terdekat->jam_mulai, 0, 5) ?>
                -
                <?= substr($booking_terdekat->jam_selesai, 0, 5) ?>
            </div>
            <a href="<?= base_url('riwayat_booking/detail/' . $booking_terdekat->id) ?>" class="btn btn-primary rounded-pill px-4 mt-3">
                <i class="bi bi-qr-code me-1"></i>
            </a>
        </div>
    </div>
<?php endif; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="fw-bold mb-0">Lapangan Tersedia</h6>
    <a href="<?= base_url('jadwal_lapangan') ?>" class="small text-primary text-decoration-none">Lihat Semua</a>
</div>
<?php foreach ($lapangan as $item): ?>
    <div class="card card-custom mb-3">
        <div class="card-body p-3">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <?php if (!empty($item['foto'])) : ?>
                        <img src="<?= base_url('uploads/lapangan/' . $item['foto']) ?>" style="width:64px;height:64px;border-radius:12px;object-fit:cover;">
                    <?php else : ?>
                        <div class="d-flex align-items-center justify-content-center" style="width:64px;height:64px;border-radius:12px;background:rgba(13,110,253,.12);color:#0d6efd;">
                            <i class="bi bi-grid-1x2-fill fs-4"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-1 fw-bold"><?= $item['nama_lapangan'] ?></h6>
                    <div class="small text-muted"><?= $item['jenis_lantai'] ?? '-' ?></div>
                    <div class="small fw-semibold text-primary">Rp<?= number_format($item['harga'], 0, ',', '.') ?>/jam</div>
                </div>
                <a href="<?= base_url('jadwal_lapangan') ?>"
                    class="btn btn-outline-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-arrow-right-circle me-1"></i>
                    Booking
                    <i class="bi bi-chevron-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
<?php endforeach; ?>