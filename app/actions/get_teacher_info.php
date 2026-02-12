<?php

include("connection.php");
$id = $_GET['t_id'];

$sql = "SELECT * FROM teachers WHERE id = '$id'";
$query = mysqli_query($conn, $sql);

if(mysqli_num_rows($query) >= 0)
{
    while($row = mysqli_fetch_array($query))
    {
        echo '
                <div class="team-pic-fill">
                <img src="assets/img/teachers/' . $row['pic'] . '" class="team-pics">
                <span>' . $row['name'] .'</span>
                </div>
            ';

    }
}
else
{
    echo "<h1>* עדיין לא עודכנה רשימת המורים *</h1>";
}

?>