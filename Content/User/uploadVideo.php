<?php

//in einem array speichern 
if(isset ($_POST["submit"]) && ($_FILES["my_video"])){
    $video_name = $_FILES['my_video']['name'];
    $tmp_name = $_FILES['my_video']['tmp_name'];
    $error = $_FILES['my_video']['error'];
     if ($error === 0) {
    	$video_ex = pathinfo($video_name, PATHINFO_EXTENSION);

    	//echo $video_ex;
    }
}

//ini datei ändern

?>