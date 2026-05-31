<div class="card">
    <div class="card-body">
        <h5 class="mb-4">
            <?= $pembayaran->invoice_no ?>
        </h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <small class="text-muted">
                    Booking
                </small>
                <div class="fw-bold">
                    <?= $pembayaran->kode_booking ?>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <small class="text-muted">
                    Cabang
                </small>
                <div class="fw-bold">
                    <?= $pembayaran->nama_cabang ?>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <small class="text-muted">
                    Pemesan
                </small>
                <div class="fw-bold">
                    <?= $pembayaran->nama_pemesan ?>
                </div>

            </div>

            <div class="col-md-6 mb-3">

                <small class="text-muted">
                    No HP
                </small>

                <div class="fw-bold">
                    <?= $pembayaran->no_hp_pemesan ?>
                </div>

            </div>

            <div class="col-md-6 mb-3">

                <small class="text-muted">
                    Metode Bayar
                </small>

                <div class="fw-bold">
                    <?= strtoupper(
                        $pembayaran->metode_bayar
                    ) ?>
                </div>

            </div>

            <div class="col-md-6 mb-3">

                <small class="text-muted">
                    Status Pembayaran
                </small>

                <div>

                    <?= badge_status_pembayaran(
                        $pembayaran->status_pembayaran
                    ) ?>

                </div>

            </div>

            <div class="col-md-6 mb-3">

                <small class="text-muted">
                    Tanggal Main
                </small>

                <div class="fw-bold">

                    <?= $pembayaran->tanggal_main ?>

                </div>

            </div>

            <div class="col-md-6 mb-3">

                <small class="text-muted">
                    Jam Main
                </small>

                <div class="fw-bold">

                    <?= substr(
                        $pembayaran->jam_mulai,
                        0,
                        5
                    ) ?>

                    -

                    <?= substr(
                        $pembayaran->jam_selesai,
                        0,
                        5
                    ) ?>

                </div>

            </div>

        </div>

        <hr>

        <h6 class="mb-3">
            Riwayat Status Pembayaran
        </h6>

        <?php foreach ($riwayat as $r) : ?>

            <div class="border rounded p-3 mb-2">

                <div class="d-flex justify-content-between">

                    <div>

                        <?= badge_status_pembayaran(
                            $r->status_pembayaran
                        ) ?>

                    </div>

                    <small class="text-muted">

                        <?= $r->created_at ?>

                    </small>

                </div>

                <?php if ($r->keterangan) : ?>

                    <div class="mt-2">

                        <?= $r->keterangan ?>

                    </div>

                <?php endif; ?>

                <small class="text-muted">
                    Oleh:
                    <?php //$r->nama ?: 'System' //= $r->nama ?: 'System' 
                    ?>
                </small>

            </div>

        <?php endforeach; ?>

    </div>
    ```

</div>