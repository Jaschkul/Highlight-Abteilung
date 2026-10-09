<?php
// Seite alle 60 Sekunden neu laden
header("Refresh:60");
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Highlight Anzeige</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Bereiche für die Highlight-Daten -->
<h1 id="titel"></h1>
<h3 id="beschreibung"></h3>
<h3 id="autor"></h3>
<h3 id="abteilung"></h3>
<h3 id="erstellt_am"></h3>
<div id="bilder"></div>

<script>
// Array für alle Highlights
let highlights = [];
let index = 0;

// Highlights aus der Datenbank laden
async function loadHighlights() {
    const response = await fetch("highlights.php");
    highlights = await response.json();
    showHighlight(); // erstes Highlight anzeigen
}

// Ein Highlight anzeigen
function showHighlight() {
    if (highlights.length === 0) return;

    const h = highlights[index];
    const date = new Date(h.erstellt_am);

// Datum Format: Y-m-d
const formatted =
    date.getFullYear() + "-" +
    String(date.getMonth() + 1).padStart(2, "0") + "-" +
    String(date.getDate()).padStart(2, "0");




    // Textfelder füllen
    document.getElementById("titel").innerText = h.titel;
    document.getElementById("beschreibung").innerText = h.beschreibung1;
    document.getElementById("autor").innerText = h.autor;
    document.getElementById("abteilung").innerText = h.abteilungen;
    document.getElementById("erstellt_am").innerText = formatted;

    // Bilder anzeigen
    let bilderDiv = document.getElementById("bilder");
    bilderDiv.innerHTML = "";

    for (let i = 1; i <= 5; i++) {
        let key = "bild" + i;
        if (h[key]) {
            let img = document.createElement("img");
            img.src = "/User/uploads/" + h[key];
            bilderDiv.appendChild(img);
        }
    }

    // Index erhöhen → nächstes Highlight
    index = (index + 1) % highlights.length;
}

// Start
loadHighlights();

// Automatischer Wechsel alle 6 Sekunden
setInterval(showHighlight, 6000);
</script>

</body>
</html>
