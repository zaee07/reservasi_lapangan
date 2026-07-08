<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-4 col-6 mb-4">
      <div class="card">
        <div class="card-body">
          <span>Booking Hari Ini</span>
          <h3><?= count($booking_list_hari_ini) ?></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-6 mb-4">
      <div class="card">
        <div class="card-body">
          <span>Check-In Hari Ini</span>
          <h3><?= $checkin_hari_ini ?></h3>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-12 mb-4">
      <div class="card">
        <div class="card-body">
          <span>Belum Check-In</span>
          <h3><?= $booking_checkin_pending ?></h3>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body text-center">
          <i class="bx bx-qr-scan display-4 text-primary"></i>
          <h5 class="mt-2"> Scan QR</h5>
          <a href="<?= base_url('checkin') ?>" class="btn btn-primary"> Mulai Scan</a>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body text-center">
          <i class="bx bx-user-plus display-4 text-success"></i>
          <h5 class="mt-2"> Booking Walk In</h5>
          <a href="<?= base_url('walkin') ?>" class="btn btn-success"> Buat Booking</a>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="card mb-4">
    <div class="card-header">
      <h5 class="mb-0"> Sedang Berlangsung</h5>
    </div>
    <div class="card-body">
      <?php foreach ($booking_berlangsung as $b): ?>
        <div class="border rounded p-3 mb-2">
          <div class="fw-bold">
            <?= $b->nama_lapangan ?>
          </div>
          <div>
            <?= $b->nama_pemesan ?>
          </div>
          <div class="small text-muted">
            <?= substr($b->jam_mulai, 0, 5) ?>
            -
            <?= substr($b->jam_selesai, 0, 5) ?>
          </div>
          <div class="mt-2">
            <?= badge_status_booking(
              $b->status_booking
            ) ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <h5 class="mb-0"> Booking Berikutnya</h5>
    </div>
    <div class="card-body">
      <?php foreach ($booking_berikutnya as $b): ?>
        <div class="d-flex justify-content-between mb-2">
          <div>
            <div class="fw-semibold">
              <?= $b->nama_pemesan ?>
            </div>
            <small>
              <?= $b->nama_lapangan ?>
            </small>
          </div>
          <div>
            <?= substr(
              $b->jam_mulai,
              0,
              5
            ) ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div> -->
</div>