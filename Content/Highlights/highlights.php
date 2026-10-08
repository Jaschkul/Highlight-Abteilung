<?php
$host = "mariadb";
$user = "azubi26";
$pass = "Cucxe9-vyxxos";
$db   = "iii";

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

$stmt = $pdo->query("SELECT * FROM highlights ORDER BY id ASC");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($rows);
?>