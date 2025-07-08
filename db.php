<?php
$host = 'localhost';
$user = 'root';
$password = 'root'; // ← mot de passe correct pour MAMP
$dbname = 'eglise';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
