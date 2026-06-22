<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-primary">
                            <?= strtoupper(substr($member['nama'], 0, 1)) ?>
                        </span>
                    </div>
                    <h5><?= $member['nama'] ?></h5>
                    <p class="text-muted mb-1"><?= $member['email'] ?></p>
                    <p class="text-muted"><?= $member['no_hp'] ?></p>
                    <hr>
                    <div class="row text-center">
                        <div class="col-12">
                            <small class="text-muted">Tanggal Daftar</small>
                            <div class="fw-bold"><?= date('d M Y', strtotime($member['created_at'])) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Riwayat Booking</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table
                            id="table-riwayat"
                            class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <th>Cabang</th>
                                    <th>Lapangan</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($riwayat as $r): ?>
                                    <tr>
                                        <td>
                                            <?= $r->kode_booking ?>
                                        </td>
                                        <td>
                                            <?= date('d M Y', strtotime($r->tanggal_main)) ?>
                                        </td>
                                        <td>
                                            <?= $r->nama_cabang ?>
                                        </td>
                                        <td>
                                            <?= $r->nama_lapangan ?>
                                        </td>
                                        <td>
                                            <?= badge_status_booking($r->status_booking) ?>
                                        </td>
                                        <td>
                                            Rp <?= number_format($r->total_bayar, 0, ',', '.') ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#table-riwayat').DataTable({
            pageLength: 10,
            order: [
                [1, 'desc']
            ]
        });
    });
</script>