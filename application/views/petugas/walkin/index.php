<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="fw-bold">Booking Walkin</h4>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('petugas/walkin/simpan') ?>" method="post">
                <div class="mb-3">
                    <label>Tipe Pemesan </label>
                    <select id="tipe_pemesan" name="tipe_pemesan" class="form-control">
                        <option value="member">Member</option>
                        <option value="non_member">Non Member</option>
                    </select>
                </div>
                <div id="non-member-section">
                    <div class="mb-3">
                        <label>Nama Pemesan</label>
                        <input type="text" name="nama_pemesan" class="form-control" placeholder="Masukkan nama pemesan">
                    </div>

                    <div class="mb-3">
                        <label>No HP</label>
                        <input type="text" name="no_hp_pemesan" class="form-control" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
                <div id="member-section">
                    <select name="user_id" id="member-select" class="form-select">
                    </select>
                </div>
                <?php foreach ($slot_tersedia as $cabang => $lapangans): ?>
                    <h5><?= $cabang ?></h5>
                    <?php foreach ($lapangans as $lapangan => $slots): ?>
                        <div class="card mb-3">
                            <div class="card-header"><?= $lapangan ?></div>
                            <div class="card-body">
                                <?php foreach ($slots as $slot): ?>
                                    <div class="form-check">
                                        <input type="checkbox" name="slot_ids[]" class="form-check-input slot-checkbox" id="slot<?= $slot->id ?>" value="<?= $slot->id ?>" class="form-check-input">
                                        <label class="form-check-label">
                                            <?= substr($slot->jam_mulai, 0, 5) ?> - <?= substr($slot->jam_selesai, 0, 5) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h6>Ringkasan Booking</h6>
                        <div class="d-flex justify-content-between">
                            <span>Jumlah Slot</span>
                            <strong id="jumlah-slot">0</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Durasi</span>
                            <strong id="durasi-jam">0 Jam</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Harga / Jam</span>
                            <strong id="harga-perjam">Rp 20.000</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Total Bayar</span>
                            <strong class="text-primary" id="total-bayar">
                                Rp 0
                            </strong>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary"> Simpan Walk In </button>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#member-select').select2({
            placeholder: 'Cari Member',
            minimumInputLength: 2,
            ajax: {
                url: "<?= base_url('petugas/walkin/search_member') ?>",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    });

    function updateSummary() {
        const tipe = document.getElementById('tipe_pemesan').value;
        const hargaPerJam = tipe === 'member' ? 20000 : 25000;
        const jumlahSlot = document.querySelectorAll('.slot-checkbox:checked').length;
        const total = jumlahSlot * hargaPerJam;
        document.getElementById('jumlah-slot').innerText = jumlahSlot;
        document.getElementById('durasi-jam').innerText = jumlahSlot + ' Jam';
        document.getElementById('harga-perjam').innerText = 'Rp ' + hargaPerJam.toLocaleString('id-ID');
        document.getElementById('total-bayar').innerText = 'Rp ' + total.toLocaleString('id-ID');
    }
    document.querySelectorAll('.slot-checkbox').forEach(function(cb) {
        cb.addEventListener('change', updateSummary);
    });
    document.getElementById('tipe_pemesan').addEventListener('change', updateSummary);
    updateSummary();

    const tipe = document.getElementById('tipe_pemesan');
    const memberSection = document.getElementById('member-section');
    const nonMemberSection = document.getElementById('non-member-section');

    function togglePemesan() {
        if (tipe.value === 'member') {
            memberSection.style.display = 'block';
            nonMemberSection.style.display = 'none';
        } else {
            memberSection.style.display = 'none';
            nonMemberSection.style.display = 'block';
        }
    }
    tipe.addEventListener('change', togglePemesan);
    togglePemesan();
</script>