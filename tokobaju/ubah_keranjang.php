<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['produk_id'])) {
        $id = $_POST['produk_id'];

        if (isset($_POST['hapus'])) {
            if (isset($_SESSION['keranjang'][$id])) {
                unset($_SESSION['keranjang'][$id]);
            }
        } elseif (isset($_POST['jumlah'])) {
            $jumlah = (int) $_POST['jumlah'];
            if ($jumlah <= 0) {
                unset($_SESSION['keranjang'][$id]);
            } else {
                $_SESSION['keranjang'][$id] = $jumlah;
            }
        }
    }
}

header("Location: keranjang.php");
exit();
?>