<?php

include_once "database_connect.php";

// get more info from 
// https://www.w3schools.com/php/php_file_upload.asp

$uploadOk = 0;

function upload_image($target_file){
    $uploadOk = 1;

    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["image"]["tmp_name"]);
      if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        //echo "File is not an image.";
        $uploadOk = 0;
      }
    }
    
    // Check if file already exists
    /*if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }*/
    
    // Check file size
    if ($_FILES["image"]["size"] > 900000) {
        echo "الصورة حجمها كبير, لايمكنك رفع صورة كبيرة الحجم </br>";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif") {
        //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        echo "الرجاء رفع صورة صحيحة </br>";
        $uploadOk = 0;
    }

    if($uploadOk){
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
            $uploadOk = 1;
        }else{
            $uploadOk = 0;
        }
    }
    

    return $uploadOk;

}

function upload_image2($target_file){
    $uploadOk = 1;

    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["image2"]["tmp_name"]);
      if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        //echo "File is not an image.";
        $uploadOk = 0;
      }
    }
    
    // Check if file already exists
    /*if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }*/
    
    // Check file size
    if ($_FILES["image2"]["size"] > 900000) {
        echo "الصورة حجمها كبير, لايمكنك رفع صورة كبيرة الحجم </br>";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"&& $imageFileType != "gif") {
        //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        echo "الرجاء رفع صورة صحيحة </br>";
        $uploadOk = 0;
    }

    if($uploadOk){
        if (move_uploaded_file($_FILES["image2"]["tmp_name"], $target_file)){
            $uploadOk = 1;
        }else{
            $uploadOk = 0;
        }
    }
    

    return $uploadOk;

}

function upload_audio($audio_target_file){
    $uploadOk = 1;

    $audioFileType = strtolower(pathinfo($audio_target_file,PATHINFO_EXTENSION));
        
    // Check file size
    if ($_FILES["audio"]["size"] > 20000000) {
        echo "حجم الملف الصوتي كبير</br>";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if ($audioFileType != "ogg" && $audioFileType != "mp4" && $audioFileType != "mp3" && $audioFileType != "oga" && $audioFileType != "opus" && $audioFileType != "wav" && $audioFileType != "wma") {
        //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        echo "الرجاء رفع صيغة صوت صحيحة!</br>";
        $uploadOk = 0;
    }

    if($uploadOk){
        if (move_uploaded_file($_FILES["audio"]["tmp_name"], $audio_target_file)){
            $uploadOk = 1;
        }else{
            $uploadOk = 0;
        }
    }
    
    return $uploadOk;

}

if($_POST){

    if(empty($_POST['title'])){
        echo "الرجاء كتابة عنوان القصة, جاري الرجوع خلال 5 ثواني";
        //header('Refresh:5; url=http://localhost/story/add_story.html');
        exit;
    }

    if(empty($_POST['body'])){
        echo "الرجاء كتابة الجزء الاول من القصة";
        //header('Refresh:5; url=http://localhost/story/add_story.html');
        exit;
    }

    if(empty($_POST['body2'])){
        echo "الرجاء كتابة الجزء الثاني  من القصة";
        //header('Refresh:5; url=http://localhost/story/add_story.html');
        exit;
    }

    $audio_dir  = "audios/";
    $target_dir = "images/";

    $audio_file_name = "";
    $image_file_name = "";
    $image_file_name2= "";

    $audio_upload = 0;
    $image_upload = 0;
    $image2_upload = 0;

    // upload images
    if($_FILES["image"]['size'] > 0){
        $image_file_name = 'image1_' . date( 'Y-m-d-H-i-s' ) . basename($_FILES["image"]["name"]);
        $image_target_file = $target_dir . $image_file_name; // basename($_FILES["image"]["name"]);
        $image_upload = upload_image($image_target_file);
    }

    if($_FILES["image2"]['size'] > 0){
        $image_file_name2 = 'image2_' . date( 'Y-m-d-H-i-s' ) .basename($_FILES["image2"]["name"]);
        $image_target_file = $target_dir . $image_file_name2;// basename($_FILES["image2"]["name"]);
        $image2_upload = upload_image2($image_target_file);
    }

    
    // upload audio 
    if(!is_dir("recordings")){
        $res = mkdir("recordings",0777); 
    }

    if(!empty($_POST['audio'])){

        // pull the raw binary data from the POST array
        $data = substr($_POST['audio'], strpos($_POST['audio'], ",") + 1);

        // decode it
        $decodedData = base64_decode($data);
        $filename = 'audio_recording_' . date( 'Y-m-d-H-i-s' ) .'.mp3';

        
        // write the data out to the file
        $fp = fopen('recordings/'.$filename, 'wb');
        fwrite($fp, $decodedData);
        fclose($fp);

        $audio_file_name = $filename;

    }

    /*if($_FILES["audio"]['size'] > 0){
        $image_file_name = basename($_FILES["audio"]["name"]);
        $audio_target_file = $audio_dir . basename($_FILES["audio"]["name"]);
        $audio_upload = upload_audio($audio_target_file);
    }*/

    $title =  strip_tags($_POST['title']);
    $body  =  strip_tags($_POST['body']);
    $body2 =  strip_tags($_POST['body2']);

    $sql = "INSERT INTO stories (title, body, body2, photo , photo2, audio, published) VALUES ('$title', '$body' , '$body2', '$image_file_name' , '$image_file_name2', '$audio_file_name' , 0)";

    if ($conn->query($sql) === TRUE) {
        //echo "تمت إضافة القصة بنجاح, جاري الرجوع للرئيسية</br>";
        echo 1;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    header('Refresh:5; url=http://localhost/story');

    
}


?>