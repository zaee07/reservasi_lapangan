<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-6 col-md-12 col-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <img
                src="../assets/img/icons/unicons/chart-success.png"
                alt="chart success"
                class="rounded" />
            </div>
            <div class="dropdown">
              <button
                class="btn p-0"
                type="button"
                id="cardOpt3"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                <a class="dropdown-item" href="<?= base_url('produk') ?>">View More</a>
                <?php if (has_role([1, 4])) : ?>
                  <a class="dropdown-item" href="<?= base_url('produk/tambah') ?>">Add New Product</a>
                <?php endif; ?>
                <a class="dropdown-item" href="<?= base_url('produk/export/pdf') ?>">Download Data Booking</a>
              </div>
            </div>
          </div>
          <span class="fw-semibold d-block mb-1">Total Booking Hari ini</span>
          <h3 class="card-title mb-2"><?= !empty($booking_list_hari_ini) ? count($booking_list_hari_ini) : 0 ?></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-12 col-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <img
                src="../assets/img/icons/unicons/wallet-info.png"
                alt="Credit Card"
                class="rounded" />
            </div>
            <div class="dropdown">
              <button
                class="btn p-0"
                type="button"
                id="cardOpt6"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                <a class="dropdown-item" href="<?= base_url('transaksi') ?>">View More</a>
                <?php if (has_role([1, 3])) : ?>
                  <a class="dropdown-item" href="<?= base_url('pos') ?>">Add New Penjualan</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <span>Pendapatan Hari ini</span>
          <h3 class="card-title text-nowrap mb-1">Rp. <?= number_format($pendapatan_hari_ini, 0, ',', '.') ?></h3>
        </div>
      </div>
    </div>
    <div class="col-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <img src="../assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
            </div>
            <div class="dropdown">
              <button
                class="btn p-0"
                type="button"
                id="cardOpt4"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                <a class="dropdown-item" href="<?= base_url('transaksi') ?>">View More</a>
                <a class="dropdown-item" href="<?= base_url('transaksi/exportPerhari/pdf') ?>">Download Laporan Hari Ini (PDF)</a>
                <a class="dropdown-item" href="<?= base_url('transaksi/exportPerhari/csv') ?>">Download Laporan Hari Ini (CSV)</a>
              </div>
            </div>
          </div>
          <span class="d-block mb-1">Checkin Hari ini</span>
          <h3 class="card-title text-nowrap mb-2"><?= $checkin_hari_ini ?></h3>
          <!-- <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i></small> -->
        </div>
      </div>
    </div>
    <div class="col-6 mb-4">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <img src="../assets/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
            </div>
            <div class="dropdown">
              <button
                class="btn p-0"
                type="button"
                id="cardOpt1"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu" aria-labelledby="cardOpt1">
                <a class="dropdown-item" href="<?= base_url('transaksi') ?>">View More</a>
                <a class="dropdown-item" href="<?= base_url('transaksi/exportPerbulan/pdf') ?>">Download Laporan (PDF)</a>
                <a class="dropdown-item" href="<?= base_url('transaksi/exportPerbulan/csv') ?>">Download Laporan (CSV)</a>
                <!-- <a class="dropdown-item" href="javascript:void(0);">Delete</a> -->
              </div>
            </div>
          </div>
          <span class="fw-semibold d-block mb-1">Penjualan Bulan Ini</span>
          <h3 class="card-title mb-2">Rp. <?= number_format($pendapatan_bulan_ini, 0, ',', '.') ?></h3>
        </div>
      </div>
    </div>
    <div class="col-8 mb-2">
      <div class="card">
        <div class="card-body">
          <span class="fw-semibold d-block mb-1"> Booking Hari Ini</span>
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Pemesan</th>
                    <th>Lapangan</th>
                    <th>Jam</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($booking_list_hari_ini)) : ?>
                    <tr>
                      <td colspan="5" class="text-center"> Belum ada booking</td>
                    </tr>
                  <?php endif; ?>
                  <?php foreach ($booking_list_hari_ini as $b) : ?>
                    <tr>
                      <td><?= $b->kode_booking ?></td>
                      <td><?= $b->nama_pemesan ?></td>
                      <td><?= $b->nama_lapangan ?></td>
                      <td><?= substr($b->jam_mulai, 0, 5) ?>-<?= substr($b->jam_selesai, 0, 5) ?></td>
                      <td><?= badge_status_booking($b->status_booking) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 mb-2">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Menunggu Konfirmasi</h5>
        </div>
        <div class="card-body">
          <?php if (empty($booking_pending)) : ?>
            <div class="text-muted">Tidak ada booking pending</div>
          <?php endif; ?>
          <?php foreach ($booking_pending as $b) : ?>
            <div class="border rounded p-3 mb-3">
              <div class="fw-bold"><?= $b->kode_booking ?></div>
              <div class="small text-muted"><?= $b->nama_pemesan ?></div>
              <div class="mt-1"><?= $b->nama_lapangan ?></div>
              <div class="small">Rp <?= number_format($b->total_bayar, 0, ',', '.') ?></div>
              <div class="mt-2">
                <a href="<?= base_url('admin/reservasi/detail/' . $b->id) ?>" class="btn btn-sm btn-primary">Detail</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- <div class="card-title d-flex align-items-start justify-content-between">
    <div class="row">
    </div>
  </div> -->
  <div class="card mb-2">
    <div class="card-header">
      <h5 class="mb-0">Lapangan Terlaris Bulan Ini</h5>
    </div>
    <div class="card-body">
      <div id="lapanganChart"></div>
    </div>
  </div>
  <div class="card mb-2">
    <div class="card-header">
      <h5 class="mb-0">Booking 7 Hari Terakhir</h5>
    </div>
    <div class="card-body">
      <div id="bookingChart"></div>
    </div>
  </div>
  <div class="col-12 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
          <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
            <div class="card-title">
              <h5 class="text-nowrap mb-2">Profile Report</h5>
              <span class="badge bg-label-warning rounded-pill">Tahun <?= date('Y') ?></span>
            </div>
            <h3 class="mb-0">Rp. <?= number_format($pendapatan_tahun_ini, 0, ',', '.') ?></h3>
            <div class="mt-sm-auto">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>


