<script src="assets/js/quiz/sub_rb.js"></script>
<link rel="stylesheet" href="assets/css/quiz/add_subject.css">

<?php

include_once('../../../../config/connection.php');

$sql = "SELECT * FROM subjects WHERE sub_status = 'deleted'";
$query = mysqli_query($conn, $sql);
$empty = "";

?>

<table class="subject_rb_tbl">
    <tr class="subject_rb_tfr">
        <th class="subject_rb_col subject_rb_fr_col">ID</th>
        <th class="subject_rb_col subject_rb_fr_col">שם הנושא</th>
        <th class="subject_rb_col subject_rb_fr_col">פעולה</th>
    </tr>
    <?php
    
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            ?>
            
            <tr class="subject_rb_tr">
                <td class="subject_rb_col"><?php echo $row['id']; ?></td>
                <td class="subject_rb_col"><?php echo $row['sub_name']; ?></td>
                <td class="subject_rb_col">
                    <span class="subject_rb_recycle subject_rb_recycle_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">
                        שיחזור
                    </span>
                </td>
            </tr>

            <?php
        }
    }
    else
    {
        $empty = '<span style="font-size:30px;padding:15px;color:red;"> - אין נושאים שנמחקו - </span>';
    }
    
    ?>
    
</table>

<?php echo $empty; ?>