<link rel="stylesheet" href="assets/css/popups/edit_class.css">
<script src="assets/js/popups/edit_class.js"></script>

<?php 

include_once("../../../config/connection.php");
include_once("../../../helpers/function.php");

$sql = "SELECT * FROM users WHERE `rank` = 's' AND `user-status` = 'active'";
$query = mysqli_query($conn, $sql);
$std_list_html = "";

if(mysqli_num_rows($query) > 0)
{
    while($row = mysqli_fetch_array($query))
    {
        $full_name = $row['user-first_name'] . ' ' . $row['user-last_name'];
        $id = $row['id'];
        $std_list_html .= '
        <div class="std_fill std_fill_'.$id.'" id="'.$id.'">
            <input type="checkbox" class="chck_c_s_'.$id.'">
            <span class="s_c_std_name">'.$full_name.'</span>
        </div>
        ';
    }
}

if (session_status() === PHP_SESSION_NONE) 
{
    session_start();
}

?>

<div class="ec_background">
    <div class="ec_popup_fill">
        <div class="close_ec_fill">
            <span class="close_ec_btn">סגור</span>
        </div>

        <div class="ec_ec">
            <div class="ec_edit_fill">
                <div class="ec_title_fill">
                    <h2>עריכת כיתה</h2>
                </div>
                <form id="edit_class_form" enctype="multipart/form-data">
                    <input type="text" id="class_name_field" placeholder="שם הכיתה">
                    <select id="ec_select_course">
                        <option>בחר קורס...</option>
                    </select>
                    <!-- <select id="ec_select_teach">
                        <option>בחר מורה...</option>
                    </select> -->
                    <input type="text" id="class_loc_field" placeholder="מיקום הכיתה">
                    <label for="class_date1" style="width:100%;font-weight:bold;">תאריך התחלה - </label>
                    <input type="date" id="class_date1">
                    <label for="class_date2" style="width:100%;font-weight:bold;">תאריך סיום - </label>
                    <input type="date" id="class_date2">
                    <label for="ac_class_picture" style="width:100%;font-weight:bold;">תמונה - </label>
                    <input type="file" id="class_picture" name="class_picture">
                    <button id="update_class_data_btn">עדכון</button>
                </form>
            </div>

            <div class="ec_add_std_to_cls">
                <div class="s_c_title_fill">
                    <h2>הוספת תלמידים לכיתה</h2>
                </div>
                <div class="s_c_std_fill">
                    <?php //echo $std_list_html; ?>
                </div>
                <div class="s_c_std_update_btn_fill">
                    <button id="s_c_update_btn">עדכון</button>
                </div>
            </div>

            <div class="edit_class_teachers">
                <div class="edt_cls_tch_title_fill">
                    <h2>עריכת המורים של הכיתה</h2>
                </div>
                <div class="cls_tch_lst_fill">
                    
                </div>
                <div class="cls_tch_lst_update_btn_fill">
                    <button id="cls_tch_lst_update_btn">עדכון</button>
                </div>
            </div>
        </div>

        <?php $class_id = $_GET['class_id']; ?>
        <input type='hidden' id='class_id' value='<?php echo $class_id; ?>'>
    </div>
</div>