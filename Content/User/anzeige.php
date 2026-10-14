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

<!-- Bereiche für die Highlight-Daten -->

<!--
durch die Anzahl der Bilder haben wir das ausgewählte Template
idee hier mit einem switch zu arbeiten
-->
<div id="template">
    <div style="grid-area: titel;">
        <p id="titel"></p>
    </div>
    <div style="grid-area: beschreibung;">
        <p id="beschreibung"></p>
    </div>
    <div id="b1"> 
        <div id="bild1"></div>
    </div>
    <div id="b2"> 
        <div id="bild1"></div>
        <div id="bild2"></div>
    </div>
    <div id="b3"> 
        <div id="bild1"></div>
        <div id="bild2"></div>
        <div id="bild3"></div>
    </div>
    <div id="b4"> 
        <div id="bild1"></div>
        <div id="bild2"></div>
        <div id="bild3"></div>
        <div id="bild4"></div>
    </div>
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
        let key = "bild" + i; 
        if (h[key]) {
            let img = document.createElement("img"); //documents.getElementById("bild1")
            img.src = "/User/uploads/" + h[key];
            bilderDiv.appendChild(img);

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
    document.getElementById("b1").style.cssText=`grid-area: bild1`;
    document.getElementById("b2").style.cssText=`grid-area: bild2`;
    document.getElementById("b3").style.cssText=`grid-area: bild3`;
    document.getElementById("b4").style.cssText=`grid-area: bild4`;
    switch(anzahlBilder){
        case 1:
            document.getElementById("b2").remove();
            document.getElementById("b3").remove();
            document.getElementById("b4").remove();
            break;
        case 2:
            document.getElementById("b3").remove();
            document.getElementById("b4").remove();
            break;
        case 3:
            document.getElementById("b4").remove();
            break;
        default:
    }
    
    
   

}
// Start
loadHighlights();

// Automatischer Wechsel alle 6 Sekunden
setInterval(showHighlight, 6000);
</script>

</body>
</html>
