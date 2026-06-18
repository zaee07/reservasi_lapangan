<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Checkin Member</h4>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="text-center mb-3">
                <i class="bx bx-qr-scan display-4 text-primary"></i>
                <h5 class="mt-2">Scan QR Booking</h5>
                <small class="text-muted">Arahkan kamera ke QR booking member</small>
            </div>
            <div id="reader"></div>
            <div id="hasil" class="mt-4"></div>
        </div>
    </div>
</div>
<style>
    #reader {
        width: 100%;
    }

    #reader video {
        border-radius: 12px;
    }
</style>
<script src="https://unpkg.com/html5-qrcode"></script>
<style>
    #reader {
        width: 100%;
    }

    #reader video {
        border-radius: 12px;
    }
</style>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    let scanning = false;
    const hasilEl = document.getElementById('hasil');

    function showMessage(type, message, reload = false) {
        hasilEl.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
        if (reload) {
            setTimeout(() => {
                location.reload();
            }, 3000);
        }
    }

    function onScanSuccess(decodedText) {
        if (scanning) return;
        scanning = true;
        html5QrcodeScanner.clear();
        // showMessage(
        //     'info',
        //     '<div class="spinner-border spinner-border-sm me-2"></div> Memproses Check-In...'
        // );
        fetch(
                "<?= base_url('petugas/checkin/proses') ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'qr_data=' + encodeURIComponent(decodedText)
                }
            )
            .then(response => {
                if (!response.ok) {
                    throw new Error(
                        'HTTP Error ' + response.status
                    );
                }
                return response.json();
            })
            .then(res => {
                console.log(res); //text => { 
                if (res.status) {
                    if (navigator.vibrate) {
                        navigator.vibrate(200);
                    }
                    showMessage(
                        'success',
                        `<h5 class="mb-2">Check-In Berhasil</h5>
                        <hr>
                        <strong>${res.booking.kode_booking}</strong><br>
                        ${res.booking.nama_pemesan}<br>
                        ${res.booking.nama_lapangan}`,
                        true
                    );
                } else {
                    showMessage('danger', res.message);
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            })
            .catch(error => {
                // gagal total
                console.error(error);
                showMessage(
                    'danger',
                    `${error.message} Terjadi kesalahan saat menghubungi server`
                );

                setTimeout(() => {
                    location.reload();
                }, 2000);
            });
    }
    const html5QrcodeScanner =
        new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            }
        );
    html5QrcodeScanner.render(onScanSuccess);
</script>