<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penjualan</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Tambah Penjualan</h2>
        <form method="post" action="save.php" class="form">
            <div class="form-group">
                <label for="kode_produk">Pilih Produk:</label>
                <select name="kode_produk" id="kode_produk" onchange="setHarga()" class="form-control" required>
                    <option value="">--Pilih Produk--</option>
                    <?php
                    $produk = mysqli_query($conn, "SELECT * FROM product");
                    while ($p = mysqli_fetch_assoc($produk)) {
                        echo "<option value='{$p['product_code']}' data-harga='{$p['price']}' data-stok='{$p['stock']}'>
                                {$p['product_name']}
                              </option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah:</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" oninput="hitungSubtotal()" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" name="harga" id="harga" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label for="subtotal">Subtotal:</label>
                <input type="text" name="subtotal" id="subtotal" class="form-control" readonly>
            </div>

            <div class="form-group text-center">
                <button type="submit" name="simpan" class="btn btn-dark">Simpan Transaksi</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
    </div>

    <script>
        function setHarga() {
            let select = document.getElementById("kode_produk");
            let harga = select.options[select.selectedIndex].getAttribute("data-harga");
            document.getElementById("harga").value = harga;
            hitungSubtotal();
        }

        function hitungSubtotal() {
            let qty = document.getElementById("jumlah").value;
            let harga = document.getElementById("harga").value;
            document.getElementById("subtotal").value = qty * harga;
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
