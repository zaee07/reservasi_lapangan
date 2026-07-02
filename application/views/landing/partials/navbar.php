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
                <li class="nav-item"><a href="#fitur" class="nav-link">Fitur</a></li>
                <li class="nav-item"><a href="#lapangan" class="nav-link">Lapangan</a></li>
                <li class="nav-item"><a href="#cara-booking" class="nav-link">Cara Booking</a></li>
                <li class="nav-item"><a href="<?= base_url('jadwal_cek') ?>" class="nav-link">Jadwal</a></li>
            </ul>
            <a href="<?= base_url('auth') ?>" class="btn btn-primary ms-3">Login</a>
        </div>
    </div>
</nav>