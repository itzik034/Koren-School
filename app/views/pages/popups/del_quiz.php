<link rel="stylesheet" href="assets/css/popups/del_quiz.css">
<script src="assets/js/popups/del_quiz.js"></script>

<?php 

include_once("../../../config/connection.php");
include_once("../../../helpers/function.php");

$quiz_id = $_GET['quiz_id'];
$quiz_name = get_quiz_by_id($quiz_id, $conn);

?>

<input type="hidden" id="quiz_id" value="<?php echo $quiz_id; ?>">

<div class="del_quiz_popup_fill">
    <div class="del_quiz_popup">
        <div class="del_text">
            האם למחוק את <?php echo $quiz_name; ?>?
        </div>
        <div class="del_select">
            <div class="ds_option1"><i class="fa-solid fa-circle-check"></i> &nbsp; כן</div>
            <div class="ds_option2"><i class="fa-solid fa-circle-xmark"></i> &nbsp; לא</div>
        </div>
    </div>
</div>