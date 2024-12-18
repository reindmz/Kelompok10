<?php
require 'vendor/econea/nusoap/src/nusoap.php';
require 'vendor/autoload.php';

// Namespace untuk layanan
$namespace = "urn:cekBarang";

// Buat instance server SOAP
$server = new nusoap_server();
$server->configureWSDL("cekBarang", $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

// Deskripsikan struktur input dan output
$server->wsdl->addComplexType(
    'barang',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'nama' => array('nama' => 'nama', 'type' => 'xsd:string')
    )
);

$server->wsdl->addComplexType(
    'respon',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'status' => array('nama' => 'status', 'type' => 'xsd:string')
    )
);

function cekBarang($barang) {
    // Daftar barang yang tersedia
    $daftarBarang = ["Tamiya", "Bola", "Kemeja", "Kaos"];

    // Ambil nama barang dari parameter
    $nama = isset($barang['nama']) ? $barang['nama'] : null;

    // Periksa apakah nama barang ada di dalam array $daftarBarang
    if ($nama && in_array($nama, $daftarBarang)) {
        return array("status" => "Tersedia");
    } else {
        return array("status" => "Tidak Tersedia");
    }
}

// Register fungsi layanan SOAP
$server->register(
    'cekBarang',
    array('barang' => 'tns:barang'),
    array('respon' => 'tns:respon'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Cari Validasi apakah Barang tersedia di Inventaris'
);


// Ambil input dari SOAP client
$POST_DATA = file_get_contents("php://input");
$server->service($POST_DATA);
exit();
?>