<script src="<?= base_url() ?>assets/vendor/libs/apex-charts/apexcharts.js"></script>
<?php
$labels = [];
$series = [];

foreach ($booking_7_hari as $row) {
  $labels[] = date(
    'd M',
    strtotime($row->tanggal)
  );

  $series[] = (int)$row->total;
}

$lapangan = [];
$totalBooking = [];

foreach ($terlaris as $row) {

  $lapangan[] = $row->nama_lapangan;

  $totalBooking[] =
    (int)$row->total_booking;
}

?>
<script>
  // chart dashboard
  const bookingOptions = {
    chart: {
      type: 'line',
      height: 240,
      toolbar: {
        show: false
      }
    },
    series: [{
      name: 'Booking',
      data: <?= json_encode($series) ?>
    }],
    xaxis: {
      categories: <?= json_encode($labels) ?>
    },
    stroke: {
      curve: 'smooth',
      width: 3
    },
    dataLabels: {
      enabled: true
    },
    markers: {
      size: 5
    },
    yaxis: {
      min: 0
    }
  };
  new ApexCharts(
    document.querySelector("#bookingChart"),
    bookingOptions
  ).render();

  const lapanganOptions = {
    chart: {
      type: 'bar',
      height: 320,
      toolbar: {
        show: false
      }
    },
    plotOptions: {
      bar: {
        horizontal: true
      }
    },
    dataLabels: {
      enabled: true
    },
    series: [{
      name: 'Booking',
      data: <?= json_encode($totalBooking) ?>
    }],
    xaxis: {
      categories: <?= json_encode($lapangan) ?>
    }
  };
  new ApexCharts(
    document.querySelector("#lapanganChart"),
    lapanganOptions
  ).render();
</script>