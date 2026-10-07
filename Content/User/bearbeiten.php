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
            <style>
.dropzone {
    width: 100%;
    max-width: 400px;
    padding: 30px;
    border: 2px dashed #888;
    border-radius: 10px;
    text-align: center;
    cursor: pointer;
    margin-bottom: 20px;
    transition: 0.2s;
    position: relative;
}

.preview-img {
    width: 100%;
    max-width: 400px;
    margin-top: 0;
    display: none;
}

.dropzone.dragover {
    background-color: #eef;
    border-color: #55f;
}

</style>

<div class="dropzone" id="dropzone2">
    <span id="dropzoneText2">Bild hierher ziehen oder klicken</span>
</div>

<input type="file" name="bild2" id="bild2" style="display:none;">
<img id="preview2" class="preview-img">


        <button type="submit">Vorschau anzeigen</button>
    </form>

   <script>
const dropzone2 = document.getElementById("dropzone2");
const dropzoneText2 = document.getElementById("dropzoneText2");
const fileInput2 = document.getElementById("bild2");
const preview2 = document.getElementById("preview2");

// Klick öffnet Datei-Dialog
dropzone2.addEventListener("click", () => fileInput2.click());

// Datei per Klick ausgewählt → anzeigen
fileInput2.addEventListener("change", () => {
    showPreview(fileInput2.files[0]);
});

// Drag & Drop Events
dropzone2.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropzone2.classList.add("dragover");
});

dropzone2.addEventListener("dragleave", () => {
    dropzone2.classList.remove("dragover");
});

dropzone2.addEventListener("drop", (e) => {
    e.preventDefault();
    dropzone2.classList.remove("dragover");

    const file = e.dataTransfer.files[0];
    fileInput2.files = e.dataTransfer.files;
    showPreview(file);
});

// Bild anzeigen + Text ausblenden
function showPreview(file) {
    const reader = new FileReader();
    reader.onload = () => {
        preview2.src = reader.result;
        preview2.style.display = "block";
        dropzoneText2.style.display = "none"; // Text ausblenden
        dropzone2.appendChild(preview2);      // Bild IN den Kasten setzen
    };
    reader.readAsDataURL(file);
}
</script>


    <?php
    }
    if ($typ === 'ro') {
        ?>
        <form action="vorschau.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="typ" value="ro">
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
    if ($typ === 'lu') {
        ?>
        <form action="vorschau.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="typ" value="lu">
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
    if ($typ === 'ru') {
        ?>
        <form action="vorschau.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="typ" value="ru">
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
    ?>
    
     <a href="index.html">Zurück</a>
</body>
</html>