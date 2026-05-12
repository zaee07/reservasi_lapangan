<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header">
            <h4>Tambah Cabang</h4>
        </div>

        <div class="card-body">

            <form
                action="<?= base_url('cabang/store') ?>"
                method="POST"
                enctype="multipart/form-data">

                <div class="mb-3">
                    <label>Kode Cabang</label>

                    <input
                        type="text"
                        name="kode_cabang"
                        class="form-control">

                    <?= form_error('kode_cabang') ?>
                </div>

                <div class="mb-3">
                    <label>Nama Cabang</label>

                    <input
                        type="text"
                        name="nama_cabang"
                        class="form-control">

                    <?= form_error('nama_cabang') ?>
                </div>

                <div class="mb-3">
                    <label>Alamat</label>

                    <textarea
                        name="alamat"
                        class="form-control"></textarea>

                    <?= form_error('alamat') ?>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp</label>

                    <input
                        type="text"
                        name="no_wa"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label>Logo</label>

                    <input
                        type="file"
                        name="logo"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label>Status</label>

                    <select
                        name="status"
                        class="form-select">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

                <button class="btn btn-primary">
                    Simpan
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