<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Admin Seite</title>
<link rel="stylesheet" href="style.css">
<link rel="icon" type="image/png" href="favicon.png">
<h1> Admin Seite </h1>
</head>
<body>

<!-- Bereiche für die Highlight-Daten -->
<div id="template">
    <div style="grid-area: titel;">
        <h1 id="titel"></h1>
    </div>
    <div style="grid-area: beschreibung;">
        <p id="beschreibung"></p>
    </div>
    <div id="bild1" style="grid-area: bild1;"></div>
    <div id="bild2" style="grid-area: bild2;"></div>
    <div id="bild3" style="grid-area: bild3;"></div>
    <div id="bild4" style="grid-area: bild4;"></div>
</div>

<div class="template3">
    <div style = "grid-area: autor;">
        <p id="autor"></p>
        <button class="backBtn" onclick="prevHighlight()">⬅ zurück</button>
    </div>
    <div style = "grid-area: abteilungen;">
        <p id="abteilung"></p>
        <button class="delete" onclick="deleteHighlight()">Löschen</button>
    </div>
    <div style="grid-area: datum;">
        <p id="erstellt_am"></p>
        
        <button class= "vorschaBtn" onclick="nextHighlight()">weiter ➡</button>
    </div>
</div>



<script>
let highlights = [];
let index = 0;

// Highlights laden
async function loadHighlights() {
    const response = await fetch("/User/highlights.php");
    highlights = await response.json();
    showHighlight();
}

// Highlight anzeigen
function showHighlight() {
    if (highlights.length === 0) {
        document.body.innerHTML = "<h1>Keine Highlights vorhanden</h1>";
        return;
    }

    const h = highlights[index];
    // Datum Format: d-m-Y
    const date = new Date(h.erstellt_am);
    const formatted =
        String(date.getDate()).padStart(2, "0") + "." +
        String(date.getMonth() + 1).padStart(2, "0") + "." +
        date.getFullYear();
  let anzahlBilder = 0; // Zähler für die Bilder starten

    for (let i = 1; i <= 5; i++) { //hier entspricht die Anzahl i dem Template 
        let bildDiv = document.getElementById("bild"+i);
        let key = "bild" + i; 
        if (bildDiv) {
        // Vorherigen Inhalt (altes Bild) löschen
        bildDiv.innerHTML = "";
        if (h[key]) {
            let img = document.createElement("img"); //documents.getElementById("bild1")
            img.src = "/User/uploads/" + h[key];
            bildDiv.appendChild(img);

            anzahlBilder++;
        }}
    }

    document.getElementById("titel").innerText = h.titel;
    document.getElementById("beschreibung").innerText = h.beschreibung1;
    document.getElementById("autor").innerText = "@" + h.autor;
    document.getElementById("abteilung").innerText = "Abteilung: " + h.abteilungen;
    document.getElementById("erstellt_am").innerText = "erstellt am " + formatted;
    document.getElementById("template").className = "d" + anzahlBilder;
}

// Weiter
function nextHighlight() {
    index = (index + 1) % highlights.length;
    showHighlight();
}

// Zurück
function prevHighlight() {
    index = (index - 1 + highlights.length) % highlights.length;
    showHighlight();
}

// Löschen
async function deleteHighlight() {
    const id = highlights[index].id;

    const response = await fetch("delete.php?id=" + id);
    const result = await response.text();

    alert(result);

    // Eintrag entfernen
    highlights.splice(index, 1);

    if (index >= highlights.length) {
        index = 0;
    }

    showHighlight();
}

loadHighlights();
</script>

</body>
</html>
<?php include("footer.php");?>
