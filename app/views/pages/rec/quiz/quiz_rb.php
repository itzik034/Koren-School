<script src="assets/js/quiz/quiz_rb.js"></script>

<?php

include_once('../../../../config/connection.php');

$sql = "SELECT * FROM quizzes WHERE quiz_status = 'deleted' ORDER BY id DESC";
$query = mysqli_query($conn, $sql);
$empty = "";

?>

<table class="quiz_rb_tbl">
    <tr class="quiz_rb_tfr">
        <th class="quiz_rb_col quiz_rb_fr_col">ID</th>
        <th class="quiz_rb_col quiz_rb_fr_col">שם השאלון</th>
        <th class="quiz_rb_col quiz_rb_fr_col">פעולה</th>
    </tr>
    <?php
    
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            ?>
            
            <tr class="quiz_rb_tr">
                <td class="quiz_rb_col"><?php echo $row['id']; ?></td>
                <td class="quiz_rb_col"><?php echo $row['quiz_name']; ?></td>
                <td class="quiz_rb_col">
                    <span class="quiz_rb_recycle quiz_rb_recycle_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">
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