<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Penjualan</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_POST['simpan'])) {
            $kode = $_POST['kode_produk'];
            $qty = $_POST['jumlah'];
            $harga = $_POST['harga'];
            $subtotal = $qty * $harga;
            $ref = uniqid("REF");

            // cek stok
            $cek = mysqli_query($conn, "SELECT stock FROM product WHERE product_code='$kode'");
            $stok = mysqli_fetch_assoc($cek)['stock'];

            if ($stok < $qty) {
                echo "<div class='notification error'>
                        Stok tidak cukup! <a href='add.php'>Kembali</a>
                      </div>";
                exit;
            }

            // simpan penjualan
            mysqli_query($conn, "INSERT INTO sales (sales_reference, sales_date, product_code, quantity, price, subtotal)
                                 VALUES ('$ref', NOW(), '$kode', $qty, $harga, $subtotal)");

            // kurangi stok
            mysqli_query($conn, "UPDATE product SET stock = stock - $qty WHERE product_code = '$kode'");

            echo "<div class='notification success'>
                    Penjualan berhasil disimpan! <a href='index.php'>Kembali ke Dashboard</a>
                  </div>";
        }
        ?>
    </div>
</body>
</html>
