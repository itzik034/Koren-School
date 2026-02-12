<script src="assets/js/quiz/que_rb.js"></script>

<?php

include_once('../../../../config/connection.php');

$sql = "SELECT * FROM questions WHERE que_status = 'deleted' ORDER BY id DESC";
$query = mysqli_query($conn, $sql) or die('שגיאה במשיכת השאלות');

?>

<table class="que_rb_tbl">
    <tr class="que_rb_tfr">
        <th class="que_rb_col que_rb_fr_col">ID</th>
        <th class="que_rb_col que_rb_fr_col">שאלה</th>
        <th class="que_rb_col que_rb_fr_col">פעולה</th>
    </tr>
    <?php
    
    if(mysqli_num_rows($query) > 0)
    {
        while($row = mysqli_fetch_array($query))
        {
            ?>
            
            <tr class="que_rb_tr">
                <td class="que_rb_col"><?php echo $row['id']; ?></td>
                <td class="que_rb_col"><?php echo $row['que_text']; ?></td>
                <td class="que_rb_col">
                    <span class="que_rb_recycle que_rb_recycle_<?php echo $row['id']; ?>" id="<?php echo $row['id']; ?>">
                        שיחזור
                    </span>
                </td>
            </tr>

            <?php
        }
    }
    else
    {
        echo '<span style="font-size:30px;padding:15px;color:red;"> - אין שאלות שנמחקו - </span>';
    }
    
    ?>
    
</table>