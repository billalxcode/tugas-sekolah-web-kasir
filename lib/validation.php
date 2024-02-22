<?php

function produk_validation($barcode, $nama, $harga, $stok) {
    if (empty($barcode)) {
        setAlert("Barcode tidak boleh kosong!", "error");
        return false;
    } else if (empty($nama)) {
        setAlert("Nama tidak boleh kosong!", "error");
        return false;
    } else if (empty($harga)) {
        setAlert("Harga tidak boleh kosong", "error");
        return false;
    } else if (empty($stok)) {
        setAlert("Stok tidak boleh kosong", "error");
        return false;
    }
    return true;
}

function pelanggan_validation($nama, $alamat, $telepon) {
    if (empty($nama)) {
        setAlert("Nama tidak boleh kosong!", "error");
        return false;
    } else if (empty($alamat)) {
        setAlert("Alamat tidak boleh kosong!", "error");
        return false;
    } else if (empty($telepon)) {
        setAlert("Telepon tidak boleh kosong!", "error");
        return false;
    }
    return true;
}