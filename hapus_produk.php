<?php
include 'koneksi.php';

if (isset($_GET['kode'])) {
    $kode = $_GET['kode'];
    mysqli_query($conn, "DELETE FROM product WHERE product_code='$kode'");
}

header("Location: produk.php");
exit;
