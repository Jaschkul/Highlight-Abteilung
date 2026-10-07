<?php
session_start();

// Textdaten übernehmen
$_SESSION['titel'] = $_POST['titel'] ?? $_SESSION['titel'] ?? '';
$_SESSION['autor'] = $_POST['Autor'] ?? $_SESSION['autor'] ?? '';
$_SESSION['beschreibung1'] = $_POST['beschreibung1'] ?? $_SESSION['beschreibung1'] ?? '';
$_SESSION['abteilungs_id'] = $_POST['abteilungs_id'] ?? $_SESSION['abteilungs_id'] ?? '';

$typ = $_POST['typ'] ?? $_GET['typ'] ?? null;

// Bilder speichern / übernehmen
$uploadDir = 'temp/';
$bilder = [];

for ($i = 1; $i <= 5; $i++) {
    $feld = "bild$i";

    // Neues Bild hochgeladen?
    if (!empty($_FILES[$feld]['name'])) {
        $tmp = $_FILES[$feld]['tmp_name'];
        $name = time() . "_" . basename($_FILES[$feld]['name']);
        move_uploaded_file($tmp, $uploadDir . $name);

        $_SESSION[$feld] = $name;
        $bilder[$i] = $name;
    } else {
        // Bereits vorhandenes Bild aus Session
        $bilder[$i] = $_SESSION[$feld] ?? null;
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Vorschau</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1><?= htmlspecialchars($_SESSION['titel']) ?></h1>
<h3>Autor: <?= htmlspecialchars($_SESSION['autor']) ?></h3>
<h4>Abteilung: <?= htmlspecialchars($_SESSION['abteilungs_id']) ?></h4>

<p><?= nl2br(htmlspecialchars($_SESSION['beschreibung1'])) ?></p>

<hr>

<?php
// Anzahl Bilder je nach Typ
$bildCount = [
    'lo' => 1,
    'ro' => 1,
    'lu' => 2,
    'ru' => 5
][$typ] ?? 1;

for ($i = 1; $i <= $bildCount; $i++) {
    if (!empty($bilder[$i])) {
        echo '<img src="temp/' . htmlspecialchars($bilder[$i]) . '" 
              style="width:100%; max-width:800px; margin-bottom:20px;">';
    }
}
?>

<hr>

<a href="speichern.php" class="btn">Speichern</a>

<form action="bearbeiten.php" method="post" style="margin-top:20px;">
    <input type="hidden" name="typ" value="<?= htmlspecialchars($typ) ?>">
    <button type="submit">Bearbeiten</button>
</form>

<a href="index.html" class="btn">Zurück</a>

</body>
</html>
