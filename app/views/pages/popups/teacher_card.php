<link rel="stylesheet" href="assets/css/popups/teacher_card.css">
<script src="assets/js/popups/teacher_card.js"></script>

<?php 

include_once("../../../config/connection.php");
include_once("../../../helpers/function.php");

$tch_id = $_GET['tch_id'];

$t_pic = get_user_pic($conn, $tch_id);
$pic_url = $t_pic ? 'uploads/user_img/'.$t_pic : 'uploads/user_img/user.png';

$sql1 = "SELECT * FROM classes_teachers WHERE teacher_id = '$tch_id'";
$query1 = mysqli_query($conn, $sql1);
$num_of_classes = mysqli_num_rows($query1);

$total_students = 0;
while($row = mysqli_fetch_assoc($query1))
{
    $class_id = $row['class_id'];
    $sql2 = "SELECT * FROM classes_students WHERE class_id = '$class_id'";
    $query2 = mysqli_query($conn, $sql2);
    while ( $row2 = mysqli_fetch_assoc($query2) ){ $total_students += 1; }
}

?>

<div class="tch_card_filllll">
    <div class="teacher_card_fill">
        <div class="cls_tch_crd_fill">
            <div class="close_tch_card">סגירה</div>
            <span class="tc_et_edit_btn" id="<?php echo $tch_id; ?>">עריכה</span>
        </div>

        <split>
            <right>
                <img src="<?php echo $pic_url; ?>" class="tch_card_pic" />
            </right>
            <left>
                <span class="full_name">
                    <b>שם מלא: </b>
                    <?php echo get_user_full_name($conn, $tch_id); ?>
                </span>
                <span class="full_name">
                    <b>מספר תלמידים: </b>
                    <?php echo $total_students; ?>
                </span>
                <span class="full_name">
                    <b>מספר כיתות: </b>
                    <?php echo $num_of_classes; ?>
                </span>
            </left>
        </split>
    </div>
</div>