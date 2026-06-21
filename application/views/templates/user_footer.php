</div>
<div class="bottom-navbar">
    <a href="<?= base_url('home') ?>" class="nav-item-mobile d-flex flex-column align-items-center justify-content-center <?= ($active == 'home') ? 'active' : '' ?>">
        <i class="bi bi-house fs-5"></i>
        <span>Home</span>
    </a>
    <a href="<?= base_url('jadwal_lapangan') ?>" class="nav-item-mobile d-flex flex-column align-items-center justify-content-center <?= ($active == 'jadwal') ? 'active' : '' ?>">
        <i class="bi bi-calendar fs-5"></i>
        <span>Jadwal</span>
    </a>
    <a href="<?= base_url('booking') ?>" class="nav-item-mobile d-flex flex-column align-items-center justify-content-center <?= ($active == 'booking') ? 'active' : '' ?>">
        <i class="bi bi-receipt fs-5"></i>
        <span>Booking</span>
    </a>
    <a href="<?= base_url('riwayat_booking') ?>" class="nav-item-mobile d-flex flex-column align-items-center justify-content-center <?= ($active == 'riwayat_booking') ? 'active' : '' ?>">
        <i class="bi bi-clock-history fs-5"></i>
        <span>Riwayat</span>
    </a>
    <a href="<?= base_url('profile') ?>" class="nav-item-mobile d-flex flex-column align-items-center justify-content-center <?= ($active == 'profile') ? 'active' : '' ?>">
        <i class="bi bi-person fs-5"></i>
        <span>Profil</span>
    </a>
</div>
<script>
    document.querySelectorAll('.toggle-password').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bx-hide');
                icon.classList.add('bx-show');
            } else {
                input.type = 'password';
                icon.classList.remove('bx-show');
                icon.classList.add('bx-hide');
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>