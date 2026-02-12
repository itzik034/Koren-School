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
            <span class="close_eptu_popup_btn close">סגור</span>
        </div>
        <div class="aptu_title_fill">
            <h2>עריכת החבילה של <?php echo get_user_full_name($conn, $user_id); ?></h2>
        </div>
        <div class="aptu_form_fill">
            <form id="eptu_form">
                <div class="select_this_user_package_fill label_divs">
                    <label>בחר חבילה</label>
                    <select id="select_this_user_package" class="select_the_user_rank">
                        <option value="1">קורס פרונטלי</option>
                        <option value="2">קורס דיגיטלי</option>
                        <option value="3">שיעורים פרטיים</option>
                    </select>
                    <script>
                        $("#select_this_user_package").val("<?php echo get_pack_field($conn, $user_id, 'pack_name'); ?>");
                    </script>
                </div>
                <div class="aptu_start_date_fill label_divs">
                    <label>בחר זמן התחלה</label>
                    <input type="datetime-local" id="aptu_start_date" class="select_the_user_rank" 
                    value="<?php echo get_pack_field($conn, $user_id, 'pack_start_date'); ?>">
                </div>
                <div class="aptu_start_date_fill label_divs">
                    <label>בחר זמן סיום</label>
                    <input type="datetime-local" id="aptu_end_date" class="select_the_user_rank" 
                    value="<?php echo get_pack_field($conn, $user_id, 'pack_end_date'); ?>">
                </div>
                <div class="aptu_start_date_fill label_divs">
                    <label>אופן התשלום</label>
                    <select id="aptu_select_pay_method" class="select_the_user_rank">
                        <option value="0">(ללא)</option>
                        <option value="credit">כרטיס אשראי</option>
                        <option value="cash">מזומן</option>
                        <option value="bit">bit</option>
                    </select>
                    <script>
                        $("#aptu_select_pay_method").val("<?php echo get_pack_field($conn, $user_id, 'pack_pay_method'); ?>");
                    </script>
                </div>
                <div class="aptu_start_date_fill label_divs">
                    <label>סכום ששולם</label>
                    <input type="number" id="paid_amount" class="select_the_user_rank" 
                    value="<?php echo get_pack_field($conn, $user_id, 'pack_pay_price'); ?>">
                </div>
                <div class="delete_user_pack_fill">
                    <span class="delete_user_pack_btn">מחיקת החבילה</span>
                </div>
                <div class="submit_fill">
                    <button id="eptu_submit" class="add_pack_to_user_btn">עדכון</button>
                </div>
            </form>
        </div>
    </div>
</div>