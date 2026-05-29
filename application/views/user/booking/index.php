<div class="mb-3">
    <form method="GET">
        <div class="row g-2">
            <div class="col-8">
                <input type="date" name="tanggal" class="form-control" value="<?= $tanggal ?>">
            </div>
            <div class="col-4 d-grid">
                <button class="btn btn-primary">Filter </button>
            </div>
        </div>
    </form>
</div>

<?php if ($this->session->flashdata('error')) : ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error') ?>
    </div>
<?php endif; ?>
<form action="<?= base_url('booking/proses') ?>" method="POST">
    <?php foreach ($jadwal as $nama_cabang => $lapangan) : ?>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <div class="fw-bold fs-6"><?= $nama_cabang ?></div>
            </div>
            <div class="card-body">
                <?php foreach ($lapangan as $nama_lapangan => $slots) : ?>
                    <div class="mb-4">
                        <div class="fw-semibold mb-2"><?= $nama_lapangan ?></div>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($slots as $slot) : ?>
                                <input
                                    type="checkbox"
                                    class="btn-check slot-checkbox"
                                    name="slot_id[]"
                                    value="<?= $slot->id ?>"
                                    id="slot<?= $slot->id ?>"
                                    autocomplete="off">
                                <label class="btn btn-outline-primary rounded-3" for="slot<?= $slot->id ?>">
                                    <?= substr($slot->jam_mulai, 0, 5) ?>-<?= substr($slot->jam_selesai, 0, 5) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (!empty($jadwal)) : ?>
        <div class="position-fixed bottom-0 start-0 end-0 bg-white border-top shadow-lg p-3"
            style="z-index:999; margin-bottom:70px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-bold" id="total-slot"> 0 Slot Dipilih</div>
                    <small class="text-muted" id="total-harga"> Rp 0</small>
                </div>
                <button type="submit" class="btn btn-primary"> Booking</button>
            </div>
        </div>
    <?php endif; ?>
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.slot-checkbox');
        const totalSlot = document.getElementById('total-slot');
        const totalHarga = document.getElementById('total-harga');

        function updateSummary() {
            let total = 0;
            let count = 0;
            checkboxes.forEach(function(item) {
                if (item.checked) {
                    total += 20000;
                    count++;
                }
            });
            totalSlot.innerHTML = count + ' Slot Dipilih';
            totalHarga.innerHTML = 'Rp ' + total.toLocaleString('id-ID');
        }
        checkboxes.forEach(function(item) {
            item.addEventListener('change', updateSummary);
        });
    });
</script>