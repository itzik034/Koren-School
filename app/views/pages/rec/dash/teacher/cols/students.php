<div class="rc_row rc_title">התלמידים שלי</div>
<div class="rc_scroll">
    
<?php 

if (session_status() === PHP_SESSION_NONE) 
{
    session_start();
}

function check_student_teacher($conn, $student_id, $teacher_id)
{
    $sql = "SELECT class_id FROM classes_teachers WHERE teacher_id = '$teacher_id'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            $class_id = $row[0];
            $sql2 = "SELECT student_id FROM classes_students WHERE class_id = '$class_id'";
            $query2 = mysqli_query($conn, $sql2);
            if(mysqli_num_rows($query2) > 0)
            {
                while($row2 = mysqli_fetch_array($query2))
                {
                    if($student_id == $row2[0])
                    {
                        return true;
                    }
                }
            }
        }
    }
    return false;
}

if(!isset($_GET['class_id'])){ die("Error"); }

$user_id = $_SESSION['user_id'];
$class_id = $_GET['class_id'];

include_once("../../../../../../config/connection.php");
include_once("../../../../../../helpers/function.php");

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
        
        if($class_id == '-1' || $class_id == '')
        {
            if(check_student_teacher($conn, $student_id, $user_id))
            {
                $s_text .= '<div class="rc_row" id="rcrow_id_' . $row['id'] . '">';
                $s_text .= '<div class="rc_row_pic">';
                $s_text .= $profile_pic_html;
                $s_text .= '</div>';
                $s_text .= '<div class="rc_row_text">';
                $s_text .= '<div class="edit-split">';
                $s_text .= '</div>';
                $s_text .= '<div class="rc_row_text1">';
                $s_text .= $row['user-first_name'];
                $s_text .= '&nbsp;';
                $s_text .= $row['user-last_name'];
                $s_text .= '</div>';
                $s_text .= '<div class="rc_row_text2">';
                $s_text .= '<div class="rc_text2_num">';
                $s_text .= '&nbsp;';
                $s_text .= '</div>';
                $s_text .= '<div class="rc_text2_prog dash_quiz_box_prog std_prog_in_tch_dash_'+$student_id+'">';
                $s_text .= '<span class="rc_prog_inside"></span>';
                $s_text .= '</div>';
                $s_text .= '</div>';
                $s_text .= '</div>';
                $s_text .= '</div>';
            }
        }
        else
        {
            if(check_student_teacher($conn, $student_id, $user_id) && is_student_in_class($conn, $student_id, $class_id))
            {
                $s_text .= '<div class="rc_row" id="rcrow_id_' . $row['id'] . '">';
                $s_text .= '<div class="rc_row_pic">';
                $s_text .= $profile_pic_html;
                $s_text .= '</div>';
                $s_text .= '<div class="rc_row_text">';
                $s_text .= '<div class="edit-split">';
                $s_text .= '</div>';
                $s_text .= '<div class="rc_row_text1">';
                $s_text .= $row['user-first_name'];
                $s_text .= '&nbsp;';
                $s_text .= $row['user-last_name'];
                $s_text .= '</div>';
                $s_text .= '<div class="rc_row_text2">';
                $s_text .= '<div class="rc_text2_num">';
                $s_text .= '&nbsp;';
                $s_text .= '</div>';
                $s_text .= '<div class="rc_text2_prog dash_quiz_box_prog">';
                $s_text .= '<span class="rc_prog_inside"></span>';
                $s_text .= '</div>';
                $s_text .= '</div>';
                $s_text .= '</div>';
                $s_text .= '</div>';
            }
        }
    }
    if($s_text == "")
    {
        echo "<span style='padding:10px;'>עדיין אין תלמידים בכיתה.</span>";
    }
}
else
{
    $s_text = "<span style='padding:10px;'>עדיין אין תלמידים.</span>";
}
echo $s_text;

?>
</div>