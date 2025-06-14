<?php
session_start();

// Ambil data checkout dari session
$checkoutData = $_SESSION['checkout_data'] ?? null;
unset($_SESSION['checkout_data']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Checkout Berhasil</h3>
    <?php if ($checkoutData): ?>
        <div class="alert alert-success">
            <p>Terima kasih, <strong><?= htmlspecialchars($checkoutData['nama']) ?></strong>!</p>
            <p>Pesananmu akan segera dikirim ke alamat:</p>
            <blockquote><?= nl2br(htmlspecialchars($checkoutData['alamat'])) ?></blockquote>
            <p><strong>Total Belanja: Rp <?= number_format($checkoutData['total'], 0, ',', '.') ?></strong></p>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            Data checkout tidak ditemukan. Silakan lakukan pembelian dari awal.
        </div>
    <?php endif; ?>
    <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
</div>
</body>
</html>
        