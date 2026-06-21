<div class="mb-3">
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h5 class="mb-1 fw-bold">Hi, <?= isset($user['nama']) ? $user['nama'] : 'User' ?> 👋</h5>
            <small class="text-muted">Selamat datang kembali!</small>
        </div>
        <a href="<?= base_url('notifikasi') ?>" class="text-primary fs-5">
            <i class="bi bi-bell"></i>
        </a>
    </div>
</div>

<!-- Banner Promo -->
<div class="card card-custom mb-4 overflow-hidden" style="background: linear-gradient(135deg, #0d6efd, #3b82f6); color: #fff;">
    <div class="card-body p-3">
        <div class="row align-items-center">
            <div class="col-7">
                <h5 class="fw-bold mb-2">Main Seru, Harga Hemat!</h5>
                <p class="mb-2 small">Diskon 20% setiap hari pukul 10.00 - 14.00</p>
                <a href="<?= base_url('jadwal_lapangan') ?>" class="btn btn-light btn-sm rounded-pill px-3">
                    Booking Sekarang
                </a>
            </div>
            <div class="col-5 text-end">
                <img src="https://cdn-icons-png.flaticon.com/512/857/857455.png" alt="Badminton" class="img-fluid" style="max-height: 90px; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<!-- Quick Action -->
<div class="mb-4">
    <h6 class="fw-bold mb-3">Quick Action</h6>
    <div class="row g-3">
        <div class="col-6">
            <a href="<?= base_url('booking') ?>" class="text-decoration-none">
                <div class="card card-custom text-center h-100">
                    <div class="card-body py-3">
                        <div class="mb-2">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                style="width: 44px; height: 44px; background: rgba(13, 110, 253, 0.12); color: #0d6efd;">
                                <i class="bi bi-calendar-check fs-5"></i>
                            </span>
                        </div>
                        <div class="fw-semibold text-dark">Booking Sekarang</div>
                        <small class="text-muted">Pilih jadwal main</small>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-6">
            <a href="<?= base_url('riwayat_booking') ?>" class="text-decoration-none">
                <div class="card card-custom text-center h-100">
                    <div class="card-body py-3">
                        <div class="mb-2">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                style="width: 44px; height: 44px; background: rgba(13, 110, 253, 0.12); color: #0d6efd;">
                                <i class="bi bi-receipt-cutoff fs-5"></i>
                            </span>
                        </div>
                        <div class="fw-semibold text-dark">Booking Saya</div>
                        <small class="text-muted">Cek status booking</small>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Ringkasan -->
<div class="row g-3 mb-4">
    <div class="col-6">
        <div class="card card-custom h-100">
            <div class="card-body py-3">
                <small class="text-muted d-block mb-1">Booking Aktif</small>
                <h5 class="fw-bold mb-0"><?= isset($booking_aktif) ? $booking_aktif : 0 ?></h5>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card card-custom h-100">
            <div class="card-body py-3">
                <small class="text-muted d-block mb-1">Pending Bayar</small>
                <h5 class="fw-bold mb-0 text-warning"><?= isset($booking_pending) ? $booking_pending : 0 ?></h5>
            </div>
        </div>
    </div>
</div>

<!-- Lapangan Tersedia -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h6 class="fw-bold mb-0">Lapangan Tersedia</h6>
    <a href="<?= base_url('jadwal_lapangan') ?>" class="small text-primary text-decoration-none">Lihat semua</a>
</div>

<?php
$lapangan_list = isset($lapangan) && is_array($lapangan) && count($lapangan) > 0
    ? $lapangan
    : [
        [
            'id' => 1,
            'nama_lapangan' => 'Lapangan 1',
            'jenis_lantai' => 'Vinyl',
            'harga' => 50000,
            'foto' => null,
            'status' => 'Tersedia'
        ],
        [
            'id' => 2,
            'nama_lapangan' => 'Lapangan 2',
            'jenis_lantai' => 'Karpet',
            'harga' => 60000,
            'foto' => null,
            'status' => 'Tersedia'
        ]
    ];
?>

<?php foreach ($lapangan_list as $item): ?>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="fw-semibold">Lapangan 1</h5>
            <p class="mb-1 text-muted">Karpet</p>
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-primary fw-bold">Rp50.000</span>
                <a href="#" class="btn btn-sm btn-primary">Pesan</a>
            </div>
        </div>
    </div>
    <div class="card card-custom mb-3">
        <div class="card-body p-3">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <?php if (!empty($item['foto'])): ?>
                        <img src="<?= base_url('uploads/lapangan/' . $item['foto']) ?>"
                            alt="<?= $item['nama_lapangan'] ?>"
                            style="width: 64px; height: 64px; object-fit: cover; border-radius: 12px;">
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center"
                            style="width: 64px; height: 64px; border-radius: 12px; background: rgba(13, 110, 253, 0.12); color: #0d6efd;">
                            <i class="bi bi-grid-1x2-fill fs-4"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="flex-grow-1">
                    <h6 class="mb-1 fw-bold"><?= $item['nama_lapangan'] ?></h6>
                    <div class="small text-muted mb-1"><?= isset($item['jenis_lantai']) ? $item['jenis_lantai'] : '-' ?></div>
                    <div class="small fw-semibold text-primary">
                        Rp<?= number_format($item['harga'], 0, ',', '.') ?>/jam
                    </div>
                </div>

                <div class="text-end">
                    <span class="badge rounded-pill text-bg-light border mb-2">
                        <?= isset($item['status']) ? $item['status'] : 'Tersedia' ?>
                    </span>
                    <br>
                    <a href="<?= base_url('jadwal?lapangan=' . $item['id']) ?>" class="btn btn-primary btn-sm rounded-pill px-3">
                        Pesan
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Informasi -->
<div class="card card-custom mt-4 border-0" style="background: #eff6ff;">
    <div class="card-body p-3">
        <div class="d-flex align-items-start">
            <div class="me-2 text-primary">
                <i class="bi bi-info-circle-fill"></i>
            </div>
            <div>
                <div class="fw-semibold mb-1">Informasi Booking</div>
                <small class="text-muted d-block">
                    Booking yang sudah berhasil dibayar tidak dapat dibatalkan.
                </small>
                <small class="text-muted d-block">
                    Datang minimal 10 menit sebelum jadwal bermain.
                </small>
            </div>
        </div>
    </div>
</div>
<?php if ($booking_terdekat) : ?>
    <div class="card card-custom mb-4">
        <div class="card-body">

            <small class="text-muted">
                Booking Terdekat
            </small>

            <h6 class="fw-bold mt-2">
                <?= $booking_terdekat->nama_lapangan ?>
            </h6>

            <div>
                <?= date('d M Y', strtotime($booking_terdekat->tanggal_main)) ?>
            </div>

            <div>
                <?= substr($booking_terdekat->jam_mulai, 0, 5) ?>
                -
                <?= substr($booking_terdekat->jam_selesai, 0, 5) ?>
            </div>

            <a
                href="<?= base_url('booking/detail/' . $booking_terdekat->id) ?>"
                class="btn btn-primary btn-sm mt-3">

                Detail Booking

            </a>

        </div>
    </div>
<?php endif; ?>