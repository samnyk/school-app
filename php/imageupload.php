<?php

if ( !empty( $_FILES ) ) {
    $file_name = $_FILES['file']['name'];
    $file_temp = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_basename=basename($_FILES['file']['name']) ;

    $dir = '../uploads/';
    $final_dir = $dir.$file_basename;

    move_uploaded_file($file_temp,$final_dir);


    $done = array();
    $done['img'] = 'uploads/'.$file_name;

    echo $done['img'];
} else {
    return 'no files found';
}

