<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internes Intranet IT</title>
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Wähle ein Template aus</h1>
    
    
    <form action="bearbeiten.php" method="post">
    <div class="gridContainer">
        
        <!-- d0 -->
          <div><button class="d0" id="btn0" type="submit" name="typ" value="btn0">
                <div class="titel" style = "grid-area: titel;">
                    <p>Titel</p>
                </div>
                <div class="beschreibung" style = "grid-area: beschreibung;">
                    <p>Beschreibung</p>
                </div>
                
            </button></div> 

        <!-- links oben-->
            <div><button class="d1" id="btnlo" type="submit" name="typ" value="lo">
                <div class="titel" style = "grid-area: titel;">
                    <p>Titel</p>
                </div>
                <div class= "bild1" style = "grid-area: bild1;"> <p>Bild</p>
                </div>
                <div class="beschreibung" style = "grid-area: beschreibung;">
                    <p>Beschreibung</p>
                </div>
                
            </button></div> 
        <!-- rechts oben-->

            <div><button class="d2" id="btnro" type="submit" name="typ" value="ro">
               <div class="titel" style = "grid-area: titel;"> 
                     <p>Titel</p>
                </div>
                <div class= "bild1" style = "grid-area: bild1;"> <p>Bild</p>
                </div>
                <div class= "bild2" style = "grid-area: bild2;"> <p>Bild</p>
                </div>
                <div class="beschreibung" style = "grid-area: beschreibung;">
                    <p>Beschreibung</p>
                </div>
                
            </button></div>
       
        <!--links unten-->

            <div><button class="d3" id="btnlu" type="submit" name="typ" value="lu">
                  <div class="titel" style = "grid-area: titel;">
                     <p>Titel</p>
                </div>
                <div class= "bild1" style = "grid-area: bild1;"> <p>Bild</p>
                </div>
                <div class= "bild2" style = "grid-area: bild2;"> <p>Bild</p>
                </div>
                <div class= "bild3" style = "grid-area: bild3;"> <p>Bild</p>
                </div>
                <div class="beschreibung" style = "grid-area: beschreibung;">
                    <p>Beschreibung</p>
                </div>
                
            </button></div>
      
        <!--rechts unten-->
        
            <div><button class="d4" id="btnru" type="submit" name="typ" value="ru">
                <div class="titel" style = "grid-area: titel;">
                     <p>Titel</p>
                </div>
                <div class= "bild1" style = "grid-area: bild1;"><p>Bild</p>
                </div>
                <div class= "bild2" style = "grid-area: bild2;"> <p>Bild</p>
                </div>
                <div class= "bild3" style = "grid-area: bild3;"> <p>Bild</p>
                </div>
                <div class= "bild4" style = "grid-area: bild4;"> <p>Bild</p>
                </div>
                <div class="beschreibung" style = "grid-area: beschreibung;">
                    <p>Beschreibung</p>
                </div>
                
                
            </button></div>
            <!--d weitere-->

            <div>
                <a href="video.php">
                <button class="dW" type="button">
                <div style = "grid-area: titel;">
                    <p> Video </p>
                </div>
            </button></a>
        </div> 
    </div>
<!--
<a href="zielseite.php">
    <button type="button">Zur nächsten PHP-Datei</button>
</a>
-->

    </form>
   
</body>
</html>
<?php include("footer.php");?>