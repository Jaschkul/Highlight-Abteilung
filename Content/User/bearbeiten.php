<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['titel'])) {
    $_SESSION['titel'] = $_POST['titel'];
    $_SESSION['autor'] = $_POST['Autor'];
    $_SESSION['beschreibung1'] = $_POST['beschreibung1'];
    $_SESSION['abteilungs_id'] = $_POST['abteilungs_id'];

    // Bilder speichern
    $uploadDir = "temp/";
    for ($i = 1; $i <= 5; $i++) {
        $feld = "bild" . $i;

        if (!empty($_FILES[$feld]['name'])) {
            $tmp = $_FILES[$feld]['tmp_name'];
            $name = time() . "_" . basename($_FILES[$feld]['name']);
            move_uploaded_file($tmp, $uploadDir . $name);
            $_SESSION[$feld] = $name;
        }
    }
}


$typ = $_GET['typ'] ?? $_POST['typ'] ?? null;

// DB laden
$pdo = new PDO(
    'mysql:host=mariadb;dbname=iii;charset=utf8',
    'azubi26',
    'Cucxe9-vyxxos'
);
$stmt = $pdo->query('SELECT id, name FROM abteilung ORDER BY name ASC');
$abteilungen = $stmt->fetchAll(PDO::FETCH_ASSOC);

 // Anzahl Bilder je nach Typ
    $bildCount = [
        'lo' => 1,
        'ro' => 1,
        'lu' => 2,
        'ru' => 5
    ][$typ] ?? 1;
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Bearbeiten</title>
</head>
<body>

<?php if ($typ): ?>
<form action="vorschau.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="typ" value="<?= $typ ?>">

    <label>Titel:</label>
    <input type="text" name="titel" required value="<?= htmlspecialchars($_SESSION['titel'] ?? '') ?>">

    <label>Autor:</label>
    <input type="text" name="Autor" required value="<?= htmlspecialchars($_SESSION['autor'] ?? '') ?>">

    <label>Beschreibung:</label>
    <textarea name="beschreibung1" required><?= htmlspecialchars($_SESSION['beschreibung1'] ?? '') ?></textarea>

    <label>Abteilung:</label>
    <select name="abteilungs_id" required>
        <option value="" disabled>Bitte auswählen</option>
        <?php foreach ($abteilungen as $abt): ?>
            <option value="<?= $abt['id'] ?>"
                <?= (isset($_SESSION['abteilungs_id']) && $_SESSION['abteilungs_id'] == $abt['id']) ? 'selected' : '' ?>
            >
                <?= htmlspecialchars($abt['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php for ($i = 1; $i <= $bildCount; $i++): ?>
        <div class="dropzone" id="dropzone<?= $i ?>">
            <span id="dropzoneText<?= $i ?>">Bild hierher ziehen oder klicken</span>
        </div>
        <input type="file" name="bild<?= $i ?>" id="bild<?= $i ?>" style="display:none;">
        <?php if (!empty($_SESSION["bild$i"])): ?>
            <img id="preview<?= $i ?>" class="preview-img" src="temp/<?= htmlspecialchars($_SESSION["bild$i"]) ?>" style="display:block;">
        <?php else: ?>
            <img id="preview<?= $i ?>" class="preview-img" style="display:none;">
        <?php endif; ?>
    <?php endfor; ?>

    <button type="submit">Vorschau anzeigen</button>
</form>
<?php endif; ?>

<script>
// Bestehende Bilder aus PHP an JavaScript übergeben
const existingImages = <?= json_encode(array_map(fn($i) => $_SESSION["bild$i"] ?? null, range(1, 5))) ?>;

for (let i = 1; i <= 5; i++) {
    const dropzone = document.getElementById("dropzone" + i);
    const dropzoneText = document.getElementById("dropzoneText" + i);
    const fileInput = document.getElementById("bild" + i);
    const preview = document.getElementById("preview" + i);

    if (!dropzone || !fileInput || !preview) continue;

    // Bestehendes Bild anzeigen
    if (existingImages[i-1]) {
        preview.style.display = "block";
        dropzoneText.style.display = "none";
    }

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
        dropzoneText.style.display = "none";
        dropzone.appendChild(preview);
    };
    reader.readAsDataURL(file);
}
</script>

<a href="index.html" <?php session_destroy(); ?>>Zurück</a>

</body>
</html>
