<?php
require_once "lib/database.php";

function product_detail($productId) {
    /// mengambil detail produk
    global $connector;
    $productData = $connector->query("SELECT * FROM produk WHERE $productId");
    return $productData->fetch_assoc();
}

function save_penjualan($total, $pelanggan_id) {
    global $connector;
    $connector->query(
        "INSERT INTO penjualan VALUES (NULL, NOW(), $total, $pelanggan_id)"
    );
    return $connector->insert_id;
}

function save_detail_penjualan($penjualan_id, $produk_id, $qty, $subtotal) {
    global $connector;
    $connector->query(
        "INSERT INTO detailpenjualan VALUES (NULL, $penjualan_id, $produk_id, $qty, $subtotal)"
    );
}

$request_method = $_SERVER['REQUEST_METHOD'];
if ($request_method == "POST") {
    // ambil data post dari request
    $cash = $_POST['cash'];
    $pelanggan = $_POST['pelanggan'];
    
    $products = [];
    $total_harga = 0;
    $form_products = explode(",", $_POST['products']);
    
    // hitung jumlah produk yang sama
    $qty_products = array_count_values($form_products);
    // menghitung jumlah kuantitas produk dari request
    foreach (array_unique($form_products) as $produk) {
        $produk_detail = product_detail($produk);
        $produk_detail["qty"] = $qty_products[$produk];
        $produk_detail["subtotal"] = $produk_detail['harga'] * $qty_products[$produk];
        $total_harga += intval($produk_detail['harga']);
        array_push($products, $produk_detail);
    }
    $penjualan = save_penjualan($total_harga, $pelanggan);
    foreach ($products as $produk) {
        save_detail_penjualan($penjualan, $produk["id"], $produk["qty"], $produk["subtotal"]);
    }
    header('location: index.php?alertType=success&alertMessage=Transaksi+Berhasil');
    die();
} else {
    // ketika request method bukan POST maka
    // web akan diarahkan ke index.php
    header("location: index.php");
    die();
}