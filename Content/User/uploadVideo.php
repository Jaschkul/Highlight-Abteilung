<?php

//in einem array speichern 
if(isset ($_POST["submit"]) && ($_FILES["my_video"])){
    $video_name = $_FILES['my_video']['name'];
    $tmp_name = $_FILES['my_video']['tmp_name'];
    $error = $_FILES['my_video']['error'];
     
    //print_r($_FILES["my_video"]);
    /*if ($error === 0) {
    	$video_ex = pathinfo($video_name, PATHINFO_EXTENSION); //zeigt .mp4 zum Beispiel
        $video_ex_lc = strtolower($video_ex); //in Kleinbuchstaben
        $allowed_exs = array("mp4", 'webm', 'avi', 'flv'); //was sind die gültigen Formate
    	//echo $video_ex;
        if (in_array($video_ex_lc, $allowed_exs)) {
            $new_video_name = uniqid("video-", true). '.'.$video_ex_lc; //das video bekommt einen einzugartigen neuen Namen 
    		$video_upload_path = 'uploads/'.$new_video_name; // wo speichere ich es? 
    		move_uploaded_file($tmp_name, $video_upload_path);
    }*/
}
//}
//ini datei ändern

?>