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
                <a class="dropdown-item" href="<?= base_url('produk/export/pdf') ?>">Download Data Produk</a>
              </div>
            </div>
          </div>
          <span class="fw-semibold d-block mb-1">Total Booking</span>
          <h3 class="card-title mb-2"><?= $total_booking ?></h3>
          <!-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small> -->
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
          <!-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small> -->
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
          <span class="d-block mb-1">Transaksi Hari ini</span>
          <h3 class="card-title text-nowrap mb-2"><?= 10000 ?></h3>
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
          <!-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> %</small> -->
        </div>
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
                <!-- <small class="text-success text-nowrap fw-semibold"><i class="bx bx-chevron-up"></i> 68.2%</small>
                <h3 class="mb-0">Rp. <s?php // number_format($pendapatan_tahun_ini, 0, ',', '.') ?></h3> -->
              </div>
            </div>
            <?php if (!empty($stok_minimal)) : ?>
              <div class="stok-minimal">
                <div class="alert alert-danger">
                  <strong>Peringatan!</strong><br>Stok barang berikut hampir habis :
                  <ul>
                    <?php foreach ($stok_minimal as $item) : ?>
                      <li><?= $item->nama_produk ?> (<?= $item->stok . " " . $item->satuan ?>)</li>
                    <?php endforeach ?>
                  </ul>
                </div>
              </div>
              <div class="col-md-4">
                <div class="btn-group">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"><i class='bx bxs-report'></i> Export Data Peringatan Stok <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= base_url('produk/exportStok/pdf') ?>" target="_blank" rel="noopener noreferrer">Export PDF</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('produk/exportStok/csv') ?>" target="_blank" rel="noopener noreferrer">Export CSV</a></li>
                  </ul>
                </div>
              </div>
            <?php endif ?>
            <!-- <div id="profileReportChart"></div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>