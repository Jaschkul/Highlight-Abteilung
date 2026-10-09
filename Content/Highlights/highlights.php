<?php
$host = "mariadb";
$user = "azubi26";
$pass = "Cucxe9-vyxxos";
$db   = "iii";

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
$sql = "
    SELECT h.*, a.name AS abteilungsname
    FROM highlights h
    LEFT JOIN abteilung a ON h.abteilungs_id = a.id
    ORDER BY h.id ASC";

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($rows);
?>