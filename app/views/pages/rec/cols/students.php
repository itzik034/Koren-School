<div class="rc_row rc_title">תלמידים</div>
<div class="rc_scroll">
    <div class="rc_plus" id="add-student"><i class="fa-solid fa-plus"></i>&nbsp;הוספת תלמיד</div>
<?php 

include_once("../../../../config/connection.php");
include_once("../../../../helpers/function.php");

$course_id = $_GET['course_id'];

function student_in_class($conn, $student_id, $class_id)
{
    $sql = "SELECT * FROM classes_students WHERE class_id = '$class_id' AND student_id = '$student_id'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function student_in_course($conn, $student_id, $course_id)
{
    $output = 0;
    $sql1 = "SELECT * FROM classes WHERE course_id = '$course_id'";
    $query1 = mysqli_query($conn, $sql1);
    if(mysqli_num_rows($query1) > 0)
    {
        while($row = $query1 -> fetch_array())
        {
            if(student_in_class($conn, $student_id, $row['id']))
            {
                $output .= 1;
            }
        }
    }
    if($output > 0){ return true; }else{ return false; }
}

function get_undone_quizzes($conn, $student_id)
{
    $student_quizzes = [];
    $undone_quizzes = 0;
    $sql1 = "SELECT * FROM classes_students WHERE student_id = '$student_id'";
    $query1 = mysqli_query($conn, $sql1);
    if(mysqli_num_rows($query1) > 0)
    {
        while($row = $query1 -> fetch_array())
        {
            $class_id = $row['class_id'];
            $sql2 = "SELECT * FROM homework WHERE hw_status = 'publish' AND class_id = '$class_id'";
            $query2 = mysqli_query($conn, $sql2);
            while($row2 = $query2 -> fetch_array())
            {
                array_push($student_quizzes, $row2['quiz_id']);
            }
        }
    }
    
    foreach ($student_quizzes as $quiz_id) 
    {
        $sql3 = "SELECT * FROM user_quiz_run WHERE quiz_id = '$quiz_id' AND user_id = '$student_id' LIMIT 1";
        $query3 = mysqli_query($conn, $sql3);
        if(mysqli_num_rows($query3) > 0)
        {
            while($row3 = $query3 -> fetch_assoc())
            {
                if($row3['run_status'] != 'end'){ $undone_quizzes += 1; }
            }
            
        }
        else
        {
            return 0;
        }
    }

    return $undone_quizzes;
}

$sql3 = "SELECT * FROM users WHERE rank = 's' AND `user-status` = 'active' ORDER BY id DESC";
$query3 = mysqli_query($conn, $sql3);

if(mysqli_num_rows($query3) > 0)
{
    $s_text = "";
    while($row = mysqli_fetch_array($query3))
    {
        $student_id = $row['id'];
        $pic_field = get_user_field($conn, $row['id'], 'user-pic');
        $profile_picture_url = $pic_field ? 'uploads/user_img/'.$pic_field : 'uploads/user_img/user.png';
        $profile_pic_html = '<img src="'.$profile_picture_url.'" class="std_profile_pic" />';
        $undone_quizzes = get_undone_quizzes($conn, $student_id);
        
        if(!student_in_course($conn, $student_id, $course_id) && $course_id != '-1' && $course_id != '0'){ continue; }
        
        $s_text .= '<div class="rc_row" id="rcrow_id_' . $row['id'] . '">';
        $s_text .= '<div class="rc_row_pic">';
        $s_text .= $profile_pic_html;
        $s_text .= '</div>';
        $s_text .= '<div class="rc_row_text">';
        $s_text .= '<div class="edit-split">';
        $s_text .= '<div class="edit-click-student" id="' . $row['id'] . '">עריכה</div>';
        $s_text .= '<div class="delete-click delete-student" id="' . $row['id'] . '">מחיקה</div>';
        $s_text .= '</div>';
        $s_text .= '<div class="rc_row_text1">';
        $s_text .= $row['user-first_name'];
        $s_text .= '&nbsp;';
        $s_text .= $row['user-last_name'];
        $s_text .= '</div>';
        $s_text .= '<div class="rc_row_text2">';
        $s_text .= '<div class="rc_text2_num">';
        $s_text .= $undone_quizzes;
        $s_text .= '</div>';
        $s_text .= '<div class="rc_text2_prog dash_quiz_box_prog">';
        $s_text .= '<span class="rc_prog_inside"></span>';
        $s_text .= '</div>';
        $s_text .= '</div>';
        $s_text .= '</div>';
        $s_text .= '</div>';
    }
    if($s_text == ""){ echo "<span style='padding:10px;'>עדיין אין תלמידים בקורס הזה.</span>"; }
}
else
{
    $s_text = "<span style='padding:10px;'>עדיין אין תלמידים.</span>";
}
echo $s_text;

?>
</div>