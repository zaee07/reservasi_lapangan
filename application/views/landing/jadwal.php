<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title> <?= isset($title) ? $title : 'GOR Harmoni' ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        .hero-section {
            min-height: 80vh;
            display: flex;
            align-items: center;
        }

        .section-title {
            font-weight: 700;
            margin-bottom: 50px;
        }

        .card-hover {
            transition: .3s;
        }

        .card-hover:hover {
            transform: translateY(-5px);
        }

        .gallery-img {
            height: 250px;
            width: 100%;
            object-fit: cover;
        }

        .card-cabang {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
        }

        footer {
            margin-top: 0;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url() ?>">
                <img src="<?= base_url('assets/img/1.png') ?>" alt="logo" width="50">
                GOR Harmoni</a>
            <button
                class="navbar-toggler"
                data-bs-toggle="collapse"
                data-bs-target="#navbarLanding">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarLanding">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="<?= base_url('#fitur') ?>" class="nav-link">Fitur</a></li>
                    <li class="nav-item"><a href="<?= base_url('#lapangan') ?>" class="nav-link">Lapangan</a></li>
                    <li class="nav-item"><a href="<?= base_url('#cara-booking') ?>" class="nav-link">Cara Booking</a></li>
                    <li class="nav-item"><a href="#jadwal" class="nav-link">Jadwal</a></li>
                </ul>
                <a href="<?= base_url('auth') ?>" class="btn btn-primary ms-3">Login</a>
            </div>
        </div>
    </nav>
    <?php $this->load->view('landing/partials/hero'); ?>
    <section id="jadwal" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center fw-bold mb-4">Cek Jadwal Lapangan</h2>
            <form method="get" class="row g-2 mb-5">
                <div class="col-md-4">
                    <input type="date" name="tanggal" value="<?= $tanggal ?>" class="form-control">
                </div>
                <div class="col-md-4">
                    <select name="cabang" class="form-select">
                        <option value="">Semua Cabang</option>
                        <?php foreach ($cabangs as $c): ?>
                            <option value="<?= $c->kode_cabang ?>" <?= $kode_cabang == $c->kode_cabang ? 'selected' : '' ?>>
                                <?= $c->nama_cabang ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary">Cek Jadwal</button>
                </div>
            </form>
            <?php if (empty($jadwal)) : ?>
                <div class="alert alert-warning"> Jadwal belum tersedia </div>
            <?php endif; ?>
            <?php foreach ($jadwal as $nama_cabang => $lapangans): ?>
                <div class="card card-cabang shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><?= $nama_cabang ?></h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($lapangans as $nama_lapangan => $slots): ?>
                            <div class="mb-4">
                                <h6 class="fw-bold"><?= $nama_lapangan ?></h6>
                                <?php foreach ($slots as $slot): ?>
                                    <?php
                                    $class = 'bg-secondary';
                                    if ($slot->status_slot == STATUS_SLOT_AVAILABLE) {
                                        $class = 'bg-success';
                                    } elseif ($slot->status_slot == STATUS_SLOT_BOOKED) {
                                        $class = 'bg-danger';
                                    }
                                    ?>
                                    <span class="slot-badge badge <?= $class ?> me-1 mb-2 p-2"> <?= substr($slot->jam_mulai, 0, 5) ?> </span>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="mb-4">
                <span class="badge bg-success">Tersedia</span>
                <span class="badge bg-danger">Terbooking</span>
                <span class="badge bg-secondary">Ditutup</span>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>