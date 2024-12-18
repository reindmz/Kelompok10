<?php
class InventoryService {
    private $lowStockItems = [
        ['id' => 'P001', 'name' => 'Produk A', 'stock' => 5],
        ['id' => 'P002', 'name' => 'Produk B', 'stock' => 3],
    ];

    public function getLowStockNotification() {
        return $this->lowStockItems;
    }
}

$server = new SoapServer(null, ['uri' => "http://localhost/soap"]);
$server->setClass('InventoryService');
$server->handle();
?>
