<?php
session_start(); // Session starten, um die zwischengespeicherten Daten zu verwenden

try {

    // Verbindung zur Datenbank herstellen
    $pdo = new PDO(
        'mysql:host=mariadb;dbname=iii;charset=utf8',
        'azubi26',
        'Cucxe9-vyxxos'
    );

    // SQL für das Haupt-Highlight (ohne Abteilungen)
    $sql = 'INSERT INTO highlights 
        (titel, beschreibung1, autor, bild1, bild2, bild3, bild4, bild5)
        VALUES (:titel, :beschreibung1, :autor, :bild1, :bild2, :bild3, :bild4, :bild5)';

    $stmt = $pdo->prepare($sql);

    // Highlight-Daten aus der Session einfügen
    $stmt->execute([
        ':titel' => $_SESSION['titel'] ?? null,
        ':beschreibung1' => $_SESSION['beschreibung1'] ?? null,
        ':autor' => $_SESSION['autor'] ?? null,
        ':bild1' => $_SESSION['bild1'] ?? null,
        ':bild2' => $_SESSION['bild2'] ?? null,
        ':bild3' => $_SESSION['bild3'] ?? null,
        ':bild4' => $_SESSION['bild4'] ?? null,
        ':bild5' => $_SESSION['bild5'] ?? null
    ]);

    // ID des neu eingefügten Highlights holen
    $highlight_id = $pdo->lastInsertId();

    // Falls Abteilungen ausgewählt wurden → Zuordnung speichern
    if (!empty($_SESSION['abteilungs_id'])) {

        $sql2 = 'INSERT INTO highlight_abteilung (highlight_id, abteilungs_id)
                 VALUES (:highlight_id, :abteilungs_id)';
        $stmt2 = $pdo->prepare($sql2);

        // Jede Abteilung einzeln einfügen
        foreach ($_SESSION['abteilungs_id'] as $abteilungs_id) {
            $stmt2->execute([
                ':highlight_id' => $highlight_id,
                ':abteilungs_id' => $abteilungs_id
            ]);
        }
    }

    // Bilder aus temp/ nach uploads/ verschieben
    for ($i = 1; $i <= 5; $i++) {
        $feld = 'bild' . $i;

        if (!empty($_SESSION[$feld])) {

            $tempPath = 'temp/' . $_SESSION[$feld];
            $uploadPath = 'uploads/' . $_SESSION[$feld];

            // Datei verschieben, falls sie existiert
            if (file_exists($tempPath)) {
                rename($tempPath, $uploadPath);
            }
        }
    }

    echo 'Highlight gespeichert!';

} catch (\Throwable $th) {
    // Fehler ausgeben
    echo '' . $th->getMessage() . '';
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speichern</title>
</head>
