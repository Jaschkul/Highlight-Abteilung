<!DOCTYPE php>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <?php
            session_start();

            // Textdaten speichern
            $_SESSION['titel'] = $_POST['titel'];
            $_SESSION['beschreibung1'] = $_POST['beschreibung1'];
            $_SESSION['abteilungs_id'] = $_POST['abteilungs_id'];

            $uploadDir = "temp/";
            $bilder = [];

            for ($i = 1; $i <= 5; $i++) {
                $feld = "bild" . $i;

                if (!empty($_FILES[$feld]['name'])) {
                    $tmp = $_FILES[$feld]['tmp_name'];
                    $name = time() . "_" . basename($_FILES[$feld]['name']);
                    move_uploaded_file($tmp, $uploadDir . $name);
                    $_SESSION[$feld] = $name;
                    $bilder[$i] = $name;
                } else {
                    $_SESSION[$feld] = null;
                    $bilder[$i] = null;
                }
            }
        ?>
        <h1><?= $_SESSION['titel'] ?></h1>
        <p><?= $_SESSION['beschreibung1'] ?></p>

        <?php if ($bilder[1]): ?>
            <img src="temp/<?= $bilder[1] ?>" style="width:100%; max-width:800px;">
        <?php endif; ?>

        <a href="bearbeiten.php">Zurück</a>
        <a href="speichern.php">Speichern</a>

    </body>
</html>