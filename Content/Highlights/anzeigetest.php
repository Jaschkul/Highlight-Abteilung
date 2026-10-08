<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Highlight Anzeige</title>



</head>
<body>

<h1 id="titel"></h1>
<h3 id="beschreibung"></h3>
<h3 id="autor"></h3>
<h3 id="abteilung"></h3>
<h3 id="erstellt_am"></h3>
<div id="bilder"></div>

<script>
let highlights = [];
let index = 0;

async function loadHighlights() {
    const response = await fetch("highlights.php");
    highlights = await response.json();
    showHighlight();
}

function showHighlight() {
    if (highlights.length === 0) return;

    const h = highlights[index];

    document.getElementById("titel").innerText = h.titel;
    document.getElementById("beschreibung").innerText = h.beschreibung1;

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

    // Nächstes Highlight nach 60 Sekunden
    index = (index + 1) % highlights.length;
}

// Start
loadHighlights();

// Automatischer Wechsel alle 60 Sekunden
setInterval(showHighlight, 6000);
</script>

</body>
</html>
