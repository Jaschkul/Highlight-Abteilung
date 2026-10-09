<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Admin Seite</title>
<link rel="stylesheet" href="/User/style.css">
</head>
<body>

<!-- Bereiche für die Highlight-Daten -->
<h1 id="titel"></h1>
<h3 id="beschreibung"></h3>
<h3 id="autor"></h3>
<h3 id="abteilung"></h3>
<h3 id="erstellt_am"></h3>
<div id="bilder"></div>

<!-- Navigation -->
<button class="class-button" onclick="prevHighlight()">⬅ Zurück</button>
<button class="class-button" onclick="nextHighlight()">➡ Weiter</button>
<button class="class-button" onclick="deleteHighlight()">Löschen</button>

<script>
let highlights = [];
let index = 0;

// Highlights laden
async function loadHighlights() {
    const response = await fetch("/Highlights/highlights.php");
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

    document.getElementById("titel").innerText = h.titel;
    document.getElementById("beschreibung").innerText = h.beschreibung1;
    document.getElementById("autor").innerText = h.autor;
    document.getElementById("abteilung").innerText = h.abteilungen;
    document.getElementById("erstellt_am").innerText = formatted;

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
