<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header">
            <h4>Edit Cabang</h4>
        </div>

        <div class="card-body">

            <form
                action="<?= base_url('cabang/update/' . $cabang->id) ?>"
                method="POST"
                enctype="multipart/form-data">

                <div class="mb-3">
                    <label>Kode Cabang</label>

                    <input
                        type="text"
                        class="form-control"
                        value="<?= $cabang->kode_cabang ?>"
                        disabled>
                </div>

                <div class="mb-3">
                    <label>Nama Cabang</label>

                    <input
                        type="text"
                        name="nama_cabang"
                        class="form-control"
                        value="<?= $cabang->nama_cabang ?>">
                </div>

                <div class="mb-3">
                    <label>Alamat</label>

                    <textarea
                        name="alamat"
                        class="form-control"><?= $cabang->alamat ?></textarea>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp</label>

                    <input
                        type="text"
                        name="no_wa"
                        class="form-control"
                        value="<?= $cabang->no_wa ?>">
                </div>

                <div class="mb-3">
                    <label>Logo</label>

                    <input
                        type="file"
                        name="logo"
                        class="form-control">

                    <br>

                    <?php if ($cabang->logo) : ?>

                        <img
                            src="<?= base_url('uploads/logo/' . $cabang->logo) ?>"
                            width="100">

                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label>Status</label>

                    <select
                        name="status"
                        class="form-select">
                        <option
                            value="aktif"
                            <?= $cabang->status == 'aktif' ? 'selected' : '' ?>>
                            Aktif
                        </option>

                        <option
                            value="nonaktif"
                            <?= $cabang->status == 'nonaktif' ? 'selected' : '' ?>>
                            Nonaktif
                        </option>
                    </select>
                </div>

                <button class="btn btn-primary">
                    Update
                </button>

                <a
                    href="<?= base_url('cabang') ?>"
                    class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>

    </div>

</div>