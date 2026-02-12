<script src="assets/js/rec/course_rb.js"></script>
<link rel="stylesheet" href="assets/css/rec/add_course.css">

<?php

include_once('../../../config/connection.php');

$sql = "SELECT * FROM courses WHERE course_status = 'deleted' ORDER BY id DESC";
$query = mysqli_query($conn, $sql);
$empty = "";

?>

<table class="course_rb_tbl">
    <tr class="course_rb_tfr">
        <th class="course_rb_col course_rb_fr_col">ID</th>
        <th class="course_rb_col course_rb_fr_col">שם הקורס</th>
        <th class="course_rb_col course_rb_fr_col">פעולה</th>
    </tr>
    <?php
    
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            ?>
            
            <tr class="course_rb_tr">
                <td class="course_rb_col"><?php echo $row['id']; ?></td>
                <td class="course_rb_col"><?php echo $row['course_name']; ?></td>
                <td class="course_rb_col">
                    <span class="course_rb_recycle course_rb_recycle_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">
                        שיחזור
                    </span>
                </td>
            </tr>

            <?php
        }
    }
    else
    {
        $empty = '<span style="font-size:30px;padding:15px;color:red;"> - אין שאלונים שנמחקו - </span>';
    }
    
    ?>
    
</table>

<?php echo $empty; ?>