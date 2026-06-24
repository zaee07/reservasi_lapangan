<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Jadwal Operasional</h4>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input type="date" name="tanggal" class="form-control" value="<?= $tanggal ?>">
                    </div>
                    <div class="col-md-4">
                        <select name="lapangan" class="form-select">
                            <option value="">-- Pilih Lapangan --</option>
                            <?php foreach ($lapangan as $l) : ?>
                                <option value="<?= $l->id ?>" <?= $this->input->get('lapangan') == $l->id ? 'selected' : '' ?>>
                                    <?= $l->nama_lapangan ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table id="table-jadwal" class="table table-hover">
                <thead>
                    <tr>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jadwal as $j) : ?>
                        <tr>
                            <td><?= $j->nama_lapangan ?></td>
                            <td><?= date('d/m/Y', strtotime($j->tanggal)) ?></td>
                            <td>
                                <?= substr($j->jam_mulai, 0, 5) ?>
                                -
                                <?= substr($j->jam_selesai, 0, 5) ?>
                            </td>
                            <td><?= badge_status_slot($j->status_slot) ?></td>
                            <td>
                                <?php if ($j->status_slot !== STATUS_SLOT_BOOKED) : ?>
                                    <a href="<?= base_url('jadwal/edit/' . $j->id) ?>" class="btn btn-sm btn-outline-warning">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#table-jadwal').DataTable({
            pageLength: 25,
            order: [
                [1, 'asc']
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data"
            }
        });
    });
</script>