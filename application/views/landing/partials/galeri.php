<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Galeri Lapangan</h2>
        <div class="row">
            <?php foreach ($lapangan as $l): ?>
                <?php if ($l->foto_1): ?>
                    <div class="col-md-4 mb-3">
                        <img src="<?= base_url('uploads/lapangan/' . $l->foto_1) ?>" class="img-fluid rounded">
                    </div>
                <?php endif; ?>
                <?php if ($l->foto_2): ?>
                    <div class="col-md-4 mb-3">
                        <img src="<?= base_url('uploads/lapangan/' . $l->foto_2) ?>" class="img-fluid rounded">
                    </div>
                <?php endif; ?>
                <?php if ($l->foto_3): ?>
                    <div class="col-md-4 mb-3">
                        <img src="<?= base_url('uploads/lapangan/' . $l->foto_3) ?>" class="img-fluid rounded">
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>