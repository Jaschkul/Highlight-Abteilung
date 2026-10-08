<?php
    session_start();
try {
    
    
    $pdo = new PDO(
    'mysql:host=mariadb;dbname=iii;charset=utf8',
    'azubi26',
    'Cucxe9-vyxxos');

    $sql = 'INSERT INTO highlights 
        (titel, beschreibung1, bild1, bild2, bild3, bild4, bild5, abteilungs_id)
        VALUES (:titel, :beschreibung1, :bild1, :bild2, :bild3, :bild4, :bild5, :abteilungs_id)';

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':titel' => $_SESSION['titel'],
        ':beschreibung1' => $_SESSION['beschreibung1'],
        ':bild1' => $_SESSION['bild1'],
        ':bild2' => $_SESSION['bild2'],
        ':bild3' => $_SESSION['bild3'],
        ':bild4' => $_SESSION['bild4'],
        ':bild5' => $_SESSION['bild5'],
        ':abteilungs_id' => $_SESSION['abteilungs_id']
    ]);

    // Bilder aus temp/ nach uploads/ verschieben
    rename('temp/' . $_SESSION['bild1'], 'uploads/' . $_SESSION['bild1']);
    rename('temp/' . $_SESSION['bild2'], 'uploads/' . $_SESSION['bild2']);
    rename('temp/' . $_SESSION['bild3'], 'uploads/' . $_SESSION['bild3']);
    rename('temp/' . $_SESSION['bild4'], 'uploads/' . $_SESSION['bild4']);
    rename('temp/' . $_SESSION['bild5'], 'uploads/' . $_SESSION['bild5']);

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