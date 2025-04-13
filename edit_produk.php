<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Produk</h2>

        <?php
        if (isset($_GET['kode'])) {
            $kode = $_GET['kode'];
            $data = mysqli_query($conn, "SELECT * FROM product WHERE product_code='$kode'");
            $produk = mysqli_fetch_assoc($data);
        }

        if (isset($_POST['update'])) {
            $kode = $_POST['kode'];
            $nama = $_POST['nama'];
            $harga = $_POST['harga'];
            $stok = $_POST['stok'];

            $query = "UPDATE product SET 
                        product_name='$nama', 
                        price=$harga, 
                        stock=$stok 
                      WHERE product_code='$kode'";
            mysqli_query($conn, $query);

            echo "<div class='notification success'>Data produk berhasil diperbarui! </div>";
        }
        ?>

        <?php if (!empty($produk)) { ?>
        <form method="post"  class="form">
            <input type="hidden" name="kode" value="<?= $produk['product_code']; ?>">

            <label for="nama">Nama Produk:</label>
            <input type="text" name="nama" id="nama" value="<?= $produk['product_name']; ?>" required>

            <label for="harga">Harga:</label>
            <input type="number" name="harga" id="harga" value="<?= $produk['price']; ?>" required>

            <label for="stok">Stok:</label>
            <input type="number" name="stok" id="stok" value="<?= $produk['stock']; ?>" required>

            <button type="submit" name="update" class="btn">Update Produk</button>
        </form>
        <?php } else { ?>
            <p class="error">Produk tidak ditemukan.
        <?php } ?>
        <div class="buttons">
            <a href="produk.php" class="btn">Kembali</a>
        </div>

    </div>
</body>
</html>
