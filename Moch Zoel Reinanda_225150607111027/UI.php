<?php
// Mengimpor file Inventaris.php yang berisi class Inventaris
require_once 'Inventaris.php';

// Inisialisasi objek Inventaris
$inventaris = new Inventaris();

// Pesan umpan balik untuk user
$pesan = "";

// Memeriksa jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari input form
    $productId = intval($_POST['product_id']);
    $newStock = intval($_POST['new_stock']);

    // Memanggil fungsi notifikasiRestock untuk mengirim pemberitahuan ke sistem marketing
    $result = $inventaris->notifikasiRestock($productId, $newStock);

    // Menentukan pesan umpan balik berdasarkan hasil notifikasi
    $pesan = $result ? "Notifikasi restock berhasil dikirim ke sistem marketing." : "Gagal mengirim notifikasi restock. Silakan coba lagi.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Restock Barang</title>
    <style>
        body { font-family: Arial, sans-serif; }
        form { max-width: 400px; margin: auto; padding: 20px; border: 1px solid #ccc; }
        label, input { display: block; margin: 10px 0; }
        button { background-color: #4CAF50; color: white; padding: 10px; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Pemberitahuan Restock Barang</h2>

    <!-- Menampilkan pesan umpan balik -->
    <?php if (!empty($pesan)): ?>
        <p style="text-align: center; color: green;"><?php echo htmlspecialchars($pesan); ?></p>
    <?php endif; ?>

    <!-- Form untuk memasukkan data restock -->
    <form method="POST" action="">
        <label for="product_id">Product ID:</label>
        <input type="number" id="product_id" name="product_id" required placeholder="Masukkan Product ID">

        <label for="product_name">Nama Produk:</label>
        <input type="text" id="product_name" name="product_name" required placeholder="Masukkan Nama Produk">

        <label for="new_stock">Jumlah Stok Baru:</label>
        <input type="number" id="new_stock" name="new_stock" required placeholder="Masukkan Jumlah Stok Baru">

        <button type="submit">Simpan & Kirim Pemberitahuan</button>
    </form>
</body>
</html>
