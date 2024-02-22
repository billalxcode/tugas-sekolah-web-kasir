<?php
require_once "lib/database.php";

$request_method = $_SERVER['REQUEST_METHOD'];

if ($request_method == "POST") {
    $pelanggan_id = $_GET["id"];

    if (empty($pelanggan_id)) {
        header("location: /tambah-pelanggan.php?alertType=error&alertMessage=Gagal+menghapus+data");
        die();
    } else {
        $deleted = $connector->query("DELETE FROM pelanggan WHERE id = $pelanggan_id");
        
        if ($deleted) {
            header("location: /tambah-pelanggan.php?alertType=success&alertMessage=Pelanggan+berhasil+dihapus");
            die();
        } else {
            header("location: /tambah-pelanggan.php?alertType=error&alertMessage=Gagal+menghapus+data");
            die();
        }
    }
} else {
    header("location: /tambah-pelanggan.php?alertType=error&alertMessage=Gagal+menghapus+data");
    die();
}