<?php
require_once "lib/database.php";
require_once "lib/alert.php";
require_once "lib/auth.php";

check_session();
$penjualan_id = $_GET['id'];
if (!isset($penjualan_id)) {
    header("location: riwayat-penjualan.php");
    die();
}
$data_detail_penjualan = $connector->query("SELECT * FROM detailpenjualan LEFT JOIN produk ON produk.id = produk_id WHERE penjualan_id = $penjualan_id");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Kasir App</title>
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/modules/izitoast/css/iziToast.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <marquee behavior="right" direction="left" class="text-white">
                    Selamat datang di Program Kasir Sistem Informasi. Program ini dibuat sebagai bagian dari tugas Semester 2 kelas XI RPL 1. Semoga penggunaan program ini mempermudah proses kasir dan memberikan pengalaman yang nyaman bagi penggunanya.
                </marquee>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html">KasirApp</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="index.html">KAPP</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Dashboard</li>
                        <li><a class="nav-link" href="/index.php"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
                        <li class="menu-header">Data</li>
                        <li><a class="nav-link" href="/tambah-produk.php"><i class="fas fa-th"></i> <span>Tambah Produk</span></a></li>
                        <li><a class="nav-link" href="/tambah-pelanggan.php"><i class="fas fa-user"></i> <span>Tambah pelanggan</span></a></li>
                        <li class="active"><a class="nav-link" href="/riwayat-penjualan.php"><i class="fas fa-history"></i> <span>Riwayat Penjualan</span></a></li>
                        <li class="menu-header">Lainnya</li>
                        <li><a class="nav-link" href="/logout.php"><i class="fas fa-sign-out"></i> <span>Logout</span></a></li>
                    </ul>

                    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                        <a href="https://github.com/billalxcode/tugas-sikasir" class="btn btn-primary btn-lg btn-block btn-icon-split">
                            <i class="fas fa-rocket"></i> Source Code
                        </a>
                    </div>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Riwayat</h1>
                    </div>

                    <div class="section-body">
                        <div class="card">
                            <div class="card-header">
                                <h5>Riwayat Penjualan</h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>PRODUK</th>
                                        <th>HARGA</th>
                                        <th>QTY</th>
                                        <th>TOTAL</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($penjualan = $data_detail_penjualan->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?= $penjualan['id'] ?></td>
                                                <td><?= $penjualan['nama'] ?></td>
                                                <td>Rp. <?= number_format($penjualan['subtotal'], 2, ",", ".") ?></td>
                                                <td><?= $penjualan['qty'] ?></td>
                                                <td>
                                                    <a href="/detail-penjualan.php?id=<?= $penjualan['id'] ?>" class="btn btn-primary">
                                                        <i class="fa fa-search"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <footer class="main-footer">
        <div class="footer-left">
            Copyright &copy; 2024 <div class="bullet"></div> Develop by <a href="https://github.com/billalxcode">Billal Fauzan</a>
        </div>
        <div class="footer-right">

        </div>
    </footer>
    </div>
    </div>

    <script src="assets/modules/jquery.min.js"></script>
    <script src="assets/modules/popper.js"></script>
    <script src="assets/modules/tooltip.js"></script>
    <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="assets/modules/moment.min.js"></script>
    <script src="assets/js/stisla.js"></script>
    <script src="assets/modules/izitoast/js/iziToast.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/custom.js"></script>

    <?php
    if ($alertData["message"] !== "") {?>
        <script>
            iziToast.<?= $alertData["type"] ?>({
            title: 'SUKSES',
            message: '<?= $alertData["message"] ?>',
            position: 'topRight'
        });
        </script>
    <?php } ?>
</body>

</html>