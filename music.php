<?php
// Import script autoload agar bisa menggunakan library
require_once('./vendor/autoload.php');
// Import library
use Firebase\JWT\JWT;
use Dotenv\Dotenv;

// Load dotenv
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Atur jenis response
header('Content-Type: application/json');

// Cek method request
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  http_response_code(405);
  exit();
}

$headers = getallheaders();

// Periksa apakah header authorization-nya ada
if (!isset($headers['Authorization'])) {
  http_response_code(401);
  exit();
}

// Mengambil token
list(, $token) = explode(' ', $headers['Authorization']);

try {
  // Men-decode token. Dalam library ini juga sudah sekaligus memverfikasinya
  JWT::decode($token, $_ENV['ACCESS_TOKEN_SECRET'], ['HS256']);
  
  $music = [
    [
      'title' => 'Butter',
      'genre' => 'Pop',
      'penyanyi' => 'BTS'
    ],
    [
      'title' => 'Dynamite',
      'genre' => 'Pop/Disco',
      'penyanyi' => 'BTS'
    ],
    [
      'title' => 'Life Goes On',
      'genre' => 'Synthpop',
      'penyanyi' => 'BTS'
    ],
    [
      'title' => 'Fever',
      'genre' => 'Pop',
      'penyanyi' => 'En-'
    ],
    [
      'title' => 'Mic Drop',
      'genre' => 'Dance/Electronic',
      'penyanyi' => 'BTS'
    ],
    [
      'title' => 'Boy With Luv',
      'genre' => 'Pop Funk',
      'penyanyi' => 'BTS'
    ]
  ];

  echo json_encode($music);
} catch (Exception $e) {
  // Bagian ini akan jalan jika terdapat error saat JWT diverifikasi atau di-decode
  http_response_code(401);
  exit();
}
?>