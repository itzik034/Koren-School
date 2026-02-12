<link rel="stylesheet" href="assets/css/header.css">
<script src="assets/js/header.js"></script>

<?php 

include_once('app/helpers/function.php');
include_once('app/config/connection.php');

if(session_status() === PHP_SESSION_NONE) 
{
    session_start();
}

if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
{
    $user_id = $_SESSION['user_id'];

    $user_first_name = get_user_first_name($conn, $user_id);
    $user_last_name = get_user_last_name($conn, $user_id);
    $user_full_name = $user_first_name . "&nbsp;" . $user_last_name;

    $pic_field = get_user_field($conn, $user_id, 'user-pic');
    $profile_picture_url = $pic_field ? 'uploads/user_img/'.$pic_field : 'uploads/user_img/user.png';
    $user_pic = '<img src="'.$profile_picture_url.'" class="header_profile_pic" />';

    $login_in_menu = 
    '<a href="?page=edit_profile" class="header-menu-item header-menu-profile" id="menu-profile">
        ' . $user_pic . '
        &nbsp;
        <span id="login_btn">
            ' . $user_full_name . '
        </span>
    </a>
    <div id="profile-menu" class="profile-menu" style="display:none;">
        <a href="?page=edit_profile" class="profile-menu-item">עריכת פרופיל</a>
        <a href="app/actions/logout.php" class="profile-menu-item">התנתק</a>
    </div>';
}
else
{
    $login_in_menu = 
    '<a href="?page=login" class="header-menu-item header-menu-profile" id="menu-profile">
        <img src="uploads/user_img/user.png" class="header-profile-img" />
        &nbsp;
        <span id="login_btn">התחבר</span>
    </a>';
}

?>

<header class="header-main">
    <h1 id="header-logo">מכינת קורן</h1>
    <div class="header-menu">
        <a href="/" class="header-menu-item">בית</a>
        <a href="?page=records" class="header-menu-item" style="color:darkblue;font-weight:bold">הקלטות</a>
        <a href="?page=packages" class="header-menu-item">חבילות</a>
        <a href="?page=contact" class="header-menu-item">צור קשר</a>
        <a href="?page=qna" class="header-menu-item">שאלות נפוצות</a>
        <a href="?page=about" class="header-menu-item">אודות הקורס</a>
        <?php if(is_user_login() && is_admin_login())
        {echo '<a href="?page=admin" class="header-menu-item">ניהול האתר</a>';} ?>
        <?php echo $login_in_menu; ?>
    </div>
</header>