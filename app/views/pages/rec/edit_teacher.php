<link rel="stylesheet" href="assets/css/rec/edit_teacher.css">
<script src="assets/js/popups/edit_teacher.js"></script>
<?php include_once('../../../helpers/function.php'); ?>
<?php include_once('../../../config/connection.php'); ?>
<?php

$t_id = $_GET['teacher_id'];
if($t_id == '0'){ die('לא נבחר מורה'); }

?>

<div class="etd_content_fill">
    <div class="teacher_name_fill">
        <span>עריכת המורה <?php echo get_teacher_name_by_id($conn, $_GET['teacher_id']); ?></span>
    </div>
    <div class="cl_to_tch_fill et_div_main">
        <input type="hidden" id="teacher_id" value="<?php echo $_GET['teacher_id']; ?>">
        <div class="cls_to_tch_ttl_fill">
            <h1>כיתות של המורה</h1>
        </div>
        <div class="tchcls_spl_fill">
            <div class="add_cls_to_tch_fill">
                <h2>הוספת כיתות למורה</h2>
                <div class="actt_fill"></div>
                <button id="update_checked_classes_btn" class="basic_field pointer">עדכון</button>
            </div>
            <div class="create_cls_to_tch_fill">
                <div class="cctt_title_fill">
                    <h2>יצירת כיתה למורה</h2>
                </div>
                <div class="cctt_fill">
                    <form id="cctt_form">
                        <label>שם הכיתה</label>
                        <input type="text" class="cctt_frm_inputs" id="cctt_name" placeholder="שם הכיתה">
                        <label>בחר קורס</label>
                        <select id="cctt_crs" class="cctt_frm_inputs">
                            <option value="0">בחר קורס...</option>
                        </select>
                        <label>מיקום הכיתה</label>
                        <input type="text" class="cctt_frm_inputs" id="cctt_loc" placeholder="מיקום הכיתה">
                        <label>תאריך התחלה</label>
                        <input type="date" class="cctt_frm_inputs" id="cctt_year">
                        <label>תאריך סיום</label>
                        <input type="date" class="cctt_frm_inputs" id="cctt_year2">
                        <div class="send_ncls_form_btn_fill">
                            <button id="cctt_frm_subm">צור כיתה</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="tch_info_fill et_div_main">
        <h1>עריכת פרטי המורה</h1>
        <form id="edit-teacher-form">
            <input type="text" id="f_tch_f_name" placeholder="שם פרטי" class="basic_field">
            <input type="text" id="f_tch_l_name" placeholder="שם משפחה" class="basic_field">
            <!-- <input type="text" id="f_username" placeholder="שם משתמש" class="basic_field"> -->
            <input type="text" id="f_tch_email" placeholder="Email" class="basic_field">
            <input type="password" id="f_tch_password" placeholder="סיסמה" class="basic_field">
            <input type="text" id="f_tch_address" placeholder="כתובת" class="basic_field">
            <input type="text" id="f_tch_country" placeholder="מדינה" class="basic_field">
            <input type="text" id="f_tch_school" placeholder="בית ספר" class="basic_field">
            <input type="text" id="f_tch_phone" placeholder="מספר טלפון" class="basic_field">
            <!-- <input type="text" id="f_tch_id" placeholder="מספר זהות" class="basic_field"> -->
        </form>
        <button id="etu" class="basic_field">עדכן</button>
    </div>
</div>