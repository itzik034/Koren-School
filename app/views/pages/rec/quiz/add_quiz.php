<link rel="stylesheet" href="assets/css/quiz/add_quiz.css">
<script src="assets/js/quiz/add_quiz.js" defer></script>

<div class="add_quiz_content">
    <div class="add_quiz_form_fill">
        <div class="add_quiz_tb">
            <h2>הוספת שאלון</h2>
            <div class="quiz_rb">סל המיחזור</div>
        </div>
        <form method="post" id="add_quiz_form">
            <div class="new_quiz_name_fill">
                <label for="new_quiz_name">שם השאלון</label>
                <input type="text" id="new_quiz_name">
            </div>
            <div class="new_answear_select_course_fill">
                <label for="select_course">בחר קורס</label>
                <select name="select_course" id="select_course"></select>
            </div>
            <input type="submit" value="צור שאלון" id="create_quiz_button">
        </form>
    </div>
    
    <div class="quiz_tbl_spacer"></div>

    <div class="quiz_search_fill">
        <h2 class="quiz_search_title">חיפוש בטבלה</h2>
        <form id="quiz_search_form">
            <input type="text" class="quiz_search_inputs" name="quiz_search_value" id="quiz_search_value">
            <button class="quiz_search_inputs quiz_search_btns" id="quiz_search_reset">איפוס</button>
        </form>
        <span class="no_res_quiz"></span>
    </div>

    <div class="quiz_table_fill">
        <table id="quizzes_table">
            <tr class="quizt_first_row quizt_row">
                <th class="quizt_col quizt_col_fr">ID</th>
                <th class="quizt_col quizt_col_fr">שאלון</th>
                <th class="quizt_col quizt_col_fr">קורס</th>
                <th class="quizt_col quizt_col_fr">תמונה</th>
                <th class="quizt_col quizt_col_fr">פעולה</th>
            </tr>
        </table>
    </div>
</div>