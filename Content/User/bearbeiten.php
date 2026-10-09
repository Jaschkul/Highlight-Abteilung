<?php
session_start();

$typ = $_GET['typ'] ?? $_POST['typ'] ?? $_SESSION['typ'] ?? null;

if ($typ !== null) {
    $_SESSION['typ'] = $typ;
}

// Textdaten übernehmen, wenn das Formular abgeschickt wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['titel'] = $_POST['titel'] ?? $_SESSION['titel'] ?? '';
    $_SESSION['autor'] = $_POST['autor'] ?? $_SESSION['autor'] ?? '';
    $_SESSION['beschreibung1'] = $_POST['beschreibung1'] ?? $_SESSION['beschreibung1'] ?? '';
    $_SESSION['abteilungs_id'] = $_POST['abteilungs_id'] ?? $_SESSION['abteilungs_id'] ?? '';
}

// Nur neue Bilder speichern.
// Wenn kein neues Bild hochgeladen wurde, bleibt das vorhandene Session-Bild erhalten.
$uploadDir = __DIR__ . '/temp/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

for ($i = 1; $i <= 4; $i++) {
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
// Abteilungsname laden
$stmt = $pdo->query('SELECT id, name FROM abteilung ORDER BY name ASC');
$abteilungen = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Anzahl Bilder je nach Template Typ
$bildCount = [
    'lo' => 1,
    'ro' => 2,
    'lu' => 3,
    'ru' => 4
][$typ] ?? 1;
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Bearbeiten</title>
    <h1>Template1</h1>
</head>
<body>
<!-- Textfelder und Dropzones für Bilder -->
<?php if ($typ): ?>
<form action="vorschau.php" method="post" enctype="multipart/form-data">
    
    <input id="inputTitel" type="hidden" name="typ" value="<?= $typ ?>">
    
    <!--
    hier wird ein Container für die Anordnung des Templates geöffnet. Dieser wird später wieder geschlossen
    - es muss eine Variable in die class eingesetzt werden 
    -->
    <div class="d<?php echo $bildCount; ?>">
        <!--Titel box 1-->
        <div style ="grid-area: box-1;">
            <label>Titel:</label>
            <input type="text" name="titel" required value="<?= htmlspecialchars($_SESSION['titel'] ?? '') ?>">
        </div>
        <!--Autor box 4-->
        <div style ="grid-area: box-4;">
            <label>Autor:</label>
            <input type="text" name="autor" required value="<?= htmlspecialchars($_SESSION['autor'] ?? '') ?>">
        </div>
        <!--Beschreibung box 2-->
        <div style ="grid-area: box-2;">
            <label>Beschreibung:</label>
            <textarea name="beschreibung1" required><?= htmlspecialchars($_SESSION['beschreibung1'] ?? '') ?></textarea>
        </div>
        <!--Abteilungen box 5-->
        <div style ="grid-area: box-5;">
            <label>Abteilung:</label>
            <select name="abteilungs_id[]" multiple required>
                <option value="" selected >Bitte auswählen</option>
                <?php foreach ($abteilungen as $abt): ?>
                <option value="<?= $abt['id'] ?>"
                    <?= (!empty($_SESSION['abteilungs_id']) && in_array($abt['id'], $_SESSION['abteilungs_id'])) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($abt['name']) ?>
                </option>
                <?php endforeach; ?>
            </select>

        </div>

    <?php for ($i = 1; $i <= $bildCount; $i++): ?>
    <?php
    $bildname = $_SESSION["bild$i"] ?? '';
    $bildUrl = '';

    if ($bildname !== '') {
        $bildUrl = 'temp/' . rawurlencode(basename($bildname));
    }
    ?>
    <!--Dropzone box 3-->
    <div class="dropzone" id="dropzone<?= $i ?>" style ="grid-area: box-3;">
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
    <!--Error Message box 8-->
    <div id="errorBox" style ="grid-area: box-8;"></div>
    <!--Vorschau box 7-->
    <div style ="grid-area: box-7;">
        <button type="submit" id="vorschauBtn">Vorschau anzeigen</button>
    </div>
</form>
<?php endif; ?>

<!-- Script für Drag & Drop und Vorschau-Validierung -->
<script>
for (let i = 1; i <= 4; i++) {
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
//Vorschau-Button Validierung Bild muss ausgewählt sein
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

document.getElementById("vorschauBtn").addEventListener("click", function(e) {

    const required = <?= $bildCount ?>; // Anzahl Bilder aus PHP
    let filled = 0;

    for (let i = 1; i <= required; i++) {
        const input = document.getElementById("bild" + i);

        // Neues Bild hochgeladen?
        if (input.files && input.files.length > 0) {
            filled++;
            continue;
        }

        // Bereits vorhandenes Bild in der Session?
        const preview = document.getElementById("preview" + i);
        if (preview && preview.src && preview.style.display !== "none") {
            filled++;
        }
    }

    if (filled < required) {
        e.preventDefault();

        const errorBox = document.getElementById("errorBox");
        errorBox.textContent = "Bitte alle " + required + " Bilder hochladen, bevor du zur Vorschau gehst.";

        
        for (let i = 1; i <= required; i++) {
            const input = document.getElementById("bild" + i);
            const preview = document.getElementById("preview" + i);
            const dropzone = document.getElementById("dropzone" + i);

            if (
                (!input.files || input.files.length === 0) &&
                (!preview.src || preview.style.display === "none")
            ) {
                dropzone.style.border = "2px solid red";
            } else {
                dropzone.style.border = "";
            }
        }
    }
});


</script>
<form action="reset.php" method="post" class="class-button">
    <!--zurück box 6-->
    <div style ="grid-area: box-6;">
        <button type="submit">Zurück</button>
    </div>
    <!--mit diesem schließenden div wird der Container für das GridLayout geschlossen-->
    </div>
</form>


</body>
</html>
