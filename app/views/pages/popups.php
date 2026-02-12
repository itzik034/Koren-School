<?php

$url = $_SERVER['REQUEST_URI'];

if(!is_user_login() && $url == '/index.php?page=popups')
{
    echo '<script>window.location.href = "?page=login";</script>';
    die();
}
else
{
    if($url == '/index.php?page=popups')
    {
        if(!is_admin_login() && !is_teacher_login())
        {
            echo 'אין לך הרשאות לצפות בדף זה';
            die();
        }
    }
}

?>

<div id="popup-window"></div>
<div id="popup-window-msg">
    <div id="popup-msg-text">
        <div id="popup-inner">
            <div id="popup-split-top"></div>
            <div id="popup-split-bottom">
                <div id="popup-ok"><i class="fa-solid fa-circle-check"></i>&nbsp;כן</div>
                <div id="popup-cancel"><i class="fa-solid fa-circle-xmark"></i>&nbsp;ביטול</div>
            </div>
        </div>
    </div>
</div>
<div id="popup-edit-teacher">
    <div id="popup-et-fill">
        <div class="close-popup-edit-fill">
            <div id="close-popup-edit">סגור</div>
        </div>
        <div class="edit_teacher_layout_fill">
            <?php include_once("rec/edit_teacher.php?teacher_id=0"); ?>
        </div>
    </div>
</div>
<div id="popup-edit-student">
    <div id="popup-es-fill">
        <div class="close_edit_std_popup_btn_fill">
            <div id="close-st-popup-edit">סגור</div>
        </div>
        <form id="edit-student-form">
            <input type="text" id="f_st_f_name" placeholder="שם פרטי">
            <input type="text" id="f_st_l_name" placeholder="שם משפחה">
            <input type="text" id="f_st_password" placeholder="סיסמה">
            <input type="text" id="f_st_email" placeholder="Email">
            <input type="text" id="f_st_address" placeholder="כתובת"> 
            <input type="text" id="f_st_country" placeholder="מדינה"> 
            <input type="text" id="f_st_school" placeholder="בית ספר"> 
            <input type="text" id="f_st_phone" placeholder="מספר טלפון">
            <input type="text" id="f_st_mom_name" placeholder="שם האמא">
            <input type="text" id="f_st_mom_phone" placeholder="טלפון של האמא">
        </form>
        <button id="esu">עדכן</button>
    </div>
</div>
<div class="green_alert_fill">
    <div id="alert">
        <div id="alert-close"><i class="fa-solid fa-circle-xmark"></i></div>
        <div id="alert-content"></div>
    </div>
</div>
<div class="red_alert_fill">
    <div id="alert-err">
        <div id="alert-err-close"><i class="fa-solid fa-circle-xmark"></i></div>
        <div id="alert-err-content"></div>
    </div>
</div>
<div id="popup-new-teacher">
    <div id="popup-nt-fill">
        <div class="close_ant_fill">
            <div id="close-popup-fill">סגור</div>
        </div>
        <form id="add-teacher-form">
            <input type="text" id="tch_f_name" class="basic_field" placeholder="שם פרטי">
            <input type="text" id="tch_l_name" class="basic_field" placeholder="שם משפחה">
            <input type="email" id="tch_email" class="basic_field" placeholder="Email">
            <input type="password" id="tch_password" class="basic_field" placeholder="סיסמה">
            <input type="text" id="tch_phone" class="basic_field" placeholder="מספר טלפון">
        </form>
        <button id="cnt" class="basic_field pointer">צור</button>
    </div>
</div>
<div id="popup-new-student">
    <div id="popup-ns-fill">
        <div id="close-st-popup">סגור</div>
        <form id="add-student-form">
            <input type="text" id="st_f_name" placeholder="שם פרטי">
            <input type="text" id="st_l_name" placeholder="שם משפחה">
            <input type="text" id="st_username" placeholder="שם משתמש">
            <input type="text" id="st_password" placeholder="סיסמה">
            <input type="text" id="st_email" placeholder="Email">
            <input type="text" id="st_address" placeholder="כתובת"> 
            <input type="text" id="st_country" placeholder="מדינה" value="ישראל"> 
            <input type="text" id="st_school" placeholder="בית ספר"> 
            <input type="text" id="st_phone" placeholder="מספר טלפון">  
            <input type="text" id="st_mom_name" placeholder="שם האמא">  
            <input type="text" id="st_mom_phone" placeholder="טלפון של האמא">  
            <!-- <input type="text" id="st_id" placeholder="מספר זהות">  -->
        </form>
        <button id="cnst">צור</button>
    </div>
</div>
<div class="popup_add_course_fill">
    <div class="popup_add_course"></div>
</div>