<?php

require "vendor/autoload.php"; // Memastikan autoloading berjalan dengan baik

require "Inventaris.php"; // Memanggil file Inventaris.php

// Membuat instance PHP2WSDL untuk menghasilkan WSDL dari kelas Inventaris
$gen = new \PHP2WSDL\PHPClass2WSDL("Inventaris", "http://localhost/WSInventaris/Server.php");

// Menghasilkan file WSDL
$gen->generateWSDL();

// Menyimpan file WSDL yang dihasilkan
file_put_contents("inventaris.wsdl", $gen->dump());

echo "Done!"; // Memberikan notifikasi bahwa proses selesai
