<link rel="stylesheet" href="assets/css/quiz/add_question.css">
<script src="assets/js/quiz/add_question.js"></script>
<link rel="stylesheet" href="assets/css/quiz/add_answear.css">
<script src="assets/js/quiz/add_answear.js"></script>

<div class="add_answear_content">
    <div class="add_answear_form_fill">
        <div class="add_que_tb">
            <h2>ניהול שאלות ותשובות</h2>
            <div class="que_rb">סל המיחזור</div>
        </div>
        <div class="sec_spl">
            <form method="post" id="add_que_form" class="add_que_form_2">
                <div class="que_mang_split_top">
                    <div class="new_question_select_quiz_fill">
                        <label for="new_question_select_quiz">בחר שאלון</label>
                        <select name="new_question_select_quiz" id="new_question_select_quiz">
                            <option value="0">כל השאלונים</option>
                        </select>
                    </div>
                    <div class="new_question_select_sub_fill">
                        <label for="select_sub">בחר נושא</label>
                        <select name="select_sub" id="select-sub"></select>
                    </div>
                    <div class="new_question_select_bin_fill">
                        <label for="select_bin">בחר בין</label>
                        <select name="select_bin" id="select_bin">
                            <option value="">---</option>
                        </select>
                    </div>
                </div>
                <div class="que_mang_split_bottom">
                    <div class="new_question_name_fill">
                        <label for="new_question_name">הוספת שאלה</label>
                        <input type="text" id="new_question_name">
                    </div>
                    <input type="submit" value="צור שאלה">
                </div>
            </form>
            <div class="qna_mn_split_right">
                <form method="post" id="add_ans_form">
                    <h2>הוספת תשובות</h2>
                    <div class="add_ans_split_top">
                        <div class="select_question_fill">
                            <label for="select_quest">שאלה</label>
                            <select name="select_quest" id="select_quest">
                                <option value="0">אין שאלות בבין זה</option>
                            </select>
                            <span id="scrl_to_top_btn_fill"><span id="scrl_to_top_btn"><i class="fa-solid fa-circle-arrow-up"></i></span></span>
                        </div>
                    </div>
                    <div class="add_ans_split_bottom">
                        <div class="new_answear_name_fill ans1">
                            <label for="new_answear_name">תשובה נכונה</label>
                            <input type="text" id="new_answear_0">
                        </div>
                        <div class="ans_inco_split">
                            <div class="ans_inco_split_right">
                                <div class="new_answear_name_fill ans2">
                                    <label for="new_answear_name">תשובה לא נכונה 1</label>
                                    <input type="text" id="new_answear_1">
                                </div>
                                <div class="new_answear_name_fill ans2">
                                    <label for="new_answear_name">תשובה לא נכונה 2</label>
                                    <input type="text" id="new_answear_2">
                                </div>
                                <div class="new_answear_name_fill ans2">
                                    <label for="new_answear_name">תשובה לא נכונה 3</label>
                                    <input type="text" id="new_answear_3">
                                </div>
                            </div>
                            <div class="ans_inco_split_left">
                                <div class="new_answear_name_fill ans2">
                                    <label for="new_answear_name">תשובה לא נכונה 4</label>
                                    <input type="text" id="new_answear_4">
                                </div>
                                <div class="new_answear_name_fill ans2">
                                    <label for="new_answear_name">תשובה לא נכונה 5</label>
                                    <input type="text" id="new_answear_5">
                                </div>
                                <div class="new_answear_name_fill ans2">
                                    <label for="new_answear_name">תשובה לא נכונה 6</label>
                                    <input type="text" id="new_answear_6">
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="עדכון תשובות">
                    </div>
                </form>
            </div>
        </div>
        
        <div class="que_tbl_spacer"></div>

        <div class="que_search_fill">
            <h2 class="que_search_title">חיפוש בטבלה</h2>
            <form id="que_search_form">
                <input type="text" class="que_search_inputs" id="que_search_value">
                <button class="que_search_inputs que_search_btns" id="que_search_reset">איפוס</button>
            </form>
            <span class="no_res_q"></span>
        </div>

        <div class="qna_mn_split">
            <div class="qna_mn_split_left">
                <table id="ques_table">
                    <tr class="qet_row qet_first_row">
                        <th class="qet_col qet_fr_col">ID</th>
                        <th class="qet_col qet_fr_col">שאלה</th>
                        <th class="qet_col qet_fr_col">נושא</th>
                        <th class="qet_col qet_fr_col">בין</th>
                        <th class="qet_col qet_fr_col">סרטון</th>
                        <th class="qet_col qet_fr_col">תמונה</th>
                        <th class="qet_col qet_fr_col">פעולה</th>
                    </tr>
                </table>

                <div class="pagination_fill">
                    <div class="previous_page">&lt;</div>
                    <div class="page_nums_fill">
                        <div class="pg active">1</div>
                    </div>
                    <div class="next_page">&gt;</div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<?php

if(isset($_GET['sub_id']) && !empty($_GET['sub_id']))
{
    $sub_id = $_GET['sub_id'];
    ?>
    <script>
        setTimeout(function()
        {
            var sub_id = '<?php echo $sub_id; ?>';
            
            $("#select-sub option#"+sub_id).prop('selected', true);
            update_the_bins_list(sub_id, function()
            {
                var slct_bin_id = $("#select_bin").val();
                load_que_list_by_bin(sub_id, slct_bin_id, function(response)
                {
                    $("#select_quest").html(response);
                });
            });
        }, 400);
    </script>
    <?php 
}
if(isset($_GET['que_id']) && !empty($_GET['que_id']))
{
    $que_id = $_GET['que_id'];
    ?>
    <script>
        setTimeout(function()
        {
            var que_id = '<?php echo $que_id; ?>';
            
            add_ans_update_ques_list(function(response)
            {
                $("#select_quest").html(response);
                $("#select_quest option#"+que_id).prop('selected', true);
                alert(que_id);
            });
        }, 800);
    </script>
    <?php 
}

?>