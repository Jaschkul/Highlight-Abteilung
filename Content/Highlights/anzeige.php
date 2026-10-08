<?php

header("Refresh:1");
echo date('H:i:s Y-m-d'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anzeige</title>
</head>
<body>
    
    
</body>
</html>

<?php




$host = "mariadb";
$user = "azubi26";
$pass = "Cucxe9-vyxxos";
$db   = "iii";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

    

      

      foreach ($tables as $table) {
        echo "<h3>Tabelle: $table</h3>";

        // Daten abrufen
        $stmt = $pdo->query("SELECT * FROM `$table`");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            echo "<i>Keine Daten vorhanden.</i><br><br>";
            continue;
        }

        echo "<table border='1' cellpadding='5' cellspacing='0' style='margin-bottom:20px;'>";

        // Spaltenüberschriften
        echo "<tr>";
        foreach (array_keys($rows[0]) as $col) {
            echo "<th>$col</th>";
        }
        echo "</tr>";

        // Datenzeilen
        foreach ($rows as $row) {
            echo "<tr>";
            foreach ($row as $col => $value) {

                // Bildfelder automatisch erkennen
                if (preg_match('/bild[1-5]/', $col) && !empty($value)) {
                    echo "<td><img src='/User/uploads/$value' style='width:150px; border-radius:8px;'></td>";
                } else {
                    echo "<td>" . htmlspecialchars($value ?? '') . "</td>";
                }
            }
            echo "</tr>";
        }

        echo "</table>";
    }
}

catch (PDOException $e) {
    echo "❌ Fehler: " . $e->getMessage();
}
?>
