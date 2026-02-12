<script src="assets/js/rec/classes.js"></script>

<div class="rc_row rc_title">
    כיתות
</div>
<div class="rc_scroll">
    <div class="rc_plus" id="add_class"><i class="fa-solid fa-plus" aria-hidden="true"></i>&nbsp;הוספת כיתה</div>

<?php 

function get_num_of_std_in_cls($conn, $class_id)
{
    $sql = "SELECT * FROM classes_students WHERE class_id = '$class_id'";
    $query = mysqli_query($conn, $sql);
    return mysqli_num_rows($query);
}

include_once('app/config/connection.php');
include_once('app/helpers/function.php');

$sql9 = "SELECT * FROM classes WHERE class_status = 'publish' ORDER BY id DESC";
$query9 = mysqli_query($conn, $sql9);

if(mysqli_num_rows($query9) > 0)
{
    $c_text = "";

    while($row = mysqli_fetch_array($query9))
    {
        // Prints class box in dashboard

        $class_pic_field = $row['class_pic'];
        $class_pic = $class_pic_field ? 'uploads/class_img/'.$class_pic_field : 'uploads/class_img/default.png';
        $class_pic_html = '<img src="'.$class_pic.'">';

        $c_text .= '<div class="rc_row" id="rcrow_id_' . $row['id'] . '">';
        $c_text .= '<div class="rc_row_pic rc_class_pic">';
        $c_text .= $class_pic_html;
        $c_text .= '</div>';
        $c_text .= '<div class="rc_row_text">';
        $c_text .= '<div class="edit-split">';
        $c_text .= '<div class="edit-click-class edit_class_'.$row['id'].'" id="' . $row['id'] . '">עריכה</div>';
        $c_text .= '<div class="delete-click delete-class del_class_' . $row['id'] . '" id="' . $row['id'] . '">מחיקה</div>';
        $c_text .= '</div>';
        $c_text .= '<div class="rc_row_text1">';
        $c_text .= $row['class_text'];
        $c_text .= '</div>';
        $c_text .= '<div class="rc_row_text2">';
        $c_text .= '<div class="rc_text2_num" title="מספר התלמידים בכיתה">';
        $c_text .= get_num_of_std_in_cls($conn, $row['id']);
        $c_text .= '</div>';
        $c_text .= '<div class="rc_text2_prog dash_quiz_box_prog">';
        $c_text .= '<span class="rc_prog_inside"></span>';
        $c_text .= '</div>';
        $c_text .= '</div>';
        $c_text .= '</div>';
        $c_text .= '</div>';
    }
}
else
{
    $c_text = "<span style='padding:10px;'>עדיין אין כיתות.</span>";
}

echo $c_text;

?>

</div>