<?php

include_once("connection.php");

$uploadDir = "../uploads/class_img/";

if ($_SERVER["REQUEST_METHOD"] === "POST") 
{
    $class_id = $_POST['class_id'];

    if (isset($_FILES["class_picture"]) && $_FILES["class_picture"]["error"] === 0) 
    {
        $fileTmpPath = $_FILES["class_picture"]["tmp_name"];
        $fileName = basename($_FILES["class_picture"]["name"]);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ["jpg", "jpeg", "png", "gif"];

        if (in_array($fileExt, $allowedExtensions)) 
        {
            $newFileName = uniqid("class_", true) . "." . $fileExt;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destination)) 
            {
                echo $newFileName;
                
                $sql = "UPDATE classes SET `class_pic` = '$newFileName' WHERE id = '$class_id'";
                mysqli_query($conn, $sql) or die('sql error');
            } 
            else 
            {
                echo "שגיאה בהעלאה";
            }
        } 
        else 
        {
            echo "סוג קובץ לא נתמך";
        }
    } 
    else 
    {
        echo "לא נבחר קובץ";
    }
}

?>
