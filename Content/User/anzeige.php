<?php
// Seite alle 60 Sekunden neu laden
header("Refresh:60");
?>
<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Highlight Anzeige</title>
<h1> Highlights IT</h1>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png">
</head>
<body>

<div id="template">
    <div style="grid-area: titel;">
        <p id="titel"></p>
    </div>
    <div style="grid-area: beschreibung;">
        <p id="beschreibung"></p>
    </div>
    <div id="bild1" style="grid-area: bild1;"></div>
    <div id="bild2" style="grid-area: bild2;"></div>
    <div id="bild3" style="grid-area: bild3;"></div>
    <div id="bild4" style="grid-area: bild4;"></div>
</div>

<div class="template2">
    <div style = "grid-area: autor;">
        <p id="autor"></p>
    </div>
    <div style = "grid-area: abteilungen;">
        <p id="abteilung"></p>
    </div>
    <div style="grid-area: vorschauBtn;">
        <p id="erstellt_am"></p>
    </div>
</div>

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

// Datum Format: d-m-Y
const formatted =
    String(date.getDate()).padStart(2, "0") + "." +
    String(date.getMonth() + 1).padStart(2, "0") + "." +
    date.getFullYear();

    // Bilder anzeigen und zählen
    let bilderDiv = document.getElementById("bilder");
    bilderDiv.innerHTML = "";
    let anzahlBilder = 0; // Zähler für die Bilder starten

    for (let i = 1; i <= 5; i++) { //hier entspricht die Anzahl i dem Template 
        let bildDiv = document.getElementById("bild"+i);
        let key = "bild" + i; 
        if (h[key]) {
            let img = document.createElement("img"); //documents.getElementById("bild1")
            img.src = "/User/uploads/" + h[key];
            bildDiv.appendChild(img);

            anzahlBilder++;
        }
    }

    // Index erhöhen → nächstes Highlight
    index = (index + 1) % highlights.length;

 // Textfelder füllen hier ein switch einbauen
    document.getElementById("titel").innerText = h.titel;
    document.getElementById("beschreibung").innerText = h.beschreibung1;
    document.getElementById("autor").innerText = h.autor;
    document.getElementById("abteilung").innerText = h.abteilungen;
    document.getElementById("erstellt_am").innerText = formatted;
    document.getElementById("template").className = "d" + anzahlBilder;
}
// Start
loadHighlights();

// Automatischer Wechsel alle 6 Sekunden
setInterval(showHighlight, 6000);
</script>

</body>
</html>
