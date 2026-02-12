<link rel="stylesheet" href="assets/css/quiz/add_question.css">
<script src="assets/js/quiz/add_question.js"></script>

<div class="add_question_content">
    <div class="add_question_form_fill">
        <h2>הוספת שאלה</h2>
        <form method="post" id="add_que_form" class="add_que_form">
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
            <div class="new_question_name_fill">
                <label for="new_question_name">תוכן השאלה</label>
                <input type="text" id="new_question_name">
            </div>
            <input type="submit" value="צור שאלה">
        </form>
    </div>

    <div class="add_question_list"></div>
</div>