<?php  

$que_id = $_GET['que_id'];
$sub_id = $_GET['sub_id'];
echo '<input type="hidden" value="' . $que_id . '" id="que_id">';
echo '<input type="hidden" value="' . $sub_id . '" id="sub_id">';

?>

<script src="assets/js/quiz/edit_question.js"></script>
<link rel="stylesheet" href="assets/css/quiz/edit_question.css">

<div class="back_btn_fill_edit_que">
    <a id="back_to_que_mana">&lt;&nbsp;חזור</a>
</div>

<div id="edit_que_content">
    <form id="edit_que_form">
        <input type="text" id="edit_que_que_text" placeholder="תוכן השאלה">
        <input type="submit" value="עדכון">
    </form>
</div>