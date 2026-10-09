<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="UTF-8">
<title>Highlight Anzeige</title>

<style>
button {
    padding: 10px 20px;
    margin: 10px;
    font-size: 18px;
}
img {
    width: 300px;
    border-radius: 10px;
    margin: 10px;
}
</style>

</head>
<body>

<h1 id="titel"></h1>
<h3 id="beschreibung"></h3>
<h3 id="autor"></h3>
<h3 id="abteilung"></h3>
<h3 id="erstellt_am"></h3>
<div id="bilder"></div>

<button class="class-button">⬅ Zurück</button>
<button class="class-button">➡ Weiter</button>
<button class="class-button">Löschen</button>

<script>
let highlights = [];
let index = 0;

async function loadHighlights() {
    const response = await fetch("/Highlights/highlights.php");
    highlights = await response.json();
    showHighlight();
}

function showHighlight() {
    if (highlights.length === 0) {
        document.body.innerHTML = "<h1>Keine Highlights vorhanden</h1>";
        return;
    }

    const h = highlights[index];

    document.getElementById("titel").innerText = h.titel;
    document.getElementById("beschreibung").innerText = h.beschreibung1;
    document.getElementById("autor").innerText = h.autor;
    document.getElementById("abteilung").innerText = h.abteilungen;
    document.getElementById("erstellt_am").innerText = h.erstellt_am;

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

function nextHighlight() {
    index = (index + 1) % highlights.length;
    showHighlight();
}

function prevHighlight() {
    index = (index - 1 + highlights.length) % highlights.length;
    showHighlight();
}

async function deleteHighlight() {
    const id = highlights[index].id;

    const response = await fetch("delete.php?id=" + id);
    const result = await response.text();

    alert(result);

    // Eintrag aus Array entfernen
    highlights.splice(index, 1);

    // Falls letzter Eintrag gelöscht wurde
    if (index >= highlights.length) {
        index = 0;
    }

    showHighlight();
}

loadHighlights();
</script>

</body>
</html>
