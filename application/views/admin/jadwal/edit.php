<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header">
            <h4>Edit Status Jadwal</h4>
        </div>

        <div class="card-body">

            <form
                action="<?= base_url('jadwal/update/' . $jadwal->id) ?>"
                method="POST">

                <div class="mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select">

                        <option
                            value="tersedia"
                            <?= $jadwal->status == 'tersedia' ? 'selected' : '' ?>>
                            Tersedia
                        </option>

                        <option
                            value="maintenance"
                            <?= $jadwal->status == 'maintenance' ? 'selected' : '' ?>>
                            Maintenance
                        </option>

                        <option
                            value="tutup"
                            <?= $jadwal->status == 'tutup' ? 'selected' : '' ?>>
                            Tutup
                        </option>

                    </select>

                </div>

                <button class="btn btn-primary">
                    Update
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