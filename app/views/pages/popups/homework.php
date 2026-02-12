<link rel="stylesheet" href="assets/css/popups/homework.css">
<script src="assets/js/popups/homework.js"></script>

<?php

include_once("../../../config/connection.php");
include_once("../../../helpers/function.php");

if(!isset($_GET['class_id'])){ die("שגיאה"); }
$class_id = $_GET['class_id'];
$class_name = get_class_name_by_id($conn, $class_id);

if (session_status() === PHP_SESSION_NONE) { session_start(); }
$user_id = $_SESSION['user_id'];

$hwtc_html = '';

$sql = "SELECT * FROM quizzes WHERE quiz_status = 'publish'";
$query = mysqli_query($conn, $sql);
if(mysqli_num_rows($query) > 0)
{
    while($row = mysqli_fetch_array($query))
    {
        $my_id = $row['id'];

        // If the quiz is'nt of this teacher class so don't show it
        $my_class_id = get_class_by_quiz_id($conn, $my_id);
        if(!is_teacher_in_class($conn, $user_id, $my_class_id)){ continue; }

        $my_name = get_quiz_by_id($my_id, $conn);
        $checked = '';
        $sql2 = "SELECT * FROM homework WHERE class_id = '$my_class_id' AND quiz_id = '$my_id' LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        while($row2 = mysqli_fetch_array($query2))
        {
            if($row2['class_id'] == $my_class_id)
            {
                $checked = 'checked';
            }
        }
        $hwtc_html .= 
        '<div class="hwtc hwtc_'.$my_id.'" id="'.$my_id.'">
            <input type="checkbox" class="chck_hwtc_'.$my_id.'" '.$checked.'>
            <span>'.$my_name.'</span>
        </div>';
    }
}
else
{
    echo "אין עדיין כיתות";
}

?>

<input type="hidden" id="class_id" value="<?php echo $class_id; ?>">

<!--      hwtc = Home Work To Class      -->

<div class="hw_popup_fill">
    <div class="hw_popup">
        <div class="hwp_close_fill">
            <span class="close_hw_btn">סגור</span>
        </div>
        <div class="hwp_content">
            <h2>שיעורי בית לכיתה <?php echo $class_name; ?></h2>
            <div class="hwtc_fill">
                <?php echo $hwtc_html; ?>
            </div>
            <div class="hwtc_update_btn_fill">
                <button id="hwtc_update_btn">עדכון</button>
            </div>
        </div>
    </div>
</div>