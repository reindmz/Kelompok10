<?php
require 'vendor/econea/nusoap/src/nusoap.php';

$client = new nusoap_client("http://example.com/service.php?wsdl", true);
$response = $client->call('cekBarang', array('barang' => array('nama' => 'Tamiya')));

if ($client->fault) {
    echo "Fault: <pre>";
    print_r($response);
    echo "</pre>";
} else {
    $err = $client->getError();
    if ($err) {
        echo "Error: " . $err;
    } else {
        echo "Response: <pre>";
        print_r($response);
        echo "</pre>";
    }
}
