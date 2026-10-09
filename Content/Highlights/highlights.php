<?php
$host = "mariadb";
$user = "azubi26";
$pass = "Cucxe9-vyxxos";
$db   = "iii";

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
$sql = "
    SELECT 
    h.*,
    GROUP_CONCAT(a.name SEPARATOR ', ') AS abteilungen
FROM highlights h
LEFT JOIN highlight_abteilung ha ON h.id = ha.highlight_id
LEFT JOIN abteilung a ON ha.abteilungs_id = a.id
GROUP BY h.id
ORDER BY h.id ASC;


$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($rows);
?>