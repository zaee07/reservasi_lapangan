<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>
        <?= isset($title) ? $title : 'GOR Harmoni' ?>
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

        footer {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <?php $this->load->view('landing/partials/navbar'); ?>
    <?php $this->load->view('landing/partials/hero'); ?>
    <!-- Statistik -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <h2 class="fw-bold text-primary"><?= $total_cabang ?></h2>
                    <p class="mb-0">Cabang</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <h2 class="fw-bold text-primary"><?= $total_lapangan ?></h2>
                    <p class="mb-0">Lapangan</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <h2 class="fw-bold text-primary"><?= $total_member ?></h2>
                    <p class="mb-0">Member</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <h2 class="fw-bold text-primary"><?= $total_booking ?></h2>
                    <p class="mb-0">Booking</p>
                </div>
            </div>
        </div>
    </section>
    <?php $this->load->view('landing/partials/fitur'); ?>
    <?php $this->load->view('landing/partials/lapangan'); ?>
    <?php $this->load->view('landing/partials/galeri'); ?>
    <?php $this->load->view('landing/partials/cara_booking'); ?>
    <?php $this->load->view('landing/partials/cta'); ?>
    <?php $this->load->view('landing/partials/footer'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>