<?php
session_start(); // Session starten

// Session leeren
$_SESSION = [];

// Session vollständig zerstören
session_destroy();

// Zurück zur Startseite
header('Location: index.html');
exit; // Skript beenden – alles danach darf NICHT mehr existieren!
