<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Lapangan</h4>
        </div>
        <form action="<?= base_url('lapangan/store') ?>" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <div class="mb-3">
                    <label>Nama Lapangan</label>
                    <input type="text" name="nama_lapangan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Jenis Lantai</label>
                    <select name="jenis_lantai" class="form-select">
                        <option value="Karpet">Karpet</option>
                        <option value="Vinyl">Vinyl</option>
                        <option value="Semen">Semen</option>
                        <option value="rumput_sintetis">Rumput Sintetis</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Jam Buka</label>
                        <input type="time" name="jam_buka" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Jam Tutup</label>
                        <input type="time" name="jam_tutup" class="form-control" required>
                    </div>
                </div>
                <hr>
                <label>Hari Operasional</label>
                <div class="row">
                    <?php
                    $hari = [
                        1 => 'Senin',
                        2 => 'Selasa',
                        3 => 'Rabu',
                        4 => 'Kamis',
                        5 => 'Jumat',
                        6 => 'Sabtu',
                        0 => 'Minggu'
                    ];
                    foreach ($hari as $key => $val):
                    ?>
                        <div class="col-md-3">
                            <div class="form-check #form-check-inline">
                                <input
                                    type="checkbox"
                                    name="hari_operasional[]"
                                    value="<?= $key ?>"
                                    class="form-check-input">
                                <label class="form-check-label"><?= $val ?></label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <hr>
                <div class="mb-3">
                    <label class="form-label"> Status </label>
                    <select name="status" class="form-select">
                        <option value="aktif">Aktif</option>
                        <option value="pemeliharaan">Maintenance</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label>Foto 1</label>
                        <input type="file" name="foto_1" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Foto 2</label>
                        <input type="file" name="foto_2" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Foto 3</label>
                        <input type="file" name="foto_3" class="form-control">
                    </div>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary">Simpan Lapangan</button>
                </div>
            </div>
        </form>
    </div>
</div>