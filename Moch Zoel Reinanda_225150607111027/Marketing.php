<?php

class Marketing {
    /**
     * Menangani notifikasi restock yang dikirim oleh sistem Inventaris
     *
     * @param int $productId ID produk yang di-restock
     * @param int $newStock Jumlah stok yang baru
     * @return bool
     */
    public function notifikasiRestock($productId, $newStock) {
        // Simulasi: Menyimpan atau memperbarui data produk yang di-restock
        echo "Notifikasi diterima untuk produk ID: $productId dengan stok baru: $newStock.\n";

        // Misalnya, kita dapat memperbarui status produk dalam database di sini
        // Contoh:
        // $this->updateStatusProduk($productId, $newStock);

        // Kembalikan true jika berhasil, atau false jika gagal
        return true;
    }

    /**
     * Contoh fungsi untuk memperbarui status produk di database (simulasi)
     *
     * @param int $productId ID produk
     * @param int $newStock Jumlah stok baru
     */
    private function updateStatusProduk($productId, $newStock) {
        // Logika untuk memperbarui status produk di database
        // Misalnya menggunakan PDO untuk mengupdate database
        // $db = new PDO('mysql:host=localhost;dbname=marketing', 'username', 'password');
        // $stmt = $db->prepare("UPDATE produk SET stok = ? WHERE id = ?");
        // $stmt->execute([$newStock, $productId]);

        echo "Status produk ID $productId diperbarui dengan stok baru: $newStock.\n";
    }
}

// Menangani permintaan dari sistem Inventaris
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data yang dikirim oleh Inventaris
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['product_id']) && isset($input['new_stock'])) {
        $marketing = new Marketing();
        $productId = $input['product_id'];
        $newStock = $input['new_stock'];

        // Panggil method untuk memproses notifikasi restock
        $response = $marketing->notifikasiRestock($productId, $newStock);

        if ($response) {
            // Mengirimkan response sukses
            echo json_encode(['status' => 'success', 'message' => 'Produk berhasil diperbarui']);
        } else {
            // Mengirimkan response gagal
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui produk']);
        }
    } else {
        // Jika data tidak lengkap
        echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    }
} else {
    // Jika bukan POST request
    echo json_encode(['status' => 'error', 'message' => 'Method tidak valid']);
}
