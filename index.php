<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - 5 Produk dengan Penjualan Terbanyak</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard - 5 Produk dengan Penjualan Terbanyak</h2>
        <table class="product-table">
            <tr>
                <th>Nama Produk</th>
                <th>Total Terjual</th>
            </tr>
            <?php
            $query = "SELECT product.product_name, SUM(sales.quantity) as total_terjual
                      FROM sales
                      JOIN product ON sales.product_code = product.product_code
                      GROUP BY product.product_name
                      ORDER BY total_terjual DESC
                      LIMIT 5";
            $hasil = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($hasil)) {
                echo "<tr>";
                echo "<td>" . $row['product_name'] . "</td>";
                echo "<td>" . $row['total_terjual'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <div class="buttons">
            <a href="produk.php" class="btn">Master Produk</a>
            <a href="add.php" class="btn">Tambah Penjualan</a>
        </div>
    </div>
</body>
</html>
