<?php 

include_once("app/helpers/function.php");
include_once("app/config/connection.php");

if (session_status() === PHP_SESSION_NONE) 
{
    session_start();
}

if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id']))
{
    echo '<script>window.location.href="?page=login";</script>';
    die();
}

$user_id = $_SESSION['user_id'];

if(isset($_GET['update']))
{
    $f_f_name = $_POST['first_name'];
    $f_l_name = $_POST['last_name'];
    $f_password = $_POST['password'];
    $f_birthday = $_POST['birthday'];
    $f_address = $_POST['address'];
    $f_country = $_POST['country'];
    $f_school = $_POST['school'];
    $f_phone_number = $_POST['phone_number'];
    $f_parent_name = $_POST['parent_name'];
    $f_parent_phone_number = $_POST['parent_phone_number'];
    // $f_identical_number = $_POST['identical_number'];
    
    if(!empty($f_password))
    {
        $sql = "UPDATE users SET `password` = '$f_password' WHERE id = '$user_id'";
        mysqli_query($conn, $sql) or die("שגיאה בעדכון הנתונים");
    }
    
    if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0)
    {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileTmpName = $_FILES['profile_picture']['tmp_name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileError = $_FILES['profile_picture']['error'];
        $fileType = $_FILES['profile_picture']['type'];
        
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        
        if(in_array($fileActualExt, $allowed))
        {
            if($fileError === 0)
            {
                if($fileSize < 10000000) // Limit to 10MB
                {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = 'uploads/user_img/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    
                    $sql = "UPDATE users SET `user-pic` = '$fileNameNew' WHERE id = '$user_id'";
                    mysqli_query($conn, $sql) or die("שגיאה בעדכון הנתונים");
                }
                else
                {
                    echo "הקובץ גדול מידי. נסה להעלות קובץ קטן יותר.";
                }
            }
            else
            {
                echo "הייתה שגיאה בהעלאת הקובץ";
            }
        }
        else
        {
            echo "פורמט זה אינו נתמך. נסה קובץ תמונה בפורמט jpg, jpeg, png או gif";
        }
    }

    $sql = "UPDATE users SET `user-first_name` = '$f_f_name', 
                             `user-last_name` = '$f_l_name', 
                             `user-birthday` = '$f_birthday', 
                             `user-address` = '$f_address', 
                             `user-country` = '$f_country', 
                             `user-school` = '$f_school', 
                             `user-phone` = '$f_phone_number', 
                             `user-mom_name` = '$f_parent_name', 
                             `user-mom_phone` = '$f_parent_phone_number'
     WHERE id = '$user_id'";

    mysqli_query($conn, $sql) or die("שגיאה בעדכון הנתונים");

    echo "<span id='edit_user_updated_msg'>הנתונים עודכנו בהצלחה</span>";
    echo '<script>
            setTimeout(function()
            { 
                document.getElementById("edit_user_updated_msg").remove();
                history.replaceState(null, "", "?page=edit_profile");
            }, 5000);
          </script>';
}

$pic_field = get_user_field($conn, $user_id, 'user-pic');
$profile_picture_url = $pic_field ? 'uploads/user_img/'.$pic_field : 'uploads/user_img/user.png';
$profile_pic_html = '<img src="'.$profile_picture_url.'" class="edit_profile_pic" />';

?>

<link rel="stylesheet" href="assets/css/pages/edit_profile.css">

<div class="fill">
    <div class="container">
        <h2>עריכת פרופיל</h2>

        <div class="ep_page_pic_fill">
            <?php echo $profile_pic_html; ?>
        </div>

        <form action="?page=edit_profile&update" method="post" enctype="multipart/form-data">
            <label for="profile_picture">תמונת פרופיל:</label>
            <input type="file" id="profile_picture" name="profile_picture"><br>

            <label for="first_name">שם פרטי:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo get_user_first_name($conn, $user_id); ?>"><br>

            <label for="last_name">שם משפחה:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo get_user_last_name($conn, $user_id); ?>"><br>

            <label for="password">סיסמה:</label>
            <input type="password" id="password" name="password" placeholder="(ללא שינוי)"><br>

            <label for="password">יום הולדת:</label>
            <input type="date" id="birthday" name="birthday" value="<?php echo get_user_field($conn, $user_id, "user-birthday"); ?>"><br>

            <label for="address">כתובת:</label>
            <input type="text" id="address" name="address" value="<?php echo get_user_field($conn, $user_id, "user-address"); ?>"><br>

            <label for="country">מדינה:</label>
            <input type="text" id="country" name="country" value="<?php echo get_user_field($conn, $user_id, "user-country"); ?>"><br>

            <label for="school">בית ספר:</label>
            <input type="text" id="school" name="school" value="<?php echo get_user_field($conn, $user_id, "user-school"); ?>"><br>

            <label for="phone_number">מספר טלפון:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo get_user_field($conn, $user_id, "user-phone"); ?>"><br>

            <label for="parent_name">שם ההורה:</label>
            <input type="text" id="parent_name" name="parent_name" value="<?php echo get_user_field($conn, $user_id, "user-mom_name"); ?>"><br>

            <label for="parent_phone_number">מספר טלפון של הורה:</label>
            <input type="text" id="parent_phone_number" name="parent_phone_number" value="<?php echo get_user_field($conn, $user_id, "user-mom_phone"); ?>"><br>

            <!-- <label for="id_number">מספר תעודת זהות:</label>
            <input type="text" id="identical_number" name="identical_number" value="<?php echo get_user_field($conn, $user_id, "user-id"); ?>"><br> -->

            <input type="submit" value="עדכון פרטים">
        </form>
    </div>
</div>