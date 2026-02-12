<div class="rc_row rc_title">מורים</div>
<div class="rc_scroll">
    <div class="rc_plus" id="add-teacher"><i class="fa-solid fa-plus"></i>&nbsp;הוספת מורה</div>
<?php 

function get_num_of_cls_of_tch($conn, $teacher_id)
{
    $sql = "SELECT * FROM classes_teachers WHERE teacher_id = '$teacher_id'";
    $query = mysqli_query($conn, $sql);
    return mysqli_num_rows($query);
}

$sql2 = "SELECT * FROM users WHERE `rank` = 't' AND `user-status` = 'active' ORDER BY id DESC";
$query2 = mysqli_query($conn, $sql2);
if(mysqli_num_rows($query2) > 0)
{
    $t_text = "";
    while($row = mysqli_fetch_array($query2))
    {
        if($row['user-status'] == 'active')
        {
            $t_text .= '<div class="rc_row" id="rcrow_id_' . $row['id'] . '">';
            $t_text .= '<div class="rc_row_pic">';
            $t_text .= '<img src="uploads/user_img/user.png">';
            $t_text .= '</div>';
            $t_text .= '<div class="rc_row_text">';
            $t_text .= '<div class="edit-split">';
            $t_text .= '<div class="edit-click" id="' . $row['id'] . '">עריכה</div>';
            $t_text .= '<div class="delete-click delete-teacher" id="' . $row['id'] . '">מחיקה</div>';
            $t_text .= '</div>';
            $t_text .= '<div class="rc_row_text1">';
            $t_text .= $row['user-first_name'];
            $t_text .= '&nbsp;';
            $t_text .= $row['user-last_name'];
            $t_text .= '</div>';
            $t_text .= '<div class="rc_row_text2">';
            $t_text .= '<div class="rc_text2_num">';
            $t_text .= get_num_of_cls_of_tch($conn, $row['id']);
            $t_text .= '</div>';
            $t_text .= '<div class="rc_text2_prog dash_quiz_box_prog">';
            $t_text .= '<span class="rc_prog_inside"></span>';
            $t_text .= '</div>';
            $t_text .= '</div>';
            $t_text .= '</div>';
            $t_text .= '</div>';
        }
    }
}
else
{
    $t_text = "<span style='padding:10px;'>עדיין אין מורים.</span>";
}
echo $t_text;

?>
</div>