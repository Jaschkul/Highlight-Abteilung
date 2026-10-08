<?php
session_start();

$typ = $_POST['typ'] ?? $_GET['typ'] ?? $_SESSION['typ'] ?? null;
$_SESSION['typ'] = $typ;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['titel'] = $_POST['titel'] ?? $_SESSION['titel'] ?? '';
    $_SESSION['autor'] = $_POST['autor'] ?? $_SESSION['autor'] ?? '';
    $_SESSION['beschreibung1'] = $_POST['beschreibung1'] ?? $_SESSION['beschreibung1'] ?? '';
    $_SESSION['abteilungs_id'] = $_POST['abteilungs_id'] ?? $_SESSION['abteilungs_id'] ?? '';
}

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
        $extension = strtolower(
            pathinfo($_FILES[$feld]['name'], PATHINFO_EXTENSION)
        );

        $erlaubteEndungen = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($extension, $erlaubteEndungen, true)) {
            $name = bin2hex(random_bytes(16)) . '.' . $extension;

            if (move_uploaded_file($_FILES[$feld]['tmp_name'], $uploadDir . $name)) {
                $_SESSION[$feld] = $name;
            }
        }
    }
}
$pdo = new PDO(
    'mysql:host=mariadb;dbname=iii;charset=utf8',
    'azubi26',
    'Cucxe9-vyxxos'
);
$abteilungs_id = $_SESSION['abteilungs_id'] ?? null;

// Abteilungsname laden
$abteilungs_name = '';

if ($abteilungs_id) {
    $stmt = $pdo->prepare('SELECT name FROM abteilung WHERE id = ?');
    $stmt->execute([$abteilungs_id]);
    $abteilungs_name = $stmt->fetchColumn();
}

    // Aktuelles Datum und Uhrzeit erzeugen
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

<h1><?= htmlspecialchars($_SESSION['titel']) ?></h1>
<h3>Autor: <?= htmlspecialchars($_SESSION['autor']) ?></h3>
<h4>Abteilung: <?= htmlspecialchars($abteilungs_name) ?></h4>
<h3>Datum: <?= $now->format('d.m.Y') ?></h3>
<p><?= nl2br(htmlspecialchars($_SESSION['beschreibung1'])) ?></p>

<?php
// Anzahl Bilder je nach Typ
$bildCount = [
    'lo' => 1,
    'ro' => 2,
    'lu' => 3,
    'ru' => 4
][$typ] ?? 1;

for ($i = 1; $i <= $bildCount; $i++) {
    if (!empty($_SESSION["bild$i"])) {
        echo '<img src="temp/' . htmlspecialchars($_SESSION["bild$i"]) . '" 
              style="width:100%; max-width:800px; margin-bottom:20px;">';
    }
}
?>

<form action="speichern.php" method="post" class="class-button">
    <button type="submit">Speichern</button>
</form>


<form action="bearbeiten.php" method="post" class="class-button" >
    <input type="hidden" name="typ" value="<?= htmlspecialchars($typ) ?>">
    <button type="submit">Bearbeiten</button>
</form>



</body>
</html>
