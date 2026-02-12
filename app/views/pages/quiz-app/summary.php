<?php

include_once("../../../config/connection.php");
include_once("../../../helpers/function.php");

$sub_id = $_GET['sub_id'];

$sql = "SELECT * FROM subjects WHERE id = '$sub_id'";
$query = mysqli_query($conn, $sql);

$sub_exp = '';
$sub_img = '';
$sub_vid = '';

if(mysqli_num_rows($query) > 0)
{
    while($row = $query -> fetch_array())
    {
        $sub_exp = $row['sub_text'];
        $sub_img = $row['sub_img'];
        $sub_vid = $row['sub_video'];
    }
}

?>

<link rel="stylesheet" href="assets/css/quiz-app/summary.css">
<script src="assets/js/quiz-app/summary.js"></script>



<div class="sum_fill">
    <div class="sum_title_fill">
        <h2>הסבר על הנושא</h2>
    </div>

    <div class="sum_vid_fill">
        <?php echo $sub_vid; ?>
    </div>

    <div class="sum_summary_fill">
        <?php echo $sub_exp; ?>
    </div>
    
</div>

<div class="close_sum_btn_fill">
    <button id="close_exp_card">סגור הסבר</button>
</div>
