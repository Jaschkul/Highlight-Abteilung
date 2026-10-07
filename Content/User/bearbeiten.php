<?php
session_start();

$typ = $_GET['typ'] ?? $_POST['typ'] ?? $_SESSION['typ'] ?? null;

if ($typ !== null) {
    $_SESSION['typ'] = $typ;
}

// Textdaten übernehmen, wenn das Formular abgeschickt wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['titel'] = $_POST['titel'] ?? $_SESSION['titel'] ?? '';
    $_SESSION['autor'] = $_POST['Autor'] ?? $_SESSION['autor'] ?? '';
    $_SESSION['beschreibung1'] = $_POST['beschreibung1'] ?? $_SESSION['beschreibung1'] ?? '';
    $_SESSION['abteilungs_id'] = $_POST['abteilungs_id'] ?? $_SESSION['abteilungs_id'] ?? '';
}

// Nur neue Bilder speichern.
// Wenn kein neues Bild hochgeladen wurde, bleibt das vorhandene Session-Bild erhalten.
$uploadDir = __DIR__ . '/temp/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

for ($i = 1; $i <= 5; $i++) {
    $feld = 'bild' . $i;

    if (
        isset($_FILES[$feld]) &&
        $_FILES[$feld]['error'] === UPLOAD_ERR_OK &&
        is_uploaded_file($_FILES[$feld]['tmp_name'])
    ) {
        $originalName = basename($_FILES[$feld]['name']);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        $erlaubteEndungen = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($extension, $erlaubteEndungen, true)) {
            $name = bin2hex(random_bytes(16)) . '.' . $extension;

            if (move_uploaded_file($_FILES[$feld]['tmp_name'], $uploadDir . $name)) {
                // Optional: altes Bild löschen
                if (!empty($_SESSION[$feld])) {
                    $alteDatei = $uploadDir . basename($_SESSION[$feld]);

                    if (is_file($alteDatei)) {
                        unlink($alteDatei);
                    }
                }

                $_SESSION[$feld] = $name;
            }
        }
    }
}

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
    <?php
        $bildname = $_SESSION["bild$i"] ?? '';
        $bildUrl = '';

        if ($bildname !== '') {
            $bildUrl = 'temp/' . rawurlencode(basename($bildname));
        }
    ?>

    <div class="dropzone" id="dropzone<?= $i ?>">
        <span
            id="dropzoneText<?= $i ?>"
            style="<?= $bildUrl !== '' ? 'display:none;' : '' ?>"
        >
            Bild hierher ziehen oder klicken
        </span>

        <img
            id="preview<?= $i ?>"
            class="preview-img"
            src="<?= htmlspecialchars($bildUrl) ?>"
            style="<?= $bildUrl !== '' ? 'display:block;' : 'display:none;' ?>"
            alt="Bild <?= $i ?>"
        >
    </div>

    <input
        type="file"
        name="bild<?= $i ?>"
        id="bild<?= $i ?>"
        accept="image/jpeg,image/png,image/gif,image/webp"
        style="display:none;"
    >
<?php endfor; ?>

    <button type="submit">Vorschau anzeigen</button>
</form>
<?php endif; ?>

<script>
for (let i = 1; i <= 5; i++) {
    const dropzone = document.getElementById("dropzone" + i);
    const dropzoneText = document.getElementById("dropzoneText" + i);
    const fileInput = document.getElementById("bild" + i);
    const preview = document.getElementById("preview" + i);

    if (!dropzone || !dropzoneText || !fileInput || !preview) {
        continue;
    }

    dropzone.addEventListener("click", () => {
        fileInput.click();
    });

    fileInput.addEventListener("change", () => {
        if (fileInput.files.length > 0) {
            showPreview(
                fileInput.files[0],
                preview,
                dropzoneText
            );
        }
    });

    dropzone.addEventListener("dragover", (event) => {
        event.preventDefault();
        dropzone.classList.add("dragover");
    });

    dropzone.addEventListener("dragleave", () => {
        dropzone.classList.remove("dragover");
    });

    dropzone.addEventListener("drop", (event) => {
        event.preventDefault();
        dropzone.classList.remove("dragover");

        if (event.dataTransfer.files.length > 0) {
            fileInput.files = event.dataTransfer.files;

            showPreview(
                event.dataTransfer.files[0],
                preview,
                dropzoneText
            );
        }
    });
}

function showPreview(file, preview, dropzoneText) {
    if (!file.type.startsWith("image/")) {
        alert("Bitte nur ein Bild auswählen.");
        return;
    }

    const reader = new FileReader();

    reader.onload = function(event) {
        preview.src = event.target.result;
        preview.style.display = "block";
        dropzoneText.style.display = "none";
    };

    reader.readAsDataURL(file);
}
</script>

<a href="reset.php">Zurück</a>

</body>
</html>
