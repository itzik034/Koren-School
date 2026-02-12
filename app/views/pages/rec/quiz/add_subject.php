<link rel="stylesheet" href="assets/css/quiz/add_subject.css">
<script src="assets/js/quiz/add_subject.js"></script>

<div class="add_subject_content">
    <div class="add_subject_tb">
        <h2>הוספת נושא</h2>
        <div class="subjects_rb">סל המיחזור</div>
    </div>
    <div class="add_subject_form_fill">
        <form method="post" id="add_subject_form">
            <div class="new_subject_name_fill">
                <label for="new_subject_name">שם הנושא</label>
                <input type="text" id="new_subject_name">
            </div>
            <div class="new_subject_select_quiz_fill">
                <label for="select_quiz">בחר שאלון</label>
                <select name="select_quiz" id="select_quiz"></select>
            </div>
            <div class="new_subject_select_bin_count_fill">
                <label for="select_bins">לכמה בינים לחלק?</label>
                <select name="select_bins" id="select_bins">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div>
            <input type="submit" value="צור נושא">
        </form>
    </div>

    <div class="sub_tbl_spacer"></div>

    <div class="sub_search_fill">
        <h2 class="sub_search_title">חיפוש בטבלה</h2>
        <form id="sub_search_form">
            <input type="text" class="sub_search_inputs" name="sub_search_value" id="sub_search_value">
            <button class="sub_search_inputs sub_search_btns" id="sub_search_reset">איפוס</button>
        </form>
        <span class="no_res_s"></span>
    </div>

    <table id="subs_table">
        <tr class="subt_first_row subt_row">
            <th class="subt_col subt_col_fr">ID</th>
            <th class="subt_col subt_col_fr">נושא</th>
            <th class="subt_col subt_col_fr">שאלון</th>
            <th class="subt_col subt_col_fr">מספר בינים</th>
            <th class="subt_col subt_col_fr">פעולה</th>
        </tr>
    </table>

</div>

<?php

if(isset($_GET['quiz_id']) && !empty($_GET['quiz_id']))
{
    $quiz_id = $_GET['quiz_id'];
    ?>
    <script>
        setTimeout(function()
        {
            var quiz_id = '<?php echo $quiz_id; ?>';
            $('#select_quiz option#'+quiz_id).prop('selected', true);
        }, 100);
    </script>
    <?php 
}

?>