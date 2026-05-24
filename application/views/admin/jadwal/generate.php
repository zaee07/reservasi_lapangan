<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header">
            <h4>Generate Jadwal Slot</h4>
        </div>

        <div class="card-body">

            <form action="<?= base_url('jadwal/store_generate') ?>" method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Lapangan
                    </label>

                    <select
                        name="lapangan_id"
                        class="form-select"
                        required>

                        <option value="">
                            -- Pilih Lapangan --
                        </option>

                        <?php foreach ($lapangan as $l) : ?>

                            <option value="<?= $l->id ?>">
                                <?= $l->nama_lapangan ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Tanggal
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        required>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Jam Buka
                        </label>

                        <input
                            type="time"
                            name="jam_buka"
                            class="form-control"
                            value="09:00"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Jam Tutup
                        </label>

                        <input
                            type="time"
                            name="jam_tutup"
                            class="form-control"
                            value="17:00"
                            required>

                    </div>

                </div>

                <button class="btn btn-primary">
                    Generate
                </button>

                <a
                    href="<?= base_url('jadwal') ?>"
                    class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>

    </div>

</div>