<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Laporan Pendapatan dan Booking</h4>
    </div>
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <small>Total Booking</small>
                    <h3><?= $total_booking ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <small>Total Pendapatan</small>
                    <h3>Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></h3>
                </div>
            </div>
        </div>
    </div>
    <form method="get" class="row mb-4">
        <div class="col-md-2">
            <input type="date" name="tanggal_awal" class="form-control" value="<?= $tanggal_awal ?>">
        </div>
        <div class="col-md-2">
            <input type="date" name="tanggal_akhir" class="form-control" value="<?= $tanggal_akhir ?>">
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">Semua Status </option>
                <option value="completed">Completed </option>
                <option value="confirmed">Confirmed </option>
                <option value="checked_in">Check In </option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="tipe" class="form-select">
                <option value="">Semua Tipe </option>
                <option value="online">Online </option>
                <option value="offline">Walk In </option>
            </select>
        </div>
        <div class="col-md-2 d-grid"><button class="btn btn-primary">Filter</button></div>
        <div class="col-md-12 mt-2">
            <a href="<?= base_url('admin/laporan/export-pdf?' . http_build_query($_GET)) ?>" class="btn btn-danger"> PDF</a>
            <a href="<?= base_url('admin/laporan/export-excel?' . http_build_query($_GET)) ?>" class="btn btn-success">Excel</a>
        </div>
    </form>
    <div class="card">
        <div class="card-body">
            <table
                id="table-laporan"
                class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Pemesan</th>
                        <th>Lapangan</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($laporan as $r): ?>
                        <tr>
                            <td><?= $r->kode_booking ?></td>
                            <td><?= date('d/m/Y', strtotime($r->tanggal_main)) ?></td>
                            <td><?= $r->nama_pemesan ?></td>
                            <td><?= $r->nama_lapangan ?></td>
                            <td><?= ucfirst($r->tipe_booking) ?></td>
                            <td><?= badge_status_booking($r->status_booking) ?></td>
                            <td>Rp <?= number_format($r->total_bayar, 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#table-laporan').DataTable({
            pageLength: 25,
            order: [
                [1, 'desc']
            ]
        });
    });
</script>