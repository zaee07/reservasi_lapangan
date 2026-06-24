<section id="lapangan" class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Lapangan Kami</h2>
        <div class="row">
            <?php foreach ($lapangan as $l): ?>
                <div class="col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= base_url('uploads/lapangan/' . $l->foto_1) ?>" class="card-img-top">
                        <div class="card-body">
                            <h5><?= $l->nama_lapangan ?></h5>
                            <p class="mb-1"><?= ucfirst($l->jenis_lantai) ?></p>
                            <small class="text-muted"><?= substr($l->jam_buka, 0, 5) ?>-<?= substr($l->jam_tutup, 0, 5) ?> </small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>