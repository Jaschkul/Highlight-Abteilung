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
<link rel="icon" type="image/png" href="favicon.png">
</head>
<body>

<!-- Bereiche für die Highlight-Daten -->

<!--durch die Anzahl der Bilder haben wir das ausgewählte Template--> 

<h1 id="titel"></h1>
<h3 id="beschreibung"></h3>
<h3 id="autor"></h3>
<h3 id="abteilung"></h3>
<h3 id="erstellt_am"></h3>
<h3 id="template_info"></h3> 
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
        let key = "bild" + i;
        if (h[key]) {
            let img = document.createElement("img");
            img.src = "/User/uploads/" + h[key];
            bilderDiv.appendChild(img);

            anzahlBilder++;
        }
    }

    // Index erhöhen → nächstes Highlight
    index = (index + 1) % highlights.length;

 // Textfelder füllen
    document.getElementById("titel").innerText = h.titel;
    document.getElementById("beschreibung").innerText = h.beschreibung1;
    document.getElementById("autor").innerText = h.autor;
    document.getElementById("abteilung").innerText = h.abteilungen;
    document.getElementById("erstellt_am").innerText = formatted;
    document.getElementById("template_info").innerText = "Template-Typ: " + anzahlBilder + " Bilder";
}
// Start
loadHighlights();

// Automatischer Wechsel alle 6 Sekunden
setInterval(showHighlight, 6000);
</script>

</body>
</html>
