<?php
session_start(); // Session starten, um Formulardaten und Bilder zwischenzuspeichern

// Typ laden: zuerst POST, dann GET, dann Session
$typ = $_POST['typ'] ?? $_GET['typ'] ?? $_SESSION['typ'] ?? null;
$_SESSION['typ'] = $typ; // Typ in Session speichern

// Wenn das Formular abgeschickt wurde → Textdaten aktualisieren
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Titel, Autor, Beschreibung aus POST übernehmen, falls vorhanden
    $_SESSION['titel'] = $_POST['titel'] ?? $_SESSION['titel'] ?? '';
    $_SESSION['autor'] = $_POST['autor'] ?? $_SESSION['autor'] ?? '';
    $_SESSION['beschreibung1'] = $_POST['beschreibung1'] ?? $_SESSION['beschreibung1'] ?? '';

    // Abteilungs-IDs (Mehrfachauswahl) speichern
    if (isset($_POST['abteilungs_id'])) {
        $_SESSION['abteilungs_id'] = $_POST['abteilungs_id']; // Array
    }
}

// Upload-Verzeichnis definieren
$uploadDir = __DIR__ . '/temp/';

// Falls das Verzeichnis nicht existiert → erstellen
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Bild-Upload für bis zu 4 Bilder
for ($i = 1; $i <= 4; $i++) {
    $feld = 'bild' . $i;

    // Prüfen, ob Datei hochgeladen wurde
    if (
        isset($_FILES[$feld]) &&
        $_FILES[$feld]['error'] === UPLOAD_ERR_OK &&
        is_uploaded_file($_FILES[$feld]['tmp_name'])
    ) {
        // Dateiendung prüfen
        $extension = strtolower(pathinfo($_FILES[$feld]['name'], PATHINFO_EXTENSION));
        $erlaubteEndungen = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        // Nur erlaubte Bildformate akzeptieren
        if (in_array($extension, $erlaubteEndungen, true)) {

            // Zufälligen Dateinamen erzeugen
            $name = bin2hex(random_bytes(16)) . '.' . $extension;

            // Datei ins temp/-Verzeichnis verschieben
            if (move_uploaded_file($_FILES[$feld]['tmp_name'], $uploadDir . $name)) {
                $_SESSION[$feld] = $name; // Dateiname in Session speichern
            }
        }
    }
}

// Verbindung zur Datenbank herstellen
$pdo = new PDO(
    'mysql:host=mariadb;dbname=iii;charset=utf8',
    'azubi26',
    'Cucxe9-vyxxos'
);

// Abteilungs-IDs aus Session holen
$abteilungs_id = $_SESSION['abteilungs_id'] ?? null;

// Abteilungsnamen laden
$abteilungs_name = '';

if (!empty($abteilungs_id)) {

    // Platzhalter für SQL IN-Abfrage erzeugen
    $placeholders = implode(',', array_fill(0, count($abteilungs_id), '?'));

    // Abteilungsnamen anhand der IDs laden
    $stmt = $pdo->prepare("SELECT name FROM abteilung WHERE id IN ($placeholders)");
    $stmt->execute($abteilungs_id);

    // Alle Namen als Array holen
    $namen = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Zu einem String verbinden
    $abteilungs_name = implode(', ', $namen);
}

// Aktuelles Datum erzeugen
$now = new DateTime();
$now->format('Y-m-d');
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Vorschau</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Titel, Autor, Abteilung, Datum -->
<h1><?= htmlspecialchars($_SESSION['titel']) ?></h1>
<h3>Autor: <?= htmlspecialchars($_SESSION['autor']) ?></h3>
<h4>Abteilung: <?= htmlspecialchars($abteilungs_name) ?></h4>
<h3>Datum: <?= $now->format('d.m.Y') ?></h3>

<!-- Beschreibung -->
<p><?= nl2br(htmlspecialchars($_SESSION['beschreibung1'])) ?></p>

<?php
// Anzahl Bilder je nach Typ definieren
$bildCount = [
    'lo' => 1,
    'ro' => 2,
    'lu' => 3,
    'ru' => 4
][$typ] ?? 1;

// Bilder anzeigen
for ($i = 1; $i <= $bildCount; $i++) {
    if (!empty($_SESSION["bild$i"])) {
        echo '<img src="temp/' . htmlspecialchars($_SESSION["bild$i"]) . '" 
              style="width:100%; max-width:800px; margin-bottom:20px;">';
    }
}
?>

<!-- Speichern-Button -->
<form action="speichern.php" method="post" class="class-button">
    <button type="submit">Speichern</button>
</form>

<!-- Bearbeiten-Button -->
<form action="bearbeiten.php" method="post" class="class-button">
    <input type="hidden" name="typ" value="<?= htmlspecialchars($typ) ?>">
    <button type="submit">Bearbeiten</button>
</form>

</body>
</html>
