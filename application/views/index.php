<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= $title; ?></title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/components.css">

    <link rel="stylesheet" href="<?= base_url(); ?>assets/table/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/table/datatables.net-select-bs4/css/select.bootstrap4.min.css">

    <link rel="stylesheet" href="<?= base_url(); ?>assets/modules/izitoast/css/iziToast.min.css">

    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <!-- Leaflet Start -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

    <!-- rute -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <!-- drawer map -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" integrity="sha512-gc3xjCmIy673V6MyOAZhIW93xhM9ei1I+gLbmFjUHIjocENRsLX/QUE1htk5q1XV2D/iie/VQ8DXI6Vu8bexvQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js" integrity="sha512-ozq8xQKq6urvuU6jNgkfqAmT7jKN2XumbrX1JiB3TnF7tI48DPI4Gy1GXKD/V3EExgAs1V+pRO7vwtS1LHg0Gw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Leaflet End -->

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <script src="<?= base_url(); ?>assets/modules/izitoast/js/iziToast.min.js"></script>
</head>

<body class="layout-3">
    <div class="toastr-success" data-flashdata="<?= $this->session->flashdata('toastr-success'); ?>"></div>
    <div class="toastr-error" data-flashdata="<?= $this->session->flashdata('toastr-error'); ?>"></div>

    <div id="app">
        <div class="main-wrapper container">
            <nav class="navbar navbar-expand-lg main-navbar bg-primary">
                <a href="<?= base_url('home'); ?>" class="navbar-brand sidebar-gone-hide">Supplier</a>
                <div class="navbar-nav">
                    <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
                </div>
                <div class="nav-collapse">
                    <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="container">
                        <ul class="navbar-nav">
                            <li class="nav-item <?= ($this->uri->segment(1) == '' || $this->uri->segment(1) == 'home') ? 'active' : ''; ?>"><a href="<?= base_url('home'); ?>" class="nav-link">Dashboard</a></li>
                            <li class="nav-item <?= ($this->uri->segment(1) == 'paket') ? 'active' : ''; ?>"><a href="<?= base_url('paket'); ?>" class="nav-link">Paket</a></li>
                            <li class="nav-item <?= ($this->uri->segment(1) == 'pembayaran') ? 'active' : ''; ?>"><a href="<?= base_url('pembayaran'); ?>" class="nav-link">Pembayaran</a></li>
                            <li class="nav-item <?= ($this->uri->segment(1) == 'progres') ? 'active' : ''; ?>"><a href="<?= base_url('progres'); ?>" class="nav-link">Progres</a></li>
                        </ul>
                    </div>
                </div>
                <form class="form-inline ml-auto">
                    <ul class="navbar-nav">
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="<?= $this->dt_user->image; ?>" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, <?= $this->dt_user->name; ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="<?= base_url('profile'); ?>" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('auth/logout'); ?>" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                <?php $this->load->view($page); ?>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; <?= date('Y'); ?> Pick Up Service
                </div>
                <div class="footer-right">
                    2.3.0
                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="<?= base_url(); ?>assets/table/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/table/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>assets/table/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="<?= base_url(); ?>assets/js/page/modules-datatables.js"></script>

    <!-- Template JS File -->
    <script src="<?= base_url(); ?>assets/js/scripts.js"></script>
    <script src="<?= base_url(); ?>assets/js/custom.js"></script>

    <script>
        var success = $('.toastr-success').data('flashdata');
        var error = $('.toastr-error').data('flashdata');

        if (success) {
            iziToast.success({
                title: 'success',
                message: success,
                position: 'topRight'
            });
        }

        if (error) {
            iziToast.error({
                title: 'Error',
                message: error,
                position: 'topRight'
            });
        }
    </script>
</body>

</html>