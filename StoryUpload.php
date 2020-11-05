<?php

    //print_r($_FILES);
    //print_r($_POST);
    include_once "database_connect.php";
    $conn->set_charset("utf8");

    ini_set('upload_max_filesize', '64M');
    ini_set('max_execution_time', '300');
    ini_set('max_input_time', '120');
    ini_set('memory_limit', '128M');
    ini_set('post_max_size', '265M');
    
    if($_POST){

        $audio_dir  = "audios/";
        $images_dir = "images/";

        // create dirs
        if(!is_dir("audios")){
            $res = mkdir("audios",0777); 
        }

        if(!is_dir("images")){
            $res = mkdir("images",0777); 
        }

        $title = strip_tags($_POST['title']);
        $sql   = "INSERT INTO stories (title, published) VALUES ('$title', 0)";
        

        $total_audio = $_POST['total_audio'];
        $total_text  = $_POST['total_text'];

        if ($conn->query($sql) === TRUE) {
                        
            $story_id = $conn->insert_id;            

            if($total_text == $total_audio){
                
                for($i = 0; $i < $total_text ; $i++){

                    // make name for image 
                    $image_name = 'image_'.$i.'_'.date( 'Y-m-d-H-i-s' ) . basename($_FILES["image".($i+1)]["name"]);
                    // upload it to the dir
                    move_uploaded_file($_FILES["image".($i+1)]["tmp_name"], $images_dir.$image_name);    
                    
                    // upload audio
                    // pull the raw binary data from the POST array
                    $data = substr($_POST['audio'.($i+1)], strpos($_POST['audio'.($i+1)], ",") + 1);

                    // decode it
                    $decodedData = base64_decode($data);
                    $filename = 'audio_'.$i.'_recording_' . date( 'Y-m-d-H-i-s' ) .'.mp3';
                    
                    // write the data out to the file
                    $fp = fopen('audios/'.$filename, 'wb');
                    fwrite($fp, $decodedData);
                    fclose($fp);

                    $audio_name = $filename;
                    $body = $_POST['body'.($i+1)];
                    
                    // insert data to database
                    $sql = "INSERT INTO story_parts (story_id, body , image , audio) VALUES ($story_id, '$body' , '$image_name' , '$audio_name' )";
                    $conn->query($sql);

                }

            }else if($total_text > $total_audio){

                for($i = 0; $i < $total_text ; $i++){

                    // make name for image 
                    $image_name = 'image_'.$i.'_'.date( 'Y-m-d-H-i-s' ) . basename($_FILES["image".($i+1)]["name"]);
                    // upload it to the dir
                    move_uploaded_file($_FILES["image".($i+1)]["tmp_name"], $images_dir.$image_name);    
                    
                    if(($i+1) < $total_audio){

                        // upload audio
                        // pull the raw binary data from the POST array
                        $data = substr($_POST['audio'.($i+1)], strpos($_POST['audio'.($i+1)], ",") + 1);

                        // decode it
                        $decodedData = base64_decode($data);
                        $filename = 'audio_recording_' . date( 'Y-m-d-H-i-s' ) .'.mp3';
                        
                        // write the data out to the file
                        $fp = fopen('audios/'.$filename, 'wb');
                        fwrite($fp, $decodedData);
                        fclose($fp);

                        $audio_name = $filename;
                        $body = $_POST['body'.($i+1)];

                        // insert data to database
                        $sql = "INSERT INTO story_parts (story_id, body , image , audio) VALUES ($story_id, '$body' , '$image_name' , '$audio_name' )";
                        $conn->query($sql);

                    }else{

                        
                        $body = $_POST['body'.($i+1)];

                        // insert data to database
                        $sql = "INSERT INTO story_parts (story_id, body , image ) VALUES ($story_id, '$body' , '$image_name' )";
                        $conn->query($sql);

                    }
                    

                }

            }

            echo 1;
        }

        

    }
    
?>