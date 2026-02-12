<script src="assets/js/popups/add_pack_to_user.js"></script>

<?php

include_once("../../../config/connection.php");
include_once("../../../helpers/function.php");

if(!isset($_GET['user_id'])){ echo "<script>location.reload();</script>"; die('error'); }

$user_id = $_GET['user_id'];

?>

<input type="hidden" id="user_id" value="<?php echo $user_id; ?>">

<div class="aptu_background">
    <div class="aptu_popup">
        <div class="aptu_popup_close_fill">
            <span class="close_aptu_popup_btn close">סגור</span>
        </div>
        <div class="aptu_title_fill">
            <h2>הוספת חבילה ל<?php echo get_user_full_name($conn, $user_id); ?></h2>
        </div>
        <div class="aptu_form_fill">
            <form id="aptu_form">
                <div class="select_this_user_package_fill label_divs">
                    <label>בחר חבילה</label>
                    <select id="select_this_user_package" class="select_the_user_rank">
                        <option value="1">קורס פרונטלי</option>
                        <option value="2">קורס דיגיטלי</option>
                        <option value="3">שיעורים פרטיים</option>
                    </select>
                </div>
                <div class="aptu_start_date_fill label_divs">
                    <label>בחר זמן התחלה</label>
                    <input type="datetime-local" id="aptu_start_date" class="select_the_user_rank">
                </div>
                <div class="aptu_start_date_fill label_divs">
                    <label>בחר זמן סיום</label>
                    <input type="datetime-local" id="aptu_end_date" class="select_the_user_rank">
                </div>
                <div class="aptu_start_date_fill label_divs">
                    <label>אופן התשלום</label>
                    <select id="aptu_select_pay_method" class="select_the_user_rank">
                        <option value="">(ללא)</option>
                        <option value="credit">כרטיס אשראי</option>
                        <option value="cash">מזומן</option>
                        <option value="bit">bit</option>
                    </select>
                </div>
                <div class="aptu_start_date_fill label_divs">
                    <label>סכום ששולם</label>
                    <input type="number" id="paid_amount" class="select_the_user_rank">
                </div>
                <div class="submit_fill">
                    <button id="aptu_submit" class="add_pack_to_user_btn">הוספה</button>
                </div>
            </form>
        </div>
    </div>
</div>