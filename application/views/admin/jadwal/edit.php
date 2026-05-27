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
                            value="available"
                            <?= $jadwal->status_slot == 'available' ? 'selected' : '' ?>>
                            Tersedia
                        </option>

                        <option
                            value="booked"
                            <?= $jadwal->status_slot == 'booked' ? 'selected' : '' ?>>
                            Booking
                        </option>

                        <option
                            value="closed/maintenance"
                            <?= $jadwal->status_slot == 'closed/maintenance' ? 'selected' : '' ?>>
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