<?php

require('Inventaris.php'); // Memanggil file Inventaris.php yang sudah dibuat sebelumnya

// Menggunakan SoapServer untuk membuat web service
$server = new SoapServer('inventaris.wsdl'); // Ganti dengan file WSDL yang sesuai
$server->setClass('Inventaris'); // Menentukan kelas yang akan menangani request
$server->handle(); // Menangani request yang masuk
