<?php
    session_start();
try {
    
    
    $pdo = new PDO(
    'mysql:host=mariadb;dbname=iii;charset=utf8',
    'azubi26',
    'Cucxe9-vyxxos');

    $sql = 'INSERT INTO highlights 
        (titel, beschreibung1, autor, bild1, bild2, bild3, bild4, bild5, abteilungs_id)
        VALUES (:titel, :beschreibung1, :autor, :bild1, :bild2, :bild3, :bild4, :bild5, :abteilungs_id)';

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
    ':titel' => $_SESSION['titel'] ?? null,
    ':beschreibung1' => $_SESSION['beschreibung1'] ?? null,
    ':autor' => $_SESSION['autor'] ?? null,
    ':bild1' => $_SESSION['bild1'] ?? null,
    ':bild2' => $_SESSION['bild2'] ?? null,
    ':bild3' => $_SESSION['bild3'] ?? null,
    ':bild4' => $_SESSION['bild4'] ?? null,
    ':bild5' => $_SESSION['bild5'] ?? null,
    ':abteilungs_id' => $_SESSION['abteilungs_id'] ?? null
]);

    for ($i = 1; $i <= 5; $i++) {
    $feld = 'bild' . $i;
    // Bilder aus temp/ nach uploads/ verschieben
    if (!empty($_SESSION[$feld])) {
        $tempPath = 'temp/' . $_SESSION[$feld];
        $uploadPath = 'uploads/' . $_SESSION[$feld];

        if (file_exists($tempPath)) {
            rename($tempPath, $uploadPath);
        }
    }
}

    
    echo 'Highlight gespeichert!';
} catch (\Throwable $th) {
    //throw $th;
    echo ''. $th->getMessage() .'';
}
    
    ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speichern</title>
</head>