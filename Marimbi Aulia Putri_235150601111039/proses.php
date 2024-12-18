<?php
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == "Cek") {
    $nama = $_POST['nama'];

    $query = "SELECT * FROM inventaris WHERE nama = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $nama);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            echo "Barang tersedia.";
        } else {
            echo "Barang tidak ditemukan.";
        }
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
