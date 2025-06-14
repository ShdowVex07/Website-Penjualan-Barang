
<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_jumlah'])) {
    $id = $_POST['produk_id'];
    $jumlah = intval($_POST['jumlah']);
    if ($jumlah <= 0) {
        unset($_SESSION['keranjang'][$id]);
    } else {
        $_SESSION['keranjang'][$id] = $jumlah;
    }
    header("Location: keranjang.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];

    $total = 0;
    foreach ($_SESSION['keranjang'] as $id => $jumlah) {
        $query = mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'");
        if ($produk = mysqli_fetch_assoc($query)) {
            $total += $produk['harga'] * $jumlah;
        }
    }

    $_SESSION['checkout_data'] = [
        'nama' => $nama,
        'alamat' => $alamat,
        'total' => $total
    ];

    unset($_SESSION['keranjang']);
    header("Location: checkout.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Keranjang Belanja</h3>
    <a href="index.php" class="btn btn-secondary mb-3">Kembali</a>
    <table class="table">
        <thead>
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total = 0;
        if (!empty($_SESSION['keranjang'])) {
            foreach ($_SESSION['keranjang'] as $id => $jumlah) {
                $query = mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'");
                if ($produk = mysqli_fetch_assoc($query)) {
                    $sub = $produk['harga'] * $jumlah;
                    $total += $sub;
                    echo "<tr>";
                    echo "<td>{$produk['nama']}</td>";
                    echo "<td>
                        <form method='post' class='d-flex'>
                            <input type='hidden' name='produk_id' value='$id'>
                            <input type='number' name='jumlah' value='$jumlah' class='form-control me-2' min='1'>
                            <button type='submit' name='update_jumlah' class='btn btn-primary btn-sm'>Ubah</button>
                        </form>
                    </td>";
                    echo "<td>Rp " . number_format($produk['harga'], 0, ',', '.') . "</td>";
                    echo "<td>Rp " . number_format($sub, 0, ',', '.') . "</td>";
                    echo "<td><a href='hapus_keranjang.php?id=$id' class='btn btn-danger btn-sm'>Hapus</a></td>";
                    echo "</tr>";
                }
            }
        } else {
            echo "<tr><td colspan='5' class='text-center'>Keranjang kosong.</td></tr>";
        }
        ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="3">Total</th>
            <th colspan="2">Rp <?= number_format($total, 0, ',', '.') ?></th>
        </tr>
        </tfoot>
    </table>

    <?php if (!empty($_SESSION['keranjang'])): ?>
        <form method="post">
            <div class="mb-3">
                <label>Nama Pembeli</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" required></textarea>
            </div>
            <button type="submit" name="checkout" class="btn btn-success">Checkout</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>