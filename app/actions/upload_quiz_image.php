<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['quiz_img']) && isset($_POST['quiz_id'])) 
{
    $random_number = rand(111111111, 999999999);
    function rnn(){ return rand(111111111, 999999999); }
    $quiz_id = $_POST['quiz_id'];
    $target_dir = "../uploads/quiz_img/";
    if(file_exists($target_dir . $random_number . ".png")){ $random_number = rnn(); }
    else{ $target_file = $target_dir . $random_number . '.png'; $file_name = $random_number . ".png"; }
    // $target_file = $target_dir . basename($_FILES["quiz_img"]["tmp_name"]) . '.png';
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $response = array();

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["quiz_img"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $response['status'] = 'error';
        $response['message'] = 'File is not an image.';
        echo json_encode($response);
        exit;
    }

    // Check file size
    if ($_FILES["quiz_img"]["size"] > 50000000000) {
        $response['status'] = 'error';
        $response['message'] = 'File is too large.';
        echo json_encode($response);
        exit;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $response['status'] = 'error';
        $response['message'] = 'Only jpg, jpeg, png & gif files are allowed.';
        echo json_encode($response);
        exit;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) 
    {
        $response['status'] = 'error';
        $response['message'] = 'File was not uploaded.';
    } 
    else 
    {
        if (move_uploaded_file($_FILES["quiz_img"]["tmp_name"], $target_file)) 
        {
            include_once("connection.php");
            $sql = "UPDATE quizzes SET `quiz_pic` = '$file_name' WHERE id = '$quiz_id'";
            mysqli_query($conn, $sql);
            $response['status'] = 'success';
            $response['filename'] = basename($target_file);
        } 
        else 
        {
            $response['status'] = 'error';
            $response['message'] = 'Failed to move uploaded file.';
        }
    }

    echo json_encode($response);
}
?>