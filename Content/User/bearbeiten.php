<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style-sheet.css">
    <title>Bearbeiten</title>
</head>
<body>


    <?php

    $typ = $_GET['typ'] ?? $_POST['typ'] ?? null; && || oder 
    if ($typ === 'lo') {
        ?>
        <form action="vorschau.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="typ" value="lo">
        <label>Titel:</label>
        <input type="text" name="titel" value="<?= $_SESSION['titel'] ?>" required>
        <label>Beschreibung:</label>
        <textarea name="beschreibung1" required><?= $_SESSION['beschreibung1'] ?> </textarea>
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


            

<div class="dropzone" id="dropzone1">
    <span id="dropzoneText1">Bild hierher ziehen oder klicken</span>
</div>

<input type="file" name="bild1" id="bild1" style="display:none;">
<img id="preview1" class="preview-img">


        <button type="submit">Vorschau anzeigen</button>
    </form>

   


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

        <div class="dropzone" id="dropzone1">
    <span id="dropzoneText1">Bild hierher ziehen oder klicken</span>
</div>
<input type="file" name="bild1" id="bild1" style="display:none;">
<img id="preview1" class="preview-img">


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


        <div class="dropzone" id="dropzone1">
    <span id="dropzoneText1">Bild hierher ziehen oder klicken</span>
</div>
<input type="file" name="bild1" id="bild1" style="display:none;">
<img id="preview1" class="preview-img">

<div class="dropzone" id="dropzone2">
    <span id="dropzoneText2">Bild hierher ziehen oder klicken</span>
</div>
<input type="file" name="bild2" id="bild2" style="display:none;">
<img id="preview2" class="preview-img">


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


        <?php for ($i = 1; $i <= 5; $i++): ?>
<div class="dropzone" id="dropzone<?= $i ?>">
    <span id="dropzoneText<?= $i ?>">Bild hierher ziehen oder klicken</span>
</div>
<input type="file" name="bild<?= $i ?>" id="bild<?= $i ?>" style="display:none;">
<img id="preview<?= $i ?>" class="preview-img">
<?php endfor; ?>


        <button type="submit">Vorschau anzeigen</button>
    </form>
    <?php
    }
    ?>
    <script>
for (let i = 1; i <= 5; i++) {

    const dropzone = document.getElementById("dropzone" + i);
    const dropzoneText = document.getElementById("dropzoneText" + i);
    const fileInput = document.getElementById("bild" + i);
    const preview = document.getElementById("preview" + i);

    // Wenn der Typ weniger Bilder hat → überspringen
    if (!dropzone || !fileInput || !preview) continue;

    dropzone.addEventListener("click", () => fileInput.click());

    fileInput.addEventListener("change", () => {
        showPreview(fileInput.files[0], preview, dropzoneText, dropzone);
    });

    dropzone.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropzone.classList.add("dragover");
    });

    dropzone.addEventListener("dragleave", () => {
        dropzone.classList.remove("dragover");
    });

    dropzone.addEventListener("drop", (e) => {
        e.preventDefault();
        dropzone.classList.remove("dragover");

        const file = e.dataTransfer.files[0];
        fileInput.files = e.dataTransfer.files;
        showPreview(file, preview, dropzoneText, dropzone);
    });
}

function showPreview(file, preview, dropzoneText, dropzone) {
    const reader = new FileReader();
    reader.onload = () => {
        preview.src = reader.result;
        preview.style.display = "block";
        if (dropzoneText) dropzoneText.style.display = "none";
        dropzone.appendChild(preview);
    };
    reader.readAsDataURL(file);
}
</script>


     <a href="index.html", <?php session_destroy(); ?> >Zurück</a>
</body>
</html>