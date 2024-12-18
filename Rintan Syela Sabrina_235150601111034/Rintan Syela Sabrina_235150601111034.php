<?php
// Middleware untuk SOAP Web Service
function fetchLowStockData() {
    // URL SOAP Web Service
    $wsdl = "http://localhost/soap/server.php?wsdl";

    try {
        // Membuat instance SOAP client
        $client = new SoapClient($wsdl);

        // Memanggil method SOAP
        $lowStockItems = $client->getLowStockNotification();

        // Mengembalikan hasil dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($lowStockItems);
    } catch (SoapFault $e) {
        // Menangani error
        header('Content-Type: application/json');
        echo json_encode(["error" => $e->getMessage()]);
    }
}
// Panggil middleware
fetchLowStockData();
?>
