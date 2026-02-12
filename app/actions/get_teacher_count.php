<?php

include("connection.php");
$sql = "SELECT * FROM teachers";
$query = mysqli_query($conn, $sql);
$count = mysqli_num_rows($query);

echo $count;

?>