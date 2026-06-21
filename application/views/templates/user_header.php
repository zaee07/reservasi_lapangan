<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : 'Reservasi Badminton' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/sweetalert2.min.css') ?>">
    <script src="<?= base_url('assets/js/sweetalert2.all.min.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/fonts/boxicons.css" />
    <!-- Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="topbar">
        <?php if (isset($back)) : ?>
            <a href="<?= base_url($back) ?>" class="me-3 text-dark">
                <i class="bi bi-arrow-left"></i>
            </a>
        <?php endif; ?>
        <h6><?= isset($title) ? $title : 'Halaman' ?></h6>
    </div>
    <div class="container-fluid px-3 py-3" id="container-mobile">
        <?php
        $this->load->view($main_view);
        if ($this->session->flashdata('error')): ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?= $this->session->flashdata('error') ?>'
                })
            </script>
        <?php endif;
        if ($this->session->flashdata('success')): ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '<?= $this->session->flashdata('success') ?>'
                })
            </script>
        <?php endif;
        $this->load->view('templates/user_footer');
        ?>