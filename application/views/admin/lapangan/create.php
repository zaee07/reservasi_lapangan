<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <div class="card-header">
            <h4>Tambah Lapangan</h4>
        </div>

        <div class="card-body">

            <form
                action="<?= base_url('lapangan/store') ?>"
                method="POST"
                enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label">Kode Lapangan (gimmick)</label>
                    <input type="text" name="kode_lapangan" class="form-control">
                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Nama Lapangan
                    </label>

                    <input
                        type="text"
                        name="nama_lapangan"
                        class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Jenis Lantai
                    </label>

                    <select
                        name="jenis_lantai"
                        class="form-select">

                        <option value="vinyl">Vinyl</option>
                        <option value="karpet">Karpet</option>
                        <option value="semen">Semen</option>
                        <option value="rumput_sintetis">
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

                <div class="mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        name="status"
                        class="form-select">

                        <option value="aktif">Aktif</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="nonaktif">Nonaktif</option>

                    </select>

                </div>

                <button class="btn btn-primary">
                    Simpan
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