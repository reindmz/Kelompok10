<?php
require 'vendor/econea/nusoap/src/nusoap.php';
require 'vendor/autoload.php';
require 'service.php';

$namespace = "urn:validasiBarang";

$server = new soap_server();
$server->configureWSDL("validasiBarang", $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
    'cek_barang',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'barang' => array('nama' => 'barang', 'type' => 'xsd:string')
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

$server->register(
    'cek',
    array('cek_barang' => 'tns:cek_barang'),
    array('respon' => 'tns:respon'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Cari Validasi apakah Barang tersedia di Sistem Inventaris'
);

$POST_DATA = file_get_contents("php://input");
$server->service($POST_DATA);
exit();
?>
