<?php
try {
    // URL WSDL dari server SOAP
    $wsdl = "http://localhost/WSInventaris/inventaris.wsdl";

    // Membuat instance SoapClient
    $client = new SoapClient($wsdl);

    // Data yang akan dikirim ke server
    $productId = 101; // ID produk
    $newStock = 150;  // Jumlah stok baru

    // Memanggil metode notifikasiRestock di server
    $response = $client->notifikasiRestock($productId, $newStock);

    // Menampilkan respons dari server
    echo "Response from server:\n";
    print_r($response);
} catch (SoapFault $e) {
    // Menangkap error SOAP
    echo "SOAP Error: " . $e->getMessage();
}
?>