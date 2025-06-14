<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produk_id'])) {
    $id = $_POST['produk_id'];

    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    if (isset($_SESSION['keranjang'][$id])) {
        $_SESSION['keranjang'][$id]++;
    } else {
        $_SESSION['keranjang'][$id] = 1;
    }

    header("Location: index.php");
    exit();
} else {
    echo "Permintaan tidak valid.";
}
?>