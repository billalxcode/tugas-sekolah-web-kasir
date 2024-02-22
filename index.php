<?php
require_once "lib/database.php";
require_once "lib/auth.php";
require_once "lib/alert.php";

check_session();

$data_produk = $connector->query("SELECT * FROM produk");
$data_pelanggan = $connector->query("SELECT * FROM pelanggan");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Kasir App</title>
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/modules/izitoast/css/iziToast.min.css">
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
                        <li class="active"><a class="nav-link" href="/index.php"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
                        <li class="menu-header">Data</li>
                        <li><a class="nav-link" href="/tambah-produk.php"><i class="fas fa-th"></i> <span>Tambah Produk</span></a></li>
                        <li><a class="nav-link" href="/tambah-pelanggan.php"><i class="fas fa-user"></i> <span>Tambah pelanggan</span></a></li>
                        <li><a class="nav-link" href="/riwayat-penjualan.php"><i class="fas fa-history"></i> <span>Riwayat Penjualan</span></a></li>
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
                        <h1>Dashboard</h1>
                    </div>

                    <div class="section-body">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Keranjang</h4>

                                <div class="card-header-action">
                                    <button class="btn btn-primary" id="btn-add-product"><i class="fa fa-plus mr-2"></i>Tambah Produk</button>
                                    <button class="btn btn-warning" id="btn-select-customer"><i class="fa fa-user mr-2"></i>Pilih Pelanggan</button>
                                </div>

                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <th>BARCODE</th>
                                        <th>NAMA</th>
                                        <th>HARGA</th>
                                        <th></th>
                                    </thead>
                                    <tbody id="selected-product"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h4>Informasi</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-row justify-content-between">
                                    <div class="col-8">
                                        <form action="/simpan-transaksi.php" method="post">
                                            <input type="hidden" name="products" value="" id="input_products">
                                            <input type="hidden" name="pelanggan" value="" id="input_pelanggan">
                                            <div class="form-group mb-4">
                                                <label for="uang">Uang Cash</label>
                                                <input type="number" name="cash" id="cash" placeholder="Masukan uang cash" class="form-control">
                                            </div>
                                            <button class="btn btn-primary">
                                                <i class="fa fa-money-bill mr-3"></i>BAYAR</button>
                                            <button class="btn btn-warning">
                                                <i class="fa fa-print mr-3"></i>CETAK</button>
                                        </form>
                                        
                                    </div>
                                    <table class="col-4">
                                        <tr>
                                            <td class="px-5">
                                                <p>Pelanggan</p>
                                            </td>
                                            <td>
                                                <h6 id="pelanggan_name">-</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-5">
                                                <p>Subtotal</p>
                                            </td>
                                            <td>
                                                <h6 id="subtotal">-</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-5">
                                                <p>Total Tagihan</p>
                                            </td>
                                            <td>
                                                <h6 id="total_tagihan">-</h6>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-5">
                                                <p>Total Kembalian</p>
                                            </td>
                                            <td>
                                                <h6 id="total_kembalian">-</h6>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Keranjang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>BARCODE</th>
                                <th>NAMA PRODUK</th>
                                <th>HARGA</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($produk = $data_produk->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?= $produk["id"] ?></td>
                                    <td><?= $produk["nama"] ?></td>
                                    <td>Rp. <?= number_format($produk['harga'], 2, ",", ".")     ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" onclick="selectClickButton('<?= base64_encode(json_encode($produk)) ?>')">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="pelangganModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Pelanggan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>NAMA</th>
                                <th>ALAMAT</th>
                                <th>TELEPON</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($pelanggan = $data_pelanggan->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?= $pelanggan["nama"] ?></td>
                                    <td><?= $pelanggan["alamat"] ?></td>
                                    <td><?= $pelanggan["telepon"] ?></td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" onclick="selectCustomerClickButton('<?= base64_encode(json_encode($pelanggan)) ?>')">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
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
    if ($alertData["message"] !== "") { ?>
        <script>
            iziToast.<?= $alertData["type"] ?>({
                title: 'SUKSES',
                message: '<?= $alertData["message"] ?>',
                position: 'topRight'
            });
        </script>
    <?php } ?>

    <script>
        const formatRupiah = (number) => `Rp ${number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')}`;
        let selected_products = []
        let subtotal = 0
        let cash = 0
        let diskon = 0
        let totalTagihan = 0
        let totalKembalian = 0
        let pelanggan_data = {}

        const btnAddProduct =document.getElementById("btn-add-product")
        const btnAddCustomer = document.getElementById("btn-select-customer")
        const inputCash =document.getElementById("cash")

        btnAddProduct.addEventListener("click", function() {
            $("#exampleModal").modal()
        })

        btnAddCustomer.addEventListener("click", function() {
            $("#pelangganModal").modal()
        })
        
        inputCash.addEventListener("change", function() {
            const v =inputCash.value
            cash =parseInt(v)
            updateInformation()
        })

        function selectClickButton(data) {
            const data_json = JSON.parse(atob(data))
            selected_products.push(data_json)
            updateTableRow()
        }

        function selectCustomerClickButton(data) {
            const data_json =JSON.parse(atob(data))
            pelanggan_data =data_json
            updateInformation()
        }

        function removeClickButton(itemIndex) {
            selected_products.splice(itemIndex, 1)
            updateTableRow()
        }

        function updateInformation() {
            $("#pelanggan_name").html(pelanggan_data['nama'])
            $("#input_pelanggan").val(pelanggan_data['id'])
            $("#subtotal").html(formatRupiah(subtotal))
            $("#total_tagihan").html(formatRupiah(
                subtotal - diskon
            ))
            if(cash !== 0) {
                $("#total_kembalian").html(
                    formatRupiah(
                        cash - (subtotal - diskon)
                    )
                )
            }
        }

        function updateTableRow() {
            $("#selected-product").empty()
            let input_products = selected_products.map(item => item.id)
            $("#input_products").val(input_products)
            subtotal = 0
            
            let tableRows = ""
            selected_products.forEach((v, index) => {
                subtotal +=parseInt(v.harga)
                const table_row = document.createElement("tr")
                const table_row_barcode = document.createElement("td")
                table_row_barcode.innerHTML = v.id

                const table_row_name = document.createElement("td")
                table_row_name.innerHTML = v.nama

                const table_row_harga =document.createElement("td")
                table_row_harga.innerHTML = formatRupiah(parseFloat(v.harga))
                
                const table_row_action = document.createElement("td")
                const table_row_action_remove =document.createElement("button")
                table_row_action_remove.className = "btn btn-danger"
                table_row_action_remove.innerHTML = "<i class='fa fa-trash'></i>"
                table_row_action_remove.setAttribute("onclick", `removeClickButton(${index})`)

                table_row_action.appendChild(table_row_action_remove)

                table_row.appendChild(table_row_barcode)
                table_row.appendChild(table_row_name)
                table_row.appendChild(table_row_harga)
                table_row.appendChild(table_row_action)
                
                tableRows += table_row.outerHTML
            })
            $("#selected-product").html(tableRows)
            updateInformation()
        }
    </script>
</body>

</html>