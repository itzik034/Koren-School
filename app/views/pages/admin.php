<?php

if(!is_user_login() || !is_admin_login()){ echo '<script>window.location.replace("?page=login");</script>';die(); }

include_once("app/config/connection.php");
include_once("app/helpers/function.php");

$sql = "SELECT * FROM users";
$query = mysqli_query($conn, $sql);
if(mysqli_num_rows($query) > 0)
{
    $au_text = '';
    while($row = $query -> fetch_assoc())
    {
        $id = $row['id'];
        $user_pack = pack_text(get_user_pack($conn, $id));
        $user_status = get_user_field($conn, $id, 'user-status');
        if($user_status == 'active')
        {
            $delete_html = '<span class="delete delete_user_'.$id.'" id="'.$id.'">מחיקה</span>';
            $status_class = 'active_row';
        }
        else
        {
            $delete_html = '<span class="recycle recy_user_'.$id.'" id="'.$id.'">שיחזור</span>';
            $status_class = 'deleted_row';
        }
        $au_text .= '
        
        <tr class="'.$status_class.' user_row_'.$id.'">
            <td>'.$id.'</td>
            <td class="col_user_f_name_'.$id.'">'.$row['user-first_name'].'</td>
            <td class="col_user_l_name_'.$id.'">'.$row['user-last_name'].'</td>
            <td class="col_user_rank_'.$id.'">'.rank_text($row['rank']).'</td>
            <td class="col_user_email_'.$id.'">'.$row['email'].'</td>
            <td class="col_user_phone_'.$id.'">'.$row['user-phone'].'</td>
            <td>'.$row['user-register_date'].'</td>
            <td class="col_user_pack_'.$id.'">'.$user_pack.'</td>
            <td>
                <span class="edit edit_user_'.$id.'" id="'.$id.'">עריכה</span>
                &nbsp;-&nbsp;
                '.$delete_html.'
            </td>
        </tr>
        
        ';
    }
}

$sql2 = "SELECT * FROM user_pack";
$query2 = mysqli_query($conn, $sql2);
if(mysqli_num_rows($query2) > 0)
{
    $ap_text = '';
    while($row = $query2 -> fetch_assoc())
    {
        $id = $row['id'];
        $ap_text .= '
        
        <tr>
            <td>'.get_user_full_name($conn, $row['user_id']).'</td>
            <td>'.pack_text($row['pack_name']).'</td>
            <td>'.$row['pack_start_date'].'</td>
            <td>'.$row['pack_end_date'].'</td>
            <td>'.pay_text($row['pack_pay_method']).'</td>
            <td>'.$row['pack_pay_price'].'₪</td>
            <td>
                <span class="edit edit_pack_'.$id.'" id="'.$row['user_id'].'">עריכה</span>
            </td>
        </tr>
        
        ';
    }
}

?>

<link rel="stylesheet" href="assets/css/pages/admin.css">
<script src="assets/js/pages/admin.js"></script>
<script src="assets/js/functions.js"></script>

<div class="site_manage_page_fill">
    <div class="sm_title_fill">
        <h1>ניהול האתר</h1>
    </div>
    <div class="admin_menu">
        <span class="admin_links" id="users_btn">משתמשים</span>
        <span class="admin_links" id="packs_btn">חבילות</span>
        <span class="admin_links" id="reset_bins_btn">איפוס בינים</span>
    </div>
    <div class="sm_users_table_div_fill">
        <div class="smu_title_fill users_title">
            <h2>משתמשים</h2>
        </div>
        <div class="smu_table_fill">
            <table id="smu_table">
                <tr>
                    <th>ID</th>
                    <th>שם פרטי</th>
                    <th>שם משפחה</th>
                    <th>דרגה</th>
                    <th>Email</th>
                    <th>טלפון</th>
                    <th>תאריך הרשמה</th>
                    <th>חבילה</th>
                    <th>פעולות</th>
                </tr>
                <?php echo $au_text; ?>
            </table>
        </div>
    </div>
    <div class="sm_packs_table_div_fill">
        <div class="smp_title_fill packs_title">
            <h2>חבילות</h2>
        </div>
        <div class="smp_table_fill">
            <table id="smp_table">
                <tr>
                    <th>משתמש</th>
                    <th>חבילה</th>
                    <th>תאריך התחלה</th>
                    <th>תאריך סיום</th>
                    <th>אופן התשלום</th>
                    <th>סכום ששולם</th>
                    <th>פעולות</th>
                </tr>
                <?php echo $ap_text; ?>
            </table>
        </div>
    </div>
    <div class="sm_reset_bins_btn_fill">
        <div class="sm_rbb_title">
            <h2>לחצן איפוס בינים</h2>
        </div>
        <div class="sm_rbb_fill">
            <span>הלחצן מחלק את השאלות בצורה שווה בין כל הבינים באותו נושא</span>
            <button id="reset_all_bins_btn">איפוס בינים לכל השאלות באתר</button>
        </div>
    </div>
</div>