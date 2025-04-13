<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Tambah Produk</h2>
        <?php
        if (isset($_POST['simpan'])) {
            $kode = $_POST['kode'];
            $nama = $_POST['nama'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];

            $query = "INSERT INTO product (product_code, product_name, price, stock)
                      VALUES ('$kode', '$nama', $harga, $stok)";
            mysqli_query($conn, $query);

            echo "<div class='notification success'>Data produk berhasil disimpan!</div>";
        }
        ?>

        <form method="post" class="form">
            <label for="kode">Kode Produk:</label>
            <input type="text" name="kode" id="kode" required>

            <label for="nama">Nama Produk:</label>
            <input type="text" name="nama" id="nama" required>

            <label for="harga">Harga:</label>
            <input type="number" name="harga" id="harga" required>

            <label for="stok">Stok:</label>
            <input type="number" name="stok" id="stok" required>

            <button type="submit" name="simpan" class="btn">Simpan Produk</button>
        </form>

        <h2>Daftar Produk</h2>
        <table class="product-table">
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            <?php
            $data = mysqli_query($conn, "SELECT * FROM product");
            while ($row = mysqli_fetch_assoc($data)) {
                echo "<tr>";
                echo "<td>" . $row['product_code'] . "</td>";
                echo "<td>" . $row['product_name'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['stock'] . "</td>";
                echo "<td>
                        <a href='edit_produk.php?kode=" . $row['product_code'] . "' class='btn small'>Edit</a>
                        <a href='hapus_produk.php?kode=" . $row['product_code'] . "' class='btn small danger' onclick=\"return confirm('Yakin ingin menghapus produk ini?')\">Hapus</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>

        <div class="buttons">
            <a href="index.php" class="btn">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
