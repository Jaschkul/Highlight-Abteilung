<?php
session_start();

// Textdaten speichern
$_SESSION['titel'] = $_POST['titel'] ?? '';
$_SESSION['autor'] = $_POST['Autor'] ?? '';
$_SESSION['beschreibung1'] = $_POST['beschreibung1'] ?? '';
$_SESSION['abteilungs_id'] = $_POST['abteilungs_id'] ?? '';

$uploadDir = 'temp/';
$bilder = [];

for ($i = 1; $i <= 5; $i++) {
    $feld = 'bild' . $i;

    if (!empty($_FILES[$feld]['name'])) {
        $tmp = $_FILES[$feld]['tmp_name'];
        $name = time() . '_' . basename($_FILES[$feld]['name']);
        move_uploaded_file($tmp, $uploadDir . $name);
        $_SESSION[$feld] = $name;
        $bilder[$i] = $name;
    } else {
        $_SESSION[$feld] = null;
        $bilder[$i] = null;
    }
}
?>
    <h1><?= $_SESSION['titel'] ?></h1>
    <p><?= $_SESSION['beschreibung1'] ?></p>

    <?php
    for ($i = 1; $i <= 5; $i++) {
        if (!empty($bilder[$i])) {
            echo '<img src="temp/' . $bilder[$i] . '" style="width:100%; max-width:800px; margin-bottom:20px;">';
        }
    }
    ?>


    <a href="speichern.php">Speichern</a>
        <?php
        $typ = $_GET['typ'] ?? $_POST['typ'] ?? null;
        ?>
    <?php if ($typ): ?>
    <form action="bearbeiten.php" method="post">
        <input type="hidden" name="typ" value="<?= $typ ?>">
        <button>Bearbeiten</button>
    </form>
<?php endif; ?>
  

    
</body>
</html>