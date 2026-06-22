<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <small class="text-muted">Total Member</small>
                    <h3 class="mb-0"><?= $total_member ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Data Member</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table-member" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Total Booking</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $m): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded-circle bg-label-primary"><?= strtoupper(substr($m->nama, 0, 1)) ?></span>
                                        </div>
                                        <?= $m->nama ?>
                                    </div>
                                </td>
                                <td><?= $m->email ?></td>
                                <td><?= $m->no_hp ?></td>
                                <td><span class="badge bg-label-primary"><?= $m->total_booking ?></span></td>
                                <td><?= date('d M Y', strtotime($m->created_at)) ?></td>
                                <td>
                                    <a href="<?= base_url('owner/member/detail/' . $m->id) ?>" class="btn btn-sm btn-primary">
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
</div>

<script>
    $(function() {

        $('#table-member').DataTable({

            pageLength: 25,

            order: [
                [4, 'desc']
            ],

            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data"
            }

        });

    });
</script>