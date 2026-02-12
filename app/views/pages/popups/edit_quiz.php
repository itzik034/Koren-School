<?php

include_once('../../../helpers/function.php');
include_once('../../../config/connection.php');

$quiz_id = $_GET['quiz_id'];

function get_courses_option_html($conn)
{
    $sql = "SELECT * FROM courses WHERE course_status = 'publish'";
    $query = mysqli_query($conn, $sql);
    echo '<select id="eqp_select_course" class="basic_field pointer">';
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $level_name = get_level_name($row['course_level']);
            echo '<option value="' . $row['id'] . '">' . $row['course_name'] . ' - ' . $level_name . '</option>';
        }
    }
    else
    {
        echo '<option value="0">אין קורסים עדיין</option>';
    }
    echo '</select>';
}

$current_quiz_name = '';
$sql1 = "SELECT * FROM quizzes WHERE id = '$quiz_id' LIMIT 1";
$query1 = mysqli_query($conn, $sql1);
if(mysqli_num_rows($query1) > 0)
{
    while($row = mysqli_fetch_array($query1))
    {
        $current_quiz_name = $row['quiz_name'];
    }
}

?>

<link rel="stylesheet" href="assets/css/popups/edit_quiz.css">
<script src="assets/js/popups/edit_quiz.js"></script>

<div class="edit_quiz_popup_fill">
    <div class="edit_quiz_popup">
        <div class="close_eqp_fill">
            <div class="close_eqp_btn close" id="close_eqp_btn">סגור</div>
        </div>
        <h2>עריכת השאלון "<?php echo get_quiz_by_id($quiz_id, $conn); ?>"</h2>
        <div class="eqp_form_fill">
            <form id="eqp_form">
                <input type="text" id="quiz_name_field" class="basic_field" value="<?php echo $current_quiz_name; ?>">
                <?php get_courses_option_html($conn); ?>
                <button id="eqp_form_submit" class="basic_field pointer">עדכון</button>
                <input type="hidden" id="quiz_id" value="<?php echo $quiz_id; ?>">
            </form>
        </div>
    </div>
</div>