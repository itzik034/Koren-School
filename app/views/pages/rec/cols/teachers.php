<script src="assets/js/rec/cols/teachers.js" defer></script>

<div class="rc_row rc_title">מורים</div>

<div class="rc_scroll">
    <div class="rc_plus" id="add-teacher"><i class="fa-solid fa-plus"></i>&nbsp;הוספת מורה</div>
<?php 

include_once("../../../../config/connection.php");
include_once("../../../../helpers/function.php");

// Stop the script here if there is'nt course_id so the user won't get error
if(!isset($_GET['course_id']) || empty($_GET['course_id'])){ die('שגיאה בטעינת רשימת המורים'); }

$course_id = $_GET['course_id'];

function get_num_of_cls_of_tch($conn, $teacher_id)
{
    $sql = "SELECT * FROM classes_teachers WHERE teacher_id = '$teacher_id'";
    $query = mysqli_query($conn, $sql);
    return mysqli_num_rows($query);
}

// function is_teacher_learn_in_course($conn, $teacher_id, $course_id)
// {
//     $sql = "SELECT * FROM classes WHERE course_id = '$course_id'";
//     $query = mysqli_query($conn, $sql);
//     $ou = 0;
//     if(mysqli_num_rows($query) > 0)
//     {
//         while($row = mysqli_fetch_array($query))
//         {
//             $class_id = $row['id'];
//             $sql2 = "SELECT * FROM classes_teachers WHERE teacher_id = '$teacher_id' AND class_id = '$class_id'";
//             $query2 = mysqli_query($conn, $sql2);
//             if(mysqli_num_rows($query2) > 0)
//             {
//                 $ou .= 1;
//             }
//         }
//     }
//     if($ou > 0)
//     {
//         return true;
//     }
//     else
//     {
//         return false;
//     }
// }

// 1. Create table teacher_class and connect the edit teacher popup to it
// 2. Get all the classes that this teacher is learning
// 3. Check the course of those classes
// 4. If the teacher is learning a class from this course so print his box
//     =========     Now it print all the teachers. Use course_id to filter the teachers in this column.     =========     
//     =========     If the course_id is 0 or -1 so show all the teachers.     =========     


function teacher_in_classs($conn, $teacher_id, $class_id)
{
    $sql = "SELECT * FROM classes_teachers WHERE class_id = '$class_id' AND teacher_id = '$teacher_id'";
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

function teacher_in_course($conn, $teacher_id, $course_id)
{
    $output = 0;
    $sql1 = "SELECT * FROM classes WHERE course_id = '$course_id'";
    $query1 = mysqli_query($conn, $sql1);
    if(mysqli_num_rows($query1) > 0)
    {
        while($row = $query1 -> fetch_array())
        {
            if(teacher_in_classs($conn, $teacher_id, $row['id']))
            {
                $output .= 1;
            }
        }
    }
    if($output > 0){ return true; }else{ return false; }
}

$sql = "SELECT * FROM users WHERE rank = 't' AND `user-status` = 'active' ORDER BY id DESC";
$query = mysqli_query($conn, $sql);

if(mysqli_num_rows($query) > 0)
{
    $t_text = "";
    while($row = mysqli_fetch_array($query))
    {
        if(!teacher_in_course($conn, $row['id'], $course_id) && $course_id != '-1' && $course_id != '0'){ continue; }
        $pic_field = get_user_field($conn, $row['id'], 'user-pic');
        $profile_picture_url = $pic_field ? 'uploads/user_img/'.$pic_field : 'uploads/user_img/user.png';
        $profile_pic_html = '<img src="'.$profile_picture_url.'" class="tch_profile_pic" id="'.$row['id'].'" />';

        $t_text .= '<div class="rc_row" id="rcrow_id_' . $row['id'] . '">';
        $t_text .= '<div class="rc_row_pic">';
        $t_text .= $profile_pic_html;
        $t_text .= '</div>';
        $t_text .= '<div class="rc_row_text">';
        $t_text .= '<div class="edit-split">';
        $t_text .= '<div class="edit-click" id="' . $row['id'] . '">עריכה</div>';
        $t_text .= '<div class="delete-click delete-teacher" id="' . $row['id'] . '">מחיקה</div>';
        $t_text .= '</div>';
        $t_text .= '<div class="rc_row_text1 tch_name" id="'.$row['id'].'">';
        $t_text .= $row['user-first_name'];
        $t_text .= '&nbsp;';
        $t_text .= $row['user-last_name'];
        $t_text .= '</div>';
        $t_text .= '<div class="rc_row_text2">';
        $t_text .= '<div class="rc_text2_num" title="מספר הכיתות ש'.get_user_first_name($conn, $row['id']).' מלמד">';
        $t_text .= get_num_of_cls_of_tch($conn, $row['id']);
        $t_text .= '</div>';
        $t_text .= '<div class="rc_text2_prog dash_quiz_box_prog">';
        $t_text .= '<span class="rc_prog_inside tch_rc_prog_inside_'.$row['id'].'" id="'.$row['id'].'"></span>';
        $t_text .= '</div>';
        $t_text .= '</div>';
        $t_text .= '</div>';
        $t_text .= '</div>';
    }
    if($t_text == ""){echo "<span style='padding:10px;'>עדיין אין מורים בקורס הזה.</span>";}
}
else
{
    $t_text = "<span style='padding:10px;'>עדיין אין מורים.</span>";
}
echo $t_text;

?>

</div>