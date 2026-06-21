<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card">
        <div class="card-body">
          <span>Total Cabang</span>
          <h3><?= $total_cabang ?></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card">
        <div class="card-body">
          <span>Total Booking</span>
          <h3><?= $total_booking ?></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card">
        <div class="card-body">
          <span>Total Member</span>
          <h3><?= $total_member ?></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card">
        <div class="card-body">
          <span>Total Pendapatan</span>
          <h5>
            Rp <?= number_format($total_pendapatan, 0, ',', '.') ?>
          </h5>
        </div>
      </div>
    </div>
  </div>
  <div class="card mb-2">
    <div class="card-header">
      Ranking Cabang
    </div>
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>Cabang</th>
            <th>Booking</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($ranking_cabang as $c): ?>
            <tr>
              <td><?= $c->nama_cabang ?></td>
              <td><?= $c->total_booking ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="col-md-6 mb-2">
    <div class="card h-100">
      <div class="card-header">
        <h5 class="mb-0">Top Cabang</h5>
      </div>
      <div class="card-body">
        <?php if (empty($top_cabang)): ?>
          <div class="text-center text-muted">Belum ada data</div>
        <?php else: ?>
          <?php
          $rank = 1;
          foreach ($top_cabang as $c):
          ?>
            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
              <div>
                <span class="badge bg-label-primary me-2">#<?= $rank++ ?></span><?= $c->nama_cabang ?>
              </div>
              <div class="fw-bold text-success">
                Rp <?= number_format($c->total, 0, ',', '.') ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      Top 5 Lapangan Terlaris
    </div>
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>Cabang</th>
            <th>Lapangan</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($lapangan_terlaris as $l): ?>
            <tr>
              <td><?= $l->nama_cabang ?></td>
              <td><?= $l->nama_lapangan ?></td>
              <td><?= $l->total_booking ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="card mb-2">
    <div class="card-header">
      <h5 class="mb-0">Pendapatan 7 Hari Terakhir</h5>
    </div>
    <div class="card-body">
      <div id="pendapatanChart"></div>
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
</div>

<!-- apex chart -->
<script src="<?= base_url() ?>assets/vendor/libs/apex-charts/apexcharts.js"></script>
<?php
$labels = [];
$series = [];

foreach ($booking_7_hari as $row) {
  $labels[] = date('d M', strtotime($row->tanggal_main));
  $series[] = (int)$row->total;
}

$pendapatan = [];
$tglPendapatan = [];
$totalPendapatan = [];

foreach ($pendapatan_7_hari as $row) {
  $tglPendapatan[] = date('d M', strtotime($row->tanggal_main));
  $pendapatan[] = $row->total;

  $totalPendapatan[] = (int)$row->total;
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

  const pendapatanOptions = {
    chart: {
      type: 'line',
      height: 240,
      toolbar: {
        show: false
      }
    },
    plotOptions: {
      bar: {
        horizontal: false
      }
    },
    dataLabels: {
      enabled: true
    },
    series: [{
      name: 'Pendapatan',
      data: <?= json_encode($pendapatan) ?>
    }],
    xaxis: {
      categories: <?= json_encode($tglPendapatan) ?> //$pendapatan_7_hari) 
    }
  };
  new ApexCharts(
    document.querySelector("#pendapatanChart"),
    pendapatanOptions
  ).render();
</script>