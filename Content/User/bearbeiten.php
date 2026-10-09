<?php
session_start(); // Session starten, um Daten zwischenzuspeichern

// Typ laden: GET → POST → Session
$typ = $_GET['typ'] ?? $_POST['typ'] ?? $_SESSION['typ'] ?? null;

if ($typ !== null) {
    $_SESSION['typ'] = $typ; // Typ in Session speichern
}

// Textdaten übernehmen, wenn das Formular abgeschickt wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Titel, Autor, Beschreibung aktualisieren
    $_SESSION['titel'] = $_POST['titel'] ?? $_SESSION['titel'] ?? '';
    $_SESSION['autor'] = $_POST['autor'] ?? $_SESSION['autor'] ?? '';
    $_SESSION['beschreibung1'] = $_POST['beschreibung1'] ?? $_SESSION['beschreibung1'] ?? '';

    // Abteilungs-IDs (Mehrfachauswahl)
    if (isset($_POST['abteilungs_id'])) {
        $_SESSION['abteilungs_id'] = $_POST['abteilungs_id']; // Array
    }
}

// Upload-Verzeichnis für temporäre Bilder
$uploadDir = __DIR__ . '/temp/';

// Falls temp/ nicht existiert → erstellen
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Bild-Upload für bis zu 4 Bilder
for ($i = 1; $i <= 4; $i++) {
    $feld = 'bild' . $i;

    // Prüfen, ob ein neues Bild hochgeladen wurde
    if (
        isset($_FILES[$feld]) &&
        $_FILES[$feld]['error'] === UPLOAD_ERR_OK &&
        is_uploaded_file($_FILES[$feld]['tmp_name'])
    ) {
        $originalName = basename($_FILES[$feld]['name']);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        // Erlaubte Bildformate
        $erlaubteEndungen = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($extension, $erlaubteEndungen, true)) {

            // Zufälligen Dateinamen erzeugen
            $name = bin2hex(random_bytes(16)) . '.' . $extension;

            // Datei nach temp/ verschieben
            if (move_uploaded_file($_FILES[$feld]['tmp_name'], $uploadDir . $name)) {

                // Optional: altes Bild löschen
                if (!empty($_SESSION[$feld])) {
                    $alteDatei = $uploadDir . basename($_SESSION[$feld]);

                    if (is_file($alteDatei)) {
                        unlink($alteDatei);
                    }
                }

                // Neues Bild in Session speichern
                $_SESSION[$feld] = $name;
            }
        }
    }
}

// Datenbankverbindung
$pdo = new PDO(
    'mysql:host=mariadb;dbname=iii;charset=utf8',
    'azubi26',
    'Cucxe9-vyxxos'
);

// Abteilungen laden
$stmt = $pdo->query('SELECT id, name FROM abteilung ORDER BY name ASC');
$abteilungen = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Anzahl Bilder je nach Template-Typ
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

<?php if ($typ): ?>
<form action="vorschau.php" method="post" enctype="multipart/form-data">

    <!-- Template-Typ -->
    <input id="inputTitel" type="hidden" name="typ" value="<?= $typ ?>">

    <!-- Grid-Container abhängig von Bildanzahl -->
    <div class="d<?php echo $bildCount; ?>">

        <!-- Titel -->
        <div style="grid-area: box-1;">
            <label>Titel:</label>
            <input type="text" name="titel" required maxlength="100" value="<?= htmlspecialchars($_SESSION['titel'] ?? '') ?>">
        </div>

        <!-- Autor -->
        <div style="grid-area: box-4;">
            <label>Autor:</label>
            <input type="text" name="autor" required maxlength="100" value="<?= htmlspecialchars($_SESSION['autor'] ?? '') ?>">
        </div>

        <!-- Beschreibung -->
        <div style="grid-area: box-2;">
            <label>Beschreibung:</label>
            <textarea name="beschreibung1" required maxlength="200"><?= htmlspecialchars($_SESSION['beschreibung1'] ?? '') ?></textarea>
        </div>

        <!-- Abteilungen -->
        <div style="grid-area: box-5;">
            <label>Abteilung:</label>

            <?php foreach ($abteilungen as $abt): ?>
                <label style="display:block; margin-bottom:4px;">
                    <input type="checkbox"
                        name="abteilungs_id[]"
                        value="<?= $abt['id'] ?>"
                        <?= (!empty($_SESSION['abteilungs_id']) && in_array($abt['id'], $_SESSION['abteilungs_id'])) ? 'checked' : '' ?>
                    >
                    <?= htmlspecialchars($abt['name']) ?>
                </label>
            <?php endforeach; ?>
        </div>

        <!-- Dropzones für Bilder -->
        <?php for ($i = 1; $i <= $bildCount; $i++): ?>
            <?php
            $bildname = $_SESSION["bild$i"] ?? '';
            $bildUrl = $bildname ? 'temp/' . rawurlencode(basename($bildname)) : '';
            ?>

            <div class="dropzone" id="dropzone<?= $i ?>" style="grid-area: box-3;">
                <span id="dropzoneText<?= $i ?>" style="<?= $bildUrl ? 'display:none;' : '' ?>">
                    Bild hierher ziehen oder klicken
                </span>

                <img
                    id="preview<?= $i ?>"
                    class="preview-img"
                    src="<?= htmlspecialchars($bildUrl) ?>"
                    style="<?= $bildUrl ? 'display:block;' : 'display:none;' ?>"
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

        <!-- Fehlerbox -->
        <div id="errorBox" style="grid-area: box-8;"></div>

        <!-- Vorschau -->
        <div style="grid-area: box-7;">
            <button type="submit" id="vorschauBtn">Vorschau anzeigen</button>
        </div>

    </div>
</form>
<?php endif; ?>

<!-- Drag & Drop Script -->
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

<!-- Zurück-Button -->
<form action="reset.php" method="post" class="class-button">
    <div style="grid-area: box-6;">
        <button type="submit">Zurück</button>
    </div>
</form>

</body>
</html>
