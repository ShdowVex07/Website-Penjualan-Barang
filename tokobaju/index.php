<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Baju</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background: linear-gradient(90deg, #007bff, #6610f2);
            color: white;
        }
        .navbar .nav-link, .navbar-brand {
            color: white;
        }
        .navbar .nav-link:hover {
            color: #ffe600;
        }
        .btn-outline-primary {
            border-width: 2px;
            color: #007bff;
        }
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }
        .card {
            transition: 0.3s ease-in-out;
            border: none;
            border-radius: 12px;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .card-img-top {
            height: 220px;
            object-fit: cover;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        .badge {
            font-size: 0.8rem;
            padding: 5px 7px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Toko Baju</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item me-3">
                    <a href="tel:+6282124034207" class="nav-link"><i class="bi bi-telephone-fill"></i> +62821-2403-4207</a>
                </li>
                <li class="nav-item">
                    <?php
                    $jumlah_keranjang = 0;
                    if (!empty($_SESSION['keranjang'])) {
                        foreach ($_SESSION['keranjang'] as $jml) {
                            $jumlah_keranjang += $jml;
                        }
                    }
                    ?>
                    <a href="keranjang.php" class="btn btn-light position-relative">
                        <i class="bi bi-cart3"></i>
                        <?php if ($jumlah_keranjang > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $jumlah_keranjang ?>
                        </span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5 mb-5">
    <h3 class="text-center mb-4">Koleksi Produk Kami</h3>
    <div class="row">
        <?php
        $query = "SELECT * FROM produk";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="col-md-4 mb-4">';
            echo '  <div class="card">';
            echo '    <img src="images/' . $row['gambar'] . '" class="card-img-top" alt="' . $row['nama'] . '">';
            echo '    <div class="card-body">';
            echo '      <h5 class="card-title">' . $row['nama'] . '</h5>'; 
            echo '      <p class="card-text">Rp ' . number_format($row['harga'], 0, ',', '.') . '</p>';
            echo '      <form method="post" action="tambah_keranjang.php">';
            echo '          <input type="hidden" name="produk_id" value="' . $row['id'] . '">';
            echo '          <button type="submit" class="btn btn-outline-primary w-100">Tambah ke Keranjang</button>';
            echo '      </form>';
            echo '    </div>';
            echo '  </div>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<footer>
    <div class="container">
        &copy; <?= date('Y') ?> Bima J. Mambobo
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Update total saat jumlah berubah
function updateSubtotal(input, harga, id) {
    let qty = parseInt(input.value);
    let total = harga * qty;
    document.getElementById('subtotal-' + id).innerText = 'Rp ' + total.toLocaleString('id-ID');
}
</script>
</body>
</html>