<link rel="stylesheet" href="assets/css/quiz.css">
<script src="assets/js/quiz/quiz.js"></script>

<div class="rc_row rc_title">
    שאלונים
</div>
<div class="rc_scroll">
<?php 

include_once("../../../../../../config/connection.php");
include_once("../../../../../../helpers/function.php");

if(!isset($_GET['class_id']))
{
    die('error');
}

if (session_status() === PHP_SESSION_NONE) { session_start(); }
$user_id = $_SESSION['user_id'];
$class_id = $_GET['class_id'];

$sql = "SELECT * FROM quizzes WHERE `quiz_status` = 'publish' ORDER BY id DESC";
$query = mysqli_query($conn, $sql);

if(mysqli_num_rows($query) > 0)
{
    $q_text = "";

    while($row = mysqli_fetch_array($query))
    {
        $id = $row['id'];
        $sql2 = "SELECT * FROM homework WHERE class_id = '$class_id' AND quiz_id = '$id' AND hw_status = 'publish'";
        $query2 = mysqli_query($conn, $sql2);

        $class_id2 = get_class_by_quiz_id($conn, $id);
        if(!is_teacher_in_class($conn, $user_id, $class_id2))
        {
            // echo "Teacher: " . get_user_full_name($user_id) . " ~ Class: " . $class_id;
            continue;
        }

        $quiz_pic_field = get_quiz_pic($conn, $id);
        $quiz_pic = $quiz_pic_field ? 'uploads/quiz_img/'.$quiz_pic_field : 'uploads/quiz_img/default.png';
        $quiz_pic_html = '<img src="'.$quiz_pic.'">';

        $q_text .= '<div class="rc_row" id="rcrow_id_' . $row['id'] . '">';
        $q_text .= '<div class="rc_row_pic quiz_pic_fill">';
        $q_text .= $quiz_pic_html;
        $q_text .= '</div>';
        $q_text .= '<div class="rc_row_text">';
        $q_text .= '<div class="edit-split">';
        $q_text .= '</div>';
        $q_text .= '<div class="rc_row_text1 quiz_ttl quiz_ttl_' . $row['id'] . '" id="' . $row['id'] . '">';
        $q_text .= $row['quiz_name'];
        $q_text .= '</div>';
        $q_text .= '<div class="rc_row_text2">';
        $q_text .= '<div class="rc_text2_num std_ans_quiz_" title="ממוצע טעויות בשאלון">';
        $q_text .= get_mistakes_quiz($conn, $row['id']);
        $q_text .= '</div>';
        $q_text .= '<div class="rc_text2_prog dash_quiz_box_prog">';
        $q_text .= '<span class="rc_prog_inside"></span>';
        $q_text .= '</div>';
        $q_text .= '</div>';
        $q_text .= '</div>';
        $q_text .= '</div>';
    }
    if($q_text == ""){echo "<span style='padding:10px;'>עדיין אין שאלונים שמשוייכים לכיתה הזאת.</span>";}
}
else
{
    $q_text = "<span style='padding:10px;'>עדיין אין שאלונים.</span>";
}
echo $q_text;

?>
</div>