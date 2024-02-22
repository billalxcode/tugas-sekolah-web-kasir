<?php
require_once "lib/database.php";
$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == "POST") {
    $produk_id = $_GET["id"];

    if (empty($produk_id)) {
        header("location: /tambah-produk.php?alertType=error&alertMessage=Gagal+menghapus+data");
    } else {
        $deleted = $connector->query("DELETE FROM produk WHERE id = $produk_id");
        if ($deleted) {
            header("location: /tambah-produk.php?alertType=success&alertMessage=Produk+berhasil+dihapus");
        } else {
            header("location: /tambah-produk.php?alertType=error&alertMessage=Gagal+menghapus+data");
        }
    }
} else {
    header("location: /tambah-produk.php?alertType=error&alertMessage=Gagal+menghapus+data");
}