<?php
var_dump($_GET['id']);
exit;
$host = "mariadb";
$user = "azubi26";
$pass = "Cucxe9-vyxxos";
$db   = "iii";

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

$id = intval($_GET['id']);

// Bilder holen
$stmt = $pdo->prepare("SELECT bild1, bild2, bild3, bild4, bild5 FROM highlights WHERE id = ?");
$stmt->execute([$id]);
$bilder = $stmt->fetch(PDO::FETCH_ASSOC);

// Bilder löschen
foreach ($bilder as $bild) {
    if ($bild && file_exists(__DIR__ . "/../User/uploads/" . $bild)) {
        unlink(__DIR__ . "/../User/uploads/" . $bild);
    }
}
foreach ($bilder as $bild) {
    if ($bild) {
        $pfad = __DIR__ . "/../User/uploads/" . $bild;
        var_dump($pfad, file_exists($pfad));
    }
}
exit;


// DB-Eintrag löschen
$stmt = $pdo->prepare("DELETE FROM highlights WHERE id = ?");
$stmt->execute([$id]);

echo "Highlight wurde gelöscht.";
?>
