<?php session_start(); // Session starten, um Daten zwischenzuspeichern

// Typ laden: GET → POST → Session
$typ = $_GET['typ'] ?? $_POST['typ'] ?? $_SESSION['typ'] ?? null;

if ($typ !== null) {
    $_SESSION['typ'] = $typ; // Typ in Session speichern
}



//in einem array speichern 
if(isset ($_POST["submit"]) && ($_FILES["my_video"])){
    $video_name = $_FILES['my_video']['name'];
    $tmp_name = $_FILES['my_video']['tmp_name']; // das ist der temporäre Name /tmp/phpKGHBca
    $error = $_FILES['my_video']['error'];
     
    //print_r($_FILES["my_video"]);
    if ($error === 0) {
    	$video_ex = pathinfo($video_name, PATHINFO_EXTENSION); //zeigt .mp4 zum Beispiel
        $video_ex_lc = strtolower($video_ex); //in Kleinbuchstaben
        $allowed_exs = array("mp4", 'webm', 'avi', 'flv'); //was sind die gültigen Formate
    	//echo $video_ex;
        if (in_array($video_ex_lc, $allowed_exs)) {
            $new_video_name = uniqid("video-", true). '.'.$video_ex_lc; //das video bekommt einen einzugartigen neuen Namen 
    		$video_upload_path = __DIR__ . '/temp/' .$new_video_name; // wo speichere ich es? 
    		move_uploaded_file($tmp_name, $video_upload_path); //filename und destination dateiname und ziel 

             $_SESSION[$tmp_name] = $new_video_name; // gespeichert 
    }
}
}
//ini datei ändern
// Datenbankverbindung
$pdo = new PDO(
    'mysql:host=mariadb;dbname=iii;charset=utf8',
    'azubi26',
    'Cucxe9-vyxxos'
);

?>

