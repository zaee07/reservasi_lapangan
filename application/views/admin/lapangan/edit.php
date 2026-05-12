<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header">
            <h4>Edit Lapangan</h4>
        </div>

        <div class="card-body">

            <form
                action="<?= base_url('lapangan/update/' . $lapangan->id) ?>"
                method="POST"
                enctype="multipart/form-data">

                <div class="mb-3">

                    <label class="form-label">
                        Kode Lapangan
                    </label>

                    <input
                        type="text"
                        name="kode_lapangan"
                        class="form-control"
                        value="<?php //= $lapangan->kode_lapangan 
                                ?>">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Nama Lapangan
                    </label>

                    <input
                        type="text"
                        name="nama_lapangan"
                        class="form-control"
                        value="<?= $lapangan->nama_lapangan ?>">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Jenis Lantai
                    </label>

                    <select
                        name="jenis_lantai"
                        class="form-select">

                        <option
                            value="vinyl"
                            <?= $lapangan->jenis_lantai == 'vinyl' ? 'selected' : '' ?>>
                            Vinyl
                        </option>

                        <option
                            value="karpet"
                            <?= $lapangan->jenis_lantai == 'karpet' ? 'selected' : '' ?>>
                            Karpet
                        </option>

                        <option
                            value="semen"
                            <?= $lapangan->jenis_lantai == 'semen' ? 'selected' : '' ?>>
                            Semen
                        </option>

                        <option
                            value="rumput_sintetis"
                            <?= $lapangan->jenis_lantai == 'rumput_sintetis' ? 'selected' : '' ?>>
                            Rumput Sintetis
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Foto
                    </label>

                    <input
                        type="file"
                        name="foto"
                        class="form-control">

                </div>

                <?php if ($lapangan->foto) : ?>

                    <div class="mb-3">

                        <img
                            src="<?= base_url('uploads/lapangan/' . $lapangan->foto) ?>"
                            width="120"
                            class="rounded">

                    </div>

                <?php endif; ?>

                <div class="mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select">

                        <option
                            value="aktif"
                            <?= $lapangan->status == 'aktif' ? 'selected' : '' ?>>
                            Aktif
                        </option>

                        <option
                            value="maintenance"
                            <?= $lapangan->status == 'maintenance' ? 'selected' : '' ?>>
                            Maintenance
                        </option>

                        <option
                            value="nonaktif"
                            <?= $lapangan->status == 'nonaktif' ? 'selected' : '' ?>>
                            Nonaktif
                        </option>

                    </select>

                </div>

                <button class="btn btn-primary">
                    Update
                </button>

                <a
                    href="<?= base_url('lapangan') ?>"
                    class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>

    </div>

</div>