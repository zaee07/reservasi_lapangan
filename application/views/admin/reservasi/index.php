<div class="card">
    <div class="card-body">

        <form method="GET" class="mb-4">

            <div class="row">

                <div class="col-md-4">

                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        value="<?= $tanggal ?>">

                </div>

                <div class="col-md-4">

                    <select
                        name="status"
                        class="form-select">

                        <option value="">
                            Semua Status
                        </option>

                        <option
                            value="pending"
                            <?= $status == 'pending' ? 'selected' : '' ?>>
                            Pending
                        </option>

                        <option
                            value="confirmed"
                            <?= $status == 'confirmed' ? 'selected' : '' ?>>
                            Confirmed
                        </option>

                        <option
                            value="checked_in"
                            <?= $status == 'checked_in' ? 'selected' : '' ?>>
                            Checked In
                        </option>

                        <option
                            value="completed"
                            <?= $status == 'completed' ? 'selected' : '' ?>>
                            Completed
                        </option>

                    </select>

                </div>

                <div class="col-md-4 d-grid">

                    <button class="btn btn-primary">
                        Filter
                    </button>

                </div>

            </div>

        </form>

        <div class="table-responsive">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Kode</th>
                        <th>Lapangan</th>
                        <th>Jam</th>
                        <th>Pemesan</th>
                        <th>Booking</th>
                        <th>Pembayaran</th>
                        <th>Total</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if (empty($reservasi)) : ?>

                        <tr>

                            <td colspan="8" class="text-center">
                                Tidak ada reservasi
                            </td>

                        </tr>

                    <?php endif; ?>

                    <?php foreach ($reservasi as $r) : ?>

                        <tr>

                            <td>
                                <?= $r->kode_booking ?>
                            </td>

                            <td>
                                <?= $r->nama_lapangan ?>
                            </td>

                            <td>

                                <?= substr($r->jam_mulai, 0, 5) ?>

                                -

                                <?= substr($r->jam_selesai, 0, 5) ?>

                            </td>

                            <td>

                                <?= $r->nama_pemesan ?>

                            </td>

                            <td>

                                <?= badge_status_booking(
                                    $r->status_booking
                                ) ?>

                            </td>

                            <td>

                                <?= badge_status_pembayaran(
                                    $r->status_pembayaran
                                ) ?>

                            </td>

                            <td>

                                Rp <?= number_format(
                                        $r->total_bayar,
                                        0,
                                        ',',
                                        '.'
                                    ) ?>

                            </td>

                            <td>

                                <a
                                    href="<?= base_url(
                                                'admin/reservasi/detail/' . $r->id
                                            ) ?>"
                                    class="btn btn-sm btn-primary">
                                    Detail
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>
</div>