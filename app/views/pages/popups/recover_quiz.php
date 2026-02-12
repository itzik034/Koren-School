<?php

include_once("../../../config/connection.php");

if(!isset($_GET['quiz_id']) || empty($_GET['quiz_id'])){ die('error'); }

$quiz_id = $_GET['quiz_id'];

$sql = "UPDATE quizzes SET `quiz_status` = 'publish' WHERE id = '$quiz_id'";
mysqli_query($conn, $sql) or die("error");
return '1';

?>