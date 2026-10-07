<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bearbeiten</title>
</head>
<body>
    <?php

    $typ = $_GET['typ'] ?? $_POST['typ'] ?? null;
    if ($typ === 'lo') {
        ?>
        <form action="vorschau.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="typ" value="lo">
        <label>Titel:</label>
        <input type="text" name="titel" value="<?= $_SESSION['titel'] ?? '' ?>" required>
        <label>Beschreibung:</label>
        <textarea name="beschreibung1"><?= $_SESSION['beschreibung1'] ?? '' ?></textarea>
        <?php
        $pdo = new PDO(
            'mysql:host=mariadb;dbname=iii;charset=utf8',
            'azubi26',
            'Cucxe9-vyxxos'
        );
        $stmt = $pdo->query('SELECT id, name FROM abteilung ORDER BY name ASC');
        $abteilungen = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>


        <label>Abteilung:</label>
        <select name="abteilungs_id">
    <option value="">Bitte wählen</option>

    <?php foreach ($abteilungen as $abt): ?>
        <option value="<?= $abt['id'] ?>"
            <?= (isset($_SESSION['abteilungs_id']) && $_SESSION['abteilungs_id'] == $abt['id']) ? 'selected' : '' ?>
        >
            <?= htmlspecialchars($abt['name']) ?>
        </option>
    <?php endforeach; ?>
</select>


        <label>Bild 1:</label>
        <input type="file" name="bild1">

        <label>Bild 2:</label>
        <input type="file" name="bild2">

        <button type="submit">Vorschau anzeigen</button>
    </form>
    <?php
    }
    if ($typ === 'ro') {
        ?>
        <form action="vorschau.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="typ" value="ro">
        <label>Titel:</label>
        <input type="text" name="titel" required>

        <label>Beschreibung:</label>
        <textarea name="beschreibung1"></textarea>

        <label>Abteilung:</label>
        <select name="abteilungs_id">
            <option value="1">IT</option>
            <option value="2">Marketing</option>
            <option value="3">Vertrieb</option>
        </select>

        <label>Bild 1:</label>
        <input type="file" name="bild1">

        <label>Bild 2:</label>
        <input type="file" name="bild2">

        <button type="submit">Vorschau anzeigen</button>
    </form>
    <?php
    }
    if ($typ === 'lu') {
        ?>
        <form action="vorschau.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="typ" value="lu">
        <label>Titel:</label>
        <input type="text" name="titel" required>

        <label>Beschreibung:</label>
        <textarea name="beschreibung1"></textarea>

        <label>Abteilung:</label>
        <select name="abteilungs_id">
            <option value="1">IT</option>
            <option value="2">Marketing</option>
            <option value="3">Vertrieb</option>
        </select>

        <label>Bild 1:</label>
        <input type="file" name="bild1">

        <label>Bild 2:</label>
        <input type="file" name="bild2">

        <button type="submit">Vorschau anzeigen</button>
    </form>
    <?php
    }
    if ($typ === 'ru') {
        ?>
        <form action="vorschau.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="typ" value="ru">
        <label>Titel:</label>
        <input type="text" name="titel" required>

        <label>Beschreibung:</label>
        <textarea name="beschreibung1"></textarea>

        <label>Abteilung:</label>
        <select name="abteilungs_id">
            <option value="1">IT</option>
            <option value="2">Marketing</option>
            <option value="3">Vertrieb</option>
        </select>

        <label>Bild 1:</label>
        <input type="file" name="bild1">

        <label>Bild 2:</label>
        <input type="file" name="bild2">

        <button type="submit">Vorschau anzeigen</button>
    </form>
    <?php
    }
    ?>
    
     <a href="index.html">Zurück</a>
</body>
</html>