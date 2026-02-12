<div class="std_cls_lst_top_bar">
    <?php 

    session_start();
    $user_id = $_SESSION['user_id'];
    include_once("../../../../../helpers/function.php");
    include_once("../../../../../config/connection.php");

    $sql1 = "SELECT * FROM classes_students WHERE student_id = '$user_id' ORDER BY id DESC";
    $query1 = mysqli_query($conn, $sql1);
    if(mysqli_num_rows($query1) > 0)
    {
        echo '<span class="slct_cls slct_cls_0 chosen" id="0">כל הכיתות שלי</span>';
        while($row1 = $query1 -> fetch_array())
        {
            $cls_id = $row1['class_id'];
            $cls_name = get_class_name_by_id($conn, $cls_id);
            echo "<span class='slct_cls slct_cls_{$cls_id}' id='{$cls_id}'>{$cls_name}</span>";
        }
    }
    else
    {
        echo "אין לך כיתות עדיין.";
    }
    
    ?>
</div>