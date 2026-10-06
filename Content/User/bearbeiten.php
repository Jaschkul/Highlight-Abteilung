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
    if ($typ === 'lo') 
    ?>
        <form action="vorschau.php" method="post" enctype="multipart/form-data">

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
    endif;
    if ($typ === 'ro') 
        ?>
        <form action="vorschau.php" method="post" enctype="multipart/form-data">

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
    endif;
    if ($typ === 'lu') 
        ?>
        <form action="vorschau.php" method="post" enctype="multipart/form-data">

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
    endif;
    if ($typ === 'ru') 
        ?>
        <form action="vorschau.php" method="post" enctype="multipart/form-data">

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
    endif;
        ?>
    
     <a href="index.php">Zurück</a>
</body>
</html>