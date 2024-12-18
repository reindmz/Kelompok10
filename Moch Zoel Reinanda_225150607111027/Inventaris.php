<?php

class Inventaris {
    private $apiEndpointMarketing = "http://localhost/WSInventaris/Marketing.php";

    /**
     * Deteksi perubahan stok barang dan kirim notifikasi ke sistem marketing
     * 
     * @param int $productId ID produk yang diperbarui
     * @param int $newStock Jumlah stok yang baru
     * @return array
     */
    public function notifikasiRestock($productId, $newStock) {
        // Siapkan data produk yang di-restock
        $dataRestock = $this->siapkanDataRestock($productId, $newStock);
        
        // Kirim notifikasi ke sistem marketing
        $response = $this->kirimNotifikasiKeMarketing($dataRestock);
        
        // Jika gagal kirim, coba lagi dalam periode tertentu
        if (!$response) {
            // Coba kirim lagi dengan logika tertentu (misalnya dengan retry delay)
            $this->retryKirimNotifikasi($dataRestock);
        }

        return $response;
    }

    /**
     * Menyiapkan data produk yang di-restock
     * 
     * @param int $productId ID produk yang diperbarui
     * @param int $newStock Jumlah stok yang baru
     * @return array
     */
    private function siapkanDataRestock($productId, $newStock) {
        // Data yang dikirim ke sistem marketing (contoh)
        return [
            'product_id' => $productId,
            'new_stock' => $newStock,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * Mengirim notifikasi ke sistem marketing melalui API
     * 
     * @param array $data Data yang akan dikirim
     * @return bool
     */
    private function kirimNotifikasiKeMarketing($data) {
        // Menggunakan cURL untuk mengirim data ke API Sistem Marketing
        $ch = curl_init($this->apiEndpointMarketing);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer your_api_token' // Pastikan mengganti dengan token yang valid
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        // Cek apakah response sukses atau gagal
        return $response ? true : false;
    }

    /**
     * Retry mengirim notifikasi ke sistem marketing
     * 
     * @param array $data Data yang akan dikirim
     */
    private function retryKirimNotifikasi($data) {
        $attempts = 3; // Jumlah percobaan pengiriman
        $retryInterval = 5; // Interval waktu dalam detik untuk percobaan berikutnya

        for ($i = 1; $i <= $attempts; $i++) {
            $response = $this->kirimNotifikasiKeMarketing($data);
            if ($response) {
                echo "Notifikasi berhasil dikirim pada percobaan ke-$i.";
                return;
            }
            echo "Percobaan ke-$i gagal, mencoba lagi dalam $retryInterval detik...\n";
            sleep($retryInterval);
        }

        echo "Gagal mengirim notifikasi setelah $attempts percobaan.\n";
    }
}

// Contoh penggunaan
$inventaris = new Inventaris();
$productId = 101; // ID produk
$newStock = 150; // Jumlah stok baru

// Notifikasi restock
$inventaris->notifikasiRestock($productId, $newStock);
