<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Riwayat Booking</h4>
    </div>
    <div class="card">
        <div class="card-body">
            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="date" name="tanggal" class="form-control" value="<?= $tanggal ?>">
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-select">
                            <option value=""> Semua Status </option>
                            <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>> Pending </option>
                            <option value="confirmed" <?= $status == 'confirmed' ? 'selected' : '' ?>> Confirmed </option>
                            <option value="checked_in" <?= $status == 'checked_in' ? 'selected' : '' ?>> Checked In </option>
                            <option value="completed" <?= $status == 'completed' ? 'selected' : '' ?>> Completed </option>
                        </select>
                    </div>
                    <div class="col-md-4 d-grid"><button class="btn btn-primary"> Filter</button></div>
                </div>
            </form>
            <div class="table-responsive">
                <table id="table-booking" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Lapangan</th>
                            <th>Jam</th>
                            <th>Pemesan</th>
                            <th>Booking</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($reservasi)) : ?>
                            <?php foreach ($reservasi as $r) : ?>
                                <tr>
                                    <td><?= $r->kode_booking ?></td>
                                    <td><?= $r->nama_lapangan ?></td>
                                    <td>
                                        <?= substr($r->jam_mulai, 0, 5) ?>
                                        -
                                        <?= substr($r->jam_selesai, 0, 5) ?>
                                    </td>
                                    <td><?= $r->nama_pemesan ?></td>
                                    <td><?= badge_status_booking($r->status_booking) ?></td>
                                    <td>
                                        Rp <?= number_format($r->total_bayar, 0, ',', '.') ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/transaksi/detail/' . $r->id) ?>" class="btn btn-sm btn-primary">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#table-booking').DataTable({
            pageLength: 10,
            order: [
                [0, 'desc']
            ],
            language: {
                // url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/id.json'
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                }
            },
            columnDefs: [{
                targets: 6,
                orderable: false,
                searchable: false
            }]
        });
    });
</script>