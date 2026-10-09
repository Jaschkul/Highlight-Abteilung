<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "mariadb";
$user = "azubi26";
$pass = "Cucxe9-vyxxos";
$db   = "iii";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "DB-Verbindung fehlgeschlagen: " . $e->getMessage();
    exit;
}

$id = intval($_GET['id'] ?? 0);

if ($id === 0) {
    echo "Keine gültige ID übergeben.";
    exit;
}

// Prüfen ob der Datensatz existiert
$stmt = $pdo->prepare("SELECT * FROM highlights WHERE id = ?");
$stmt->execute([$id]);
$highlight = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$highlight) {
    echo "Highlight mit ID $id nicht gefunden.";
    exit;
}

// Bilder löschen
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/User/uploads/";

for ($i = 1; $i <= 5; $i++) {
    $bild = $highlight["bild$i"];
    if ($bild) {
        $pfad = $uploadDir . $bild;

        if (file_exists($pfad)) {
            unlink($pfad);
        }
    }
}

// Datensatz löschen
$stmt = $pdo->prepare("DELETE FROM highlights WHERE id = ?");
$stmt->execute([$id]);

echo "Highlight $id wurde gelöscht.";
?>
