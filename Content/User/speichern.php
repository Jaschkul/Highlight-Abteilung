<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    session_start();

    $pdo = new PDO(
        'mysql:host=mariadb;dbname=iii;charset=utf8',
        'azubi26',
        'Cucxe9-vyxxos'
    );

    $sql = 'INSERT INTO highlights 
        (titel, beschreibung1, bild1, bild2, abteilungs_id, freigegeben)
        VALUES (:titel, :beschreibung1, :bild1, :bild2, :abteilungs_id, FALSE)';

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':titel' => $_SESSION['titel'],
        ':beschreibung1' => $_SESSION['beschreibung1'],
        ':bild1' => $_SESSION['bild1'],
        ':bild2' => $_SESSION['bild2'],
        ':abteilungs_id' => $_SESSION['abteilungs_id']
    ]);

    // Bilder aus temp/ nach uploads/ verschieben
    rename('temp/' . $_SESSION['bild1'], 'uploads/' . $_SESSION['bild1']);
    rename('temp/' . $_SESSION['bild2'], 'uploads/' . $_SESSION['bild2']);

    echo '✔ Highlight gespeichert!';
    ?>
</body>
</html>