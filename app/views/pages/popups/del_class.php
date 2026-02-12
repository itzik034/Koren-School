<link rel="stylesheet" href="assets/css/popups/del_quiz.css">
<script src="assets/js/popups/del_class.js"></script>

<?php 

include_once("../../../config/connection.php");
include_once("../../../helpers/function.php");

$class_id = $_GET['class_id'];
$class_name = get_class_name_by_id($conn, $class_id);

?>

<input type="hidden" id="class_id" value="<?php echo $class_id; ?>">

<div class="del_quiz_popup_fill">
    <div class="del_quiz_popup">
        <div class="del_text">
            האם למחוק את <?php echo $class_name; ?>?
        </div>
        <div class="del_select">
            <div class="ds_option1"><i class="fa-solid fa-circle-check"></i> &nbsp; כן</div>
            <div class="ds_option2"><i class="fa-solid fa-circle-xmark"></i> &nbsp; לא</div>
        </div>
    </div>
</div>